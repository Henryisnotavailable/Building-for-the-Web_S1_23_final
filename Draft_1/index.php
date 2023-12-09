<?php

session_start();

if(!isset($_SESSION["loggedin"])) {
    header("Location: login.php?msg=Please Login First");
    exit;
}



$msg = "";

if (isset($_GET["msg"])) {
    $msg = htmlspecialchars($_GET["msg"]);
}




?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./index.html_.css">
    </link>
</head>

<body>
    <article>
        <header>
            <div id="wrapper">
                <div id="PageHeader">
                    <h1>The Bike House</h1>
                    <br></br>
                    <p>Main Menu</p>
                </div>
            </div>
            <div id="navbarWrapper">
                <nav>
                    <ul>
                        <li><a href="./index.php"><img src="./assets/icons/home_icon.png" />Home</a></li>
                        <li><a href="./my_account.php"><img
                                    src="./assets/icons/3994415_account_avatar_person_profile_user_icon.png" />My
                                Account</a></li>
                        <li><a href="./sell.php"><img
                                    src="./assets/icons/4634978_pig_coin_financial_money_icon.png" />Sell!</a>
                        </li>
                        <li><a href="./my_bikes.php"><img src="./assets/icons/352313_bike_directions_icon.png" />My
                                Bikes</a></li>
                                <li><a href="./browse_bikes.php"><img src="./assets/icons/4781848_bag_buy_cart_ecommerce_shop_icon.png" />Browse Bikes</a>
                                </li>
                        <li><a href="./about_auth.php"><img src="./assets/icons/430101_help_question_icon.png" />About Us</a>
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

                    <div class='right-column'>


                        <div class="main_body_container">
                            <div class="bg_wrapper">
                                <div class="image_container">
                                    <img src="<?php echo $_SESSION["profile_picture"];?>"
                                        class="user_picture"></img>
                                </div>
                                <h1>Hi <?php echo htmlspecialchars($_SESSION["username"]);?></h1>
                                <div class="main_body_text">
                                    <p>Welcome to the main menu!</p>
                                    <div id="general_error_div" class="error_div"><p><?php echo $msg;?></p></div>
                                    <br>
                                    <div class="right_column_wrapper">
                                        <div class="left_inside_column">
                                            <br>
                                            <h3>From here you can access everything</h3>
                                            <br>
                                            <br>

                                            <ul>
                                                <li>
                                                    <p><a href="./my_account.php"><img
                                                                src="./assets/icons/3994415_account_avatar_person_profile_user_icon.png" /><br>My
                                                            Account
                                                            - Modify your account details</p></a>
                                                </li>
                                                <li>
                                                    <p><a href="./sell.php"> <img
                                                                src="./assets/icons/4634978_pig_coin_financial_money_icon.png" /><br>Sell!
                                                            - To sell your bike so we can rent it out!</p></a>
                                                </li>
                                                <li>
                                                    <p><a href="./my_bikes.php"> <img
                                                                src="./assets/icons/352313_bike_directions_icon.png" /><br>My
                                                            Bikes!
                                                            - To
                                                            see all of your listed bikes</p></a>
                                                </li>
                                                

                                                <li>
                                                    <p><a href="#5"><img
                                                                src="./assets/icons/4781848_bag_buy_cart_ecommerce_shop_icon.png" /><br>Browse Bikes
                                                            -
                                                            To rent a bike</p></a>
                                                </li>
                                                <li>
                                                    <p><a href="./about_auth.php"><img
                                                                src="./assets/icons/430101_help_question_icon.png" /><br>About Us
                                                            -
                                                            To learn more about the developer</p></a>
                                                </li>
                                                <li>
                                                    <p><a href="#5"><img
                                                                src="./assets/icons/2931185_door_enter_exit_leave_out_icon(1).png" /><br>Logout
                                                            - To logout of your account</p></a>
                                                </li>
                                            </ul>

                                            <br>
                                        </div>
                                        <div class="right_inside_column">
                                            <br>
                                            <h3>We're a small team, so please</h3>
                                            <br><br>
                                            <ul>
                                                <li>
                                                    <p><a href="mailto:st20271561@outlook.cardiffmet.ac.uk"><img
                                                                src="./assets/icons/134146_mail_email_icon.png"></img><br>Mail
                                                            us your suggestions </a></p>
                                                </li>
                                                <li>
                                                    <p><a
                                                            href="https://github.com/Henryisnotavailable/Building-for-the-Web_S1_23"><img
                                                                src="./assets/icons/940962_git_github_hub icon_icon.png" /><br>Checkout
                                                            our Git repository!

                                                        </a></p>
                                                </li>
                                                <li>
                                                    <p><a href="https://discord.com"><img
                                                                src="./assets/icons/8546766_discord_icon.png" /><br>Join
                                                            our discord?</a></p>
                                                </li>

                                                <li>
                                                    <p><a href="https://youtube.com"><img
                                                                src="./assets/icons/2559760_media_social_video_youtube_icon.png" /><br>Checkout
                                                            out youtube channel!</a></p>
                                                </li>

                                                <li>
                                                    <p><a href="https://patreon.com"><img
                                                                src="./assets/icons/4691478_patreon_icon.png" /><br>Support
                                                            us on Patreon</a></p>
                                                </li>
                                                <li>
                                                    <p><a href="mailto:st20271561@outlook.cardiffmet.ac.uk"><img
                                                                src="./assets/icons/8666142_bitcoin_icon.png"></img><br>Donate Bitcoin </a></p>
                                                </li>

                                            </ul>

                                            <br>
                                        </div>
                                    </div>
                                    <br></br>

                                    <br>
                                </div>
                                <p id="support_email">For any questions, concerns or issues please contact our <a
                                        href="mailto:st20271561@outlook.cardiffmet.ac.uk">Support</a> team<br><br></p>
                            </div>
                        </div>
                        <br></br>
                        <hr>
                        

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