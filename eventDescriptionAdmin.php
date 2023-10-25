<link rel="stylesheet" type="text/css" href="css/eventDesc.css" />
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
include('includes/headerAdmin.php');
?>
<?php 
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);   
$events = strtoupper($_GET["events"]);     
$sql = "SELECT * FROM Events WHERE EventName = '$events'";

$result = $con->query($sql);
if ($row = $result->fetch_object())
{
    
    $events  = $row->EventName;
    $date    = $row->EventDate;
    $admin   = $row->AdminName;
}

?>

<div class="DescAdmin">
    <?php 
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
            
            $targetDir = "event_img/";
            $ext = pathinfo($events, PATHINFO_EXTENSION);
            $targetFile = $targetDir . $events . ".jpg";
            $targetFile1 = $targetDir . $events . ".png";
            $targetFile2 = $targetDir . $events . ".jpeg";

            printf('<h1>%s</h1>'."\n",$events);
            if (file_exists($targetFile))
            {
                printf('<img src="%s" alt="%s">'."\n",$targetFile,$events);
            }
            else if (file_exists($targetFile1))
            {
                printf('<img src="%s" alt="%s">'."\n",$targetFile1,$events);
            }
            else if (file_exists($targetFile2))
            {
                printf('<img src="%s" alt="%s">'."\n",$targetFile2,$events);
            }

            $textDir = "desc/";
            $textFile = $textDir . "event_desc_" . $events . ".txt";

            if (file_exists($textFile))
            {

                if(filesize($textFile) == 0)
            {
                printf("<p class='emptyDesc'>THIS EVENT DON'T HAVE ANY DESCRIPTION!!!</p>");
            }

                $description = file_get_contents($textFile);

                $description = htmlspecialchars($description);

                if(filesize($textFile) < 140)
                {
                printf("<p class='lessDesc'>%s</p>",nl2br($description));
                }
                else
                printf("<p class='normalDesc'>%s</p>",nl2br($description));
            }else
                printf("<p class='lessDesc'>FAIL TO READING THE DESCRIPTION FILE!</p>");


            
        }
        else
        {
            printf("
                    <script>
                    alert('Oops, record not found!');
                    window.location.href='eventAdmin.php?name=%s';
                    </script>",$name);
        }
    }else if($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET["events"]))
    {
        printf("
                <script>
                alert('Oops, record not found!');
                window.location.href='eventAdmin.php?name=%s';
                </script>",$name);
    }
    ?>
</div>
<div class="DescTable">
<table class="event" cellpadding="5" cellspacing="0">
    <tr>
        <th colspan="3" class="design">Participant in this event</th>
    </tr>

<?php
require_once 'includes/helper.php';


$headers = array(
    "JoinDate" => "Join Dates",
    "UserJoined" => "Participant",
);

$sort    = isset($_GET['sort']) ? 
(array_key_exists($_GET['sort'], $headers) ? $_GET['sort'] : "JoinDate") 
:
"JoinDate";
$order   = isset($_GET["order"]) ? $_GET["order"] : "ASC";

if(isset($_POST['searchInput']))
{
$search = $_POST["searchInput"];
printf("<script>
        window.location.href='?name=%s&events=%s&searchInput=%s';
        </script>",$name,$events,$search);  

}else
{
    $search = '';
}


$search1 = isset($_GET['searchInput']) ? $_GET['searchInput'] : '';

echo '<tr>';
echo '<th colspan=4>';
echo '<form id="searchForm" action="" method="POST">';
printf (' <input type="text" id="searchInput" name="searchInput" placeholder="Search Participant Name..."  value="%s" class="search">',$search1);
echo '</form>';
echo '</th>';
echo '</tr>';
echo '<tr>';
echo '<td> </td>';
    foreach ($headers as $key => $value)
    {
        
        if ($key == $sort)
        {
            printf('
                <th>
                <a href="?name=%s&events=%s&sort=%s&order=%s&searchInput=%s" class="order">%s</a>
                <img src="images/%s.png" alt="%s" />
                </th>             
              ',$name,$events ,$key, $order=='DESC' ? 'ASC' : 'DESC' 
                ,$search1,$value
               , $order=='DESC' ? 'ASC' : 'DESC'
               ,$order=='DESC' ? 'ASC' : 'DESC');
            
        }
        else 
        {
            printf('
                <th>
                <a href="?name=%s&events=%s&sort=%s&order=%s&searchInput=%s" class="order">%s</a>
                </th>                 
                ',$name,$events ,$key,'ASC',$search1,$value);
            
        }
    }
echo '</tr>';


echo '<form id="deleteBox" action="" method="post">';
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

if ($conn->connect_error){
    die("Connection Failed: ". $conn->connect_error);
}

$sql = "SELECT * FROM eventJoin WHERE EventJoined = '$events' AND UserJoined LIKE '%" . $search1 . "%' ORDER BY $sort $order";

$result = $conn->query($sql);


if ($result->num_rows > 0)
{
    while ($row = $result->fetch_object())
    {
        printf('
            <tr>
            <td>
            <input type="checkbox" name="checked[]" value="%s" />
            </td> 
            <td>%s</td>
            <td>%s  [<a class="eventLink" href="eventUserRemove.php?name=%s&events=%s&eventuser=%s">Remove</a>]</td>
            </tr>',
            $row->UserJoined,
            $row->JoinDate,
            $row->UserJoined,
            $name,
            $row->EventJoined,
            $row->UserJoined);
    }
}
if (isset($_POST['delete']))
    {
        $checked = isset($_POST['checked']) ? $_POST['checked'] : null;
  
        if (!empty($checked))
        {
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            $escaped = array();
            foreach($checked as $key => $value) {
                $escaped[$key] = $con->real_escape_string($value);
            }


            $sql = "DELETE FROM EventJoin WHERE EventJoined = '$events' AND UserJoined IN ('" . implode("','", $escaped) . "')";
            
            if ($con->query($sql))
            {
                printf("
                    <script>
                    alert('Participant(s) has been removed!');
                    window.location.href='eventDescriptionAdmin.php?name=%s&events=%s';
                    </script>",$name,$events);
                $con->affected_rows;
            }

            $con->close();
        }else
        {
            printf("
                    <script>
                    window.location.href='eventDescriptionAdmin.php?name=%s&events=%s';
                    </script>",$name,$events);
        }
}
printf('
    <tr>
    <td colspan="3">
        %d participant(s) recorded.
        [ <input type="submit" name="delete" value="Remove Checked Participant" class="deleteBox"
        onclick=\'return confirm("This will delete all checked Participant records.\nAre you sure?")\' /> ]
    </td>
    </tr>',
    $result->num_rows);
echo '</form>';

$result->free();
$conn->close();
?>
</table>
</div>
<?php
include('includes/footerAdmin.php');
?>