<?php
// Include database connection
require_once '../config/conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    $firstName = isset($_POST['first_name']) ? $_POST['first_name'] : null;
    $lastName = isset($_POST['last_name']) ? $_POST['last_name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $newPassword = isset($_POST['newpass']) ? $_POST['newpass'] : null;
    $contact = isset($_POST['contact']) ? $_POST['contact'] : null;
    $location = isset($_POST['location']) ? $_POST['location'] : null;
    $region = isset($_POST['region']) ? $_POST['region'] : null;
    $province = isset($_POST['province']) ? $_POST['province'] : null;
    $city = isset($_POST['city']) ? $_POST['city'] : null;


    // Validate user ID
    if (!$user_id) {
        $msg = 'User ID is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Fetch existing data from the database
    $sql_fetch_user = "SELECT * FROM tbl_users WHERE user_id = :user_id";
    $stmt_fetch_user = $DB_con->prepare($sql_fetch_user);
    $stmt_fetch_user->bindParam(':user_id', $user_id);
    $stmt_fetch_user->execute();
    $existingUserData = $stmt_fetch_user->fetch(PDO::FETCH_ASSOC);

    // Compare form data with existing data
    if (
        $firstName == $existingUserData['firstname'] &&
        $lastName == $existingUserData['lastname'] &&
        $email == $existingUserData['email'] &&
        $contact == $existingUserData['contact'] &&
        $location == $existingUserData['location'] &&
        $username == $existingUserData['username'] &&
        $region == $existingUserData['region'] &&
        $province == $existingUserData['province'] &&
        $city == $existingUserData['city'] &&
        empty(trim($newPassword))
    ) {
        $msg = 'No changes were made.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate first name
    if (empty(trim($firstName))) {
        $msg = 'Please enter a first name.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate last name
    if (empty(trim($lastName))) {
        $msg = 'Please enter a last name.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate email
    if (empty(trim($email))) {
        $msg = 'Please enter email.';
        echo json_encode(['msg' => $msg]);
        exit();
    }
    // Validate email
    if (empty(trim($contact))) {
        $msg = 'Please enter your phone number.';
        echo json_encode(['msg' => $msg]);
        exit();
    }
    // Validate email
    if (empty(trim($location))) {
        $msg = 'Please enter your location.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate username
    if (empty(trim($username))) {
        $msg = 'Please enter a username.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate password
    if (!empty(trim($newPassword))) {
        if (strlen($newPassword) < 8) {
            $msg = 'New Password must be at least 8 characters long.';
            echo json_encode(['msg' => $msg]);
            exit();
        }
    }

    // Retrieve old password from the database
    $sql_select_password = "SELECT password FROM tbl_users WHERE user_id = :user_id";
    $stmt_select_password = $DB_con->prepare($sql_select_password);
    $stmt_select_password->bindParam(':user_id', $user_id);
    $stmt_select_password->execute();
    $row = $stmt_select_password->fetch(PDO::FETCH_ASSOC);
    $oldPassword = $row['password'];

    // Compare old password with new password
    if (!empty(trim($newPassword))) {
        if (password_verify($newPassword, $oldPassword)) {
            $msg = 'New password must be different from the old password.';
            echo json_encode(['msg' => $msg]);
            exit();
        } else {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            // Update data in the database
            $sql = "UPDATE tbl_users SET firstname = :firstname, lastname = :lastname, password = :password, email = :email, username = :username, contact = :contact, region = :region, province = :province, city = :city, location = :location  WHERE user_id = :user_id";
            $stmt = $DB_con->prepare($sql);
            $stmt->bindParam(':firstname', $firstName);
            $stmt->bindParam(':lastname', $lastName);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':region', $region);
            $stmt->bindParam(':province', $province);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':user_id', $user_id);

            try {
                // Execute the prepared statement
                if ($stmt->execute()) {
                    $success = 'Profile successfully updated!';
                    echo json_encode(['success' => $success]);
                    exit();
                } else {
                    $msg = 'Oops! Something went wrong. Please try again later.';
                    echo json_encode(['msg' => $msg]);
                    exit();
                }
            } catch (PDOException $e) {
                $msg = 'Error: ' . $e->getMessage();
                echo json_encode(['msg' => $msg]);
                exit();
            }

        }
    } else {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update data in the database
        $sql = "UPDATE tbl_users SET firstname = :firstname, lastname = :lastname, email = :email, username = :username, contact = :contact, region = :region, province = :province, city = :city, location = :location  WHERE user_id = :user_id";
        $stmt = $DB_con->prepare($sql);
        $stmt->bindParam(':firstname', $firstName);
        $stmt->bindParam(':lastname', $lastName);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':region', $region);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':user_id', $user_id);

        try {
            // Execute the prepared statement
            if ($stmt->execute()) {
                $success = 'Profile successfully updated!';
                echo json_encode(['success' => $success]);
                exit();
            } else {
                $msg = 'Oops! Something went wrong. Please try again later.';
                echo json_encode(['msg' => $msg]);
                exit();
            }
        } catch (PDOException $e) {
            $msg = 'Error: ' . $e->getMessage();
            echo json_encode(['msg' => $msg]);
            exit();
        }
    }

} else {
    $msg = 'Invalid request method.';
    echo json_encode(['msg' => $msg]);
    exit();
}
?>