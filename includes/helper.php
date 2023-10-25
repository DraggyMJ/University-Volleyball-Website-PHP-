<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'assignment');


//input
function htmlInputFile()
{
    printf('<input type="file" name="image" id="image" value="image"/>',
            );
}
function htmlInputDesc($name, $value = '', $maxlength = '',$label = '',$desc = '')
{
    printf('<textarea name="%s" id="%s" value="%s" maxlength="%s" placeholder="%s" class="desc" id="desc"/>%s</textarea>' . "\n",
           $name, $name, $value, $maxlength,$label,$desc);
}
function htmlInputText($name, $value = '', $maxlength = '',$label = '')
{
    printf('<input type="text" name="%s" id="%s" value="%s" maxlength="%s" placeholder="%s" class="text username" id="username"/>' . "\n",
           $name, $name, $value, $maxlength,$label);
}
function htmlInputEmail($name, $value = '', $maxlength = '',$label = '')
{
    printf('<input type="text" name="%s" id="%s" value="%s" maxlength="%s" placeholder="%s" class="text email" id="username"/>' . "\n",
           $name, $name, $value, $maxlength,$label);
}
function htmlInputPhone($name, $value = '', $maxlength = '',$label = '')
{
    printf('<input type="text" name="%s" id="%s" value="%s" maxlength="%s" placeholder="%s" class="text phone" id="username"/>' . "\n",
           $name, $name, $value, $maxlength,$label);
}
function htmlInputPassword($name, $value = '', $maxlength = '',$label = '')
{
    printf('<input type="password" name="%s" id="%s" value="%s" maxlength="%s" placeholder="%s" class="text pass" id="pass"/> <label class="visibility"><input type="checkbox" onclick="visibilityPassword()">Show Password</label>'. "\n",
           $name, $name, $value, $maxlength,$label);
}
function htmlInputConfirmPassword($name, $value = '', $maxlength = '',$label = '')
{
    printf('<input type="password" name="%s" id="%s" value="%s" maxlength="%s" placeholder="%s" class="text confirm" id="confirm"/> <label class="visibility"><input type="checkbox" onclick="visibilityConfirmPassword()">Show Password</label>'. "\n",
           $name, $name, $value, $maxlength,$label);
}
function htmlInputHidden($name, $value = '',$label = '')
{
    printf('<input type="hidden" name="%s" id="%s" value="%s" placeholder="%s" class="text"/>' . "\n",
           $name, $name, $value,$label);
}
function htmlRadioList($name, $items, $selectedValue = '', $break = false)
{
    foreach ($items as $value => $text)
    {
        printf('
            <input type="radio" name="%s" id="%s" value="%s" %s />
            <label for="%s" class="genderRadio">%s</label>' . "\n",
            $name, $value, $value,
            $value == $selectedValue ? 'checked="checked"' : '',
            $value, $text);

        if ($break)
            echo "<br />\n";
    }
}
function htmlDate($name, $value = '')
{
    printf('<input type="date" id="%s" name="%s" value="%s" class="text date" />',$name,$name,$value);
}


//validate
function validateUserName($name) //register
{
    if ($name == null)
    {
        
        return '<style>
                div.form input.username {
                border: 3px solid red;
                }
                div.form input.username::placeholder {
                    color: red;
                }
                div.error h4.userEmpty {
                    display: block;
                }
                </style>
                '; 
    }
    else if (strlen($name) > 30) // Prevent hacks.
    {
        return '<style>
                div.form input.username {
                border: 3px solid red;
                }
                div.form input.username::placeholder {
                    color: red;
                }
                div.error h4.userMore {
                    display: block;
                }
                </style>
                ';

    }
    else if (!preg_match('/^[A-Za-z @,\'\.\-\/]+$/', $name))
    {
        return '<style>
                div.form input.username {
                border: 3px solid red;
                }
                div.form input.username::placeholder {
                    color: red;
                }
                div.error h4.userInvalid {
                    display: block;
                }
                </style>
                ';
    }
    else if (isUserNameExist($name))
    {
        return '<style>
                div.form input.username {
                border: 3px solid red;
                }
                div.form input.username::placeholder {
                    color: red;
                }
                div.error h4.userExist {
                    display: block;
                }
                </style>
                ';
    }
}


