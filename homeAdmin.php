<link rel="stylesheet" type="text/css" href="css/home.css" />
<script src="javascript/home.js"></script>
<script>auto();</script>
<?php
include('includes/headerAdmin.php');
?>

<!-- home body -->
<body>
    <div class="slideshow" >

        <div class="imgSlide fade imgSlide1">
        <img onmouseover="pause()" onmouseout="resume()" src="images/image1.png"/>
        </div>

        <div class="imgSlide fade">
        <img onmouseover="pause()" onmouseout="resume()" src="images/image2.png"/>
        </div>

        <div class="imgSlide fade">
        <img onmouseover="pause()" onmouseout="resume()" src="images/image3.png"/>
        </div>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span> 
            <span class="dot" onclick="currentSlide(2)"></span> 
            <span class="dot" onclick="currentSlide(3)"></span> 
        </div>
    </div>
    <div class="event">
        <h2>Event</h2>
        <div class="img">
        <?php printf('<a href="eventAdmin.php?name=%s" class="img1"><img src="images/event1.png"/></a>',$name);?>
        <?php printf('<a href="eventAdmin.php?name=%s" class="img2"><img src="images/event2.png"/></a>',$name) ?>
        <?php printf('<a href="eventAdmin.php?name=%s" class="img3"><img src="images/event3.png"/></a>',$name) ?>
        </br>
        </div>
        <?php printf("<button onclick=\"location.href='eventAdmin.php?name=%s'\" class=\"admin\">Event &#8594;</button>",$name) ?>
    </div>
    <div class="member">
        <h2>Become a member</h2>
        <img src="images/memberBanner.png"/></br>
        <button disabled class="disabled" class="admin">Sign up &#8594;</button>
    </div>
    <div class="about">
        <h2>Wanna to know more about TARUMT Volleyball?</h2>
        <img src="images/AboutBanner.png"/></br>
        <button disabled class="disabled">About Us &#8594;</button>
    </div>
</body>



<?php
?>

<?php
include('includes/footerAdmin.php');
?>