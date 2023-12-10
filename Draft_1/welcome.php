<?php

session_start();


//If user is logged in, redirect to main page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: index.php");
    exit;
}

require_once "config.php";

//ORDER BY RAND() isn't the most efficient, but the database table shouldn't get too big, so it's ok for this use case (I hope...)
$sql = "SELECT vehicle_id,advert_title,image_url FROM bike_details INNER JOIN users USING (user_id) WHERE visibility = 1 ORDER BY RAND() LIMIT 3";
$results = null;

if ($q = $mysqli->query($sql)) {
    $results = $q;
    
    
}
//Couldn't prepare
//TODO




?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./welcome.css">
    </link>
    <link rel="icon" type="image/x-icon" href="./assets/icons/favicon.ico.png"></link>
    <meta charset="utf-8"/>
    <title>Welcome</title>
</head>

<body>
    <article>
        <header>
            <div id="wrapper">
                <div id="PageHeader">
                    <h1>The Bike House</h1>
                    <br></br>
                    <p>Welcome Page</p>
                </div>
            </div>
            <div id="navbarWrapper">
                <nav>
                    <ul>
                        <li><a href="./welcome.php"><img src="./assets/icons/10406450_hi_gesture_hand_hello_interaction_icon.png" />Welcome</a></li>
                        
                        
                                

                                <li><a href="./login.php"><img src="./assets/icons/10523360_login_1_icon.png" />Login</a>
                                </li>
                                <li><a href="./register.php"><img src="./assets/icons/11030003_user_up_account_profile_icon.png" />Register</a>
                                </li>
                        <li><a href="./about_unauth.php"><img src="./assets/icons/430101_help_question_icon.png" />About Us</a>
                        </li>
                        
                        <li id="placeholder"><a></a></li>
                        <li id="logout_button"><a href="./logout.php"><img
                                    src="./assets/icons/2931185_door_enter_exit_leave_out_icon(1).png" />Logout</a>
                        </li>
                    </ul>
                </nav>


            </div>
        </header>
        <main>
            <div class="page-wrapper">
                <div class="row">
                    <div class="column">
                        <div class="left-column">
                            <h1>Some of the latest Bikes</h1>
                            <p><b>Login</b> to see more information!</p>
                            <br></br>
                            <div class="image_container_wrapper">
                                <?php
                                if (isset($results)) {
                                    $i = 0;
                                    while ($row = $results->fetch_assoc()) {
                                        $i+=1;
                                        //HTML for each uploaded bike
                                        $out = "<div class=\"image_container\">\n";
                                        $out .= "<a href=\"login.php?redirect_to={$row['vehicle_id']}\" id=\"bike_{$i}\">\n";
                                        $out .= "<figure>\n";
                                        $out .= "<img src=\"{$row['image_url']}\" alt=\"A random bike\"></img>";
                                        $out .= "<figcaption>Bike {$i} - {$row['advert_title']}</figcaption>";
                                        $out .= "</figure>\n";
                                        $out .= "</a>";
                                        $out .= "</div>";
                                        echo $out;
                                    }
                                }
                                
                                ?>
                            
                            
                            
                            
                            </div>
                        </div>
                    </div>
                    <div class='right-column'>
                        <div class="main_body_container">
                            <div class="image_container">
                                <img src="https://static.thenounproject.com/png/3119765-200.png"
                                    class="user_picture"></img>
                            </div>
                            <h1>Welcome to the Bike House!</h1>
                            <div class="main_body_text">
                                <p>
                                    Hi there, this is the latest project of our small team. If you want to sell bikes, or rent them out, this is the place!<br>
                                    <br>
                                    Please login, or register for an account!
                                </p>
                            </div>
                            <br></br>
                            <p>Our small team are working hard on new features!</p>
                            <div class="image_container">
                                <figure>
                                    <img src="/assets/images/developer.jpg"
                                        alt="The Dev Team"></img>
                                    <figcaption>The Dev Team</figcaption>
                                </figure>
                            </div>
                            <br></br>
                            <p>Send us bitcon at 12312412451251-25125125</p>
                        </div>
                        <br></br>
                        
                        
                    </div>
                </div>
            </div>

        </main>
        <footer>
            <div class="social_media_row">
                <p><b>Follow our social media accounts!</b></p>


                <a href="https://twitter.com"><img
                        src="./assets/icons/twitter.webp"
                        id="twitter" /></a>

                <a href="https://instagram.com"><img
                        src="./assets/icons/instagram-white-icon.webp" /></a>

                <a href="https://example.com"><img
                        src="./assets/icons/tiktok.png" /></a>
                <a href="https://old.com"><img
                        src="./assets/icons/facebook-icon-white-png.png" /></a>

            </div>
        </footer>
    </article>
</body>

</html>