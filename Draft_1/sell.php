<?php


//Make sure user is logged in
session_start();
if(!isset($_SESSION["loggedin"])) {
    header("Location: login.php?msg=Please Login First");
    exit;
}


//Set all variables to ""
$ad_title = $bike_model = $asking_price_lower = $asking_price_upper = $bike_date_of_birth  = $bike_seats = $is_bike_electric = $bike_colour = $bike_bio = "";
$ad_title_error = $bike_model_error = $asking_price_lower_error = $asking_price_upper_error = $bike_mileage_error = $bike_date_of_birth_error = $bike_mileage_error = $bike_seats_error = $is_bike_electric_error = $bike_colour_error = $bike_bio_error = "";

$bike_photo_error = $bike_other_media_error = "";

$error = "";

//This must be -1 for the slider to work properly.
$bike_mileage = $bike_mileage  = -1;

//This is the default
$bike_colour = "#e62739";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $valid = true;


    //Validate advert title
    if(!isset($_POST["advert_title"])){
        $valid = false;
        $ad_title_error = "!!! Please set advert title !!!";
    }
    else if (empty(trim($_POST["advert_title"]))) {
        $ad_title_error = "!!! The advert title cannot be empty !!!";
        $valid = false;
    }

    elseif (!preg_match("/[a-zA-Z0-9_'\-\.]{4,50}/", trim($_POST["advert_title"]))) {
        $ad_title_error = "!!! Invalid advert title, it should be less than 50 alphanumeric characters !!!";
        $valid = false;
        $ad_title = htmlspecialchars($_POST["advert_title"]);
    }

    else {
        $ad_title = htmlspecialchars($_POST["advert_title"]);
    }
    //End of ad title validation
    

    //Validate bike model
    if(!isset($_POST["bike_model"])){
        $valid = false;
        $bike_model_error = "!!! Please set bike model !!!";
    }
    else if (empty(trim($_POST["bike_model"]))) {
        $bike_model_error = "!!! The bike model cannot be empty !!!";
        $valid = false;
    }

    elseif (!preg_match("/[a-zA-Z0-9_'\-\.]{4,30}/", trim($_POST["bike_model"]))) {
        $bike_model_error = "!!! Invalid bike model, it should be less than 30 alphanumeric characters !!!";
        $valid = false;
        $bike_model = htmlspecialchars($_POST["bike_model"]);
    }

    else {
        $bike_model = htmlspecialchars($_POST["bike_model"]);
    }
    //End of bike model validation

    //Validate lower and upper asking price
        if(!isset($_POST["asking_price_lower"])){
            $valid = false;
            $asking_price_lower_error = "!!! Please set lower asking price !!!";
        }

        else if (empty(trim($_POST["asking_price_lower"]))) {
            $asking_price_lower_error = "!!! The lower asking price cannot be empty !!!";
            $valid = false;
        }
    



        if(!isset($_POST["asking_price_upper"])){
            $valid = false;
            $asking_price_upper_error = "!!! Please set upper asking price !!!";
        }

        else if (empty(trim($_POST["asking_price_upper"]))) {
            $asking_price_upper_error = "!!! The upper asking price cannot be empty !!!";
            $valid = false;
        }

        $both_positive = true;
        //Check if positive number
        if (!ctype_digit(trim($_POST["asking_price_lower"]))) {
            $asking_price_lower_error = "!!! Invalid lower asking price, it must be a positive whole number !!!";
            $valid = false;
            $asking_price_lower = htmlspecialchars($_POST["asking_price_lower"]);
            $both_positive = false;
        }

        if (!ctype_digit(trim($_POST["asking_price_upper"]))) {
            $asking_price_upper_error = "!!! Invalid upper asking price, it must be a positive whole number !!!";
            $valid = false;
            $asking_price_upper = htmlspecialchars($_POST["asking_price_upper"]);
            $both_positive = false;
        }

        //If both are numbers, cast to ints
        if ($both_positive === true) {
            $lower_int = intval(trim($_POST["asking_price_lower"]));
            $upper_int = intval(trim($_POST["asking_price_upper"]));

            if ($lower_int > $upper_int) {
                $asking_price_lower_error = $asking_price_upper_error = "!!! The lower price cannot be more than the upper price !!!";
                $valid = false;
                }
            else if ($lower_int > 10000 || $lower_int < 50) {
                $asking_price_lower_error = "!!! Lower asking price must be between 50 - 10,000!!!";
                $valid = false;
            }

            if ($upper_int > 10000 || $upper_int < 50) {
                $asking_price_upper_error = "!!! Upper asking price must be between 50 - 10,000!!!";
                $valid = false;
            }
            
            $asking_price_upper = htmlspecialchars($_POST["asking_price_upper"]);
            $asking_price_lower = htmlspecialchars($_POST["asking_price_lower"]);
            
        }
    //End of bike price validation

    //Validate bike quality values
    if(!isset($_POST["bike_mileage"])){
        $valid = false;
        $bike_mileage_error = "!!! Please set bike quality !!!";
    }
    else if (empty(trim($_POST["bike_mileage"]))) {
        $bike_mileage_error = "!!! The bike quality cannot be empty !!!";
        $valid = false;
    }

    //If the user submits via HTML this >should< always be a number (because it's a slider)
    else if (!ctype_digit($_POST["bike_mileage"])) {
        $bike_mileage_error = "!!! The bike quality must be a number between 0-5 !!!";
        $valid = false;
    }


    elseif (intval(trim($_POST["bike_mileage"])) > 5 || intval(trim($_POST["bike_mileage"])) < 0) {
        $bike_mileage_error = "!!! Invalid bike quality, it should be a number between 0-5 !!!";
        $valid = false;
    }

    else {
        $bike_mileage = htmlspecialchars($_POST["bike_mileage"]);
    }
    //End of validation for bike quality values

    //Validate bike manufacture year
    if(!isset($_POST["bike_date_of_birth"])){
        
        $valid = false;
        $bike_date_of_birth_error = "!!! Please set bike year of birth !!!";
    }
    else if (empty(trim($_POST["bike_date_of_birth"]))) {
        $bike_date_of_birth_error = "!!! The bike year of birth cannot be empty !!!";
        $valid = false;
    }

    //If the user submits via HTML this >should< always be a number (because it's a slider)
    else if (!ctype_digit($_POST["bike_date_of_birth"])) {
        $bike_date_of_birth_error = "!!! The bike year of birth must be a number !!!";
        $valid = false;
        $bike_date_of_birth = htmlspecialchars($_POST["bike_date_of_birth"]);
   
    }


    //If bike was made in the future, error
    elseif (intval(trim($_POST["bike_date_of_birth"])) > intval((new DateTime)->format("Y")) ) {
        $bike_date_of_birth_error = "!!! The bike cannot be made in the future, sorry... !!!";
        $bike_date_of_birth = htmlspecialchars($_POST["bike_date_of_birth"]);
        $valid = false;
    }

    //If bike was made before the first ever bike (Full disclosure, 1817 was the first result from google. It may be wrong)
    elseif (intval(trim($_POST["bike_date_of_birth"])) < 1817) {
        $bike_date_of_birth_error = "!!! The first bike was made in 1817, I doubt your bike was made before that !!!";
        $bike_date_of_birth = htmlspecialchars($_POST["bike_date_of_birth"]);
        $valid = false;
    }

    else {
        $bike_date_of_birth = htmlspecialchars($_POST["bike_date_of_birth"]);
    }

    //End of bike manufacture date validation

        //Validate bike mileage values
        
        if(!isset($_POST["bike_mileage"])){
            $valid = false;
            $bike_mileage_error = "!!! Please set bike mileage !!!";
        }
        else if (empty(trim($_POST["bike_mileage"]))) {
            $bike_mileage_error = "!!! The bike mileage cannot be empty !!!";
            $valid = false;
        }
    
        //If the user submits via HTML this >should< always be a number (because it's a slider)
        else if (!ctype_digit($_POST["bike_mileage"])) {
            $bike_mileage_error = "!!! The bike mileage must be a ->number<- between 0-1100+ !!!";
            $valid = false;
            $bike_mileage = htmlspecialchars($_POST["bike_mileage"]);
        }
    
    
        elseif (intval(trim($_POST["bike_mileage"])) > 1100 || intval(trim($_POST["bike_mileage"])) < 0) {
            $bike_mileage_error = "!!! The bike mileage must be a number between 0-1100+ !!!";
            $valid = false;
            $bike_mileage = htmlspecialchars($_POST["bike_mileage"]);
        }
    
        //Check if divisible by 100, to ensure the value is in steps of 100 (same as the HTML slider)
        elseif (intval(trim($_POST["bike_mileage"])) % 100 !== 0) {
            $bike_mileage_error = "!!! The bike mileage must be a number divisible by 100 between 0-1100+ (e.g. 300, 700, 1000) !!!";
            $valid = false;
            $bike_mileage = htmlspecialchars($_POST["bike_mileage"]);
        }

        else {
            $bike_mileage = htmlspecialchars($_POST["bike_mileage"]);
        }
        //End of validation for bike mileage values



        //Start of Bike seats validation
        
        if(!isset($_POST["bike_seats"])){
            $valid = false;
            $bike_seats_error = "!!! Please set bike seats !!!";
        }
        else if (empty(trim($_POST["bike_seats"]))) {
            $bike_seats_error = "!!! The bike seats cannot be empty !!!";
            $valid = false;
        }
    
        //If the user submits via HTML this >should< always be a number (because it's a slider)
        else if (!ctype_digit($_POST["bike_seats"])) {
            $bike_seats_error = "!!! The bike seat must be a ->number<- between 1-3 !!!";
            $valid = false;
            $bike_seats = htmlspecialchars($_POST["bike_seats"]);
        }
    
    
        elseif (intval(trim($_POST["bike_seats"])) > 3 || intval(trim($_POST["bike_seats"])) < 1) {
            $bike_seats_error = "!!! The bike seat must be a ->number<- between 1-3 !!!";
            $valid = false;
            $bike_seats = htmlspecialchars($_POST["bike_seats"]);
        }


        else {
            $bike_seats = htmlspecialchars($_POST["bike_seats"]);
        }
        //End of validation for bike seats

        //Start of Bike seats validation
        //If a checkbox is NOT selected, it isn't even sent.
                if(isset($_POST["is_electric"])){
                    $is_bike_electric = true;
                }
                else {
                    $is_bike_electric = false;
                }
        //End of bike seats validation
        
        //Validate bike colour

        $colour_pattern = "/#[a-fA-F0-9]{6}/";
        if(!isset($_POST["bike_colour"])){
            $valid = false;
            $bike_colour_error = "!!! Please set bike colour !!!";
        }
        else if (empty(trim($_POST["bike_colour"]))) {
            $bike_colour_error = "!!! The bike colour cannot be empty !!!";
            $valid = false;
        }

        //If not matches hex pattern like #BEDEAD
        else if (!preg_match($colour_pattern, trim($_POST["bike_colour"]))) {
            $bike_colour_error = "!!! The bike colour must be a valid hex code with # !!!";
            $valid = false;
        }

        else {
            $bike_colour = htmlspecialchars($_POST["bike_colour"]);
        }
        //End bike colour validation

        //Validate bike description
                if(!isset($_POST["bike_desc"])){
                    $valid = false;
                    $bike_bio_error = "!!! Please set bike bio !!!";
                }
                else if (empty(trim($_POST["bike_desc"]))) {
                    $bike_bio_error = "!!! The bike bio cannot be empty !!!";
                    $valid = false;
                }
        
                //200 Characters is the max length
                else if (strlen($_POST["bike_desc"]) > 200) {
                    $bike_bio_error = "!!! The bike bio cannot be more than 200 characters !!!";
                    $valid = false;
                    $bike_bio = htmlspecialchars($_POST["bike_desc"]);
                }
        
                else {
                    $bike_bio = htmlspecialchars($_POST["bike_desc"]);
                }

                //End bike description validation


            //Validate bike_pic

            if(!isset($_POST["bike_pic"])){
                $valid = false;
                $bike_photo_error = "!!! Please set the bike picture !!!";
            }

            else if (file_exists($_FILES['profile_pic']['tmp_name']) || is_uploaded_file($_FILES['profile_pic']['tmp_name'])) {
                error_log("Hit file upload part",0);
            }

            else {
                $bike_photo_error = "!!! Please choose a picture of the bike !!!";
            
            }

            //End of bike_pic validation

}




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
                                            <label for="bike_mileage">Select bike quality: *<span
                                                    id="bike_slider_value">Ok</span></label>
                                            <input id="bike_mileage" autocomplete="off" type="range" min="0" max="5"
                                                step="1" value="<?php echo $bike_mileage; ?>" class="slider" name="bike_mileage" required></input>
                                                <div id="bike_mileage_error_div" class="error_div"><p><?php echo $bike_mileage_error; ?></p></div>


                                        </div>

                                        <div class="input_col">
                                            <label for="bike_date_of_birth">The year the bike was made *</label>
                                            <input type="number" min="1817" max="<?php echo (new DateTime)->format('Y'); ?>" step="1" placeholder="2023"
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