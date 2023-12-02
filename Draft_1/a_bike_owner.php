<?php


function update_media($file_tempname,$extension,$old_name) {
    

    //If there is an old image, remove it
    if (!is_null($old_name)) {
        $path = pathinfo($old_name);
        unlink($old_name);
        //There are 2 files, the random file and the random file + extension
        unlink($path["dirname"].'/'.$path["filename"]);
    }

    $target_path = "./assets/users/bikes";  
    //Generate a new unique EMPTY file  
    $tempname = tempnam($target_path,"img");

    //New filename = random + old_extension
    $target = $tempname . "." . $extension;

    //Copy unique empty file to new filename 
    copy($tempname,$target);

    //Move temporary file from POST to ./assets/users/bikes/
    move_uploaded_file($file_tempname,$target);
    //tempnam returns a FULL path (e.g. /var/www/html/...) I just want a relative path
    $relative_path =  $target_path."/". basename($target);

    //unlink($target);
    //unlink($tempname);
    error_log("DEBUG: Replacing old image {$old_name} with {$relative_path}",0);
    return $relative_path;
}

session_start();


if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php?msg=Please Login First");
    exit;
}

if (!isset($_GET["id"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
    header("Location: index.php?msg=!!! Error: Please choose a bike from 'My Bikes' !!!");
    exit;
}

    //Validate all receieved data
    //Set all variables to ""
    $page_title = $page_bike_lower_price = $page_bike_upper_price = $page_description = $page_bike_model = $page_bike_lower_price = $page_bike_upper_price = $page_bike_quality = $page_bike_manufacture_year = $page_bike_mileage = $page_num_seats = $page_colour = $page_is_electric = $page_other_media_url = $page_profile_url = $page_username = $page_registration_date = $page_telephone = $page_pronouns = $page_email = $page_favourite_bike = $page_user_description = '';
    $ad_title_error = $bike_model_error = $asking_price_lower_error = $asking_price_upper_error = $bike_quality_error = $bike_date_of_birth_error = $bike_mileage_error = $bike_seats_error = $is_bike_electric_error = $bike_colour_error = $bike_bio_error = "";
    
    //$ad_title_error = "Potato";
    $bike_photo_error = $bike_other_media_error = "";
    
    $error = "";
    $vehicle_retreived = false;
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
                    //If user tries viewing a bike that's not theirs, then redirect to a viewer page
                    if ($owner_user_id !== $_SESSION["id"]) {
                        error_log("DEBUG: User doesn't own this bike... Redirecting", 0);
                        header("Location: a_bike_viewer.php?msg=You are not the owner of this bike&id={$_GET['id']}");
                        exit;
                    }



                    error_log("DEBUG: HIT {$bike_id}", 0);
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
                    $page_other_media_url = htmlspecialchars($other_media_url);
                    $page_colour = htmlspecialchars($colour);

                    $page_is_electric = ($is_electric == 1) ? "checked" : "";
                    $vehicle_retreived = true;


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
    //If user posted data (e.g. if editing) then handle it
else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Get current values of vehicle
    $bike_id = $_POST["bike_id"];
    $select_sql = "SELECT vehicle_id,user_id,advert_title,
    description,bike_model,bike_lower_price,bike_upper_price,bike_quality,
    bike_mileage,manufacture_year,num_seats,other_media_url,colour,image_url,is_electric
    FROM bike_details WHERE vehicle_id = ?";

if ($q = $mysqli->prepare($select_sql)) {
    
    $q->bind_param("s", $bike_id);
    //Execute query
    if ($q->execute()) {
        //Store query result
        $q->store_result();

        if ($q->num_rows > 0) {
            $q->bind_result($vehicle_id, $owner_user_id, $title, $description, $bike_model, $bike_lower_price, $bike_upper_price, $bike_quality, $bike_mileage, $manufacture_year, $num_seats, $other_media_url, $colour, $image_url, $is_electric);
            //Get the bike
            if ($q->fetch()) {
                //If user tries editing a bike that's not theirs, then redirect to a viewer page
                if ($owner_user_id !== $_SESSION["id"]) {
                    error_log("DEBUG: User doesn't own this bike... Redirecting", 0);
                    header("Location: a_bike_viewer.php?msg=You are not the owner of this bike");
                    exit;
                }

                $vehicle_retreived = true;


            }



        }


        //Bike doesn't exist
        else {
            //Just log it
            error_log("ERROR: No results for user {$_SESSION['username']}", 0);
            echo("That bike doesn't exist");
            exit;
        }
        $q->close();

    } else {
        error_log("ERROR: Could not execute query", 0);
    }



    $valid = true;

    //Ad Title validation
    if (!isset($_POST["advert_title"])) {
        $valid = false;
        $ad_title_error = "!!! Please set advert title !!!";
    } else if (empty(trim($_POST["advert_title"]))) {
        $ad_title_error = "!!! The advert title cannot be empty !!!";
        $valid = false;
    } elseif (!preg_match("/[a-zA-Z0-9_'\-\.]{4,50}/", trim($_POST["advert_title"]))) {
        $ad_title_error = "!!! Invalid advert title, it should be less than 50 alphanumeric characters !!!";
        $valid = false;
        $page_title = htmlspecialchars($_POST["advert_title"]);
    } else {
        $page_title = htmlspecialchars($_POST["advert_title"]);
    }
    //End ad title validation
    //Validate bike model
    if (!isset($_POST["bike_model"])) {
        $valid = false;
        $bike_model_error = "!!! Please set bike model !!!";
    } else if (empty(trim($_POST["bike_model"]))) {
        $bike_model_error = "!!! The bike model cannot be empty !!!";
        $valid = false;
    } elseif (!preg_match("/[a-zA-Z0-9_'\-\.]{4,30}/", trim($_POST["bike_model"]))) {
        $bike_model_error = "!!! Invalid bike model, it should be less than 30 alphanumeric characters !!!";
        $valid = false;
        $page_bike_model = htmlspecialchars($_POST["bike_model"]);
    } else {
        $page_bike_model = htmlspecialchars($_POST["bike_model"]);
    }
    //End of bike model validation

    //Validate lower and upper asking price
    if (!isset($_POST["asking_price_lower"])) {
        $valid = false;
        $asking_price_lower_error = "!!! Please set lower asking price !!!";
    } else if (empty(trim($_POST["asking_price_lower"]))) {
        $asking_price_lower_error = "!!! The lower asking price cannot be empty !!!";
        $valid = false;
    }




    if (!isset($_POST["asking_price_upper"])) {
        $valid = false;
        $asking_price_upper_error = "!!! Please set upper asking price !!!";
    } else if (empty(trim($_POST["asking_price_upper"]))) {
        $asking_price_upper_error = "!!! The upper asking price cannot be empty !!!";
        $valid = false;
    }

    $both_positive = true;
    //Check if positive number
    if (!ctype_digit(trim($_POST["asking_price_lower"]))) {
        $asking_price_lower_error = "!!! Invalid lower asking price, it must be a positive whole number !!!";
        $valid = false;
        $page_bike_lower_price = htmlspecialchars($_POST["asking_price_lower"]);
        $both_positive = false;
    }

    if (!ctype_digit(trim($_POST["asking_price_upper"]))) {
        $asking_price_upper_error = "!!! Invalid upper asking price, it must be a positive whole number !!!";
        $valid = false;
        $page_bike_upper_price = htmlspecialchars($_POST["asking_price_upper"]);
        $both_positive = false;
    }

    //If both are numbers, cast to ints
    if ($both_positive === true) {
        $lower_int = intval(trim($_POST["asking_price_lower"]));
        $upper_int = intval(trim($_POST["asking_price_upper"]));

        if ($lower_int > $upper_int) {
            $asking_price_lower_error = $asking_price_upper_error = "!!! The lower price cannot be more than the upper price !!!";
            $valid = false;
        } else if ($lower_int > 10000 || $lower_int < 50) {
            $asking_price_lower_error = "!!! Lower asking price must be between 50 - 10,000!!!";
            $valid = false;
        }

        if ($upper_int > 10000 || $upper_int < 50) {
            $asking_price_upper_error = "!!! Upper asking price must be between 50 - 10,000!!!";
            $valid = false;
        }

        $page_bike_upper_price = htmlspecialchars($_POST["asking_price_upper"]);
        $page_bike_lower_price = htmlspecialchars($_POST["asking_price_lower"]);

    }
    //End of bike price validation

    //Validate bike quality values
    if (!isset($_POST["bike_quality"])) {
        $valid = false;
        $bike_quality_error = "!!! Please set bike quality !!!";
    }
    //This was throwing when the user set bike quality to 0 (Broken) because empty(0) === true
    else if (empty(trim($_POST["bike_quality"])) && strlen(trim($_POST["bike_quality"])) == 0) {
        $bike_quality_error = "!!! The bike quality cannot be empty !!!";
        $valid = false;
    }

    //If the user submits via HTML this >should< always be a number (because it's a slider)
    else if (!ctype_digit($_POST["bike_quality"])) {
        $bike_quality_error = "!!! The bike quality must be a number between 0-5 !!!";
        $valid = false;
    } elseif (intval(trim($_POST["bike_quality"])) > 5 || intval(trim($_POST["bike_quality"])) < 0) {
        $bike_quality_error = "!!! Invalid bike quality, it should be a number between 0-5 !!!";
        $valid = false;
    } else {
        $page_bike_quality = htmlspecialchars($_POST["bike_quality"]);
    }
    //End of validation for bike quality values

    //Validate bike manufacture year
    if (!isset($_POST["bike_date_of_birth"])) {
        $valid = false;
        $bike_date_of_birth_error = "!!! Please set bike year of birth !!!";
    } else if (empty(trim($_POST["bike_date_of_birth"]))) {
        $bike_date_of_birth_error = "!!! The bike year of birth cannot be empty !!!";
        $valid = false;
    }

    //If the user submits via HTML this >should< always be a number (because it's a slider)
    else if (!ctype_digit($_POST["bike_date_of_birth"])) {
        $bike_date_of_birth_error = "!!! The bike year of birth must be a number !!!";
        $valid = false;
        $page_bike_manufacture_year = htmlspecialchars($_POST["bike_date_of_birth"]);

    }


    //If bike was made in the future, error
    elseif (intval(trim($_POST["bike_date_of_birth"])) > intval((new DateTime)->format("Y"))) {
        $bike_date_of_birth_error = "!!! The bike cannot be made in the future, sorry... !!!";
        $page_bike_manufacture_year = htmlspecialchars($_POST["bike_date_of_birth"]);
        $valid = false;
    }

    //If bike was made before the first ever bike (Full disclosure, 1817 was the first result from google. It may be wrong)
    elseif (intval(trim($_POST["bike_date_of_birth"])) < 1817) {
        $bike_date_of_birth_error = "!!! The first bike was made in 1817, I doubt your bike was made before that !!!";
        $page_bike_manufacture_year = htmlspecialchars($_POST["bike_date_of_birth"]);
        $valid = false;
    } else {
        $page_bike_manufacture_year = htmlspecialchars($_POST["bike_date_of_birth"]);
    }

    //End of bike manufacture date validation

    //Validate bike mileage values

    if (!isset($_POST["bike_mileage"])) {
        $valid = false;
        $bike_mileage_error = "!!! Please set bike mileage !!!";
    } else if (empty(trim($_POST["bike_mileage"]))) {
        $bike_mileage_error = "!!! The bike mileage cannot be empty !!!";
        $valid = false;
    }

    //If the user submits via HTML this >should< always be a number (because it's a slider)
    else if (!ctype_digit($_POST["bike_mileage"])) {
        $bike_mileage_error = "!!! The bike mileage must be a ->number<- between 0-1100+ !!!";
        $valid = false;
        $page_bike_mileage = htmlspecialchars($_POST["bike_mileage"]);
    } elseif (intval(trim($_POST["bike_mileage"])) > 1100 || intval(trim($_POST["bike_mileage"])) < 0) {
        $bike_mileage_error = "!!! The bike mileage must be a number between 0-1100+ !!!";
        $valid = false;
        $page_bike_mileage = htmlspecialchars($_POST["bike_mileage"]);
    }

    //Check if divisible by 100, to ensure the value is in steps of 100 (same as the HTML slider)
    elseif (intval(trim($_POST["bike_mileage"])) % 100 !== 0) {
        $bike_mileage_error = "!!! The bike mileage must be a number divisible by 100 between 0-1100+ (e.g. 300, 700, 1000) !!!";
        $valid = false;
        $page_bike_mileage = htmlspecialchars($_POST["bike_mileage"]);
    } else {
        $page_bike_mileage = htmlspecialchars($_POST["bike_mileage"]);
    }
    //End of validation for bike mileage values



    //Start of Bike seats validation

    if (!isset($_POST["bike_seats"])) {
        $valid = false;
        $bike_seats_error = "!!! Please set bike seats !!!";
    } else if (empty(trim($_POST["bike_seats"]))) {
        $bike_seats_error = "!!! The bike seats cannot be empty !!!";
        $valid = false;
    }

    //If the user submits via HTML this >should< always be a number (because it's a slider)
    else if (!ctype_digit($_POST["bike_seats"])) {
        $bike_seats_error = "!!! The bike seat must be a ->number<- between 1-3 !!!";
        $valid = false;
        $page_num_seats = htmlspecialchars($_POST["bike_seats"]);
    } elseif (intval(trim($_POST["bike_seats"])) > 3 || intval(trim($_POST["bike_seats"])) < 1) {
        $bike_seats_error = "!!! The bike seat must be a number between 1-3 !!!";
        $valid = false;
        $page_num_seats = htmlspecialchars($_POST["bike_seats"]);
    } else {
        $page_num_seats = htmlspecialchars($_POST["bike_seats"]);
    }
    //End of validation for bike seats

    //Start of Bike seats validation
//If a checkbox is NOT selected, it isn't even sent.
    if (isset($_POST["is_electric"])) {
        $page_is_electric = "checked";
    } else {
        $page_is_electric = "";
    }
    //End of bike seats validation

    //Validate bike colour

    $colour_pattern = "/#[a-fA-F0-9]{6}/";
    if (!isset($_POST["favourite_bike_colour"])) {
        $valid = false;
        $bike_colour_error = "!!! Please set bike colour !!!";
    } else if (empty(trim($_POST["favourite_bike_colour"]))) {
        $bike_colour_error = "!!! The bike colour cannot be empty !!!";
        $valid = false;
    }

    //If not matches hex pattern like #BEDEAD
    else if (!preg_match($colour_pattern, trim($_POST["favourite_bike_colour"]))) {
        $bike_colour_error = "!!! The bike colour must be a valid hex code with # !!!";
        $valid = false;
        $page_colour = htmlspecialchars($_POST["favourite_bike_colour"]);
    } else {
        $page_colour = htmlspecialchars($_POST["favourite_bike_colour"]);
    }
    //End bike colour validation

    //Validate bike description (Not required)
    if (isset($_POST["bike_desc"])) {



        //200 Characters is the max length
        if (strlen($_POST["bike_desc"]) > 200) {
            $bike_bio_error = "!!! The bike description cannot be more than 200 characters !!!";
            $valid = false;
            $page_description = htmlspecialchars($_POST["bike_desc"]);
        } else {
            $page_description = htmlspecialchars($_POST["bike_desc"]);
        }
    }
    //End bike description validation


    //Validate bike_pic, we will save it later
    if (file_exists($_FILES['bike_pic']['tmp_name']) || is_uploaded_file($_FILES['bike_pic']['tmp_name'])) {


        $original_file_name = strtolower($_FILES["bike_pic"]["name"]);
        $bike_img_extension = pathinfo($original_file_name, PATHINFO_EXTENSION);

        //Get the filetype of the "image"
        $mime_type = exif_imagetype($_FILES["bike_pic"]["tmp_name"]);
        //Allowed Extensions
        $allowed_ext = array('gif', 'png', 'jpg', "jpeg", "webp");
        $allowed_mime_type = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP);
        $str_extensions = implode(", ", $allowed_ext);
        //If extension not allowed, error
        if (!in_array($bike_img_extension, $allowed_ext)) {
            $bike_photo_error = "!!! Only {$str_extensions} extensions allowed !!!";
            $valid = false;
        }

        //Check if a valid image mime type
        else if (!in_array($mime_type, $allowed_mime_type)) {
            $bike_photo_error = "!!! Only {$str_extensions} file types allowed !!!";
            $valid = false;
        }

        //Because this is updating the image, if the user DOESN'T want to update, keep the old one
    } 
    //End of bike_pic validation



    //Validate extra media (not required, so no error if not there)

    if (isset($_FILES["upload_media"])) {

        if (file_exists($_FILES['upload_media']['tmp_name']) || is_uploaded_file($_FILES['upload_media']['tmp_name'])) {
            error_log("Hit media upload part", 0);
            $original_file_name = strtolower($_FILES["upload_media"]["name"]);
            $other_media_extension = pathinfo($original_file_name, PATHINFO_EXTENSION);
            error_log($other_media_extension, 0);
            //Get the filetype of the "image"
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $_FILES["upload_media"]["tmp_name"]);
            //Allowed Extensions
            $allowed_ext = array('gif', 'png', 'jpg', "jpeg", "webm", "mp4", "webp", "ogg", "ogv");
            $allowed_mime_type = array("image/gif", "image/png", "image/jpg", "image/jpeg", "video/mp4", "video/webm", "video/webp", "video/ogg");
            $str_extensions = implode(", ", $allowed_ext);

            //If extension not allowed, error
            if (!in_array($other_media_extension, $allowed_ext)) {
                $bike_other_media_error = "!!! Only {$str_extensions} extensions allowed !!!";
                $valid = false;
            }

            //Check if a valid image mime type
            else if (!in_array($mime_type, $allowed_mime_type)) {
                $bike_other_media_error = "!!! Only {$str_extensions} file types allowed !!!";
                $valid = false;
            }
        }

        //If file is too big, then handle
        else if ($_FILES["upload_media"]["error"] === UPLOAD_ERR_INI_SIZE) {
            $max_upload = (int) (ini_get('upload_max_filesize'));
            $bike_other_media_error = "!!! Sorry, uploaded file is too big, max size is {$max_upload}MB!!!";
            $valid = false;
        }




    }

    if ($valid == true) {

        $relative_bike_media_path = $other_media_url;
        $relative_bike_img_path = $image_url;

        //If user set a new bike, update it
        if (isset($bike_img_extension)) {
            //Save image to disk, and return relative path. This removes the old image with the new
            $relative_bike_img_path = update_media($_FILES["bike_pic"]["tmp_name"], $bike_img_extension, $image_url);
        } 

        if (file_exists($_FILES['upload_media']['tmp_name']) || is_uploaded_file($_FILES['upload_media']['tmp_name'])) {
            //Save media to disk and return relative path
            $relative_bike_media_path = update_media($_FILES["upload_media"]["tmp_name"], $other_media_extension, $other_media_url);
        }



        $page_image_url = htmlspecialchars($relative_bike_img_path);

        $sql_insert_statement = "UPDATE bike_details 
            SET 
            advert_title = ?, description = ?, bike_model = ?, bike_lower_price = ?,
            bike_upper_price = ?, bike_quality = ?, bike_mileage = ?, manufacture_year = ?, 
            num_seats = ?, other_media_url = ?, image_url = ?, colour = ?, is_electric = ?  
            WHERE vehicle_id = ?";


        if ($statement = $mysqli->prepare($sql_insert_statement)) {
            error_log("DEBUG: Binding parameters to UPDATE statement", 0);
            $statement->bind_param("sssiiiisisssii", $param_advert_title, $param_description, $param_bike_model, $param_bike_lower_price, $param_bike_upper_price, $param_bike_quality, $param_bike_mileage, $param_manufacture_year, $param_num_seats, $param_other_media_url, $param_image_url, $param_colour, $param_is_electric, $param_vehicle_id);
            //$param_user_id = $_SESSION["id"];
            $param_vehicle_id = $_POST["bike_id"];
            $param_advert_title = trim($_POST["advert_title"]);
            $param_description = trim($_POST["bike_desc"]);
            $param_bike_model = trim($_POST["bike_model"]);
            $param_bike_lower_price = intval(trim($_POST["asking_price_lower"]));
            $param_bike_upper_price = intval(trim($_POST["asking_price_upper"]));
            $param_bike_quality = intval(trim($_POST["bike_quality"]));
            $param_bike_mileage = intval(trim($_POST["bike_mileage"]));
            $param_manufacture_year = (trim($_POST["bike_date_of_birth"]));
            $param_num_seats = intval(trim($_POST["bike_seats"]));
            $param_other_media_url = $relative_bike_media_path;
            $param_image_url = $relative_bike_img_path;
            $param_colour = $_POST["favourite_bike_colour"];
            $param_is_electric = $page_is_electric ? 1 : 0;



            if ($statement->execute()) {
                //Get the last inserted ID, to redirect the user
                
                header("Location: a_bike_owner.php?id={$_POST['bike_id']}");
            } else {
                error_log("ERROR: Executing statement", 0);
            }

            $statement->close();

        } else {
            error_log("ERROR: Could not prepare statement", 0);
        }


    } else {
        $error = "!!! Errors, please review !!!";
        $page_image_url = $image_url;
        $page_other_media_url = $other_media_url;
    }

}

}

