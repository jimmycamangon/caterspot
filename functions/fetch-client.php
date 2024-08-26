<?php
// Include database connection
require_once 'config/conn.php';

function getClient($client_id)
{
    global $DB_con;

    // Prepare and execute SQL query to fetch client data based on username
    $sql = 'SELECT A.*,A.contact, B.cater_name, B.cater_location,B.cater_email, B.about_us, B.bg_image, B.cater_contactno, B.socmed_link, B.cater_gmaplink FROM tbl_clients AS A
    LEFT JOIN tblclient_settings AS B ON A.client_id = B.client_id
    WHERE B.client_id = :client_id';
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch client data from the result
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return client data
    return $client;
}

if (isset($_GET['id'])) {

    $client_id = $_GET['id'];


    // Fetch client data based on username
    $client = getClient($client_id);

    // Example usage:
    if ($client) {
        // Access client data
        $clientUsername = $client['username'];
        // You can access other columns similarly
        $clientAddress = $client['address'];

        $cater_location = $client['cater_location'];
        $cater_email = $client['cater_email'];
        $client_cater_id = $client_id;
        $cater_contactno = $client['cater_contactno'];
        $cater_gmaplink = $client['cater_gmaplink'];
        $socmed_link = $client['socmed_link'];
        $cater_about_us = $client['about_us'];
        $cater_bg_image = $client['bg_image'];
        $client_contact = $client['contact'];
        $cater_name = $client['cater_name'];
        $client_email = $client['email'];
        $client_image = $client['client_image'];

    } else {
        // Client not found
        echo "Client not found";
    }
}
?>
