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
include('includes/headerAdmin.php'); ?>

<div class="title3">
    <h1>Delete Event</h1>
</div>
<div>
    <?php
    require_once('includes/helper.php');

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["events"]))
    {
        
        $events = strtoupper($_GET["events"]);

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);       
        $sql = "SELECT * FROM Events WHERE EventName = '$events'";

        $result = $con->query($sql);
        if ($row = $result->fetch_object())
        {
            
            $events  = $row->EventName;
            $date    = $row->EventDate;
            $admin   = $row->AdminName;
            
            printf('
            <div class="table">
            <table cellpadding="5" cellspacing="0" class="delete">
            <tr>
                <td class="small_title a"><label for="name">Created By :</label></td>
                <td class="b">
                %s
                </td>
            </tr>
            <tr>
                <td class="small_title"><label for="events">Event Name :</label></td>
                <td >
                %s
                </td>
            </tr>
            <tr>
                <td class="small_title"><label for="date">Event Date :</label></td>
                <td>
                %s
                </td>
            </tr>
            </table>
            <form action="" method="post">
                        <input type="hidden" name="events" value="%s" />
                        <input type="submit" name="yes" value="Delete" onclick=\'return confirm("This will permanently delete this Event records.\nAre you sure?")\'/>
                        <input type="button" value="Back"
                            onclick=location=\'eventAdmin.php?name=%s\' />
                    </form>
            </div>
            ',$admin,$events,$date,$events,$admin);
            
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
   
    else if(isset($_POST['events']))
    {
        $events  = trim($_POST['events']);

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        $sql = 'DELETE FROM Events WHERE EventName = ? ';

        $stm = $con->prepare($sql);
        $stm->bind_param('s', $events);
        $stm->execute();
        if ($stm->affected_rows > 0)
        {
            $dir = './desc/';
            $file_name = 'event_desc_' . $events. '.txt';
            $file_path = $dir . $file_name;

            if (file_exists($file_path)) {

                unlink($file_path);
            }

            $targetDir = "event_img/";
            $img_file_name = $events;

            $oldFile = $targetDir . $events;
            $imageName = $oldFile;

            $oldfiles = glob($imageName . ".*");
            
            foreach ($oldfiles as $old_file) {
                if (is_file($old_file)) {
                    unlink($old_file);
                }
            }

            printf("
                    <script>
                    alert('Event has been deleted!');
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
    }else
    {
        printf("
                    <script>
                    alert('Oops, Please provide event name!');
                    window.location.href='eventAdmin.php?name=%s';
                    </script>",$name);
    }
    ?>
</div>

<?php include('includes/footerAdmin.php'); ?>