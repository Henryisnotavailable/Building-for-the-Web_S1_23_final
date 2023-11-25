<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'www-data');
define('DB_PASSWORD', '5tr0ng_P455W0RD!');
define("DB_NAME","rentmybike");

$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

if($conn === false) {
    error_log("ERROR: Could not connect :( ". mysqli_connect_error(), 0);
    die("ERROR: Could not connect :( ". mysqli_connect_error());
}

else {
    error_log("DEBUG: DATABASE connected!", 0);
}


?>