<?php

require_once '../../../config/conn.php';

if (isset($_GET['transactionNo'])) {
    // Get the transaction number from the URL
    $transactionNo = $_GET['transactionNo'];
    
    try {
        // Prepare and execute the SQL query to update is_read
        $stmt = $DB_con->prepare("UPDATE tbl_orders SET is_read = 1 WHERE transactionNo = ?");
        $stmt->execute([$transactionNo]);
        
    } catch (PDOException $e) {
        // Output an error message if the query fails
        echo "Error updating is_read: " . $e->getMessage();
    }
} else {
    // Output an error message if transactionNo is not set
    echo "Transaction number not provided";
}
?>
