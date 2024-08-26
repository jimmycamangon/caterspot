<?php
// Include database connection
require_once '../../config/conn.php';

function getClient($client_id)
{
    global $DB_con;

    // Prepare and execute SQL query to fetch client data based on client_id
    $sql = 'SELECT A.*,A.contact, B.cater_name, B.cater_description,B.cater_location, B.cater_email, B.about_us, B.cater_contactno, B.cater_gmaplink, B.socmed_link, B.bg_image, C.faq_id, C.cater_question, C.cater_answer FROM tbl_clients AS A 
    LEFT JOIN tblclient_settings AS B ON A.client_id = B.client_id
    LEFT JOIN tblclient_faqs AS C ON A.client_id = C.client_id
    WHERE A.client_id = :client_id';
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch client data from the result
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return client data
    return $user;
}

if (isset($_SESSION['client_id'])) {
    // Retrieve the user_id from the URL parameter
    $client_id = $_SESSION['client_id'];

    // Fetch client data based on username
    $client = getClient($client_id);


    // Example usage:
    if ($client) {
        // Access client data
        $client_username = $client['username'];
        $client_email = $client['email'];
        $client_contact = $client['contact'];
        $client_joined = $client['createdAt'];
        $client_password = $client['password'];
        $client_description = $client['cater_description'];
        $client_bg_image = $client['bg_image'];
        $client_cater_location = $client['cater_location'];
        $client_cater_name = $client['cater_name'];
        $client_cater_email = $client['cater_email'];
        $client_cater_contactno = $client['cater_contactno'];
        $client_cater_gmaplink = $client['cater_gmaplink'];
        $socmed_link = $client['socmed_link'];
        $client_about_us = $client['about_us'];
        $client_img = $client['client_image'];



    } else {
        // Client not found
        echo "User not found";
    }
}

?>