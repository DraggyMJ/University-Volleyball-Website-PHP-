<link rel="stylesheet" type="text/css" href="css/infoEdit.css" />
<link href="css/background.css" rel="stylesheet" />
<?php
include('includes/headerUser.php');
require_once('includes/helper.php');
$GENDERS = getGenders();
function getGenders()
{
    return array(
        'F' => 'Female',
        'M' => 'Male'
    );
}

if(isset($_POST["update"]))
    {
        $pass   = trim($_POST['pass']);
        $gender  = isset($_POST['gender']) ? trim($_POST['gender']) : null;
        $birth  = trim($_POST['birth']);
        $email  = trim($_POST['email']);
        $phone  = trim($_POST['phone']);

        $error['pass']  =  validateEditPassword($pass);
        $error['gender']  = validateGender($gender);
        $error['birthday'] = validateBirthday($birth);
        $error['email'] = validateEmail($email);
        $error['phone'] = validatePhone($phone);

        $error = array_filter($error); 

        if (empty($error))
        {
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            $intbirth = (int)$birth;
                $currdate = date("Y");
                $age = $currdate - $intbirth;

            $sql = "UPDATE Users 
                    SET Pass = ?, Gender = ?, Birth = ?, Age = ?, Email = ?, Phone = ?
                    WHERE UserName = '$name'
                    ";
            $stm = $con->prepare($sql);
            $stm->bind_param('sssdss', $pass, $gender, $birth, $age, $email,$phone);

            if($stm->execute())
            {
                printf("
                    <script>
                    alert('Edit success!');
                    window.location.href='userInfo.php?name=%s';
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
                        <?php htmlInputHidden('name', $name)?>
                    </td>
                </tr>
                <tr>
                    <td class="small_title"><label for="pass">Password* :</label></td>
                    <td>
                        <?php htmlInputPassword('pass', isset($pass) ? $pass : "" , 50, 'Enter new Password') ?>
                    </td>
                </tr>
                <tr>
                <tr>
                    <td class="small_title">Gender* :</td>
                    <td>
                        <?php htmlRadioList('gender', $GENDERS, $gender) ?>
                    </td>
                </tr>
                <tr>
                    <td class="small_title">Birthday* :</td>
                    <td>
                        <?php htmlDate('birth', isset($birth) ? $birth : "") ?>
                    </td>
                </tr>
                <tr>
                    <td class="small_title">Email :</td>
                    <td>
                    <?php htmlInputEmail('email', isset($email) ? $email : "" , 20, 'Enter Email Address') ?>
                    </td>
                </tr>
                <tr>
                    <td class="small_title">Phone Number :</td>
                    <td>
                        <?php htmlInputPhone('phone', isset($phone) ? $phone : "" , 10, 'Enter Phone number (number only)') ?>
                    </td>
                </tr>
            </table>
            <br />
            <input type="submit" name="update" value="Update" class="user"/>
            <input type="button" value="Back" onclick="location='userInfo.php?name=<?php printf('%s',$name)?>'" class="user"/>
            <div class="error">
                    <h4 class="passwordEmpty">Password Cannot Be Empty!</h4>
                    <h4 class="passwordMore">Password must not more than 50 words!</h4>

                    <h4 class="genderEmpty">Gender cannot be Empty!</h4>
                    <h4 class="genderInvalid">Invalid Gender!</h4>

                    <h4 class="birthdayEmpty">Birthday cannot be Empty!</h4>
                    <h4 class="birthdayInvalid">Invalid date!</h4>
                    <h4 class="birthdayLow">Age too low!</h4>

                    <h4 class="emailMore">Email must not more than 20 words!</h4>
                    <h4 class="emailFormat">Email wrong format!</h4>

                    <h4 class="phoneMore">Phone number must not more than 10 words!</h4>
                    <h4 class="phoneFormat">Phone number wrong format(start in "01" and number only)!</h4>
            </div>
        </form>
</div>
</body>

<?php
include('includes/footerUser.php');
?>