<link rel="stylesheet" type="text/css" href="css/signup.css" />
<link href="css/background.css" rel="stylesheet" />
<body id="top">
    <div class="logo"><a href="home.php"><img src="images/Tarumt_Volleyball_Logo.png" class="header"/></a></div>
    <div class="form">
        <h1>User Register</h1>

        <?php
        require_once('includes/helper.php');
        
        if (!empty($_POST))
        {
            
            $name    = trim($_POST['name']);
            $pass = trim($_POST['pass']);
            $confirm = trim($_POST['confirm']);

            
            $error['name']    = validateUserName($name);
            $error['confirm']  = validatePassword($confirm,$pass);
            
            
            $error = array_filter($error); 
            
            if (empty($error)) // If no error.
            {
                
                        
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
                
                $sql = 'INSERT INTO Users (UserName, Pass) VALUES (?,?)';
                
                
                $stm = $con->prepare($sql);
                
                
                $stm->bind_param("ss",$name,$pass);
                
                $stm->execute();
                
                if ($stm->affected_rows>0)
                {
                    printf("
                    <script>
                    alert('Register success. Welcome to TARUMT Volleyball club! Please remember to key in your information after register!');
                    window.location.href='userInfo.php?name=%s';
                    </script>",$name);

                
                }
                else
                {
                    printf("
                    <script>
                    alert('ERROR. Database issues');
                    </script>");
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
        <form action="" method="post">
            <table>
                <tr>
                    <td>
                        <?php 
                        htmlInputText('name', isset($name) ? $name : "" , 30, 'Enter New Username') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php htmlInputPassword('pass', isset($pass) ? $pass : "" , 50, 'Enter new Password') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php htmlInputConfirmPassword('confirm', isset($confirm) ? $confirm : "" , 50, 'Confirm Password') ?>
                    </td>
                </tr>
            </table>

            <input type="submit" name="insert" value="Register" />
            <input type="button" value="Back" onclick="location='home.php'" />
            <a  class="login" href="login.php">LOG IN</a>
            <div class="error">
                <h4 class="userEmpty">Username Cannot Be Empty!</h4>
                <h4 class="userMore">Username Cannot more than 30 words!</h4>
                <h4 class="userInvalid">Username Cannot use Invalid Character!</h4>
                <h4 class="userExist">Username is already Exist!</h4>

                <h4 class="passwordEmpty">Password Cannot Be Empty!</h4>
                <h4 class="passwordSame">Password and Confirm Password are not same!</h4>
                <h4 class="passwordMore">Password must not more than 50 words!</h4>
            </div>
        </form>
    </div>
</body>

<?php
include('includes/footer.php');
?>