<?php

//Calculate quality string based on integer value
function get_quality($quality) {
    $quality = (int) $quality;
    switch ($quality) {
        case 0:
            return "Broken";
        case 1:
            return "Poor";
        case 2:
            return "Ok";

        case 3:
            return "Good";

        case 4:
            return "Great";

        case 5:
            return "Perfect";

        default:
            return "Unknown";
    }
}

session_start();
if(!isset($_SESSION["loggedin"])) {
    header("Location: login.php?msg=Please Login First");
    exit;
}
require_once "config.php";

$bike_results = [];


//GET if the user browses to the page, searching will be handled by JS and api/bike_search.php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //So this gets all bikes with owners that have a visibility of 1 (so Public)
    $sql = "SELECT vehicle_id,user_id,advert_title,bike_details.description,bike_model,bike_lower_price,
    bike_upper_price,bike_quality,manufacture_year,colour,image_url FROM bike_details 
    INNER JOIN users USING (user_id) WHERE visibility = 1";
    //bike_details.description is needed as both tables have the description field, so just "description" is ambiguous
    
    if ($q = $mysqli->prepare($sql)) {
        //Execute query
        if ($q->execute()) {
            //Store query result
            $q->store_result();

            if ($q->num_rows > 0) {
                $q->bind_result($vehicle_id, $user_id, $title, $description, $bike_model, $bike_lower_price, $bike_upper_price, $bike_quality, $manufacture_year, $colour, $image_url);
                //Loop over each result (e.g. each bike the user uploaded)
                while ($q->fetch()) {

                    error_log("DEBUG: HIT {$user_id}");
                    $test = [
                        "bike_id" => $vehicle_id,
                        "bike_ad_name" => $title,
                        "bike_model" => $bike_model,
                        "lower_asking_price" => $bike_lower_price,
                        "upper_asking_price" => $bike_upper_price,
                        "bike_quality" => get_quality($bike_quality),
                        "bike_birthday" => $manufacture_year,
                        "image_url" => $image_url,
                        "bike_colour_code" => $colour,
                        "description" => $description == null ? "No description" : $description 
                    ];
                    array_push($bike_results, $test);
                }



            }


            //User owns no bikes :(, the JS will handle
            else {
                //Just log it
                error_log("ERROR: No results for user {$_SESSION['username']}", 0);
            }
            $q->close();

        }

        $mysqli->close();

    } else {
        error_log("ERROR: Failed preparing statement", 0);
    }
}
?>



<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./browse_bikes.css">
    </link>
    <link rel="icon" type="image/x-icon" href="./assets/icons/favicon.ico.png"></link>
    <meta charset="utf-8"/>
    <title>Browse Bikes</title>
</head>

<body>
    <article>
        <header>
            <div id="wrapper">
                <div id="PageHeader">
                    <h1>The Bike House</h1>
                    <br></br>
                    <p>Browse Bikes</p>
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

                    <div class='left-column'>
                        <div class="main_body_container">
                            <div class="left-internal-col">
                                <br>
                                <h1>Search below!</h1>


                                <form class="search_bar">
                                    <label for="search_value">Search by title, model or your desired price! </label>
                                    <input type="search" placeholder="Brompton Mark 1" id="search_value"><button type="submit" class="custom_button" id="search_button">Search!</button>
                                    <div class="error_div" id="search_error"><p id="search_error_msg"></p></div>
                                </form> 
                                <p>Some of the bike's details can be seen on the right!</p>
                                <br>
                                <h1>Click on the bike to see more details and rent it!</h1>

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
                                        <p id="slide_count"><?php echo sizeof($bike_results) == 0 ? "No bikes!": "1 of ".sizeof($bike_results);?></p>

                                    </div>





                                </div>
                            </div>

                        </div>
                        <br></br>


                    </div>
                    <div class='right-column'>
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
    
    <script type="text/javascript">var api_data = <?php echo json_encode($bike_results); ?>;</script>
    <script src="./browse_bikes.js"></script>
</body>

</html>