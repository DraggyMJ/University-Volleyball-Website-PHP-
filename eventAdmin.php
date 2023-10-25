<link rel="stylesheet" type="text/css" href="css/events.css" />
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
<div class="banner">
<img src="images/events.png" alt="event" class="image"/>
<div class="title"><h2>Looking for Competitions/Campaigns ?</h2></div>
</div>

<div class="table">
<table class="event" cellpadding="5" cellspacing="0">

    <tr>
        <th colspan="4" class="design">Upcoming Events</th>
    </tr>

<?php
require_once 'includes/helper.php';

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

            $sql = "DELETE FROM Events WHERE EventName IN ('" . implode("','",$escaped) . "')";
            
            if ($con->query($sql))
            {
                printf("
                    <script>
                    alert('Event(s) has been deleted!');
                    window.location.href='eventAdmin.php?name=%s';
                    </script>",$name);
                $con->affected_rows;
            }

            $con->close();
        }
    }
else if(isset($_POST['searchInput']))
    {
    
    $search = $_POST['searchInput'];
    printf("<script>
            window.location.href='?name=%s&searchInput=%s';
            </script>",$name,$search);  
    
    }else if (!isset($_POST['searchInput']))
    {
        $search = '';
    }


$headers = array(
    "EventDate" => "Dates",
    "EventName" => "Event",
    "AdminName" => "Created By",
);

$sort    = isset($_GET['sort']) ? 
(array_key_exists($_GET['sort'], $headers) ? $_GET['sort'] : "EventDate") 
:
"EventDate";
$order   = isset($_GET["order"]) ? $_GET["order"] : "ASC";



$search1 = isset($_GET['searchInput']) ? $_GET['searchInput'] : '';


echo '<tr>';
echo '<th colspan=4>';
echo '<form id="searchForm" action="" method="POST">';
printf (' <input type="text" id="searchInput" name="searchInput" placeholder="Search Event Name..."  value="%s" class="search">',$search1);
echo '</form>';
echo '</th>';
echo '</tr>';
echo '<tr>';
echo '<th> </th>';
    foreach ($headers as $key => $value)
    {
        
        if ($key == $sort)
        {
            printf('
                <th>
                <a href="?name=%s&sort=%s&order=%s&searchInput=%s" class="order">%s</a>
                <img src="images/%s.png" alt="%s" />
                </th>             
              ',$name ,$key, $order=='DESC' ? 'ASC' : 'DESC' 
                ,$search1,$value
               , $order=='DESC' ? 'ASC' : 'DESC'
               ,$order=='DESC' ? 'ASC' : 'DESC');
            
        }
        else 
        {
            printf('
                <th>
                <a href="?name=%s&sort=%s&order=%s&searchInput=%s" class="order">%s</a>
                </th>                 
                ',$name,$key,'ASC',$search1,$value);
            
        }
    }
    echo '</tr>';



echo '<form id="deleteBox" action="" method="post">';
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$sql = "SELECT * FROM events WHERE EventName LIKE '%" . $search1 . "%' ORDER BY $sort $order;";
if($result = $conn->query($sql)){

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
            <td>%s  [<a class="eventLink" href="eventEdit.php?name=%s&events=%s">Edit</a>] | [<a class="eventLink" href="eventDelete.php?name=%s&events=%s">Delete</a>] | [<a class="eventLink" href="eventDescriptionAdmin.php?name=%s&events=%s">Description</a>]</td>
            <td>%s</td>
            </tr>',
            $row->EventName,
            $row->EventDate,
            $row->EventName,
            $name,
            $row->EventName,
            $name,
            $row->EventName,
            $name,
            $row->EventName,
            $row->AdminName,);
    }
}

printf('
    <tr>
    <td colspan="4">
        %d event(s) recorded.
        [ <a class="eventLink" href="eventAdd.php?name=%s">Add new Event</a> ] |
        [<input type="submit" name="delete" value="Delete Checked Event" class="deleteBox"
           onclick=\'return confirm("This will delete all checked Event records.\nAre you sure?")\' />]
        
    </td>
    </tr>',
    $result->num_rows, $name);
echo '</form>';

$result->free();
$conn->close();
}
?>
</table>

</div>
<?php
include('includes/footerAdmin.php');
?>