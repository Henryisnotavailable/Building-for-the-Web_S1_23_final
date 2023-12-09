<?php

function delete_accounts_bikes($mysqli) {
    error_log("DEBUG: Trying to delete user's bikes",0);
    $sql_for_media = "SELECT other_media_url, image_url FROM bike_details WHERE vehicle_id = ?";
    if ($qu = $mysqli->prepare($sql_for_media)) {
        $qu->bind_param("i", $_GET["bike_id"]);
        if ($qu->execute()) {
            $qu->store_result();

            if ($qu->num_rows > 0) {
                $qu->bind_result($bind_other_media_url,$bind_image_url);
                //Get the bike
                if ($qu->fetch()) {
                    //Load into variables
                    $other_media_url = $bind_other_media_url;
                    $image_url = $bind_image_url;
                    
                    if(!is_null($image_url)) {
                        
                        $path = pathinfo($image_url);
                        unlink($image_url);
                        error_log("DEBUG: Removing {$image_url}");
                        unlink($path["dirname"].'/'.$path["filename"]);

                    }
                    if(!is_null($other_media_url)) {
                        $path = pathinfo($other_media_url);
                        unlink($other_media_url);
                        error_log("DEBUG: Removing {$other_media_url}");
                        unlink($path["dirname"].'/'.$path["filename"]);

                    }
    
    
    
                }
    
    
    
            }
        }

        else {
            die("Sorry, the query failed, try again later");
        }
    }
    

    else {
        die("Sorry, something went wrong");
    }
    $qu->close();
    $user_id = $_SESSION["id"];
    //Make sure users can only delete their own bikes
    $sql = "DELETE FROM bike_details WHERE user_id = ?";
    if ($q = $mysqli->prepare($sql)) {
        
        $q->bind_param("i",$user_id);

        //Execute query
        if($q->execute()) {
            $status_code = 0;
        }
        //Delete failed?
        else {
            $status_code = 1;
            //"!!! Website Error, Something Went Wrong, please try again later !!!";
        }

        $q->close();
    }

    else {
        $status_code = 1;
    }

    return $status_code;
}

function delete_account($mysqli)
{
    error_log("DEBUG: Trying to delete user's account",0);
    $user_id = $_SESSION["id"];
    $profile_pic_url = $_SESSION["profile_picture"];
    //Remove the original file (old user profile picture)
    
    if (delete_accounts_bikes($mysqli) === 0) {
        $sql = "DELETE FROM users WHERE user_id = ?";
        if ($q = $mysqli->prepare($sql)) {
            $q->bind_param("i", $user_id);
            if ($q->execute()) {
                $status = 0;
                if (!is_null($profile_pic_url)) {
                    
                    $path = pathinfo($profile_pic_url);

                    if (!$path["filename"] === "default_avatar") {
                        error_log("DEBUG: Removing old image {$profile_pic_url}", 0);
                        if (file_exists($profile_pic_url)) {
                        unlink($profile_pic_url);
                        }
                        //There are 2 files, the random file and the random file + extension
                        if (file_exists($path["dirname"] . '/' . $path["filename"])) {
                        unlink($path["dirname"] . '/' . $path["filename"]);
                        }
                    }

                    else {
                        error_log("DEBUG: Old avatar, not removing", 0);
                    }
                }
            } else {
                $status = 1;
                error_log("ERROR: Could not execute DELETE statement for user", 0);
            }
        } else {
            $status = 1;
            error_log("ERROR: Could not prepare DELETE statement for user", 0);
        }
    }
    else {
        $status = 1;
    }
    return $status;
}

function replace_profile_pic($posted_filepath,$extension,$old_filepath) {
    
    //Remove the original file (old user profile picture)
    if (!is_null($old_filepath)) {
    
        

        error_log("DEBUG: Removing old image {$old_filepath}",0);
        
        
        $path = pathinfo($old_filepath);
        //Don't delete if the user has the default avatar
        if ($path["filename"] !== "default_avatar") {
            if (file_exists($old_filepath)) {
                unlink($old_filepath);
            }
            
            if (file_exists($path["dirname"].'/'.$path["filename"])) {
        //There are 2 files, the random file and the random file + extension
        unlink($path["dirname"].'/'.$path["filename"]);
            }
        }

        else {
            error_log("DEBUG: Old avatar, not removing", 0);
        }
    }

    $target_path = "./assets/users/profile_pictures";  
    //Generate a new unique EMPTY file  
    $tempname = tempnam($target_path,"img");

    //New filename = random + old_extension
    $target = $tempname . "." . $extension;

    //Copy unique empty file to new filename 
    error_log("DEBUG: Moving to {$target}", 0);
    copy($tempname,$target);

    //Move temporary file from POST to ./assets/users/bikes/
    move_uploaded_file($posted_filepath,$target);
    //tempnam returns a FULL path (e.g. /var/www/html/...) I just want a relative path
    $relative_path =  $target_path."/". basename($target);

    //unlink($target);
    //unlink($tempname);
    error_log("DEBUG: Replacing old image {$old_filepath} with {$relative_path}",0);
    return $relative_path;
}

