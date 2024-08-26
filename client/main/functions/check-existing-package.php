<?php
// Include database connection
require_once '../../../config/conn.php';

// Check if the package_id is set in the POST data
if(isset($_POST['package_id'])) {
    $package_id = $_POST['package_id'];

    // Query to check if there are any existing menus connected with the package
    $sql = "SELECT COUNT(*) AS menu_count
            FROM tbl_menus
            WHERE package_id = :package_id";

    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $menu_count = $result['menu_count'];

    // Prepare data to send back as JSON
    $response = array();

    if ($menu_count > 0) {
        // If there are existing menus
        $response['exists'] = true;
    } else {
        // If there are no existing menus
        $response['exists'] = false;
    }

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If package_id is not set in the POST data, return an error response
    http_response_code(400);
    echo json_encode(array("error" => "Package ID not provided"));
}
?>