//Handle when user wants to DELETE a bike (calling code is in the JS)
else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

    
    if(!isset($_GET["bike_id"])) {
        header("Location: index.php?msg=Sorry, there was no bike specified in the delete request");
        exit;
    }

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
    $bike_id = $_GET["bike_id"];
    $user_id = $_SESSION["id"];
    //Make sure users can only delete their own bikes
    $sql = "DELETE FROM bike_details WHERE vehicle_id = ? AND user_id = ?";
    if ($q = $mysqli->prepare($sql)) {
        
        $q->bind_param("ii", $bike_id,$user_id);

        //Execute query
        if($q->execute()) {
               $error = "Deleted bike account!";
        }
        //Delete failed (user tried deleting non-existent bike or bike they don't own)
        else {
            $error = "!!! Website Error, Something Went Wrong, please try again later !!!";
            http_response_code(403);
        }

        $q->close();
            $mysqli->close();
            exit;
    }

    else {
        $error = "!!! Website Error, Something Went Wrong, please try again later !!!";
    }

}


//This populates the owners details, as long as the bike was loaded properly (e.g. it exists and the current user owns it)
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
}

$mysqli->close();

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

                            <form id="sell_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>"
                                method="post" enctype="multipart/form-data">
                                <input readonly id="bike_id" name="bike_id" value="<?php if ($_SERVER["REQUEST_METHOD"] == "GET") { echo $_GET["id"];} elseif (isset($_POST["bike_id"])) {echo $_POST["bike_id"];} ?>"></input>
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
                                                <div id="bike_model_error_div" class="error_div"><p><?php echo $bike_model_error; ?></p></div>
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


                                    <div id="error_message_row" class="error_div">
                                    <p style="font-size: x-large"><?php echo $error; ?></p>
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
    <?php
    //If the user is POSTing data, then they should be put back into edit mode, to avoid re-pressing the button
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<script>setup_edit(null)</script>";
    };
    ?>
    <?php 
    //Focus at bottom of page (the error message) if not valid
    if (isset($valid) && $valid === false) {
        echo "<script>document.getElementById('error_message_row').scrollIntoView();</script>";
    }
    ?>
</body>

</html>