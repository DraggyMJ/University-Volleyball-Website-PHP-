<link rel="stylesheet" type="text/css" href="css/home.css" />
<script src="javascript/home.js"></script>
<script>auto();</script>
<?php
include('includes/header.php');
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
        <a href="signup.php" class="img1"><img src="images/event1.png"/></a>
        <a href="signup.php" class="img2"><img src="images/event2.png"/></a>
        <a href="signup.php" class="img3"><img src="images/event3.png"/></a>
        </br>
        </div>
        <button onclick="location.href='signup.php'">Event &#8594;</button>
    </div>
    <div class="member">
        <h2>Become a member</h2>
        <img src="images/memberBanner.png"/></br>
        <button onclick="location.href='signup.php'">Sign up &#8594;</button>
    </div>
    <div class="about">
        <h2>Wanna to know more about TARUMT Volleyball?</h2>
        <img src="images/AboutBanner.png"/></br>
        <button onclick="location.href='signup.php'">About Us &#8594;</button>
    </div>
</body>

<?php
include('includes/footer.php');
?>