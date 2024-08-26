<?php
// Include the database configuration file if needed
require_once '../../../../config/conn.php';

// Check if files are sent
if (isset($_FILES['files']) && isset($_POST['client_id']) && isset($_POST['service'])) {
    // Retrieve client_id and service
    $client_id = $_POST['client_id'];
    $service = $_POST['service'];

    // Count total files
    $countfiles = count($_FILES['files']['name']);

    // Check if number of files exceeds 10
    if ($countfiles > 10) {
        $error_msg = "You can only upload up to 10 images.";
        echo json_encode(['error' => $error_msg]);
        exit();
    }

    // Upload Location
    $upload_location = "../../../../assets/img/client-gallery/";

    // To store uploaded files path
    $files_arr = array();

    // Loop all files
    for ($index = 0; $index < $countfiles; $index++) {

        if (isset($_FILES['files']['name'][$index]) && $_FILES['files']['name'][$index] != '') {
            // File name
            $filename = $_FILES['files']['name'][$index];

            // Get extension
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            // Valid image extension
            $valid_ext = array("png", "jpeg", "jpg");

            // Check extension
            if (in_array($ext, $valid_ext)) {

                // Check file size
                $file_size = $_FILES['files']['size'][$index];
                $max_size = 2 * 1024 * 1024; // 2MB (in bytes)

                if ($file_size > $max_size) {
                    $error_msg = "File size exceeds the limit of 2MB.";
                    echo json_encode(['error' => $error_msg]);
                    exit();
                }

                // Generate unique ID
                $uniq_id = mt_rand(10000, 99999);

                // File path
                $path = $upload_location . $filename;

                // Upload file
                if (move_uploaded_file($_FILES['files']['tmp_name'][$index], $path)) {
                    $files_arr[] = $path;

                    // Insert into database
                    $sql = "INSERT INTO tblclient_gallery (client_id, uniq_id, service, file_name) VALUES (:client_id, :uniq_id, :service, :file_name)";
                    $stmt = $DB_con->prepare($sql);
                    $stmt->bindParam(':client_id', $client_id);
                    $stmt->bindParam(':uniq_id', $uniq_id);
                    $stmt->bindParam(':file_name', $filename);
                    $stmt->bindParam(':service', $service);

                    if ($stmt->execute()) {
                        $success = 'Image successfully uploaded!';
                        // Don't exit here to process all files
                    } else {
                        // Insertion failed
                        $error_msg = "Error inserting file into database";
                        echo json_encode(['error' => $error_msg]);
                        exit();
                    }
                } else {
                    $error_msg = "Error moving file to upload location";
                    echo json_encode(['error' => $error_msg]);
                    exit();
                }
            } else {
                $error_msg = "Invalid file type. Only PNG, JPEG, and JPG files are allowed.";
                echo json_encode(['error' => $error_msg]);
                exit();
            }
        }
    }

    // If all files were processed successfully
    $success = "Images uploaded successfully!";
    echo json_encode(['success' => $success]);
    exit();
} else {
    $error_msg = "Missing client_id, service, or files.";
    echo json_encode(['error' => $error_msg]);
    exit();
}
?>