function update_user_account($mysqli,$column,$new_value) {
    //This isn't vulnerable to SQL injection because $column is not user supplied
    $sql_insert_statement = "UPDATE users SET $column = ? WHERE user_id = ?";
    if ($statement = $mysqli->prepare($sql_insert_statement)) {
        error_log("DEBUG: Binding parameters to UPDATE statement", 0);
        $param_new_value = $new_value;
        $param_user_id = $_SESSION["id"];
        $statement->bind_param("si",$param_new_value,$param_user_id);
        
        if ($statement->execute()) {
            error_log("UPDATE WORKED!!!",0);
            $statement->close();
            header("Location: my_account.php?updated=$column");
            
        } else {
            error_log("ERROR: Executing statement", 0);
            $statement->close();
        }

        

    } else {
        error_log("ERROR: Could not prepare statement", 0);
    }
}

function username_taken($username,$mysqli) {
    $sql = "SELECT user_id FROM users WHERE username = ?";
    if($stmt = $mysqli->prepare($sql)) {
        $param_username = trim($username);
        $stmt->bind_param("s", $param_username);
        

        if($stmt->execute()) {
            $stmt->store_result();

            if($stmt->num_rows === 1) {
                $taken = true;
            }

            else {
                $taken = false;
            }

        }

        $stmt->close();

    }

    return $taken;
}

session_start();

if(!isset($_SESSION["loggedin"])) {
    header("Location: login.php?msg=Please Login First");
    exit;
}

require_once "config.php";

//Get users details

