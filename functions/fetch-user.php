<?php
// Include database connection
require_once 'config/conn.php';

function getUserByUserID($user_id)
{
    global $DB_con;

    // Prepare and execute SQL query to fetch user data based on user_id
    $sql = 'SELECT A.*, B.regDesc, C.provDesc, D.citymunDesc  FROM tbl_users AS A
            LEFT JOIN tbl_refregion AS B ON A.region = B.regCode
            LEFT JOIN tbl_refprovince AS C ON A.province = C.provCode
            LEFT JOIN tbl_refcitymun AS D ON A.city = D.citymunCode
            WHERE user_id = :user_id';
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch client data from the result
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return client data
    return $user;
}

if (isset($_SESSION['user_id'])) {
    // Retrieve the user_id from the URL parameter
    $user_id = $_SESSION['user_id'];

    // Fetch client data based on username
    $user = getUserByUserID($user_id);


    // Example usage:
    if ($user) {
        // Access client data
        $Username = $user['username'];
        $Userfullname = ucwords($user['firstname']) . ' ' . ucwords($user['lastname']);
        $Userfirstname = $user['firstname'];
        $Userlastname = $user['lastname'];
        $Useremail = $user['email'];
        $Userjoined = $user['createdAt'];
        $Usercontact = $user['contact'];
        $UserRegion = $user['regDesc'];
        $UserProvince = $user['provDesc'];
        $UserCity = $user['citymunDesc'];
        $Userlocation = $user['location'];
        $Userpassword = $user['password']; // Include the hashed password

    } else {
        // Client not found
        echo "User not found";
    }
}

?>