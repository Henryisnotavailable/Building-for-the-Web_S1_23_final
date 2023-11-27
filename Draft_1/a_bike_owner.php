<?php

session_start();


if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php?msg=Please Login First");
    exit;
}

if (!isset($_GET["id"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
    header("Location: index.php?msg=Please choose a bike and its ID");
    exit;
}

    //Validate all receieved data
    //Set all variables to ""
    $ad_title = $bike_model = $asking_price_lower = $asking_price_upper = $bike_date_of_birth  = $bike_seats = $is_bike_electric = $bike_bio = "";
    $ad_title_error = $bike_model_error = $asking_price_lower_error = $asking_price_upper_error = $bike_quality_error = $bike_date_of_birth_error = $bike_mileage_error = $bike_seats_error = $is_bike_electric_error = $bike_colour_error = $bike_bio_error = "";
    
    //$ad_title_error = "Potato";
    $bike_photo_error = $bike_other_media_error = "";
    
    $error = "";
    
    //This must be -1 for the slider to work properly.
    $bike_mileage = $bike_quality  = -1;
    
    //This is the default
    $bike_colour = "#e62739";

require_once "config.php";

//If user is VIEWING the bike, display its details
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $bike_id = $_GET["id"];

    $sql = "SELECT vehicle_id,user_id,advert_title,
description,bike_model,bike_lower_price,bike_upper_price,bike_quality,
bike_mileage,manufacture_year,num_seats,other_media_url,colour,image_url,is_electric
FROM bike_details WHERE vehicle_id = ?";

    if ($q = $mysqli->prepare($sql)) {
        $param_vehicle_id = $_GET["id"];
        $q->bind_param("s", $param_vehicle_id);
        //Execute query
        if ($q->execute()) {
            //Store query result
            $q->store_result();

            if ($q->num_rows > 0) {
                $q->bind_result($vehicle_id, $owner_user_id, $title, $description, $bike_model, $bike_lower_price, $bike_upper_price, $bike_quality, $bike_mileage, $manufacture_year, $num_seats, $other_media_url, $colour, $image_url, $is_electric);
                //Get the bike
                if ($q->fetch()) {
                    //If user tries viewing a bike that's not theirs, then redirect to a viewer page
                    if ($owner_user_id !== $_SESSION["id"]) {
                        error_log("DEBUG: User doesn't own this bike... Redirecting", 0);
                        header("Location: a_bike_viewer.php?msg=You are not the owner of this bike");
                        exit;
                    }



                    error_log("DEBUG: HIT {$bike_id}", 0);
                    //HTML encode all values before putting in the page
                    $page_vehicle_id = htmlspecialchars($vehicle_id);
                    $page_title = htmlspecialchars($title);
                    $page_description = htmlspecialchars($description);
                    $page_image_url = htmlspecialchars($image_url);
                    $page_bike_model = htmlspecialchars($bike_model);
                    $page_bike_lower_price = htmlspecialchars($bike_lower_price);
                    $page_bike_upper_price = htmlspecialchars($bike_upper_price);
                    $page_bike_quality = htmlspecialchars($bike_quality);
                    $page_bike_mileage = htmlspecialchars($bike_mileage);
                    $page_bike_manufacture_year = htmlspecialchars($manufacture_year);
                    $page_num_seats = htmlspecialchars($num_seats);
                    $page_other_media_url = htmlspecialchars($other_media_url);
                    $page_colour = htmlspecialchars($colour);

                    $page_is_electric = ($is_electric == 1) ? "checked" : "";



                }



            }


            //Bike doesn't exist
            else {
                //Just log it
                error_log("ERROR: No results for user {$_SESSION['username']}", 0);
                exit;
            }
            $q->close();

        } else {
            error_log("ERROR: Could not execute query", 0);
        }



    } else {
        error_log("ERROR: Failed preparing statement", 0);
    }

    //If the bike has been loaded, show the owner's details
    if (isset($owner_user_id)) {
        $sql = "SELECT profile_url,username,registration_date,telephone,pronouns,email,favourite_bike,description FROM users WHERE user_id = ?";

        if ($q = $mysqli->prepare($sql)) {
            $param_user_id = $owner_user_id;
            $q->bind_param("s", $param_user_id);
            //Execute query
            if ($q->execute()) {
                //Store query result
                $q->store_result();

                if ($q->num_rows > 0) {
                    $q->bind_result($param_profile_url, $param_username, $param_registration_date, $param_telephone, $param_pronouns, $param_email, $param_favourite_bike, $param_description);
                    //Get the bike
                    if ($q->fetch()) {
                        error_log("DEBUG: HIT {$param_username}", 0);
                        $page_profile_url = htmlspecialchars($param_profile_url);
                        $page_username = htmlspecialchars($param_username);
                        $page_registration_date = htmlspecialchars($param_registration_date);
                        $page_telephone = htmlspecialchars($param_telephone);
                        $page_pronouns = htmlspecialchars($param_pronouns);
                        $page_email = htmlspecialchars($param_email);
                        $page_favourite_bike = htmlspecialchars($param_favourite_bike);
                        $page_user_description = htmlspecialchars($param_description);


                    }



                }


                //Bike doesn't exist
                else {
                    //Just log it
                    error_log("ERROR: No results for user {$_SESSION['username']}", 0);
                    exit;
                }
                $q->close();

            } else {
                error_log("ERROR: Could not execute query", 0);
            }



        } else {
            error_log("ERROR: Failed preparing statement", 0);
        }
    }


    $mysqli->close();
}

elseif ($_SERVER["REQUEST_METHOD"] == "POST") {





}


?>





<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./a_bike_owner.css">
    </link>
</head>

<body>
    <article>
        <header>
            <div id="wrapper">
                <div id="PageHeader">
                    <h1>The Bike House</h1>
                    <br></br>
                    <p>Bike Info (Owner)</p>
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
                            <h1><u>Bike Info</u></h1>

                            <form id="sell_form" action="<?php echo htmlspecialchars($_SERVER["SELF"])?>"
                                method="post" enctype="multipart/form-data">
                                <div class="form_main">







                                    <div class="input_row">
                                        <div class="input_col" id="title_container">
                                            <h1>Advert Title</h1>
                                            <div id="advert_title_container">
                                                <h3 id="current_title"><?php echo $page_title;?></h3>
                                                <div id="ad_title_error_div" class="error_div"><p><?php echo $ad_title_error; ?></p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="input_row" id="input_row_for_bike_image">
                                        <div class="input_col" id="bike_image_column">
                                            
                                            <img id="current_bike_img" src="<?php echo $page_image_url;?>"></img>
                                            <div id="bike_image_error_div" class="error_div"><p><?php echo $bike_photo_error; ?></p></div>
                                            <p id="price_range">Selling for between <b>£<span id="lower_price"><?php echo $page_bike_lower_price;?></span></b>
                                                - <b>£<span id="upper_price"><?php echo $page_bike_upper_price;?></span></b></p>
                                        </div>
                                    </div>


                                    <div class="input_row">
                                        <div class="input_col" id="bike_desc_col">
                                            <h2>Short Description</h2>
                                            <div class="bike_desc">
                                                <p id="current_bike_desc"><i><?php echo $page_description;?></i></p>
                                                <div id="bike_desc_error" class="error_div"><p><?php echo $bike_bio_error; ?></p></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input_row">
                                        <div class="input_col" id="bike_model_col">
                                            <h2>Bike model</h2>
                                            <div class="bike_model_container">
                                                <p id="current_bike_model"><?php echo $page_bike_model;?></p>
                                                <div id="ad_title_error_div" class="error_div"><p><?php echo $bike_model_error; ?></p></div>
                                            </div>
                                        </div>


                                    </div>

                                    <!--This will be changed to display once EDIT is pressed-->
                                    <div class="input_row" style="display: none;" id="price_row">
                                        <div class="input_col">
                                            <label for="asking_price_lower">Select lower asking price (£)</label>
                                            <input type="number" min="50" max="10000" placeholder="1000" step="10"
                                                id="asking_price_lower" name="asking_price_lower" autocomplete="off"
                                                readonly value="<?php echo $page_bike_lower_price;?>"></input>
                                                <div id="lower_price_error_div" class="error_div"><p><?php echo $asking_price_lower_error; ?></p></div>

                                        </div>

                                        <div class="input_col">
                                            <label for="asking_price_upper">Select upper asking price (£)</label>
                                            <input type="number" min="50" max="10000" placeholder="2000" step="10"
                                                id="asking_price_upper" name="asking_price_upper" autocomplete="off"
                                                readonly value="<?php echo $page_bike_upper_price;?>"></input>
                                                <div id="upper_price_error_div" class="error_div"><p><?php echo $asking_price_upper_error; ?></p></div>
                                        </div>
                                    </div>
                                    <!--End of hidden row before EDIT is pressed-->



                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="bike_quality">Bike quality: <span
                                                    id="bike_slider_value">Ok</span></label>
                                            <input id="bike_quality" autocomplete="off" type="range" min="0" max="5"
                                                step="1" value=<?php echo $page_bike_quality;?> class="slider" name="bike_quality" disabled></input>
                                                <div id="bike_quality_error_div" class="error_div"><p><?php echo $bike_quality_error; ?></p></div>

                                        </div>

                                        <div class="input_col" id="bike_birthday_col">
                                            <h2>The year the bike was made</h2>
                                            <div class="bike_birthday_container">
                                                <p id="current_birthday"><?php echo $page_bike_manufacture_year;?></p>
                                                <div id="bike_date_of_birth_error" class="error_div"><p><?php echo $bike_date_of_birth_error; ?></p></div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="bike_mileage">Bike mileage: <span id="bike_mileage_span">
                                                    < 500 miles</span></label>
                                            <input id="bike_mileage" autocomplete="off" type="range" min="0" max="1100"
                                                step="100" value=<?php echo $page_bike_mileage;?> class="slider" name="bike_mileage"
                                                disabled></input>
                                                <div id="bike_mileage_error_div" class="error_div"><p><?php echo $bike_mileage_error; ?></p></div>


                                        </div>

                                        <div class="input_col" id="seat_col">
                                            <h2>Number of seats</h2>
                                            <div class="seat_container">
                                                <p id="seat_value"><?php echo $page_num_seats;?></p>
                                                <div id="bike_seats_error_div" class="error_div"><p><?php echo $bike_seats_error; ?></p></div>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="input_row">


                                        <div class="input_col" id="FaveColourBike">
                                            <h2>The Bike's Colour</h2>
                                            <input type="color" value="<?php echo $page_colour;?>" id="favourite_bike_colour"
                                                autocomplete="off" name="favourite_bike_colour" autocomplete="off"
                                                disabled></input>
                                                <div id="favourite_bike_colour_error" class="error_div"><p><?php echo $bike_colour_error; ?></p></div>
                                        </div>

                                        <div class="input_col" id="electric_row">
                                            <h2>Is the bike electric?</h2>
                                            <input id="is_electric" autocomplete="off" type="checkbox" disabled
                                                name="is_electric" <?php echo $page_is_electric;?>><label for="is_electric"></label></input>
                                                <div id="bike_electric_error_div" class="error_div"><p><?php echo $is_bike_electric_error; ?></p></div>

                                        </div>
                                    </div>

                                    <div class="input_row" id="other_media_row">

                                        <div class="input_col" id="other_media_column">
                                            <h2>Other media of the Bike</h2>
                                            <?php

                                            if (isset($other_media_url) && !is_null($other_media_url)) {

                                            $other_media_extension = pathinfo($other_media_url, PATHINFO_EXTENSION);
                                            $img_extensions = array('gif', 'png', 'jpg',"jpeg","webp");
                                            if (in_array($other_media_extension,$img_extensions) ) {
                                                echo '<img src="'.$page_other_media_url. '" id="current_other_media_img" class="other_media" alt="No other media!"/>';
                                            }
                                            else {
                                                echo '<video src="'.$page_other_media_url. '" id="current_other_media_img" class="other_media" alt="No other media!"/>';
                                            }
                                        }

                                        else {
                                            echo '<img src="" id="current_other_media_img" class="other_media" alt="No other media!"/>';
                                            
                                        }
                                            
                                            ?>
                                            <div id="other_media_error" class="error_div"><p><?php echo $bike_other_media_error; ?></p></div>
                                        </div>
                                    </div>





                                    <div class="button_row">
                                        <button class="custom_button" id="delete_bike_button" type="reset">DELETE
                                            BIKE</button>
                                        <button class="custom_button" id="edit_button" type="submit">Edit
                                            Details</button>


                                    </div>

                                    <div class="input_row" id="button_row">

                                        <button class="custom_button" id="sell_button" type="submit">Save
                                            Changes</button>

                                        <button class="custom_button" id="clear_button" type="reset">Clear</button>

                                    </div>
                                </div>
                            </form>






                        </div>
                    </div>
                    <div class="left-column">
                        <h1>Seller Details</h1>
                        <br>
                        <div class="user_picture"><img
                                src="<?php echo $page_profile_url; ?>" />
                        </div>
                        <p id="username_line">Username - <b id="username_value"><?php echo $page_username; ?></b></p>
                        <p id="registered_line">Registered - <b id="registered_date_value"><?php echo $page_registration_date; ?></b></p>
                        <p id="mobile_line">Phone Number - <b id="bikes_sold_value"><?php echo $page_telephone; ?></b></p>
                        <p id="pronouns_line">Preferred Pronouns - <b id="pronouns_value"><?php echo $page_pronouns; ?></b></p>
                        <p id="email_line">Email - <b id="email_value"><?php echo $page_email; ?></b></p>
                        <p id="favourite_bike_line">Favourite Bike - <b id="favourite_bike_value"><?php echo $page_favourite_bike; ?></b></p>
                        <p id="bio_line">Bio - <br><i id="bio_value"><?php echo $page_user_description; ?></i></p>
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
    <script src="./a_bike_owner.js"></script>
</body>

</html>