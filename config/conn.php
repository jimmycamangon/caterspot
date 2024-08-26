<?php
// Start the session
session_start();

// Database configuration
// $DB_host = "127.0.0.1:3306";
// $DB_user = "u682755333_caterspotadmin";
// $DB_pass = "Lig/56kMk|0c";
// $DB_name = "u682755333_dbcaterspot";


$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "";
$DB_name = "dbcaterspot";
// Set the default timezone
date_default_timezone_set('Asia/Manila');

try {
     // Create a PDO instance for database connection
     $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);

     // Set PDO attributes for better error handling
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $DB_con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
     // Output an error message if connection fails
     echo $e->getMessage();
}
?>