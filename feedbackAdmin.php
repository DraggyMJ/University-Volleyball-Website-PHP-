<link rel="stylesheet" type="text/css" href="css/userDetail.css" />
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


<div class="table">

<table class="event" cellpadding="5" cellspacing="0">
    <tr>
        <th colspan="4" class="design">Users Feedback</th>
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

            $sql = "DELETE FROM Feedback WHERE Feedback IN ('" . implode("','",$escaped) . "')";
            
            if ($con->query($sql))
            {
                printf("
                    <script>
                    alert('Event(s) has been deleted!');
                    window.location.href='feedbackAdmin.php?name=%s';
                    </script>",$name);
                $con->affected_rows;
            }

            $con->close();
        }
    }


$headers = array(
    "UserName" => "User Name",
    "FeedBack" => "Feedback",
    "FeedBackDate" => "Feedback Date",
);

$sort    = isset($_GET['sort']) ? 
(array_key_exists($_GET['sort'], $headers) ? $_GET['sort'] : "UserName") 
:
"UserName";
$order   = isset($_GET["order"]) ? $_GET["order"] : "ASC";


if(isset($_POST['searchInput']))
{

$search = $_POST['searchInput'];
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
printf (' <input type="text" id="searchInput" name="searchInput" placeholder="Search User Name..."  value="%s" class="search">',$search1);
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



echo '<form action="" method="post">';
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$sql = "SELECT * FROM Feedback WHERE UserName LIKE '%" . $search1 . "%' ORDER BY $sort $order;";
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
            <td>%s</td>
            <td>%s</td>
            </tr>',
            $row->Feedback,
            $row->UserName,
            $row->Feedback,
            $row->FeedbackDate,);
    }
}


printf('
    <tr>
    <td colspan="4">
        %d Feedback(s) recorded.
        [<input type="submit" name="delete" value="Delete Checked Feedback" class="deleteBox"
           onclick=\'return confirm("This will delete all checked Feedback records.\nAre you sure?")\' />]
        
    </td>
    </tr>',
    $result->num_rows);
echo '</form>';

$result->free();
$conn->close();
}
?>
</table>
<?php
include('includes/footerAdmin.php');
?>