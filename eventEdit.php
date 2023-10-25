<link rel="stylesheet" type="text/css" href="css/eventForm.css" />
<?php
require_once('includes/helper.php');
$name = $_GET["name"];
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$name  = $con->real_escape_string($name);
$sql = "SELECT * FROM Admin WHERE AdminName = '$name'";
$result = $con->query($sql);
if ($row = $result->fetch_object())
{
    $name    = $row->AdminName;
    $pass    = $row->AdminPass;

}
$events1 = $_GET["events"];
include('includes/headerAdmin.php');
?>

<div>
    <div class="title2"><h1>Edit Event</h1></div>

    <?php
    require_once('includes/helper.php');

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["events"]))
    {
        $events = $_GET["events"];

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);       
        
        $sql = "SELECT * FROM Events WHERE EventName = '$events'";

        $dir = './desc/';

        $file_name = 'event_desc_' . $events. '.txt';
        $file_path = $dir . $file_name;
            
        if (file_exists($file_path)) {
                $file_handle = fopen($file_path, 'r');
                $file_contents = fread($file_handle, 20000);
                fclose($file_handle);
                $desc =  $file_contents;
        }


        $result = $con->query($sql);
        if ($row = $result->fetch_object())
        { 

            $events  = $row->EventName;
            $date    = $row->EventDate;
            $admin   = $row->AdminName;
        }
        else
        {
            printf("
                    <script>
                    alert('Oops, record not found!');
                    window.location.href='eventAdmin.php?name=%s';
                    </script>",$name);
        }

        $result->free();
        $con->close();
 
    }


    else if(isset($_POST["update"]))
    {   
        $events     = trim($_POST['events']);
        $date       = trim($_POST['date']);
        $admin      = trim($_POST['admin']);
        $desc    = $_POST['desc'];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $file = $_FILES['image'];
            $file_name = $_FILES['image']['name'];

            if($file['error'] == UPLOAD_ERR_OK) {
                $targetDir = "event_img/";
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $targetFile = $targetDir . $events . "." .$ext;

                if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['image']['tmp_name'];
                    $image_info = @getimagesize($tmp_name);
                    $size = $_FILES['image']['size'];
                    $max_size = 5000000; // 5 MB
                    $allowed_extensions = array('jpg', 'jpeg');
                    $file_type = exif_imagetype($_FILES['image']['tmp_name']);
                    
                        
                        if (!$image_info) {
                            $error['image'] =  '<style>
                                                div.error h4.imageType {
                                                    display: block;
                                                }
                                                </style>';
                        }
                        else if ($size > $max_size) {
                            $error['image'] = '<style>
                                                div.error h4.imageSize {
                                                    display: block;
                                                }
                                                </style>';
                        } 
                        else {
                            list($width, $height) = @getimagesize($tmp_name);
                            $aspect_ratio = $width / $height;
    
                            
                                $mime_type = $image_info['mime'];
                                if ($mime_type == 'image/png') {
                                    if (!(abs($aspect_ratio - (16/9)) < 0.1)) {
                                        $error['image'] = '<style>
                                                            div.error h4.imageRatio {
                                                                display: block;
                                                            }
                                                            </style>';
                                    }
                                } else if (in_array($ext, $allowed_extensions) && $file_type == IMAGETYPE_JPEG && $_FILES['image']['type'] != 'image/jfif'){
                                    if (!(abs($aspect_ratio - (16/9)) < 0.1)) {
                                        $error['image'] = '<style>
                                                            div.error h4.imageRatio {
                                                                display: block;
                                                            }
                                                            </style>';
                                    }
                                } else {
                                    $error['image'] =  '<style>
                                                        div.error h4.imageType {
                                                            display: block;
                                                        }
                                                        </style>';
                                }
                        }

                } 
                

            }
        }

        $error['events']  = validateEditEventName($events,$events1);
        $error['date'] = validateEventDate($date);

        $error = array_filter($error); 

        if (empty($error))
        {
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            $sql = "UPDATE Events 
                    SET EventDate = ?, EventName = ?
                    WHERE EventName = '$events1'
                    ";

            $stm = $con->prepare($sql);
     
            $stm->bind_param('ss', $date, $events);

            if($stm->execute())
            {
                $dir = './desc/';
                $file_name = 'event_desc_' . $events. '.txt';
                $file_path = $dir . $file_name;

                $file_handle = fopen($file_path, 'w');
                fwrite($file_handle, $desc);
                fclose($file_handle);


                if($file['error'] == UPLOAD_ERR_OK) {
                    $oldFile = $targetDir . $events;

                    $imageName = $oldFile;

                    $oldfiles = glob($imageName . ".*");

                    foreach ($oldfiles as $old_file) {
                        if (is_file($old_file)) {
                            unlink($old_file);
                        }
                    }
                    
                }
                $targetDir = "event_img/";
                $img_file_name = $_FILES['image']['name'];
                $ext = pathinfo($img_file_name, PATHINFO_EXTENSION);
                $targetFile = $targetDir . $events . "." .$ext;
                if(move_uploaded_file($file["tmp_name"], $targetFile)) {} 
                else {}

                printf("
                    <script>
                    alert('Event update success!');
                    window.location.href='eventAdmin.php?name=%s';
                    </script>",$name);
            }
            else
            {
                printf("
                    <script>
                    alert('Oops, event update fail. Pls check ur database!');
                    </script>",$name);
            }

            $stm->close();
            $con->close();

        }
        else
        {
            foreach ($error as $value)
            {
                echo $value;
            }
        }
    }else{
        printf("
                    <script>
                    alert('Oops, Please provide event name!');
                    window.location.href='eventAdmin.php?name=%s';
                    </script>",$name);
    }
    ?>

    <div class="table">
    <form action="" method="post" enctype="multipart/form-data">
        <table cellpadding="5" cellspacing="0">
            <tr>
                <td class="small_title"><label for="name">Created By :</label></td>
                <td>
                    <?php echo $admin ?>
                    <?php htmlInputHidden('admin', $admin) ?>
                </td>
            </tr>
            <tr>
                <td class="small_title"><label for="events">Event Name* :</label></td>
                <td >
                    <?php htmlInputText('events', isset($events) ? $events : "" , 30, 'Enter event name') ?>
                </td>
            </tr>
            <tr>
                <td class="small_title"><label for="date">Event Date* :</label></td>
                <td>
                <?php htmlDate('date', isset($date) ? $date : "") ?>
                </td>
            </tr>
            <tr>
                <td class="small_title"><label for="desc">Event Description :</label></td>
                <td>
                <?php htmlInputDesc('desc', isset($desc) ? $desc : "" , 20000, 'Enter event description', isset($desc) ? $desc : "" ) ?>
                </td>
            </tr>
            <tr>
                <td class="small_title"> Event Image Preview :</td>
                <td class="preview">
                    <?php
                    $targetDir = "event_img/";
                    $ext = pathinfo($events, PATHINFO_EXTENSION);
                    $targetFile = $targetDir . $events . ".jpg";
                    $targetFile1 = $targetDir . $events . ".png";
                    $targetFile2 = $targetDir . $events . ".jpeg";

                    if (file_exists($targetFile))
                    {
                        printf('<img src="%s" alt="%s" class="preview">'."\n",$targetFile,$events);
                    }
                    else if (file_exists($targetFile1))
                    {
                        printf('<img src="%s" alt="%s" class="preview">'."\n",$targetFile1,$events);
                    }
                    else if (file_exists($targetFile2))
                    {
                        printf('<img src="%s" alt="%s" class="preview">'."\n",$targetFile2,$events);
                    }else
                        printf('-'."\n");

                    ?>
                </td>
            </tr>
            <tr>
                <td class="small_title"><label for="image">Upload Event Image :</label></td>
                <td>
                <input type="file" name="image" value="image"/>
                <?php //htmlInputFile() ?>
                </td>
            </tr>
        </table>

        <input type="submit" name="update" value="Edit" />
        <input type="button" value="Back" onclick="location='eventAdmin.php?name=<?php printf('%s',$name)?>'" />
        <div class="error">
            <h4 class="nameEmpty">Event name Cannot be empty!</h4>
            <h4 class="nameMore">Event name Cannot more than 50 words!</h4>
            <h4 class="nameInvalid">Event name Cannot use Invalid Character!</h4>
            <h4 class="nameExist">Event name already Exist!</h4>

            <h4 class="dateEmpty">Event date cannot be empty!</h4>
            <h4 class="dateYear">Cannot choose the year before current year and after 2 years of current year!</h4>
            <h4 class="dateMonth">Cannot choose the month before current month!</h4>
            <h4 class="dateDay">Cannot choose the day before current day!</h4>

            <h4 class="imageSize">Image file size cannot more than 5 MB!</h4>
            <h4 class="imageType">Image file only can support .jpeg .jpg and .png file!</h4>
            <h4 class="imageRatio">Image aspect ratio only allowed 16:9!</h4>
        </div>
    </form>
    </div>
</div>
<?php
include('includes/footerAdmin.php');
?>