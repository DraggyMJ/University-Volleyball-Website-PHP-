<link rel="stylesheet" type="text/css" href="css/login.css" />
<link href="css/background.css" rel="stylesheet" />
<style>
    a.login {
    margin-left: 84%;
    transition: 0.2s background-color;
    color: blue;
}
</style>
<body id="top">
    <div class="logo"><a href="home.php"><img src="images/Tarumt_Volleyball_Logo.png" class="header"/></a></div>
    <div class="form">
        <h1>Admin Login</h1>

        <?php
        require_once('includes/helper.php');
        
        if (!empty($_POST))
        {
            
            $name    = trim($_POST['name']);
            $pass = trim($_POST['pass']);

            
            $error['name']    = validateAdminUserName($name);
            $error['confirm']  = validateAdminPassword($pass);
            
            
            $error = array_filter($error); 
            
            if (empty($error)) // If no error.
            {            
                printf("
                    <script>
                    alert('Login success. Welcome to TARUMT Volleyball club!');
                    window.location.href='adminInfo.php?name=%s';
                    </script>
                        ",$name);
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
            <table cellpadding="5" cellspacing="0">
                <tr>
                    <td>
                        <?php htmlInputText('name', isset($name) ? $name : "" , 30, 'Enter Username') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php htmlInputPassword('pass', isset($pass) ? $pass : "" , 50, 'Enter Password') ?>
                    </td>
                </tr>
            </table>

            <input type="submit" name="insert" value="Login" />
            <input type="button" value="Back" onclick="location='home.php'" />
            <a  class="register" href="signup.php">Register</a>
            <a  class="adminlogin" href="login.php">Login</a>
            <div class="error">
                <h4 class="userEmpty">Username Cannot Be Empty!</h4>
                <h4 class="userMore">Username Cannot more than 30 words!</h4>
                <h4 class="userInvalid">Invalid Username!</h4>

                <h4 class="passwordEmpty">Password Cannot Be Empty!</h4>
                <h4 class="passwordMore">Password must not more than 50 words!</h4>
                <h4 class="passwordSame">Wrong Password!</h4>
            </div>
        </form>
    </div>
</body>

<?php
include('includes/footer.php');
?>