function isUserNameExist($name)
{
    $exist = false;
    
    
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    
    
    $name  = $con->real_escape_string($name);
    
   
    $sql = "SELECT * FROM Users WHERE UserName = '$name'";


    if ($result = $con->query($sql))
    {
        
        if ($result->num_rows> 0)
        {
            $exist = true;
        }
    }
    $result->free();
    $con->close();

    return $exist;
}

function validatePassword($confirm,$pass)//register
{
    if ($pass == null)
    {
        return '<style>
                div.form input.pass {
                border: 3px solid red;
                }
                div.form input.pass::placeholder {
                    color: red;
                }
                div.error h4.passwordEmpty {
                    display: block;
                }
                </style>
                ';
    }
    if (strcmp($confirm,$pass) != 0)
    {
        return '<style>
                div.form input.confirm {
                border: 3px solid red;
                }
                div.form input.pass::placeholder {
                    color: red;
                }
                div.error h4.passwordSame{
                    display: block;
                }
                </style>
                ';
    }
    else if (strlen($pass) > 50)
    {
        return '<style>
                div.form input.pass {
                border: 3px solid red;
                }
                div.form input.pass::placeholder {
                    color: red;
                }
                div.error h4.passwordMore{
                    display: block;
                }
                </style>
                ';
    }
}

function validateLoginUserName($name)//login
{
    if ($name == null)
    {
        return '<style>
                div.form input.username {
                border: 3px solid red;
                }
                div.form input.username::placeholder {
                    color: red;
                }
                div.error h4.userEmpty {
                    display: block;
                }
                </style>
                '; 
    }
    else if (strlen($name) > 30) // Prevent hacks.
    {
        return '<style>
                div.form input.username {
                border: 3px solid red;
                }
                div.form input.username::placeholder {
                    color: red;
                }
                div.error h4.userMore {
                    display: block;
                }
                </style>
                '; 
    }
    else if (loginUserNameExist($name))
    {
        return '<style>
                div.form input.username {
                border: 3px solid red;
                }
                div.form input.username::placeholder {
                    color: red;
                }
                div.error h4.userInvalid {
                    display: block;
                }
                </style>
                ';
    }
}

function loginUserNameExist($name)
{
    $exist = true;
    
    
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    
    
    $name  = $con->real_escape_string($name);
    
   
    $sql = "SELECT * FROM Users WHERE UserName = '$name'";


    if ($result = $con->query($sql))
    {
        
        if ($result->num_rows> 0)
        {
            $exist = false;
        }
    }
    $result->free();
    $con->close();

    return $exist;
}

function validateLoginPassword($pass)//login
{
    if ($pass == null)
    {
        return '<style>
                div.form input.pass {
                border: 3px solid red;
                }
                div.form input.pass::placeholder {
                    color: red;
                }
                div.error h4.passwordEmpty {
                    display: block;
                }
                </style>
                ';
    }
    else if (strlen($pass) > 50) // Prevent hacks.
    {
        return '<style>
                div.form input.pass {
                border: 3px solid red;
                }
                div.form input.pass::placeholder {
                    color: red;
                }
                div.error h4.passwordMore {
                    display: block;
                }
                </style>
                ';
    }
    else if (loginPasswordExist($pass))
    {
        return '<style>
                div.form input.pass {
                border: 3px solid red;
                }
                div.form input.pass::placeholder {
                    color: red;
                }
                div.error h4.passwordSame {
                    display: block;
                }
                </style>
                ';
    }
}

function loginPasswordExist($pass)
{
    $exist = true;
    
    
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    
    
    $pass  = $con->real_escape_string($pass);
    
   
    $sql = "SELECT * FROM Users WHERE Pass = '$pass'";


    if ($result = $con->query($sql))
    {
        
        if ($result->num_rows> 0)
        {
            $exist = false;
        }
    }
    $result->free();
    $con->close();

    return $exist;
}