if (isset($_SESSION["id"])) {
    $sql = "SELECT profile_url,username,registration_date,telephone,pronouns,email,favourite_bike,description,visibility FROM users WHERE user_id = ?";

    if ($q = $mysqli->prepare($sql)) {
        $param_user_id = $_SESSION["id"];
        $q->bind_param("s", $param_user_id);
        //Execute query
        if ($q->execute()) {
            //Store query result
            $q->store_result();

            if ($q->num_rows > 0) {
                $q->bind_result($param_profile_url, $param_username, $param_registration_date, $param_telephone, $param_pronouns, $param_email, $param_favourite_bike, $param_description,$param_visibility);
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
                    $page_visibility = (int)($param_visibility);


                }



            }


            //User doesn't exist
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

$bio_error = $username_error = $favourite_bike_error = $profile_pic_error = $pronouns_error = $password_error = $visibilty_error = $email_error = "";
$bio_value = $username_value = $favourite_bike_value = $profile_pic_value = $pronouns_value = $password_value = $visibilty_value = $email_value = "";

$delete_error = "";
$js_to_setup_edit = "";

$valid = true;



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        isset($_SERVER['CONTENT_LENGTH']) &&
        (int) $_SERVER['CONTENT_LENGTH'] > (1024 * 1024 * (int) ini_get('post_max_size'))
    ) {
        // Code to be executed if the uploaded file has size > post_max_size
        // Will issue a PHP warning message 

        if (isset($_SERVER["HTTP_REFERER"])) {
            $max_upload = (int) (ini_get('post_max_size'));
            $profile_pic_error = "!!! Sorry, uploaded file is too big, !!!";
            $_SESSION["upload_err"] = "!!! Error, sorry the uploaded files were too big, no changes were saved, the max size is {$max_upload}MB!!!";
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
        exit;
    }


    if (isset($_POST["new_bio"])) {
        if (strlen($_POST["new_bio"]) == 0) {
            $bio_error = "!!! New bio cannot be empty !!!";
            $valid = false;

        } elseif (strlen($_POST["new_bio"]) > 200) {
            $bio_error = "!!! New bio cannot exceed 200 characters !!!";
            $valid = false;
        } else {
            $bio_value = htmlspecialchars($_POST["new_bio"]);
            update_user_account($mysqli, "description", $_POST["new_bio"]);
        }

        //On POST, this sets up the edit field for the user (so they don't have to reclick it)
        if (!$valid) {
            //This sets the value of the input, so user doesn't have to retype if there are errors
            $sanitized_value = htmlspecialchars($_POST["new_bio"]);
            $js_to_setup_edit = "<script>setup_bio_change('{$sanitized_value}')</script>";
        }
    } else if (isset($_POST["new_username"])) {
        if (empty(trim($_POST["new_username"]))) {
            $username_error = "!!! Please enter a username !!!";
            $valid = false;

        } elseif (!preg_match('/[a-zA-Z0-9_]{1,20}/', trim($_POST["new_username"]))) {
            $username_error = "!!! Username can only contain letters, numbers, and underscores. !!!";
            $valid = false;
            $username_value = htmlspecialchars($_POST["new_username"]);
        } elseif (username_taken($_POST["new_username"], $mysqli)) {
            $username_error = "!!! Sorry, username taken, try something else !!!";
            $valid = false;
            $username_value = htmlspecialchars($_POST["new_username"]);
        } else {
            $username_value = htmlspecialchars($_POST["new_username"]);
            update_user_account($mysqli, "username", $_POST["new_username"]);
        }

        if (!$valid) {
            $js_to_setup_edit = "<script>setup_username_change()</script>";
        }


    } else if (isset($_POST["new_fave_bike"])) {
        if (empty(trim($_POST["new_fave_bike"]))) {
            $favourite_bike_error = "!!! Sorry, favourite bike is empty !!!";
            $valid = false;
        } elseif (strlen($_POST["new_fave_bike"]) > 50) {
            $favourite_bike_error = "!!! Sorry, favourite bike must be less than 50 characters !!!";
            $valid = false;
            $favourite_bike_value = htmlentities($_POST["new_fave_bike"]);
        } else {
            $favourite_bike_value = htmlentities($_POST["new_fave_bike"]);
            update_user_account($mysqli, "favourite_bike", $_POST["new_fave_bike"]);

            if (!$valid) {
                $js_to_setup_edit = "<script>setup_fave_bike_change()</script>";
            }
        }
    } else if (isset($_FILES["new_profile_pic"])) {
        if (file_exists($_FILES['new_profile_pic']['tmp_name']) || is_uploaded_file($_FILES['new_profile_pic']['tmp_name'])) {


            $original_file_name = strtolower($_FILES["new_profile_pic"]["name"]);
            $profile_pic_extension = pathinfo($original_file_name, PATHINFO_EXTENSION);

            //Get the filetype of the "image"
            $mime_type = exif_imagetype($_FILES["new_profile_pic"]["tmp_name"]);
            //Allowed Extensions
            $allowed_ext = array('gif', 'png', 'jpg', "jpeg", "webp");
            $allowed_mime_type = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP);
            $str_extensions = implode(", ", $allowed_ext);
            //If extension not allowed, error
            if (!in_array($profile_pic_extension, $allowed_ext)) {
                $profile_pic_error = "!!! Only {$str_extensions} extensions allowed !!!";
                $valid = false;
            }

            //Check if a valid image mime type
            else if (!in_array($mime_type, $allowed_mime_type)) {
                $profile_pic_error = "!!! Only {$str_extensions} file types allowed !!!";
                $valid = false;
            } else {
                $relative_bike_img_path = replace_profile_pic($_FILES["new_profile_pic"]["tmp_name"], $profile_pic_extension, $page_profile_url);
                update_user_account($mysqli, "profile_url", $relative_bike_img_path);
                //Update user's session to reflect change in profile picture
                $_SESSION["profile_picture"] = $relative_bike_img_path;
            }



        } else if ($_FILES["new_profile_pic"]["error"] === UPLOAD_ERR_INI_SIZE) {
            $max_upload = (int) (ini_get('upload_max_filesize'));
            $profile_pic_error = "!!! Sorry, uploaded file is too big, max size is {$max_upload}MB!!!";
            $valid = false;
        }
        if (!$valid) {
            $js_to_setup_edit = "<script>setup_profile_pic_change()</script>";
        }
    } else if (isset($_POST["new_pronouns"])) {
        if (empty(trim($_POST["new_pronouns"]))) {
            $pronouns_error = "!!! Sorry, pronouns were empty !!!";
            $valid = false;

        } elseif ($_POST["new_pronouns"] !== "he/him" && $_POST["new_pronouns"] !== "she/her" && $_POST["new_pronouns"] !== "they/them") {
            $pronouns_error = "!!! Sorry, pronouns must be he/him, she/her or they/them !!!";
            $valid = false;
        } else {
            update_user_account($mysqli, "pronouns", $_POST["new_pronouns"]);
        }

        if (!$valid) {
            $js_to_setup_edit = "<script>setup_pronouns_change()</script>";
        }
    } else if (isset($_POST["new_password"])) {
        if (!isset($_POST["new_password_confirm"])) {
            $password_error = "!!! You must input a new password and a password confirmation !!!";
            $valid = false;
        } else if (empty($_POST["new_password"]) || empty($_POST["new_password_confirm"])) {
            $password_error = "!!! The password cannot be empty !!!";
        } else if ($_POST["new_password"] !== $_POST["new_password_confirm"]) {
            $password_error = "!!! Passwords must match !!!";
            $valid = false;
        } else if (strlen($_POST["new_password"]) < 10) {
            $password_error = "!!! Please enter a longer password, think of 4 random words !!!";
            $valid = false;
            $password_value = htmlspecialchars($_POST["new_password"]);
        } elseif (strlen($_POST["new_password"]) > 72) {
            $password_error = "!!! Please enter a shorter password, 72 characters is the max !!!";
            $valid = false;
            $password_value = htmlspecialchars($_POST["new_password"]);
        } else {
            update_user_account($mysqli, "password", password_hash($_POST["new_password"],PASSWORD_BCRYPT));
        }

        if (!$valid) {
            $js_to_setup_edit = "<script>setup_password_change()</script>";
        }


    } else if (isset($_POST["new_profile_visibility"])) {

        if ($_POST["new_profile_visibility"] === "change") {
            // 1 turns to 0, 0 turns to 1
            $new_visibility = $page_visibility === 1 ? 0 : 1;
            update_user_account($mysqli, "visibility", $new_visibility);
        } else {
            //This should never actually be hit
            $visibilty_error = "!!! Visibility must have a value of change!!!";
        }


    } else if (isset($_POST["new_email"])) {
        if (empty(trim($_POST["new_email"]))) {
            $email_error = "!!! Please set email !!!";
            $valid = false;
        } else if (!(filter_var($_POST["new_email"], FILTER_VALIDATE_EMAIL))) {
            $email_error = "!!! Invalid email, please check your input !!!";
            $valid = false;
            $email_value = htmlspecialchars($_POST["new_email"]);
        } else if (strlen($_POST["new_email"]) > 100) {
            $email_error = "!!! Invalid email, must be less than 100 characters !!!";
            $valid = false;
            $email_value = htmlspecialchars($_POST["new_email"]);
        }
        
        
        else {
            $email_value = htmlspecialchars($_POST["new_email"]);
            update_user_account($mysqli, "email", $_POST["new_email"]);
        }

        if (!$valid) {
            $js_to_setup_edit = "<script>setup_email_change()</script>";
        }
    } else if (isset($_POST["delete_account"])) {
        if ($_POST["delete_account"] === "yes") {
            if (delete_account($mysqli) === 0) {
                header("Location: logout.php?msg=Account Deleted!");
            }

            else {
                $delete_error = "!!! There was a website error when deleting your account, try again later !!!";
                $valid=false;
            }
        }

        else {
            $valid=false;
            //This should always be yes, it's set to yes in the HTML, and set to readonly
            $delete_error = "!!! You must send 'yes' when deleting an account !!!";
        }

        if(!$valid) {
            $js_to_setup_edit = "<script>setup_delete_account()</script>";
        }
    }
    else {
        error_log("Received a POST but got no valid POST parameters!", 0);
    }
}

elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_SESSION["upload_err"])) {
    $profile_pic_error = $_SESSION["upload_err"];
    unset($_SESSION["upload_err"]);
    }
}

$mysqli->close();

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./my_account.css">
    </link>
    <title>My Account</title>
    <link rel="icon" type="image/x-icon" href="./assets/icons/favicon.ico.png"></link>
    <meta charset="utf-8"/>

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
                            
                                <div id="bio_change_div" class="change_div">
                                <a href="#1" id="bio_change" aria-label="change bio button">
                                    <figure>

                                        <figcaption>Change Bio</figcaption>
                                        <img src="./assets/icons/4213408_address_book_contact_contacts_human_icon.png" />
                                        

                                        <p id="test">Currently: <?php echo $page_user_description;?></p>

                                    </figure>
                                </a>
                                <div id="change_bio_input_div"></div>
                                <div id="bio_error_div" class="error_div"><p><?php echo $bio_error; ?></p></div>
                                </div>
                             
                                <div id="username_change_div" class="change_div">
                                <a href="#2" id="change_username" aria-label="change username button">
                                    <figure>

                                        <figcaption>Change Username</figcaption>
                                        <img src="./assets/icons/372902_user_name_round_username_linecon_icon.png" />


                                        <p>Currently: <?php echo $page_username;?></p>
                                    </figure>
                                </a>
                                <div id="change_username_input_div"></div>
                                <div id="username_error_div" class="error_div"><p><?php echo $username_error; ?></p></div>
