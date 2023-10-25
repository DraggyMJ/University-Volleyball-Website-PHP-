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
include('includes/headerUser.php');
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

$headers = array(
    "EventDate" => "Dates",
    "EventName" => "Event",
);

$sort    = isset($_GET['sort']) ? 
(array_key_exists($_GET['sort'], $headers) ? $_GET['sort'] : "EventDate") 
:
"EventDate";
$order   = isset($_GET["order"]) ? $_GET["order"] : "ASC";

if(isset($_POST['searchInput']))
{
$search = $_POST["searchInput"];
printf("<script>
        window.location.href='?name=%s&searchInput=%s';
        </script>",$name,$search);  

}else
{
    $search = '';
}


$search1 = isset($_GET['searchInput']) ? $_GET['searchInput'] : '';

echo '<tr>';
echo '<th colspan=4>';
echo '<form id="searchForm" action="" method="POST">';
printf (' <input type="text" id="searchInput" name="searchInput" placeholder="Search Event Name..."  value="%s" class="search1">',$search1);
echo '</form>';
echo '</th>';
echo '</tr>';
echo '<tr>';
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


$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

if ($conn->connect_error){
    die("Connection Failed: ". $conn->connect_error);
}

$sql = "SELECT * FROM events WHERE EventName LIKE '%" . $search1 . "%' ORDER BY $sort $order";

$result = $conn->query($sql);


if ($result->num_rows > 0)
{
    while ($row = $result->fetch_object())
    {
        printf('
            <tr>
            <td>%s</td>
            <td>%s [<a class="eventLink" href="eventDescription.php?name=%s&events=%s">Description</a>]</td>
            </tr>',
            $row->EventDate,
            $row->EventName,
            $name,
            $row->EventName,);
    }
}

?>

</table>
</div>

</table>

<?php
include('includes/footerUser.php');
?>