function validateGender($gender)//edit gender
{
    if ($gender == null)
    {
        return '<style>
                .genderRadio {
                    color:red;
                }
                div.error h4.genderEmpty {
                    display: block;
                }
                </style>
                ';
    }
    else if (!array_key_exists($gender, getGenders())) // Prevent hacks.
    {
        return '<style>
                div.error h4.genderInvalid {
                    display: block;
                }
                </style>
                ';
    }
}

function validateEditPassword($pass)//edit password
{
    if ($pass == null)
    {
        return '<style>
                div.table input.pass {
                border: 3px solid red;
                }
                div.table input.pass::placeholder {
                    color: red;
                }
                div.error h4.passwordEmpty {
                    display: block;
                }
                </style>
                ';
    }else if (strlen($pass) > 50)
    {
        return '<style>
                div.table input.pass {
                border: 3px solid red;
                }
                div.table input.pass::placeholder {
                    color: red;
                }
                div.error h4.passwordMore{
                    display: block;
                }
                </style>
                ';
    }
}

function validateBirthday($birth)//edit birthday
{
    if ($birth == NULL){
        return '<style>
                div.table input.date {
                border: 3px solid red;
                }
                div.error h4.birthdayEmpty {
                    display: block;
                }
                </style>
                ';
    }
    else if (DateInvalid($birth))
    {
        return '<style>
                div.table input.date {
                border: 3px solid red;
                }
                div.error h4.birthdayInvalid {
                    display: block;
                }
                </style>
                ';
    }
    else if ($birth < date("1923"))
    {
        return '<style>
                div.table input.date {
                border: 3px solid red;
                }
                div.error h4.birthdayInvalid {
                    display: block;
                }
                </style>
                ';
    }
    else if ($birth > date("2005"))
    {
        return '<style>
                div.table input.date {
                border: 3px solid red;
                }
                div.error h4.birthdayLow {
                    display: block;
                }
                </style>
                ';
    }
}

function DateInvalid($birth)
{
    $exist = true;

    $yearCurr = date("Y");
    $yearInput = $birth;

    if ($yearCurr >= $yearInput)
    {
        $exist = false;
    }

    return $exist;
}

function validateEmail($email)//edit email
{
    if (strlen($email) > 20)
    {
        return '<style>
                div.table input.email {
                border: 3px solid red;
                }
                div.error h4.emailMore {
                    display: block;
                }
                </style>
                ';
    }else if (!preg_match("/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/", $email ) && $email != NULL)
    {
        return '<style>
                div.table input.email {
                border: 3px solid red;
                }
                div.error h4.emailFormat {
                    display: block;
                }
                </style>
                ';
    }
}

function validatePhone($phone)
{
    if (strlen($phone) > 10)
    {
        return '<style>
                div.table input.phone {
                border: 3px solid red;
                }
                div.error h4.phoneMore {
                    display: block;
                }
                </style>
                ';
    }else if (!preg_match('/01[0-9]{8}/', $phone) && $phone != NULL)
    {
        return '<style>
                div.table input.phone {
                border: 3px solid red;
                }
                div.error h4.phoneFormat {
                    display: block;
                }
                </style>
                ';
    }
}

function validateAdminUserName($name)//login
{
    if ($name == null)
    {
        return '<style>
                div.form input.username {
                border: 3px solid red;
                }
                div.form input.username::placeholder {
                    color: red;
                }
                div.error h4.userEmpty {
                    display: block;
                }
                </style>
                '; 
    }
    else if (strlen($name) > 30) // Prevent hacks.
    {
        return '<style>
                div.form input.username {
                border: 3px solid red;
                }
                div.form input.username::placeholder {
                    color: red;
                }
                div.error h4.userMore {
                    display: block;
                }
                </style>
                '; 
    }
    else if (adminUserNameExist($name))
    {
        return '<style>
                div.form input.username {
                border: 3px solid red;
                }
                div.form input.username::placeholder {
                    color: red;
                }
                div.error h4.userInvalid {
                    display: block;
                }
                </style>
                ';
    }
}

