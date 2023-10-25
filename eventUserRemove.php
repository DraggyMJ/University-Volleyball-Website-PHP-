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

<div class="title4">
    <h1>Remove participant</h1>
</div>
<div>
    <?php
    require_once('includes/helper.php');

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["events"]))
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["eventuser"]))
        {
            $events = $_GET["events"];
            $eventUser =  $_GET["eventuser"];

            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);       
            $sql = "SELECT * FROM EventJoin WHERE EventJoined = '$events' AND UserJoined = '$eventUser'";

            $result = $con->query($sql);
            if ($row = $result->fetch_object())
            {
                
                $EventJoined     = $row->EventJoined;
                $UserJoined      = $row->UserJoined;
                $joinDate        = $row->JoinDate;
                
                printf('
                <div class="table">
                <table cellpadding="5" cellspacing="0" class="delete">
                <tr>
                    <td class="small_title a"><label for="name">Participant :</label></td>
                    <td class="b">
                    %s
                    </td>
                </tr>
                <tr>
                    <td class="small_title"><label for="events">Event :</label></td>
                    <td >
                    %s
                    </td>
                </tr>
                <tr>
                    <td class="small_title"><label for="date">Join Date :</label></td>
                    <td>
                    %s
                    </td>
                </tr>
                </table>
                <form action="" method="post">
                            <input type="hidden" name="events" value="%s" />
                            <input type="hidden" name="UserJoin" value="%s" />
                            <input type="submit" name="remove" value="Delete"/>
                            <input type="button" value="Back"
                                onclick="location=\'eventDescriptionAdmin.php?name=%s&events=%s\'" />
                        </form>
                </div>
                ',$UserJoined, $EventJoined , $joinDate , $EventJoined, $UserJoined, $name, $EventJoined);
                
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
        
    }
   
    else if(isset($_POST['remove']))
    {
        $events  = trim($_POST['events']);
        $eventUser =trim($_POST["UserJoin"]);

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        $sql = 'DELETE FROM Eventjoin WHERE EventJoined = ? AND UserJoined = ?';

        $stm = $con->prepare($sql);
        $stm->bind_param('ss', $events,$eventUser);
        $stm->execute();
        if ($stm->affected_rows > 0)
        {
            printf("
                    <script>
                    alert('Participant has been removed!');
                    window.location.href='eventDescriptionAdmin.php?name=%s&events=%s';
                    </script>",$name, $events);
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
                    alert('Oops, Please provide Participant name!');
                    window.location.href='eventDescriptionAdmin.php?name=%s&events=%s';
                    </script>",$name, $events);
    }
    ?>
</div>

<?php include('includes/footerAdmin.php'); ?>