<?php
// Include database connection
require_once '../../../../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;
    $cater_question = isset($_POST['question']) ? $_POST['question'] : null;
    $cater_answer = isset($_POST['answer']) ? $_POST['answer'] : null;
    $cater_faq_id = isset($_POST['faq_id']) ? $_POST['faq_id'] : null;

    // Validate user ID
    if (!$client_id) {
        $msg = 'Client ID is required.';
        echo json_encode(['msg' => $msg]);
        exit();
    }
    
    // Fetch existing data from the database
    $sql_check_existing = "SELECT cater_question, cater_answer FROM tblclient_faqs WHERE client_id = :client_id AND faq_id = :faq_id";
    $stmt_check_existing = $DB_con->prepare($sql_check_existing);
    $stmt_check_existing->bindParam(':client_id', $client_id);
    $stmt_check_existing->bindParam(':faq_id', $cater_faq_id);
    $stmt_check_existing->execute();
    $existingData = $stmt_check_existing->fetch(PDO::FETCH_ASSOC);
    
    // Check if the fetched data matches the POST data
    if ($existingData['cater_question'] === $cater_question && $existingData['cater_answer'] === $cater_answer) {
        // If both question and answer are unchanged, no changes were made
        $msg = 'No changes were made.';
        echo json_encode(['msg' => $msg]);
        exit();
    }
    


    // Update data in the database
    $sql_update = "UPDATE tblclient_faqs SET cater_question = :cater_question, cater_answer = :cater_answer WHERE faq_id = :faq_id AND client_id = :client_id";
    $stmt_update = $DB_con->prepare($sql_update);
    $stmt_update->bindParam(':cater_question', $cater_question);
    $stmt_update->bindParam(':cater_answer', $cater_answer);
    $stmt_update->bindParam(':faq_id', $cater_faq_id);
    $stmt_update->bindParam(':client_id', $client_id);

    try {
        // Execute the prepared statement
        if ($stmt_update->execute()) {
            $success = 'FAQ successfully updated!';
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

} else {
    $msg = 'Invalid request method.';
    echo json_encode(['msg' => $msg]);
    exit();
}
?>