function adminUserNameExist($name)
{
    $exist = true;
    
    
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    
    
    $name  = $con->real_escape_string($name);
    
   
    $sql = "SELECT * FROM Admin WHERE AdminName = '$name'";


    if ($result = $con->query($sql))
    {
        
        if ($result->num_rows> 0)
        {
            $exist = false;
        }
    }
    $result->free();
    $con->close();

    return $exist;
}

function validateAdminPassword($pass)//admin
{
    if ($pass == null)
    {
        return '<style>
                div.form input.pass {
                border: 3px solid red;
                }
                div.form input.pass::placeholder {
                    color: red;
                }
                div.error h4.passwordEmpty {
                    display: block;
                }
                </style>
                ';
    }
    else if (strlen($pass) > 50) // Prevent hacks.
    {
        return '<style>
                div.form input.pass {
                border: 3px solid red;
                }
                div.form input.pass::placeholder {
                    color: red;
                }
                div.error h4.passwordMore {
                    display: block;
                }
                </style>
                ';
    }
    else if (adminPasswordExist($pass))
    {
        return '<style>
                div.form input.pass {
                border: 3px solid red;
                }
                div.form input.pass::placeholder {
                    color: red;
                }
                div.error h4.passwordSame {
                    display: block;
                }
                </style>
                ';
    }
}

function adminPasswordExist($pass)
{
    $exist = true;
    
    
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    
    
    $pass  = $con->real_escape_string($pass);
    
   
    $sql = "SELECT * FROM Admin WHERE AdminPass = '$pass'";


    if ($result = $con->query($sql))
    {
        
        if ($result->num_rows> 0)
        {
            $exist = false;
        }
    }
    $result->free();
    $con->close();

    return $exist;
}

function validateEventName($events)
{
    if ($events == null)
    {
        return '<style>
                div.table input.username {
                border: 3px solid red;
                }
                div.table input.username::placeholder {
                    color: red;
                }
                div.error h4.nameEmpty {
                    display: block;
                }
                </style>
                ';
    }
    else if (eventExist($events))
    {
        return '<style>
                div.table input.username {
                border: 3px solid red;
                }
                div.table input.username::placeholder {
                    color: red;
                }
                div.error h4.nameExist {
                    display: block;
                }
                </style>
                ';
    }
    else if (strlen($events) > 50)
    {
        return '<style>
                div.table input.username {
                border: 3px solid red;
                }
                div.table input.username::placeholder {
                    color: red;
                }
                div.error h4.nameMore {
                    display: block;
                }
                </style>
                ';
    }
    else if (!preg_match('/^[A-Za-z,0-9 @,\'\.\-\/]+$/', $events))
    {
        return '<style>
                div.table input.username {
                border: 3px solid red;
                }
                div.table input.username::placeholder {
                    color: red;
                }
                div.error h4.nameInvalid {
                    display: block;
                }
                </style>
                ';
    }
}

function eventExist($events)
{
    $exist = false;
    
    
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        
   
    $sql = "SELECT * FROM events WHERE EventName = '$events'";


    if ($result = $con->query($sql))
    {
        
        if ($result->num_rows> 0)
        {
            $exist = true;
        }
    }
    $result->free();
    $con->close();

    return $exist;
}

