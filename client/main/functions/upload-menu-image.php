<?php
// Check if file was uploaded without errors
if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0){
    $allowedExtensions = array("jpg", "jpeg", "png");
    $fileExtension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

    // Check if the file extension is allowed
    if(in_array($fileExtension, $allowedExtensions)){
        $uploadDir = "../../../assets/img/menu-uploads/";
        $uploadPath = $uploadDir . basename($_FILES["file"]["name"]);

        // Get the filename without the path
        $filename = basename($_FILES["file"]["name"]);

        // Upload the file with the correct filename
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $uploadDir . $filename)){
            echo "File uploaded successfully.";
        } else{
            echo "Error uploading file.";
        }
    } else{
        echo "Invalid file extension.";
    }
} else{
    echo "Error: " . $_FILES["file"]["error"];
}
?>
