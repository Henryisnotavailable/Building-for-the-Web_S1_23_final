<?php


session_start();


if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php?msg=Please Login First");
    exit;
}

if (!isset($_GET["id"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
    header("Location: index.php?msg=!!! Error: Please choose a bike from 'Browse Bikes' !!!");
    exit;
}

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $bike_id = $_GET["id"];
    ///Got to change this to make sure the bike is public

    $sql = "SELECT vehicle_id,user_id,advert_title,
bike_details.description,bike_model,bike_lower_price,bike_upper_price,bike_quality,
bike_mileage,manufacture_year,num_seats,other_media_url,colour,image_url,is_electric
FROM bike_details INNER JOIN users USING (user_id) WHERE visibility = 1 AND vehicle_id = ?";

    //Load the page with bike data
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
                    error_log("DEBUG: HIT BIKE with ID {$bike_id}", 0);

                    //If the current user is the owner, then redirect them to the owner page (where they can edit)
                    if ($owner_user_id === $_SESSION["id"]) {
                        header("Location: ./a_bike_owner.php?id={$vehicle_id}");
                        exit;
                    }

                    //HTML encode all values before putting in the page
                    $page_vehicle_id = htmlspecialchars($vehicle_id);
                    $page_title = htmlspecialchars($title);
                    $page_description = $description == null ? "No description" : htmlspecialchars($description);
                    $page_image_url = htmlspecialchars($image_url);
                    $page_bike_model = htmlspecialchars($bike_model);
                    $page_bike_lower_price = htmlspecialchars($bike_lower_price);
                    $page_bike_upper_price = htmlspecialchars($bike_upper_price);
                    $page_bike_quality = htmlspecialchars($bike_quality);
                    $page_bike_mileage = htmlspecialchars($bike_mileage);
                    $page_bike_manufacture_year = htmlspecialchars($manufacture_year);
                    $page_num_seats = htmlspecialchars($num_seats);
                    $page_other_media_url = isset($other_media_url) ? htmlspecialchars($other_media_url) : null;
                    $page_colour = htmlspecialchars($colour);

                    $page_is_electric = ($is_electric == 1) ? "checked" : "";
                    $vehicle_retreived = true;

                    

                }

                else {
                error_log("ERROR: Could NOT fetch the bikes results - id => {$vehicle_id}", 0);
                header("Location: index.php?msg=!!! ERROR: Sorry, something went wrong, try again later !!!");
                exit;
                }



            }


            //Bike doesn't exist
            else {
                //Just log it
                error_log("ERROR: No results for user {$_SESSION['username']}", 0);
                header("Location: index.php?msg=!!! ERROR: Sorry, either that bike is private, or does not exist !!!");
            }
            $q->close();

        } else {
            error_log("ERROR: Could not execute query", 0);
        }



    } else {
        error_log("ERROR: Failed preparing statement", 0);
    }




    



}


if ($vehicle_retreived === true) {
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
                        error_log("DEBUG: HIT USER {$param_username}", 0);
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
}

$mysqli->close();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./a_bike_owner.css">
    </link>
    <link rel="icon" type="image/x-icon" href="./assets/icons/favicon.ico.png"></link>
    <meta charset="utf-8"/>
    <title>Bike Info (Viewer)</title>

</head>

