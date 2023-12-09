<?php

require_once "config.php";

//Query the table for the username

function save_user_profile_pic($extension) {
    $target_path = "./assets/users/profile_pictures";
    if (is_null($extension)) {
        return $target_path . "/default_avatar.png";
    }
    
    $tempname = tempnam($target_path,"img");
    $target = $tempname . "." . $extension;
    copy($tempname,$target);
    move_uploaded_file($_FILES["profile_pic"]["tmp_name"],$target);
    //tempnam returns a FULL path (e.g. /var/www/html/...) I just want a relative path
    $relative_path =  $target_path."/". basename($target);

    return $relative_path;
}

function username_taken($username,$mysqli) {


    $sql = "SELECT user_id FROM users WHERE username = ?";
    if($stmt = $mysqli->prepare($sql)) {
        $param_username = trim($_POST["username"]);
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



//Set all variables to ""
$firstname = $lastname = $email = $username = $password = $password_confirm = $pronouns = $date_of_birth = $phone_num = $favourite_bike = $bio = $profile_pic_error = $error = ""; 
$firstname_error = $lastname_error = $email_error = $username_error = $password_error = $password_confirm_error = $pronouns_error = $date_of_birth_error = $phone_num_error = $favourite_bike_error = $bio_error = "";
$bdate = null;
$target = null;
$extension = null;

if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    if (
        isset($_SERVER['CONTENT_LENGTH']) &&
        (int) $_SERVER['CONTENT_LENGTH'] > (1024 * 1024 * (int) ini_get('post_max_size'))
    ) {
        error_log("ERROR: Sent message too long",0);
        // Code to be executed if the uploaded file has size > post_max_size
        // Will issue a PHP warning message 

            $max_upload = (int) (ini_get('post_max_size'));
            $profile_pic_error = $error = "!!! Error, sorry the uploaded files were too big, no changes were saved, the max size is {$max_upload}MB!!!";
           $valid = false;
        
    }

    

    //Validate first name
    else {
        $valid = true;
    
    if (!isset($_POST["firstname"])) {
        $firstname_error = "!!! Sorry, firstname was not set !!!";
        $valid = false;
    }

    else if (empty(trim($_POST["firstname"]))) {
        $firstname_error = "!!! Please set firstname !!!";
        $valid = false;
    }


    elseif (!preg_match("/[a-zA-Z0-9_'\-\.]{1,30}/", trim($_POST["firstname"]))) {
        $firstname_error = "!!! Invalid first name, it should be less than 30 alphanumeric characters or _, - , . , ' !!!";
        $valid = false;
        $firstname = htmlspecialchars($_POST["firstname"]);
    }

    else {
        $firstname = htmlspecialchars($_POST["firstname"]);
    }
    //End of first name validation


        //Validate last name
        if (!isset($_POST["lastname"])) {
            $lastname_error = "!!! Sorry, lastname was not set !!!";
            $valid = false;
        }
    
        else if (empty(trim($_POST["lastname"]))) {
            $lastname_error = "!!! Please set lastname !!!";
            $valid = false;
        }
    
    
        elseif (!preg_match("/[a-zA-Z0-9_'\-\.]{1,30}/", trim($_POST["lastname"]))) {
            $lastname_error = "!!! Invalid lastname, it should be less than 30 alphanumeric characters or _, - , . , ' !!!";
            $valid = false;
            $lastname = htmlspecialchars($_POST["lastname"]);
        }

        else {
            $lastname = htmlspecialchars($_POST["lastname"]);
        }
        //End of last name validation

        //Email validation
        if (!isset($_POST["email"])) {
            $email_error = "!!! Sorry, email was not set !!!";
            $valid = false;
        }
    
        else if (empty(trim($_POST["email"]))) {
            $email_error = "!!! Please set email !!!";
            $valid = false;
        }
    
        else if (!(filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))) {
            $email_error = "!!! Invalid email, please check your input !!!";
            $valid = false;
            $email = htmlspecialchars($_POST["email"]);
        }

        else if (strlen($_POST["email"])> 100) {
            $email_error = "!!! Invalid email, must be less than 100 characters !!!";
            $valid = false;
            $email = htmlspecialchars($_POST["email"]);
        }

        else {
            $email = htmlspecialchars($_POST["email"]);
        }
        //End of email validation



    // Validate username

    if (!isset($_POST["username"])) {
        $username_error = "!!! Sorry, username was not set !!!";
        $valid = false;
    }

    elseif(empty(trim($_POST["username"]))){
        $username_error = "!!! Please enter a username !!!";
        $valid = false;

    } elseif(!preg_match('/[a-zA-Z0-9_]{1,20}/', trim($_POST["username"]))){
        $username_error = "!!! Username can only contain letters, numbers, and underscores. !!!";
        $valid = false;
        $username = htmlspecialchars($_POST["username"]);
    }
    
    elseif (username_taken($_POST["username"],$mysqli)) {
        $username_error = "!!! Sorry, username taken, try something else !!!";
        $valid = false;
        $username = htmlspecialchars($_POST["username"]);
    }

    else {
        $username = htmlspecialchars($_POST["username"]);
    }

    //End of username validation

    //Password validation

    if (!isset($_POST["password"]) || !isset($_POST["password_confirm"])) {
        $password_confirm_error = $password_error = "!!! Sorry, password was not set !!!";
        $valid = false;
    }

    elseif(empty(trim($_POST["password"])) || empty(trim($_POST["password_confirm"]))){
        $password_confirm_error = $password_error = "!!! Please enter a password and confirm it!!!";
        $valid = false;

    }

    elseif ($_POST["password"] !== $_POST["password_confirm"]) {
        $password_confirm_error = $password_error = "!!! Passwords DON'T match !!!";
        $valid = false; 
        $password  = htmlspecialchars($_POST["password"]);
        $password_confirm = htmlspecialchars($_POST["password_confirm"]);
    }


    elseif (strlen($_POST["password"]) < 10) {
        $password_confirm_error = $password_error = "!!! Please enter a longer password, think of 4 random words !!!";
        $valid = false;
        $password = $password_confirm = htmlspecialchars($_POST["password"]);
    }

    elseif (strlen($_POST["password"]) > 72) {
        $password_confirm_error = $password_error = "!!! Please enter a shorter password, 72 characters is the max !!!";
        $valid = false;
        $password = $password_confirm = htmlspecialchars($_POST["password"]);
    }

    else {
        $password = $password_confirm = htmlspecialchars($_POST["password"]);
    }

    //End of password validation

    //Start pronoun validation
    if (!isset($_POST["pronouns"])) {
        $pronouns_error = "!!! Sorry, pronouns were not set !!!";
        $valid = false;
    }

    elseif(empty(trim($_POST["pronouns"]))){
        $pronouns_error = "!!! Sorry, pronouns were empty !!!";
        $valid = false;

    }
    elseif($_POST["pronouns"] !== "he/him" && $_POST["pronouns"] !== "she/her" && $_POST["pronouns"] !== "they/them"){
        $pronouns_error = "!!! Sorry, pronouns must be he/him, she/her or they/them !!!";
        $valid = false;
    }
    //End of pronoun validation

    //Validate date of birth
    if (!isset($_POST["date_of_birth"])) {
        $date_of_birth_error = "!!! Sorry, date of birth was not set !!!";
        $valid = false;
    }

    elseif(empty(trim($_POST["date_of_birth"]))){
        $date_of_birth_error = "!!! Sorry, date of birth is empty !!!";
        $valid = false;

    }

    //If date is not empty, then perform date checks
    else {
        $bdate = new DateTime($_POST["date_of_birth"]);
        
        //No under 18s
        $min = DateInterval::createFromDateString("18 years");
        //No over 100s
        $max = DateInterval::createFromDateString("100 years");
    
        $date_now = new DateTime();
        $min_dob = (new DateTime())->sub($min);
        $max_dob = (new DateTime())->sub($max);

        if ($bdate > $date_now) {
            
            $date_of_birth_error = "!!! No dates in the future !!!";
            $valid = false;
        }

        elseif ($bdate <= $max_dob) {
            $date_of_birth_error = "!!! No over 100s !!!";
            $valid = false;
        }

        elseif ($bdate >= $min_dob) {
            $date_of_birth_error = "!!! No under 18s !!!";
            $valid = false;
        }
    
        $date_of_birth = htmlspecialchars(strval($bdate->format("Y-m-d")));
    }
    //End of date of birth validation

    //Validate phone number
    //Format of 01234567890
    $mobile_pattern = "/\d{11}/";

    if (!isset($_POST["phone_num"])) {
        $phone_num_error = "!!! Sorry, phone number was not set !!!";
        $valid = false;
    }

    elseif(empty(trim($_POST["phone_num"]))){
        $phone_num_error = "!!! Sorry, phone number is empty !!!";
        $valid = false;
    }

    elseif (!preg_match($mobile_pattern, $_POST["phone_num"])) {
        $phone_num_error = "!!! Sorry, phone number must match format of 01234567890 !!!";
        $valid = false;
        $phone_num = htmlentities($_POST["phone_num"]);
    }

    else {
        $phone_num = htmlentities($_POST["phone_num"]);
    }
    
    //Stop phone number validation



    //Validate favourite bike
    if (!isset($_POST["favourite_bike"])) {
        $favourite_bike_error = "!!! Sorry, favourite bike was not set !!!";
        $valid = false;
    }

    elseif(empty(trim($_POST["favourite_bike"]))){
        $favourite_bike_error = "!!! Sorry, favourite bike is empty !!!";
        $valid = false;
    }

    elseif (strlen($_POST["favourite_bike"]) > 50) {
        $favourite_bike_error = "!!! Sorry, favourite bike must be less than 50 characters !!!";
        $valid = false;
        $favourite_bike = htmlentities($_POST["favourite_bike"]);
    }

    else {
        $favourite_bike = htmlentities($_POST["favourite_bike"]);
    }
    
    //Stop favourite bike validation

    //Validate bio (Not REQUIRED)
    if(!empty(trim($_POST["bio"]))) {
        
        if (strlen($_POST["bio"]) > 200) {
        $bio_error = "!!! Sorry, bio was too long, must be 200 characters or less !!!";
        $bio = htmlentities($_POST["bio"]);
        $valid = false;
        }

        else {
            $bio = htmlentities($_POST["bio"]);
        }
    }

    //Stop bio validation

    //Profile Picture Validation
    
    //Not required, so no error if no profile picture
    if (file_exists($_FILES['profile_pic']['tmp_name']) || is_uploaded_file($_FILES['profile_pic']['tmp_name'])) {

        error_log("File not empty",0);

        //Get the original file name to get the extension of original file
        $original_file_name = strtolower($_FILES["profile_pic"]["name"]);
        $extension = pathinfo($original_file_name, PATHINFO_EXTENSION);

        //Get the filetype of the "image"
        $mime_type = exif_imagetype($_FILES["profile_pic"]["tmp_name"]);
        //Allowed Extensions
        $allowed_ext = array('gif', 'png', 'jpg',"jpeg","webp");
        $allowed_mime_type = array(IMAGETYPE_GIF,IMAGETYPE_JPEG,IMAGETYPE_PNG,IMAGETYPE_WEBP);
        $str_extensions = implode(", ",$allowed_ext);
        //If extension not allowed, error
        if (!in_array($extension,$allowed_ext)) {
            $profile_pic_error = "!!! Only {$str_extensions} extensions allowed !!!";
            $valid = false;
        }
        
        //Check if a valid image mime type
        else if (!in_array($mime_type,$allowed_mime_type)) {
            $profile_pic_error = "!!! Only {$str_extensions} extensions allowed !!!";
            $valid = false;
        }

        
        

    }

    else if (isset($_FILES["profile_pic"])) {
        if ($_FILES["profile_pic"]["error"] === UPLOAD_ERR_INI_SIZE) {
            $max_upload = (int) (ini_get('upload_max_filesize'));
            $profile_pic_error = "!!! Sorry, uploaded file is too big, max size is {$max_upload}MB!!!";
            $valid = false;

        }
    }

    //End profile picture validation

    //Now save the info (if valid)
    }

    

    if ($valid == true) {
        //If valid, THEN save the profile picture
        //Create the file and store in $target (a random file name in assets/users/profile_pictures    

        $relative_path = save_user_profile_pic($extension);

        $sql_insert_statement = "INSERT INTO users 
        (username,password,email,first_name,last_name,pronouns,dateofbirth,description,favourite_bike,telephone,profile_url,visibility,registration_date)
        VALUES (?,?,?,?,?,?,DATE(?),?,?,?,?,?,DATE(?))";

        if ($statement = $mysqli->prepare($sql_insert_statement)) {
            error_log("Statement there",0);
            $statement->bind_param("sssssssssssis",$param_username,$param_password,$param_email,$param_first_name,$param_last_name,$param_pronouns,$param_dateofbirth,$param_description,$param_favourite_bike,$param_telephone,$param_profile_url,$param_visibility,$param_registration_date);
            
            $param_username = trim($_POST["username"]);
            //Hash the password, never store in plainext ;)
            $param_password = password_hash($_POST["password"],PASSWORD_BCRYPT);
            $param_email = $_POST["email"];
            $param_first_name = $_POST["firstname"];
            $param_last_name = $_POST["lastname"];
            $param_pronouns = $_POST["pronouns"];
            $param_dateofbirth = $_POST["date_of_birth"];
            $param_description = $_POST["bio"];
            $param_favourite_bike = $_POST["favourite_bike"];
            $param_telephone = $_POST["phone_num"];
            $param_profile_url = $relative_path;
            $param_visibility = 1;
            $param_registration_date = (new DateTime())->format("Y-m-d");
 

            if($statement->execute()) {
                header("Location: login.php?msg=Registered Succesfully, Please Login!");
            }
            else {
                error_log("ERROR: Executing statement",0);
            }

            $statement->close();

        }
        else {
            error_log("Bad :(",0);
        }

        $mysqli->close();

    }
    //If input is invalid
    else {
        $error = "!!! Errors, please fix !!!";
    }
}




