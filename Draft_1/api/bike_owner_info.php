<?php

session_start();

if(!isset($_SESSION["loggedin"])) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}


require_once "../config.php";

$result = [];

$sql = "SELECT 
vehicle_id,user_id,advert_title,description,
bike_model,bike_lower_price,bike_upper_price,bike_quality,
manufacture_year,colour,image_url
FROM bike_details WHERE user_id = ?";

if ($q = $mysqli->prepare($sql)) {
    $param_username = $_SESSION["id"];
    $q->bind_param("s", $param_username);
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
                    "vehicle_id" => $vehicle_id,
                    "user_id" => $user_id
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

var_dump($result,0);

/*

$data = [
    [
        "bike_id" => "0xdeadbeef",
        "bike_ad_name" => "Greg's Bike for sale",
        "bike_model" => "Brompton Mk1",
        "lower_asking_price" => "1000",
        "upper_asking_price" => "2000",
        "bike_quality" => "Poor",
        "bike_birthday" => "2023",
        "image_url" => "./assets/images/bike_1.jpg",
        "bike_colour_code" => "#1F00A2",
        "description" => "This is a stellar bike, that's got 1 mile"
    ],
    [
        "bike_id" => "0xdeadbeef",
        "bike_ad_name" => "Greg's Bike for sale",
        "bike_model" => "Brompton Mk1",
        "lower_asking_price" => "1000",
        "upper_asking_price" => "2000",
        "bike_quality" => "Poor",
        "bike_birthday" => "2023",
        "image_url" => "./assets/images/bike_1.jpg",
        "bike_colour_code" => "#1F00A2",
        "description" => "This is a stellar bike, that's got 1 mile"
    ]
];

// Convert data to JSON
$jsonResult = json_encode($data, JSON_PRETTY_PRINT);

// Set response headers to indicate JSON content
header('Content-Type: application/json');

// Output the JSON
echo $jsonResult;

*/


?>