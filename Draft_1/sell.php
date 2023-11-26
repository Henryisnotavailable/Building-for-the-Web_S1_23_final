<?php


//Make sure user is logged in
session_start();
if(!isset($_SESSION["loggedin"])) {
    header("Location: login.php?msg=Please Login First");
    exit;
}


//Set all variables to ""
$ad_title = $bike_model = $asking_price_lower = $asking_price_upper = $bike_date_of_birth  = $bike_seats = $is_bike_electric = $bike_colour = $bike_bio = "";
$ad_title_error = $bike_model_error = $asking_price_lower_error = $asking_price_upper_error = $bike_quality_error = $bike_date_of_birth_error = $bike_mileage_error = $bike_seats_error = $is_bike_electric_error = $bike_colour_error = $bike_bio_error = "";

$bike_photo_error = $bike_other_media_error = "";



//This must be -1 for the slider to work properly.
$bike_quality = $bike_mileage  = -1;

//This is the default
$bike_colour = "#e62739";






?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./sell.css">
    </link>
</head>

<body>
    <article>
        <header>
            <div id="wrapper">
                <div id="PageHeader">
                    <h1>The Bike House</h1>
                    <br></br>
                    <p>Sell!</p>
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
                                <li><a href="#4"><img src="./assets/icons/4781848_bag_buy_cart_ecommerce_shop_icon.png" />Browse Bikes</a>
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
                            <h1>Seller Guidelines</h1>
                            <br></br>
                            <p>Rule 1 - <b>No</b> offensive content</p>
                            <br></br>
                            <p>Rule 2 - <b>No</b> prices above <b>£10k</b></p>
                            <br></br>
                            <p>Rule 3 - Include a <b>high-quality</b> image</p>
                            <br></br>
                            <p>Rule 4 - <b>No</b> selling stolen bikes</p>
                            <br></br>
                            <p>Rule 5 - <b>No</b> <a href="https://en.wikipedia.org/wiki/Cryptocurrency">crypto </a>or
                                <a href="https://en.wikipedia.org/wiki/Non-fungible_token">NFTs</a>
                            </p>
                            <br></br>
                            <p>Rule 6 - Don't upload PHP webshells ;)</p>

                        </div>
                    </div>
                    <div class='right-column'>
                        <div class="main_body_container">
                            
                            <form id="sell_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                method="post" enctype="multipart/form-data">
                                <div class="form_main">
                                    <h1><u>Sell here!</u></h1>
                                    <p>* Denotes Required Fields</p>
                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="advert_title">Title your advert *</label>
                                            <input type="text" placeholder="Brand new Mark 1 Brompton!"
                                                id="advert_title" name="advert_title" autocomplete="off" required maxlength="50" minlength="4" value="<?php echo $ad_title; ?>"></input>
                                                <div id="ad_title_error_div" class="error_div"><p><?php echo $ad_title_error; ?></p></div>
                                        </div>
                                    </div>
                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="bike_model">Enter the bike's model *</label>
                                            <input type="text" placeholder="Brompton Mark 1" id="bike_model" name="bike_model" autocomplete="off" required maxlength="30" minlength="4" value="<?php echo $bike_model; ?>"></input>
                                            <div id="ad_title_error_div" class="error_div"><p><?php echo $bike_model_error; ?></p></div>
                                        </div>


                                    </div>

                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="asking_price_lower">Select lower asking price (£) *</label>
                                            <input type="number" min="50" max="10000" placeholder="1000"
                                                id="asking_price_lower" name="asking_price_lower" autocomplete="off" required step="10" value="<?php echo $asking_price_lower; ?>"></input>
                                                <div id="lower_price_error_div" class="error_div"><p><?php echo $asking_price_lower_error; ?></p></div>
                                        </div>

                                        <div class="input_col">
                                            <label for="asking_price_upper">Select upper asking price (£) *</label>
                                            <input type="number" min="50" max="10000" placeholder="2000"
                                                id="asking_price_upper" name="asking_price_upper" autocomplete="off" required step="10" value="<?php echo $asking_price_upper; ?>"></input>
                                                <div id="upper_price_error_div" class="error_div"><p><?php echo $asking_price_upper_error; ?></p></div>
                                            </div>
                                    </div>


                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="bike_quality">Select bike quality: *<span
                                                    id="bike_slider_value">Ok</span></label>
                                            <input id="bike_quality" autocomplete="off" type="range" min="0" max="5"
                                                step="1" value="<?php echo $bike_quality; ?>" class="slider" name="bike_quality" required></input>
                                                <div id="bike_quality_error_div" class="error_div"><p><?php echo $bike_quality_error; ?></p></div>


                                        </div>

                                        <div class="input_col">
                                            <label for="bike_date_of_birth">The year the bike was made *</label>
                                            <input type="number" min="1817" max="2099" step="1" placeholder="2023"
                                                id="bike_date_of_birth" name="bike_date_of_birth" autocomplete="off" required value="<?php echo $bike_date_of_birth; ?>"></input>
                                                <div id="bike_date_of_birth_error" class="error_div"><p><?php echo $bike_date_of_birth_error; ?></p></div>
                                        </div>
                                    </div>



                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="bike_mileage">Select bike mileage: *<span
                                                    id="bike_mileage_span">Ok</span></label>
                                            <input id="bike_mileage" autocomplete="off" type="range" min="0" max="1100"
                                                step="100" value="<?php echo $bike_mileage; ?>" class="slider" name="bike_mileage" required></input>
                                                <div id="bike_mileage_error_div" class="error_div"><p><?php echo $bike_mileage_error; ?></p></div>


                                        </div>

                                        <div class="input_col">
                                            <label for="bike_seats">Number of seats *</label>
                                            <input type="number" min="1" max="3" step="1" placeholder="1"
                                                id="bike_seats" name="bike_seats" autocomplete="off" required value="<?php echo $bike_seats; ?>"></input>
                                                <div id="bike_seats_error_div" class="error_div"><p><?php echo $bike_seats_error; ?></p></div>
                                        </div>
                                    </div>

                                    


                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="bike_pic">Upload Image of Bike *</label>
                                            <input type="file" id="bike_pic" name="bike_pic" autocomplete="off" required accept="image/gif, image/jpg, image/jpeg, image/png"></input>
                                            <div id="bike_image_error_div" class="error_div"><p><?php echo $bike_photo_error; ?></p></div>
                                        </div>

                                        

                                        <div class="input_col" id="electric_row">
                                            <p>Is the bike electric? *</p>
                                            <input name="is_electric" id="is_electric" autocomplete="off" type="checkbox" value="yes" <?php echo empty($is_bike_electric) ? '' : ($is_bike_electric == true ? 'checked':'')   ?>><label for="is_electric" ></label></input>
                                            <div id="bike_electric_error_div" class="error_div"><p><?php echo $is_bike_electric_error; ?></p></div>


                                        </div>
                                    </div>

                                    <div class="input_row">
                                        <div class="input_col" id="FaveColourBike">
                                            <label for="bike_colour">Select Bike's Colour</label>
                                            <input type="color" placeholder="#e62739" id="favourite_bike_colour"
                                                autocomplete="off" name="favourite_bike_colour" autocomplete="off" value="<?php echo $bike_colour; ?>"></input>
                                                <div id="favourite_bike_colour_error" class="error_div"><p><?php echo $bike_colour_error; ?></p></div>
                                        </div>
                                        <div class="input_col">
                                            <label for="bike_pic">Upload Any other media of the Bike</label>
                                            <input type="file" id="bike_pic" name="upload_media" autocomplete="off" accept="image/*, video/*"></input>
                                            <div id="other_media_error" class="error_div"><p><?php echo $bike_other_media_error; ?></p></div>
                                        </div>
                                    </div>

                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="bike_desc" id="checkboxLabel">Short Description</label>
                                            <textarea id="bike_desc" name="bike_desc" autocomplete="off"><?php echo $bike_bio; ?></textarea>
                                            <div id="bike_desc_error" class="error_div"><p><?php echo $bike_bio_error; ?></p></div>
                                        </div>
                                    </div>

                                    <div id="error_message_row">
                                        <p><?php echo $error; ?></p>
                                    </div>
                                    <div class="input_row" id="button_row">

                                        <button class="custom_button" id="sell_button" type="submit">Sell</button>
                                        <button class="custom_button" id="clear_button" type="reset">Clear</button>

                                    </div>
                                </div>
                            </form>







                            
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
    <script src="./sell.js"></script>
</body>

</html>