<?php

session_start();


//If user is logged in, redirect to main page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: index.php");
    exit;
}

?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./welcome.css">
    </link>
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
                            <p>Login to see more information</p>
                            <br></br>
                            <div class="image_container_wrapper">
                            <div class="image_container">
                                <a href="https://example.com" id="bike_1">
                                <figure>
                                    <img src="https://media.redlinebicycles.com/catalog/product/1000x1500/REDLINE-4718/redline-4718-random-2021-19190-gloss-black-web-profile.png"
                                        alt="A random bike"></img>
                                    <figcaption>Bike 1 - Name</figcaption>
                                </figure>
                            </a>
                            </div>
                            <br></br>
                            <br></br>
                            <div class="image_container">
                                <a href="https://example.com" id="bike_2">
                                <figure>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Bike_icon.png"
                                        alt="Another random bike"></img>
                                    <figcaption>Bike 2 - Name</figcaption>
                                </figure>
                            </a>
                            </div>
                            <br></br>
                            <div class="image_container">
                                <a href="https://example.com" id="bike_3">
                                <figure>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/db/USDOT_highway_sign_bicycle_symbol_-_black.svg/2560px-USDOT_highway_sign_bicycle_symbol_-_black.svg.png"
                                        alt="Another another random bike"></img>
                                    <figcaption>Bike 3 - Name</figcaption>
                                </figure>
                            </a>
                            </div>
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
                                    <img src="https://media2.giphy.com/media/Hcw7rjsIsHcmk/giphy.gif?cid=6c09b952cjxdhkrbi9tl7515lu0o6wc4mcfhuskt6sxf363l&ep=v1_gifs_search&rid=giphy.gif&ct=g"
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