<?php

session_start();

if(!isset($_SESSION["loggedin"])) {
    header("Location: login.php?msg=Please Login First");
    exit;
}


?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./my_account.css">
    </link>
    <title>My Account</title>
</head>

<body>
    <article>
        <header>
            <div id="wrapper">
                <div id="PageHeader">
                    <h1>The Bike House</h1>
                    <br></br>
                    <p>My Account</p>
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
                    <div class="column">
                        <div class="left-column">
                            <br></br>
                            <h1>Public</h1>
                            <br></br>
                            <div class="top_icon_row">
                                <a href="#1" id="bio_change" aria-label="change bio button">
                                    <figure>

                                        <figcaption>Change Bio</figcaption>
                                        <img src="./assets/icons/4213408_address_book_contact_contacts_human_icon.png" />


                                        <p>Currently: I like bikes</p>
                                    </figure>
                                </a>
                                <a href="#2" id="change_username" aria-label="change username button">
                                    <figure>

                                        <figcaption>Change Username</figcaption>
                                        <img src="./assets/icons/372902_user_name_round_username_linecon_icon.png" />


                                        <p>Currently: bik3man</p>
                                    </figure>
                                </a>
                                <a href="#4" id="change_favourite_bike" aria-label="change favourite bike button">
                                    <figure>

                                        <figcaption>Change Favourite Bike</figcaption>
                                        <img src="./assets/icons/2316017_activity_bike_bikes_outdoors_sports_icon.png" />


                                        <p>Currently: 159 Razer Byke</p>
                                    </figure>
                                </a>
                            </div>

                            <div class="bottom_icon_row">
                                <a href="#3" id="change_profile_pic" aria-label="change profile picture button">
                                    <figure>

                                        <figcaption>Change Profile Picture</figcaption>
                                        <img alt="Current Profile Picture"
                                            src="https://parspng.com/wp-content/uploads/2023/01/catpng.parspng.com-11.png" />


                                        <p>Currently: Shown Above</p>
                                    </figure>
                                </a>
                                
                                <a href="#5" id="change_pronouns" aria-label="change pronouns button">
                                    <figure>

                                        <figcaption>Change Pronouns</figcaption>
                                        <img src="./assets/icons/759440_bisexual_equality_female_gender_male_icon.png" />


                                        <p>Currently: he/him</p>
                                    </figure>
                                </a>
                            </div>
                            <br></br>

                            <br></br>

                        </div>
                    </div>
                    <div class='right-column'>
                        <div class="main_body_container">
                            <br></br>
                            <h1>Private</h1>
                            <br></br>
                            <div class="top_icon_row">
                                <a href="#6" id="enable_mfa" aria-label="enable Multi Factor Authentication button">
                                    <figure>

                                        <figcaption>Enable MFA</figcaption>
                                        <img src="./assets/icons/2205195_mobile_phone_screen_smart_icon.png" />


                                        <p>Currently: Not available yet!</p>
                                    </figure>
                                </a>
                                <a href="#7" id="change_password" aria-label="change password button">
                                    <figure>

                                        <figcaption>Change Password</figcaption>
                                        <img src="./assets/icons/2931164_clef_key_lock_unlock_password_icon.png" />


                                        <p>Currently: *********</p>
                                    </figure>
                                </a>

                                <!--Want to add a conditional eye here-->
                                <a href="#8" id="profile_visibility" aria-label="change profile visibility button">
                                    <figure>

                                        <figcaption>Change Profile Picture</figcaption>
                                        <img src="./assets/icons/8665352_eye_slash_icon.png" />


                                        <p>Currently: Public</p>
                                    </figure>
                                </a>
                            </div>


                            <div class="bottom_icon_row">
                                <a href="#9" id="change_email" aria-label="change email button">
                                    <figure>

                                        <figcaption>Change Email Address</figcaption>
                                        <img src="./assets/icons/134146_mail_email_icon.png" />


                                        <p>Currently: byk3dud3@protonmail.com</p>
                                    </figure>
                                </a>

                                <a href="#10" id="delete_account" aria-label="delete account button">
                                    <figure id="DeleteAcountFigure">


                                        <figcaption>Delete Account!</figcaption>
                                        <img src="./assets/icons/8679940_delete_bin_line_icon.png"
                                            id="DeleteAccountIcon" />



                                        <p>Are you sure?</p>
                                    </figure>
                                </a>
                            </div>
                            <br></br>

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