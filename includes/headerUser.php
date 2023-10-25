<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!-- Start of header -->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=8" />
        
        <title>TARUMT VolleyBall</title>
        <link href="css/background.css" rel="stylesheet" />
    </head>
    <script>
        function logout(){
            if (confirm("Are you sure you want to Log out?")==1){
                    alert("Log out successfully!!!");
                    window.location.href = 'home.php';
                    return true;
                }
        }
    </script>
    <header id="top" class="user">
     <?php 
            require_once('includes/helper.php');
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["name"])){
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
                else
                {
                    // printf("
                    // <script>
                    // window.location.href='https://www.youtube.com/watch?v=xvFZjo5PgG0';
                    // </script>
                    //     ");
                    printf("
                    <script>
                    window.location.href='home1.php';
                    </script>
                    ");
            }
        }
            else if(isset($_POST['name'])){
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
                else
                {
                    // printf("
                    // <script>
                    // window.location.href='https://www.youtube.com/watch?v=xvFZjo5PgG0';
                    // </script>
                    //     ");
                    printf("
                    <script>
                    window.location.href='home1.php';
                    </script>
                    ");
                    
            }

                $result->free();
                $con->close();
        }else{
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["name"])){
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
                else
                {
                    // printf("
                    // <script>
                    // window.location.href='https://www.youtube.com/watch?v=xvFZjo5PgG0';
                    // </script>
                    //     ");
                    printf("
                    <script>
                    window.location.href='home1.php';
                    </script>
                    ");
            }
        }
            else if(isset($_POST['name'])){
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
                else if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET["name"]))
                {
                    // printf("
                    // <script>
                    // window.location.href='https://www.youtube.com/watch?v=xvFZjo5PgG0';
                    // </script>
                    //     ");
                    printf("
                    <script>
                    window.location.href='home1.php';
                    </script>
                    ");
                    
            }

                $result->free();
                $con->close();
            }else if($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET["name"])){
                printf("
                <script>
                window.location.href='home1.php';
                </script>
                ");
            
            }
        }

            printf('<a href="homeUser.php?name=%s"><img src="images/Tarumt_Volleyball_Logo.png" class="header"/></a>',$name);
            printf('<nav>
                        <ul id="headNavi">
                            <li><a href="userInfo.php?name=%s">&nbsp;INFO&nbsp;</a></li>
                            <li><a onclick="logout()">&nbsp;LOG OUT&nbsp;</a></li>
                            <li><a href="homeUser.php?name=%s">&nbsp;HOME&nbsp;</a></li>
                            <li><a href="event.php?name=%s">&nbsp;EVENT&nbsp;</a></li>
                            <li><a href="about_us.php?name=%s">&nbsp;ABOUT US&nbsp;</a></li>
                            <li><a href="feedback.php?name=%s">&nbsp;FEEDBACK&nbsp;</a></li>
                        </ul>
                    </nav>',$name,$name,$name,$name,$name);
    ?>
    </header>
<!-- End of header -->