?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./register.css">
    </link>
    <link rel="icon" type="image/x-icon" href="./assets/icons/favicon.ico.png"></link>
    <meta charset="utf-8"/>
    <title>Register</title>
</head>

<body>
    <article>
        <header>
            <div id="wrapper">
                <div id="PageHeader">
                    <h1>The Bike House</h1>
                    <br></br>
                    <p>Register</p>
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
                    
                    <div class='right-column'>
                        <div class="main_body_container">
                            
                            <form id="register_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                method="post" enctype="multipart/form-data">
                                <div class="form_main">
                                    <h1><u>Enter your details!</u></h1>
                                    <p>* Denotes a required field</p>
                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="firstname">First Name *</label>
                                            <input type="text" placeholder="Your first name" id="firstname" name="firstname" required autocomplete="off" maxlength="30" value="<?php echo $firstname; ?>"></input>
                                            <div id="firstname_error_div" class="error_div"><p><?php echo $firstname_error; ?></p></div>
                                        </div>
                                        <div class="input_col">
                                            <label for="lastname">Last Name *</label>
                                            <input type="text" placeholder="Your last name" id="lastname" name="lastname" required autocomplete="off" maxlength="30" value="<?php echo $lastname; ?>"></input>
                                            <div id="lastname_error_div" class="error_div"><p><?php echo $lastname_error; ?></p></div>

                                        </div>
                                    </div>
                                    

                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="email">Email *</label>
                                            <input type="email" placeholder="Your email" id="email" name="email" required autocomplete="off" value="<?php echo $email; ?>"></input>
                                            <div id="email_error_div" class="error_div"><p><?php echo $email_error; ?></p></div>
                                        </div>

                                        <div class="input_col" id="username_column">
                                            <label for="username">Username *</label>
                                            <input type="text" placeholder="Your new username" id="username" name="username" required autocomplete="off" maxlength="20" value="<?php echo $username; ?>"></input>
                                            <div id="username_error_div" class="error_div"><p><?php echo $username_error; ?></p></div>
                                        </div>
                                    </div>


                                    <div class="input_row">
                                        <div class="input_col" id="password_col">
                                            <label for="password">Password *</label>
                                            <input type="password" placeholder="Strong Password!" id="password" minlength="10" name="password" required autocomplete="off" value="<?php echo $password; ?>"></input>
                                            <div id="password_error_div" class="error_div"><p><?php echo $password_error; ?></p></div>
                                        </div>

                                        <div class="input_col" id="password_confirm_col">
                                            <label for="password_confirm">Password (Confirmation) *</label>
                                            <input type="password" placeholder="Strong Password Again!" id="password_confirm" minlength="10" name="password_confirm" required autocomplete="off" value="<?php echo $password_confirm; ?>"></input>
                                            <div id="password_confirm_error_div" class="error_div"><p><?php echo $password_confirm_error; ?></p></div>
                                        </div>
                                    </div>



                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="pronouns">Pronouns *</label>
                                            <select id="pronouns" name="pronouns">
                                                <option value="he/him">He/him</option>
                                                <option value="she/her">She/her</option>
                                                <option value="they/them">They/them</option>
                                              </select>
                                              <div id="pronoun_error_div" class="error_div"><p><?php echo $pronouns_error; ?></p></div>                                            
                                        </div>

                                        <div class="input_col">
                                            <label for="date_of_birth">Date of Birth *</label>
                                            <input type="date" placeholder="01/01/2000" id="date_of_birth" name="date_of_birth" required autocomplete="off" value="<?php echo $date_of_birth; ?>"></input>
                                            <div id="date_of_birth_error_div" class="error_div"><p><?php echo $date_of_birth_error; ?></p></div>
                                        </div>
                                    </div>

                                    


                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="phone_num">Phone Number *</label>
                                            <input placeholder="07924424222" type="tel" id="phone_num" name="phone_num" required autocomplete="off" value="<?php echo $phone_num; ?>"></input>
                                            <div id="phone_num_error_div" class="error_div"><p><?php echo $phone_num_error; ?></p></div>
                                        </div>

                                        <div class="input_col">
                                            <label for="favourite_bike">Favourite Bike *</label>
                                            <input type="text" placeholder="Road Bike" id="favourite_bike" name="favourite_bike" autocomplete="off" maxlength="50" required value="<?php echo $favourite_bike; ?>"></input>
                                            <div id="fave_bike_error_div" class="error_div"><p><?php echo $favourite_bike_error; ?></p></div>
                                        </div>
                                    </div>

                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="profile_pic">Upload Profile Picture</label>
                                            <input type="file" id="profile_pic" name="profile_pic" autocomplete="off" accept="image/gif, image/jpg, image/jpeg, image/png,image/webp"></input>
                                            <div id="profile_pic_error_div" class="error_div"><p><?php echo $profile_pic_error; ?></p></div>
                                        </div>
                                    </div>

                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="bio">Short Bio</label>
                                            <textarea id="bio" name="bio" autocomplete="off" placeholder="I am a lover of bikes"><?php echo $bio; ?></textarea>
                                            <div id="bio_error_div" class="error_div"><p><?php echo $bio_error; ?></p></div>
                                        </div>
                                    </div>

                                    <div id="error_message_row" class="error_div">
                                    <p style="font-size: x-large"><?php echo $error; ?></p>
                                    </div>

                                    <div class="input_row" id="button_row">
                                    <button class="custom_button" id="clear_button" type="reset">Clear</button>
                                        <button class="custom_button" id="register_button" type="submit">Register</button>
                                        
                                    
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
    <script src="./register.js"></script>
    <?php 
    //Focus at bottom of page (the error message) if not valid
    if (isset($valid) && $valid === false) {
        echo "<script>document.getElementById('error_message_row').scrollIntoView();</script>";
    }
    ?>
</body>

</html>