<body>
    <article>
        <header>
            <div id="wrapper">
                <div id="PageHeader">
                    <h1>The Bike House</h1>
                    <br></br>
                    <p>Bike Info (Viewer)</p>
                </div>
            </div>
            <div id="navbarWrapper">
                <nav>
                    <ul>
                        <li><a href="./index.php"><img src="./assets/icons/home_icon.png" />Home</a></li>
                        <li><a href="./my_account.php"><img
                                    src="./assets/icons/3994415_account_avatar_person_profile_user_icon.png" />My
                                Account</a></li>
                        <li><a href="./rent_out.php"><img
                                    src="./assets/icons/4634978_pig_coin_financial_money_icon.png" />Rent out!</a>
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

                            <form id="sell_form"
                                method="post" enctype="multipart/form-data">
                                <div class="form_main">







                                    <div class="input_row">
                                        <div class="input_col">
                                            <h1>Advert Title</h1>
                                            <div class="advert_title_container">
                                                <h3><?php echo $page_title;?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="input_row" id="input_row_for_bike_image">
                                        <div class="input_col" id="bike_image_column">

                                            <img src="<?php echo $page_image_url;?>"></img>
                                            <p id="price_range">Rent it for between <b>£</b><b id="lower_price"><?php echo $page_bike_lower_price;?></b>
                                                - <b>£</b><b id="upper_price"><?php echo $page_bike_upper_price;?></b></p>
                                        </div>
                                    </div>


                                    <div class="input_row">
                                        <div class="input_col">
                                            <h2>Short Description</h2>
                                            <div class="bike_desc">
                                                <p><i><?php echo $page_description;?></i></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input_row">
                                        <div class="input_col">
                                            <h2>Bike model</h2>
                                            <div class="bike_model_container">
                                                <p><?php echo $page_bike_model;?></p>
                                            </div>
                                        </div>


                                    </div>

                                    <!--This will be changed to display once EDIT is pressed-->
                                    <div class="input_row" style="display: none;">
                                        <div class="input_col">
                                            <label for="asking_price_lower">Select lower asking price (£)</label>
                                            <input type="number" min="50" max="10000" placeholder="1000"
                                                id="asking_price_lower" name="asking_price_lower" autocomplete="off"
                                                readonly></input>

                                        </div>

                                        <div class="input_col">
                                            <label for="asking_price_upper">Select upper asking price (£)</label>
                                            <input type="number" min="50" max="10000" placeholder="2000"
                                                id="asking_price_upper" name="asking_price_upper" autocomplete="off"
                                                readonly></input>
                                        </div>
                                    </div>
                                    <!--End of hidden row before EDIT is pressed-->



                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="bike_quality">Bike quality: <span
                                                    id="bike_slider_value">Ok</span></label>
                                            <input id="bike_quality" autocomplete="off" type="range" min="0" max="5"
                                                step="1" value=<?php echo $page_bike_quality;?> class="slider" name="bike_quality" disabled></input>


                                        </div>

                                        <div class="input_col">
                                            <h2>The year the bike was made</h2>
                                            <div class="bike_birthday_container">
                                                <p><?php echo $page_bike_manufacture_year;?></p>
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


                                        </div>

                                        <div class="input_col">
                                            <h2>Number of seats</h2>
                                            <div class="bike_seats_container">
                                                <p><?php echo $page_num_seats;?></p>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="input_row">


                                        <div class="input_col" id="FaveColourBike">
                                            <h2>The Bike's Colour</h2>
                                            <input type="color" value="<?php echo $page_colour;?>" id="favourite_bike_colour"
                                                autocomplete="off" name="favourite_bike_colour" autocomplete="off"
                                                disabled></input>
                                        </div>

                                        <div class="input_col" id="electric_row">
                                            <h2>Is the bike electric?</h2>
                                            <input id="is_electric" autocomplete="off" type="checkbox" disabled="disabled"
                                            <?php echo $page_is_electric;?> ><label for="is_electric"></label></input>


                                        </div>
                                    </div>

                                    <div class="input_row" id="other_media_row">

                                        <div class="input_col" id="other_media_column">
                                            <h2>Other media of the Bike</h2>
                                            <?php
                                            //If image, set <img> tag, otherwise <video> tag
                                            if (isset($other_media_url) && !is_null($other_media_url)) {

                                                $other_media_extension = pathinfo($other_media_url, PATHINFO_EXTENSION);
                                                $img_extensions = array('gif', 'png', 'jpg', "jpeg", "webp");
                                                if (in_array($other_media_extension, $img_extensions)) {
                                                    echo '<img src="' . $page_other_media_url . '" id="current_other_media_img" class="other_media" alt="No other media!"/>';
                                                } 
                                                else {
                                                    if (file_exists($other_media_url)) {
                                                    echo '<video src="' . $page_other_media_url . '" id="current_other_media_img" class="other_media" alt="No other media!"></video>';
                                                echo file_exists($other_media_url);    
                                                }
                                                    else {
                                                        echo '<img src="" id="current_other_media_img" class="other_media" alt="No other media!"/>';
        
                                                    }
                                                }
                                            } else {
                                                echo '<img src="" id="current_other_media_img" class="other_media" alt="No other media!"/>';

                                            }
                                            
                                            ?>

                                        </div>
                                    </div>





                                    <div class="button_row">
                                        
                                        <button class="custom_button" id="rent_button" onclick="rent(this)" disabled>Rent!</button>


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
    <script src="./a_bike_viewer.js"></script>
</body>

</html>