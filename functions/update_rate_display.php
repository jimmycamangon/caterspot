<?php

require_once '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['transactionNo'])) {
        $transactionNo = $_POST['transactionNo'];

        // Update the database
        $updateRate = $DB_con->prepare("UPDATE tbl_orders SET isRateDisplayed = 1 WHERE transactionNo = :transactionNo");
        $updateRate->bindParam(':transactionNo', $transactionNo);
        $updateRate->execute();
    } else {
        echo 'transactionNo not set';
    }
}
?>
