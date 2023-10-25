<!-- Start of footer -->
<footer class="user">
        <div class="footer_logo">
            <img src="images/Tarumt_Volleyball_Logo.png" alt="logo" class="footer"/>
        </div>
        <div>
            <?php printf('<nav class="footer_nav">
                <ul>
                    <li><a href="homeUser.php?name=%s"><h2>Home</h2></a></li>
                    <li><a href="event.php?name=%s"><h2>Event</h2></a></li>
                    <li><a href="feedback.php?name=%s"><h2>Feedback</h2></a></li>
                    <li><a href="about_us.php?name=%s"><h2>About Us</h2></a></li>
                </ul>
            </nav>
        </div>
        <div class="website">
            <button id="fb"><a href="https://www.facebook.com/tarucvb2022"><img src="images/fb.png" class="fbIcon"/></a></button>
            <button id="ins"><a href="https://www.instagram.com/tarumtvb_/"><img src="images/ins.png" class="insIcon"/></a></button>
        </div>
        <div>
            <button id="top" class="pc_top"><a href="#top"><h1>&#8593;</h1></a></button>
        </div>
    </br></br>
        <div>
            <button id="top" class="mobile_top"><a href="#top"><h1>&#8593;</h1></a></button>
        </div>
        <div class="reset">
        </br>
        </div>',$name,$name,$name,$name);
        ?>
    </footer>
    </body>
</html>
<!-- End of footer -->
