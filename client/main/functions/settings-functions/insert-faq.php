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

    // Validate description
    if (empty(trim($cater_question))) {
        $msg = 'Please enter Question.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Validate description
    if (empty(trim($cater_answer))) {
        $msg = 'Please enter Answer.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Check if the FAQ already exists
    $sql_check_existing = "SELECT COUNT(*) FROM tblclient_faqs WHERE client_id = :client_id AND cater_question = :cater_question AND cater_answer = :cater_answer";
    $stmt_check_existing = $DB_con->prepare($sql_check_existing);
    $stmt_check_existing->bindParam(':client_id', $client_id);
    $stmt_check_existing->bindParam(':cater_question', $cater_question);
    $stmt_check_existing->bindParam(':cater_answer', $cater_answer);
    $stmt_check_existing->execute();
    $existing_count = $stmt_check_existing->fetchColumn();

    if ($existing_count > 0) {
        // If the FAQ already exists, return a message
        $msg = 'FAQ already exists.';
        echo json_encode(['msg' => $msg]);
        exit();
    }

    // Generate a random FAQ ID
    $faq_id = mt_rand(10000, 99999);

    // Insert data into the database
    $sql_insert = "INSERT INTO tblclient_faqs (client_id, faq_id, cater_question, cater_answer) VALUES (:client_id, :faq_id, :cater_question, :cater_answer)";
    $stmt_insert = $DB_con->prepare($sql_insert);
    $stmt_insert->bindParam(':client_id', $client_id);
    $stmt_insert->bindParam(':faq_id', $faq_id);
    $stmt_insert->bindParam(':cater_question', $cater_question);
    $stmt_insert->bindParam(':cater_answer', $cater_answer);

    try {
        // Execute the prepared statement
        if ($stmt_insert->execute()) {
            $success = 'New FAQ successfully added!';
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
