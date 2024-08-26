<?php
// Include the database connection file
require_once '../config/conn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data

    $selected_products = $_POST['selected_products'];

    try {
        // Prepare the SQL statement
        $stmt = $DB_con->prepare("INSERT INTO orders_item (selected_products) VALUES ( :selected_products)");

        // Bind parameters to prepared statement

        $stmt->bindParam(':selected_products', $selected_products);

        // Execute the prepared statement
        $stmt->execute();

        exit();
    } catch(PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
