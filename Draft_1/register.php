<?php

function username_taken($username) {
    return false;
}

require_once "config.php";

//Set all variables to ""
$firstname = $lastname = $email = $username = $password = $password_confirm = $pronouns = $date_of_birth = $phone_num = $favourite_bike = $bio = $profile_pic_error = $error = ""; 
$firstname_error = $lastname_error = $email_error = $username_error = $password_error = $password_confirm_error = $pronouns_error = $date_of_birth_error = $phone_num_error = $favourite_bike_error = $bio_error = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    $valid = true;

    //Validate first name
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
    
        else if (!filter_var(trim($_POST["email"],FILTER_VALIDATE_EMAIL))) {
            $email_error = "!!! Invalid email, please check your input !!!";
            $valid = false;
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
    //TODO!!!
    elseif (username_taken($_POST["username"])) {
        $username_error = "!!! Sorry, username taken, try something else !!!";
        $valid = false;
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
    }


    elseif (strlen($_POST["password"]) < 10) {
        $password_confirm_error = $password_error = "!!! Please enter a longer password, think of 4 random words !!!";
        $valid = false; 
    }

    

}

else {
    $username_error = "!!!BAD USERNAME!!!";
}

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./register.css">
    </link>
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
                        <li><a href="./welcome.html"><img src="./assets/icons/10406450_hi_gesture_hand_hello_interaction_icon.png" />Welcome</a></li>
                        
                        
                                

                                <li><a href="./login.html"><img src="./assets/icons/10523360_login_1_icon.png" />Login</a>
                                </li>
                                <li><a href="./register.html"><img src="./assets/icons/11030003_user_up_account_profile_icon.png" />Register</a>
                                </li>
                        <li><a href="./about_unauth.html"><img src="./assets/icons/430101_help_question_icon.png" />About Us</a>
                        </li>
                        
                        <li id="placeholder"><a></a></li>
                        <li id="logout_button"><a href="#5"><img
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
                            
                            <form id="register_form" action="./register.php"
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
                                            <input type="text" placeholder="Road Bike" id="favourite_bike" name="favourite_bike" autocomplete="off" maxlength="100" required value="<?php echo $favourite_bike; ?>"></input>
                                            <div id="fave_bike_error_div" class="error_div"><p><?php echo $favourite_bike_error; ?></p></div>
                                        </div>
                                    </div>

                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="profile_pic">Upload Profile Picture</label>
                                            <input type="file" id="profile_pic" name="profile_pic" autocomplete="off" maxlength="250" accept="image/gif, image/jpg, image/jpeg, image/png"></input>
                                            <div id="profile_pic_error_div" class="error_div"><p><?php echo $profile_pic_error; ?></p></div>
                                        </div>
                                    </div>

                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="bio">Short Bio</label>
                                            <textarea id="bio" name="bio" autocomplete="off" placeholder="I am a lover of bikes" value="<?php echo $bio; ?>"></textarea>
                                            <div id="bio_error_div" class="error_div"><p><?php echo $bio_error; ?></p></div>
                                        </div>
                                    </div>

                                    <div id="error_message_row">
                                    <p><?php echo $error; ?></p>
                                    </div>

                                    <div class="input_row" id="button_row">
                                        
                                        <button class="custom_button" id="register_button" type="submit">Register</button>
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
    <script src="./register.js"></script>
</body>

</html>
