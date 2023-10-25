<link rel="stylesheet" type="text/css" href="css/userInfo.css" />
<link href="css/background.css" rel="stylesheet" />
<?php
include('includes/headerUser.php');
?>

<body>
    <div class="title">
        <h1>User's Information</h1>
    </div>
    <div class="table">
        <table>
            <tr>
                <td class="small_title">Username : </td>
                <?php printf('<td> %s</td>',$name); ?>
            </tr>
            <tr>
                <td class="small_title">Gender : </td>
                <?php if($gender == NULL){
                    printf('<td> -</td>');
                    }else if($gender == 'M'){
                        printf('<td> Male</td>');
                    }else if($gender == 'F'){
                        printf('<td> Female</td>');
                    }else{
                        printf('<td> -</td>');
                    }; ?>
            </tr>
            <tr>
                <td class="small_title">Age : </td>
                <?php if($age <= 0)
                {
                    printf('<td> -</td>');
                }else if($age > 100){
                    printf('<td> -</td>');
                }else{
                    printf('<td> %s</td>',$age);
                } ?>
            </tr>
            <tr>
                <td class="small_title">Birthday : </td>
                <?php if ($birth == '0000-00-00'){
                    printf('<td> -</td>');
                    }else printf('<td> %s</td>',$birth); ?>
            </tr>
            <tr>
                <td class="small_title">Email : </td>
                <?php if($email == NULL){
                    printf('<td> -</td>');
                    }else printf('<td> %s</td>',$email); ?>
            </tr>
            <tr>
                <td class="small_title">Phone Number : </td>
                <?php if($phone == NULL){
                    printf('<td> -</td>');
                    }else printf('<td> %s</td>',$phone); ?>
            </tr>
        </table>
        <input type="button" value="Edit info" onclick="location='userEdit.php?name=<?php printf('%s',$name);?>'"/>
    </div>
</body>

<?php
include('includes/footerUser.php');
?>