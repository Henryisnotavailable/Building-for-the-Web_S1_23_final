<?php



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
    header("HTTP/1.1 403 Forbidden");
    exit;
}

//If no query parameter, we can't do anything
if (!isset($_GET["query"])) {
    header("HTTP/1.1 400 Bad Request");
    exit;
}


require_once "../config.php";

$result = [];
$user_query = $_GET["query"]; 

//If the query is a digit, then search for price
if (ctype_digit($user_query)) {
    error_log("DEBUG: Querying bike_search for bike_price $user_query");
    $sql = "SELECT 
    vehicle_id,user_id,advert_title,description,
    bike_model,bike_lower_price,bike_upper_price,bike_quality,
    manufacture_year,colour,image_url
    FROM bike_details WHERE (? >= bike_lower_price AND  ? <= bike_upper_price);";
    $param = (int)$user_query;
    $bind = "dd";
}

//Otherwise check the bike model and advert title
else {
    $sql = "SELECT 
vehicle_id,user_id,advert_title,description,
    bike_model,bike_lower_price,bike_upper_price,bike_quality,
    manufacture_year,colour,image_url
    FROM bike_details WHERE (advert_title LIKE ? OR bike_model LIKE ?)";
        $param = "%$user_query%";
        $bind = "ss";
}

if ($q = $mysqli->prepare($sql)) {
    $param_username = $_SESSION["id"];
    $q->bind_param($bind, $param,$param);
    //Execute query
    if($q->execute()) {
        //Store query result
        $q->store_result();

        if($q->num_rows > 0) {
            $q->bind_result($vehicle_id,$user_id,$title,$description, $bike_model, $bike_lower_price,$bike_upper_price,$bike_quality,$manufacture_year,$colour,$image_url);
            //Loop over each result (e.g. each bike the user uploaded)
            while ($q -> fetch()) {
        
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
                    "bike_colour_code" =>$colour,
                    "description" => $description
                ];
                array_push($result,$test); 
            }


           
        }
        

        //User owns no bikes :(, the JS will handle
        else {
            //Just log it
            error_log("ERROR: No results for user {$_SESSION['username']}",0);
        }
        $q->close();

    }

    $mysqli->close();

}



else {
    error_log("ERROR: Failed preparing statement",0);
}

//var_dump($result,0);



$jason = $result;

// Convert data to JSON
$jsonResult = json_encode($jason, JSON_PRETTY_PRINT);

// Set response headers to indicate JSON content
header('Content-Type: application/json');

// Output the JSON
echo $jsonResult;




?>