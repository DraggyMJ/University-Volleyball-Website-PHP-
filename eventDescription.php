
<link rel="stylesheet" type="text/css" href="css/eventDesc.css" />
<?php
require_once('includes/helper.php');
$name = $_GET["name"];
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$name  = $con->real_escape_string($name);
$sql = "SELECT * FROM Users WHERE UserName = '$name'";
$result = $con->query($sql);

$result = $con->query($sql);
if ($row = $result->fetch_object())
{
    $name    = $row->UserName;
    $pass    = $row->Pass;
    $gender  = $row->Gender;
    $age     = $row->Age;
    $email   = $row->Email;
    $phone   = $row->Phone;
    $birth   = $row->Birth;
                }
include('includes/headerUser.php');
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
                    window.location.href='event.php?name=%s';
                    </script>",$name);
        }
    }else if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET["events"]))
    {
        printf("
                <script>
                alert('Oops, record not found!');
                window.location.href='event.php?name=%s';
                </script>",$name);
    }
    ?>
</div>
<div class="joinButton">
    <form  action="" method="post" enctype="multipart/form-data">

    <?php 
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 
        $sqlJoinEvent = "SELECT * FROM EventJoin WHERE EventJoined = '$events' AND UserJoined = '$name'";
        $result = $con->query($sqlJoinEvent);
        if ($row = $result->fetch_object())
        {
            $Joinevent = $row->EventJoined;
            $Joinuser = $row->UserJoined;
        }

        if (isset($Joinevent)) {
                $Joinevent = is_null($Joinevent) ? "" : $Joinevent;
            } else {
                $Joinevent = ""; 
            }

        if(isset($Joinuser)){
            $Joinuser    = is_null($Joinuser) ? "" : $Joinuser;
            } else { 
                $Joinuser = "";
            }

        if ($name == $Joinuser)
        {
            if ($events == $Joinevent)
            {
                    function JoinEventButton()
                        {
                            printf('<button disabled class="joined">Event Joined</button>'."\n");
                            printf('<input type="submit" name="eventLeave" value="Leave Event" class="leave" onclick=\'return confirm("Are sure you want to leave this event?")\'/>'."\n");
                        }
            }
            else
                    {
                        function JoinEventButton()
                        {
                            printf('<input type="submit" name="eventJoin" value="Join Event" class="join"/>'."\n");
                        }
                    }
        }
        else
        {
            function JoinEventButton()
            {
                printf('<input type="submit" name="eventJoin" value="Join Event" class="join"/>'."\n");
            }
        }

    ?>
    <?php JoinEventButton() ?>
    </form>
</div>

<?php
$events = strtoupper($_GET["events"]);

$con1 = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);       
$sql1 = "SELECT * FROM Events WHERE EventName = '$events'";

$result = $con->query($sql1);
if ($row = $result->fetch_object())
{
    
    $events  = $row->EventName;
    $date    = $row->EventDate;
    $admin   = $row->AdminName;
}

if(isset($_POST['eventJoin']))
{       
    $joinDate = date("Y-m-d");
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "INSERT INTO EventJoin (UserJoined, EventJoined, JoinDate) VALUES (?, ? , ?)";
    $stm = $con->prepare($sql);
    $stm->bind_param('sss', $name, $events,$joinDate);
    $stm->execute();

    if ($stm->affected_rows > 0)
                    {
                        
                        printf("
                            <script>
                            alert('Event Joined!');
                            window.location.href='eventDescription.php?name=%s&events=%s';
                            </script>",$name,$events);

                    }
                    else
                    {
                        printf("
                            <script>
                            alert('Opps, unknown error cause failed to join this event!');
                            window.location.href='eventDescription.php?name=%s&events=%s';
                            </script>",$name,$events);
                    }
                    
                    $stm->close();
                    $con->close();
}else if (isset($_POST['eventLeave']))
{


    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $sqlDelete = 'DELETE FROM EventJoin WHERE UserJoined = ? AND EventJoined = ?';
    $stm = $con->prepare($sqlDelete);
    $stm->bind_param('ss', $name,$events);
    $stm->execute();
    if ($stm->affected_rows > 0)
        {
            printf("
                            <script>
                            alert('Event Leaved!');
                            window.location.href='eventDescription.php?name=%s&events=%s';
                            </script>",$name,$events);
        }
    else{
        printf("
                            <script>
                            alert('Opps, unknown error cause failed to leave this event!');
                            window.location.href='eventDescription.php?name=%s&events=%s';
                            </script>",$name,$events);
    }

}
include('includes/footerUser.php');
?>