function validateEventDate($date)
{
    if ($date == null)
    {
        return '<style>
                div.table input.date {
                border: 3px solid red;
                }
                div.error h4.dateEmpty {
                    display: block;
                }
                </style>
                ';
    }
    
    else if (checkYear($date))
    {
        return '<style>
            div.table input.date {
            border: 3px solid red;
            }
            div.error h4.dateYear {
                display: block;
            }
            </style>
            ';
    }
    else if (checkCurrYear($date))
    {
        if (checkMonth($date))
        {
            return '<style>
                div.table input.date {
                border: 3px solid red;
                }
                div.error h4.dateMonth {
                    display: block;
                }
                </style>
                ';
        }
        else if (checkCurrMonth($date))
        {
            if (checkDay($date))
            {
                return '<style>
                        div.table input.date {
                        border: 3px solid red;
                        }
                        div.error h4.dateDay {
                            display: block;
                        }
                        </style>
                        ';
            }
    }
    } 
}
function checkYear($date)
{
    $exist = true;

    $yearCurr = date("Y");

    $input = $date;

    if ($yearCurr <= $input && $input <= $yearCurr + 2)
    {
        $exist = false;
    }
    return $exist;
}
function checkCurrYear($date)
{
    $exist = true;

    $yearCurr = date("Y");

    if ($yearCurr[3] != $date[3])
    {
        $exist = false;
    }

    return $exist;
}
function checkMonth($date)
{
    $exist = true;

    $monthCurr = date("m");

    $x = (int)$date[5];

    if ($date[5] != '0')
    {
        $x = 10;
    }

    $y = (int)$date[6];

    $input = $x + $y;

    if ($monthCurr <= $input)
    {
        $exist = false;
    }

    return $exist;
}
function checkCurrMonth($date)
{
    $exist = true;

    $monthCurr = date("m");

    $x = (int)$date[5];

    if ($date[5] != '0')
    {
        $x = 10;
    }

    $y = (int)$date[6];

    $input = $x + $y;

    if ($monthCurr != $input)
    {
        $exist = false;
    }

    return $exist;
}
function checkDay($date)
{
    $exist = true;

    $dayCurr = date("d");


    $x = (int)$date[8];

    if ($date[8] != '0')
    {
        if ($date[8] == '1'){
        $x = 10;}
        else if ($date[8] == '2'){
        $x = 20;}
        else if ($date[8] == '3'){
        $x = 30;}
    }

    $y = (int)$date[9];

    $input = $x + $y;

    if ($dayCurr <= $input)
    {
        $exist = false;
    }

    return $exist;
}

function validateEditEventName($events,$events1)
{
    if ($events == null)
    {
        return '<style>
                div.table input.username {
                border: 3px solid red;
                }
                div.table input.username::placeholder {
                    color: red;
                }
                div.error h4.nameEmpty {
                    display: block;
                }
                </style>
                ';
    }
    else if (eventExist($events))
    {
        if (eventSame($events,$events1))
        {

        }
        else
        {
            return '<style>
                    div.table input.username {
                    border: 3px solid red;
                    }
                    div.table input.username::placeholder {
                        color: red;
                    }
                    div.error h4.nameExist {
                        display: block;
                    }
                    </style>
                    ';
        }
    }
    else if (strlen($events) > 50)
    {
        return '<style>
                div.table input.username {
                border: 3px solid red;
                }
                div.table input.username::placeholder {
                    color: red;
                }
                div.error h4.nameMore {
                    display: block;
                }
                </style>
                ';
    }
    else if (!preg_match('/^[A-Za-z,0-9 @,\'\.\-\/]+$/', $events))
    {
        return '<style>
                div.table input.username {
                border: 3px solid red;
                }
                div.table input.username::placeholder {
                    color: red;
                }
                div.error h4.nameInvalid {
                    display: block;
                }
                </style>
                ';
    }
}

function eventSame($events,$events1)
{
    $exist = false;
    
    if ($events == $events1)
    {
        $exist = true;
    }

    return $exist;
}

function validateFeedback($feedback)
{
    if ($feedback == NULL)
    {
        return '<style>
                div.feedback textarea.desc {
                border: 3px solid red;
                }
                div.error h4.feedbackEmpty {
                    display: block;
                }
                </style>
                ';
    }
    else if (strlen($feedback) > 500)
    {
        return '<style>
                div.feedback textarea.desc {
                border: 3px solid red;
                }
                div.error h4.feedbackMore {
                    display: block;
                }
                </style>
                ';
    }
}
?>


<script>
    function visibilityPassword() {
            var x = document.getElementById("pass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
    }
    function visibilityConfirmPassword() {
            var x = document.getElementById("confirm");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
    }
</script>