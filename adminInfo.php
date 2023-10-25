<link rel="stylesheet" type="text/css" href="css/userInfo.css" />
<link href="css/background.css" rel="stylesheet" />
<?php
include('includes/headerAdmin.php');
?>
<style>
    
div.table input#adminpass[type=button] {
    height: 8%;
    font-size: 100%;
    background-color: #00728b;
    color: white;
    border: #002929 2px solid;
    border-radius: 4px;
    cursor: pointer;
    transition: 0.2s;
    width: 25%;
    margin-left: 5%;
    margin-top: 5%;
}
div.table input#adminpass[type=button]:hover {
    background-color: #004858;
    text-decoration: none;
}
</style>

<body>
    <div class="Admintitle">
        <h1>Admin's Information</h1>
    </div>
    <div class="table">
        <table>
            <tr>
                <td class="small_title">Username : </td>
                <?php printf('<td> %s</td>',$name); ?>
            </tr>

        </table>
        <input id="adminpass" type="button" value="Change Password" onclick="location='adminEdit.php?name=<?php printf('%s',$name);?>'"/>
    </div>
</body>

<?php
include('includes/footerAdmin.php');
?>