</div>
<div id="fave_bike_change_div" class="change_div">
                                <a href="#4" id="change_favourite_bike" aria-label="change favourite bike button">
                                    <figure>

                                        <figcaption>Change Favourite Bike</figcaption>
                                        <img src="./assets/icons/2316017_activity_bike_bikes_outdoors_sports_icon.png" />


                                        <p>Currently: <?php echo $page_favourite_bike;?></p>
                                    </figure>
                                </a>
                                <div id="change_fave_bike_input_div"></div>
                                <div id="fave_bike_error_div" class="error_div"><p><?php echo $favourite_bike_error; ?></p></div>
</div>
                            </div>

                            <div class="bottom_icon_row">
                            <div id="profile_pic_change_div" class="change_div">
                                <a href="#3" id="change_profile_pic" aria-label="change profile picture button">
                                    <figure>

                                        <figcaption>Change Profile Picture</figcaption>
                                        <img alt="Current Profile Picture"
                                            src="<?php echo $page_profile_url;?>" />


                                        <p>Currently: Shown Above</p>
                                    </figure>
                                </a>
                                <div id="change_profile_pic_input_div"></div>
                                <div id="profile_pic_error_div" class="error_div"><p><?php echo $profile_pic_error; ?></p></div>
</div>
<div id="pronouns_change_div" class="change_div">
                                <a href="#5" id="change_pronouns" aria-label="change pronouns button">
                                    <figure>

                                        <figcaption>Change Pronouns</figcaption>
                                        <img src="./assets/icons/759440_bisexual_equality_female_gender_male_icon.png" />


                                        <p>Currently: <?php echo $page_pronouns;?></p>
                                    </figure>
                                </a>
                                <div id="change_pronouns_input_div"></div>
                                <div id="pronouns_error_div" class="error_div"><p><?php echo $pronouns_error; ?></p></div>
</div>
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


                                <div id="change_password_div" class="change_div">
                                <a href="#7" id="change_password" aria-label="change password button">
                                    <figure>

                                        <figcaption>Change Password</figcaption>
                                        <img src="./assets/icons/2931164_clef_key_lock_unlock_password_icon.png" />


                                        <p>Currently: Not shown for security reasons!</p>
                                    </figure>
                                </a>
                                <div id="change_password_input_div"></div>
                                <div id="password_error_div" class="error_div"><p><?php echo $password_error; ?></p></div>
</div>
                                <div id="change_profile_visibility_div" class="change_div">
                                <a href="#8" id="profile_visibility" aria-label="change profile visibility button">
                                    <figure>

                                        <figcaption>Change Profile Visbility</figcaption>
                                        <img src="<?php echo ($page_visibility === 0 ? './assets/icons/8665352_eye_slash_icon.png' : './assets/icons/8664880_eye_view_icon.png')?>" />


                                        <p>Currently: <?php echo ($page_visibility === 0 ? "Private": "Public");?></p>
                                    </figure>
                                </a>
                                <div id="change_visibility_input_div"></div>
                                <div id="visibility_error_div" class="error_div"><p><?php echo $visibilty_error; ?></p></div>
                                </div>
                            </div>


                            <div class="bottom_icon_row">
                            <div id="change_email_div" class="change_div">
                                <a href="#9" id="change_email" aria-label="change email button">
                                    <figure>

                                        <figcaption>Change Email Address</figcaption>
                                        <img src="./assets/icons/134146_mail_email_icon.png" />


                                        <p>Currently: <?php echo $page_email;?></p>
                                    </figure>
                                </a>
                                <div id="change_email_input_div"></div>
                                <div id="email_error_div" class="error_div"><p><?php echo $email_error; ?></p></div>
                            </div>
                            

                            <div id="delete_account_div" class="change_div">
                                <a href="#10" id="delete_account" aria-label="delete account button">
                                    <figure id="DeleteAcountFigure">


                                        <figcaption>Delete Account!</figcaption>
                                        <img src="./assets/icons/8679940_delete_bin_line_icon.png"
                                            id="DeleteAccountIcon" />



                                        <p>Can not be undone!</p>
                                    </figure>
                                </a>
                                <div id="delete_account_div"></div>
                                <div id="delete_account_error_div" class="error_div"><p><?php echo $delete_error; ?></p></div>
</div>
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
    <script src="./my_account.js"></script>
    <!--This is here to call JS to setup the edit if the user's input was bad-->
    <?php echo $js_to_setup_edit;?>
</body>

</html>