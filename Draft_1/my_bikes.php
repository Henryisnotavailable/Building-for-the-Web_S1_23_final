<?php

session_start();

if(!isset($_SESSION["loggedin"])) {
    header("Location: login.php?msg=Please Login First");
    exit;
}

//Most of the code is in my_bikes.js and api/bike_owner_info.php

?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./my_bikes.css">
    </link>
</head>

<body>
    <article>
        <header>
            <div id="wrapper">
                <div id="PageHeader">
                    <h1>The Bike House</h1>
                    <br></br>
                    <p>My Bikes</p>
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
                            <div class="left-internal-col">
                                <div class="image_container">
                                    <img src="https://media2.giphy.com/media/Hcw7rjsIsHcmk/giphy.gif?cid=6c09b952cjxdhkrbi9tl7515lu0o6wc4mcfhuskt6sxf363l&ep=v1_gifs_search&rid=giphy.gif&ct=g"
                                        class="user_picture"></img>
                                </div>
                                <h1>Hi <?php echo htmlspecialchars($_SESSION["username"]);?></h1>
                                <div class="main_body_text">
                                    <p>Welcome to *<b>Your</b>* bikes</p>
                                </div>

                                <p>Some of the bike's details can be seen on the right!</p>
                                <p>Click on the bike to see more details</p>

                                <div class="bike_slideshow" id="bike_slideshow_container">

                                    <div class="slider-wrapper">
                                        <div class="carousel-buttons">
                                            <button class="slider_button" id="prev_button" aria-label="Previous Slide"
                                                >❮</button>
                                            <button class="slider_button" id="next_button" aria-label="Next Slide"
                                                >❯</button>

                                        </div>
                                        <div class="slides_wrapper">
                                            <div class="slides" id="bike_slides">

                                            </div>
                                        </div>



                                    </div>





                                </div>
                            </div>

                        </div>
                        <br></br>


                    </div>
                    <div class='left-column'>
                        <div class="bike_information" id="bike_info_container">
                            <p>
                            <h1>Bike Info</h1>
                            </p>
                            <br></br>

                            <h3>Advert Title</h3>
                            <p id="AdvertTitle">Hi, this is my bike</p>

                            <h3>Bike's Model</h3>
                            <p id="BikeModel">Abla</p>

                            <h3>Price Range</h3>
                            <p id="PriceRange">£1000 - £2000</p>

                            <h3>Bike Quality</h3>
                            <p id="BikeQuality">Perfect</p>

                            <h3>Year it was made</h3>
                            <p id="BikeYearOfBirth">2001</p>

                            <h3>Bike Colour</h3>
                            <div id="ColourWrapper">
                                <div id="BikeColour"></div>
                            </div>
                            <h3>Description</h3>
                            <p id="BikeDescription" readonly>This is my bicycle, for sale</p>


                        </div>
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
    <script src="./my_bikes.js"></script>
    
</body>

</html>