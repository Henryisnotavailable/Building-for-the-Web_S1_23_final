<?php

session_start();


//If user is logged in, redirect to main page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: index.php");
    exit;
}

if (isset($_GET["msg"])) {
    $error = htmlspecialchars($_GET["msg"]);
}

else {
    $error = "";
}


//Inclue SQL connection
require_once "./config.php";

$username = $password = "";
$username_error = $password_error = "";
$valid = true;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Validate username
    
    if(!isset($_POST["username"])) {
        $valid = false;
        $username_error = "!!! Username not set !!!";
    }

    else if (empty(trim($_POST["username"]))) {
        $valid = false;
        $username_error = "!!! Username cannot be empty !!!";
    }

    else if ($_POST["username"] == "admin") {
        $valid = false;
        $username_error = "No";
        $username = htmlspecialchars($_POST["username"]);
    }

    else {
        $username = htmlspecialchars($_POST["username"]);
    }

    //End of user validation


    if(!isset($_POST["password"])) {
        $valid = false;
        $password_error = "!!! Password not set !!!";
    }

    else if (empty(trim($_POST["password"]))) {
        $valid = false;
        $password_error = "!!! Password cannot be empty !!!";
    }

    else if ($_POST["password"] == "admin") {
        $valid = false;
        $password_error = "No";
        $password = htmlspecialchars($_POST["password"]);
    }

    else {
        $password = htmlspecialchars($_POST["password"]);
    }


    if ($valid === true) {
        //SQL to check if user exists, username is Primary key so this should only return 1 result
        $sql = "SELECT user_id,username,password,profile_url FROM users WHERE username = ?";

        if ($q = $mysqli->prepare($sql)) {
            $param_username = trim($_POST["username"]);
            $q->bind_param("s", $param_username);

            //Execute query
            if($q->execute()) {
                //Store query result
                $q->store_result();
                //If username exists, retrieve the password HASH (storing passwords in plaintext is never a good idea...)
                if($q->num_rows == 1) {
                    $q->bind_result($id,$username, $pwd_hash, $profile_pic_url);
                    if ($q -> fetch()) {
                        //Verify if the entered password matches the hash
                        if(password_verify(trim($_POST["password"]),$pwd_hash)) {
                                session_destroy();
                                session_start();

                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                                $_SESSION["profile_picture"] = $profile_pic_url;

                                if (isset($_POST["redirect_to"])) {
                                    $redirect_to = $_POST["redirect_to"];
                                    header("Location: a_bike_viewer.php?id={$redirect_to}");

                                }
                                else {
                                header("Location: index.php");
                                }
                        }
                        //Invalid PASSWORD
                        else {
                            //Generic error message
                            $error = "!!! Invalid credentials, Please review !!!";
                        }
                    }


                   
                }
                

                //Invalid USERNAME
                else {
                    //Generic error message is more secure
                    $error = "!!! Invalid credentials, please review !!!";
                }
                $q->close();

            }

        }

        else {
            $error = "!!! Website Error, Something Went Wrong, please try again later !!!";
        }

    }

    else {
        $error = "!!! Error, please review !!!";
    }

    $mysqli->close();


}


?>




<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="./login.css">
    </link>
    <link rel="icon" type="image/x-icon" href="./assets/icons/favicon.ico.png"></link>
    <meta charset="utf-8"/>
    <title>Login</title>
</head>

<body>
    <article>
        <header>
            <div id="wrapper">
                <div id="PageHeader">
                    <h1>The Bike House</h1>
                    <br></br>
                    <p>Login</p>
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
                            
                            <form id="login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                method="post">
                                <div class="form_main">
                                    <h1><u>Login here!</u></h1>
                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="username">Username</label>
                                            <input type="text" placeholder="Byk3m4n"
                                                id="username" name="username" autocomplete="on" required value="<?php echo $username;?>"></input>
                                                <div id="username_error_div" class="error_div"><p><?php echo $username_error; ?></p></div>
                                        </div>
                                    </div>
                                    <div class="input_row">
                                        <div class="input_col">
                                            <label for="password">Password</label>
                                            <input type="password" placeholder="1234" id="password" name="password" autocomplete="on" required value="<?php echo $username;?>"></input>
                                            <div id="password_error_div" class="error_div"><p><?php echo $password_error; ?></p></div>
                                        </div>


                                    </div>


                                    
                                    

                                    <div id="error_message_row" class="error_div">
                                    <p style="font-size: x-large"><?php echo $error; ?></p>
                                    </div>

                                    <?php
                                    //If user clicked on a bike to get here, use this to redirect them after logging in
                                    if (isset($_GET["redirect_to"])) {
                                        $redirect_to = htmlspecialchars($_GET["redirect_to"]);
                                        echo "<input name='redirect_to' id='redirect_value' type='number' value={$redirect_to}></input>";
                                    }
                                    
                                    ?>
                                    

                                    <div class="input_row" id="button_row">
                                    <button class="custom_button" id="clear_button" type="reset">Clear</button>
                                        <button class="custom_button" id="login_button" type="submit">Login</button>
                                        

                                    </div>
                                </div>
                            </form>







                            <div class="social_media_row">

                                <a href="https://twitter.com"><img
                                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/X_logo_2023_original.svg/2048px-X_logo_2023_original.svg.png" /></a>

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
    <script src="./sell.js"></script>
</body>

</html>