<?php
// Include database connection
require_once '../../../config/conn.php';

if (isset($_POST['cater_name'])) {
    $cater_name = $_POST['cater_name'];

    // Fetch the email from the tbl_applications table based on the selected catering name
    $sql = "SELECT gmail FROM tbl_applications WHERE business_name = :cater_name";
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':cater_name', $cater_name, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row['gmail'];  // Return the email to the JavaScript
    } else {
        echo '';  // Return an empty string if no email is found
    }
}
?>
