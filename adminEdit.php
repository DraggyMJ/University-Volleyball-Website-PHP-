<link rel="stylesheet" type="text/css" href="css/infoEdit.css" />
<link href="css/background.css" rel="stylesheet" />
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
if(isset($_POST["update"]))
    {
        $pass   = trim($_POST['pass']);
        $error['pass']  =  validateEditPassword($pass);


        $error = array_filter($error); 

        if (empty($error))
        {
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            $sql = "UPDATE Admin 
                    SET AdminPass = ?
                    WHERE AdminName = '$name'
                    ";
            $stm = $con->prepare($sql);
            $stm->bind_param('s', $pass);

            if($stm->execute())
            {

                printf("
                    <script>
                    alert('Edit success!');
                    window.location.href='adminInfo.php?name=%s';
                    </script>
                        ",$name);
            }
            else
            {
                echo '
                    <div class="error">
                    Opps. Database issue. Record not updated.
                    </div>
                    ';
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
    }
?>

<body>
<div class="title">
    <h1>Edit Information</h1>
</div>
<div class="table">
        <form action="" method="post">
            <table>
                <tr>
                    <td class="small_title"><label for="name">Username :</label></td>
                    <td>
                        <?php echo $name ?>
                    </td>
                </tr>
                <tr>
                    <td class="small_title"><label for="pass">Password* :</label></td>
                    <td>
                        <?php htmlInputPassword('pass', isset($pass) ? $pass : "" , 50, 'Enter new Password') ?>
                    </td>
                </tr>
            </table>
            <br />
            <input type="submit" name="update" value="Update" class="admin" />
            <input type="button" value="Back" onclick="location='adminInfo.php?name=<?php printf('%s',$name)?>'" class="admin"/>
            <div class="error">
                    <h4 class="passwordEmpty">Password Cannot Be Empty!</h4>
                    <h4 class="passwordMore">Password must not more than 50 words!</h4>

            </div>
        </form>
</div>
</body>

<?php
include('includes/footerAdmin.php');
?>