<link rel="stylesheet" type="text/css" href="css/feedback.css" />
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

<?php 
require_once('includes/helper.php');
if(isset($_POST['Submitfeedback'])){
    $feedback = isset($_POST['feedback']) ? trim($_POST['feedback']) : NULL;
    $date = date('Y-m-d');

    $error['feedback']  = validateFeedback($feedback);

    $error = array_filter($error);

    if (empty($error))
    {
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "INSERT INTO Feedback (UserName, Feedback, FeedbackDate) VALUES (?, ?, ?)";
            $stm = $con->prepare($sql);
            $stm->bind_param('sss', $name, $feedback, $date);
            $stm->execute();

            if ($stm->affected_rows > 0)
            {
                printf("
                    <script>
                    alert('Thank you for your feedback!');
                    window.location.href='homeUser.php?name=%s';
                    </script>",$name);
            }
    }else
    {
        foreach ($error as $value)
        {
            echo $value;
        }
    }
}
?>

<div class="title">
<h1>FEEDBACK</h1>
<div>
<div class="feedback">
<form action="" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <h3>Do you like our website? Feedback us by sending message!</h3>
        </tr>
        <tr>
            <?php htmlInputDesc('feedback', isset($feedback) ? $feedback : "" , 500, 'Type your feedback here!', isset($feedback) ? $feedback : "" ) ?>
        </tr> 
    </table>
    <input type="submit" name="Submitfeedback" value="Submit your feedback here!" />
    <input type="button" value="Back" onclick="location='homeUser.php?name=<?php printf('%s',$name)?>'" />
    <div class="error" >
        <h4 class="feedbackEmpty">Feedback cannot be empty!</h4>
        <h4 class="feedbackMore">Feedback cannot more than 500 words!</h4>
    </div>
</form>

</div>

<?php
include('includes/footerUser.php');
?>