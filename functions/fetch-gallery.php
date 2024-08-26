<?php
// Include database connection
require_once 'config/conn.php';

function getGallery($client_id)
{
    global $DB_con;

    // Prepare and execute SQL query to fetch client data based on username
    $sql = 'SELECT A.* FROM tblclient_gallery AS A
    LEFT JOIN tbl_clients AS B ON A.client_id = B.client_id
    WHERE A.client_id = :client_id';
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch client data from the result
    $gallery = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return client data
    return $gallery;
}

if (isset($_GET['cater']) && isset($_GET['id'])) {
    // Retrieve the username from the URL parameter
    $username = $_GET['cater'];
    $client_id = $_GET['id'];

    // Fetch client data based on username
    $gallery = getGallery($client_id);


    // Example usage:
    if ($gallery) {

        // Access client data
        $gallery_uniqid = $gallery['uniq_id'];
        $gallery_id = $gallery['client_id'];
    } else {
        // Client not found
        echo "Client not found";
    }
}

?>