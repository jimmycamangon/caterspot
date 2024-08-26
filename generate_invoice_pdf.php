<?php
require_once 'config/conn.php';
// Include FPDF library
require ('assets/vendor/fpdf/fpdf.php');

$transactionNo = $_GET['transaction_no'];
$fullName = $_GET['full_name'];
$contactNumber = $_GET['contact_number'];
$email = $_GET['email'];
$location = $_GET['location'];
$paymentMethod = $_GET['payment_method'];
$attendees = $_GET['attendees'];
$eventDate = $_GET['event_date'];
$eventDuration = $_GET['event_duration'];
$subtotal = $_GET['subtotal'];
$tax = $_GET['tax'];
$cater = $_GET['cater'];
$cater_location = !empty($_GET['cater_location']) ? $_GET['cater_location'] : 'N/A';
$cater_contactno = !empty($_GET['cater_contactno']) ? $_GET['cater_contactno'] : 'N/A';

$initial_payment = $_GET['initial_payment'];
$balance = $_GET['balance'];
$grandTotal = $_GET['grand_total'];
$selected_items = $_GET['selected_items'];
// Get client image
$client_image = 'assets/img/client-images/' . $_GET['client_image'];
$payment_selection = $_GET['payment_selection'];




$selectedItemsSerialized = $selected_items;
// Extract the JSON string from the serialized data using regular expressions
preg_match('/s:\d+:"(.*?)";/', $selectedItemsSerialized, $matches);
$selectedItemsJSON = $matches[1];

// Unserialize the JSON string into an array
$selectedItemsArray = json_decode($selectedItemsJSON, true);


// Create a new PDF instance
$pdf = new FPDF();
$pdf->AddPage();

// Display client image at the top right corner
$pdf->Image($client_image, 160, 10, 30);

$pdf->SetFont('Times', 'B', 14); // Times New Roman, bold, size 16
$pdf->Cell(0, 10, $cater, 0, 1);
// Set font to Times New Roman
$pdf->SetFont('Times', '', 10); // Times New Roman, regular, size 12


$pdf->SetFont('Times', 'B', 10); // Set font to Times New Roman, bold, size 12
$pdf->Cell(30, 10, 'Location:', 0, 0); // Cell for the label
$pdf->SetFont('Times', '', 10); // Reset font style to regular
$pdf->Cell(0, 10, $cater_location, 0, 1); // Cell for the value

$pdf->SetFont('Times', 'B', 10); // Set font to Times New Roman, bold, size 12
$pdf->Cell(30, 10, 'Contact No:', 0, 0); // Cell for the label
$pdf->SetFont('Times', '', 10); // Reset font style to regular
$pdf->Cell(0, 10, $cater_contactno, 0, 1); // Cell for the value

$pdf->Ln(10); // Add some vertical space

// Logo
// $pdf->Image('path/to/logo.png', 10, 10, 30); // Adjust the path and coordinates as needed


// Invoice details
$pdf->SetFont('Times', 'B', 10); // Set font to Times New Roman, bold, size 12

$pdf->Cell(30, 10, 'Bill To:', 0, 0); // Cell for the label
$pdf->SetFont('Times', '', 10); // Reset font style to regular
$pdf->Cell(0, 10, $fullName, 0, 1); // Cell for the value

$pdf->SetFont('Times', 'B', 10); // Set font to Times New Roman, bold, size 12
$pdf->Cell(30, 10, 'Address:', 0, 0); // Cell for the label
$pdf->SetFont('Times', '', 10); // Reset font style to regular
$pdf->Cell(0, 10, $location, 0, 1); // Cell for the value


$pdf->SetFont('Times', 'B', 10); // Set font to Times New Roman, bold, size 12
$pdf->Cell(30, 10, 'Contact No.:', 0, 0); // Cell for the label
$pdf->SetFont('Times', '', 10); // Reset font style to regular
$pdf->Cell(0, 10, $contactNumber, 0, 1); // Cell for the value


$pdf->SetFont('Times', 'B', 10); // Set font to Times New Roman, bold, size 12
$pdf->Cell(30, 10, 'Period:', 0, 0); // Cell for the label
$pdf->SetFont('Times', '', 10); // Reset font style to regular
$pdf->Cell(0, 10, $eventDate, 0, 1); // Cell for the value

$pdf->SetFont('Times', 'B', 10); // Set font to Times New Roman, bold, size 12
$pdf->Cell(30, 10, 'Payment Type:', 0, 0); // Cell for the label
$pdf->SetFont('Times', '', 10); // Reset font style to regular
$pdf->Cell(0, 10, $payment_selection, 0, 1); // Cell for the value

$pdf->Ln(10); // Add some vertical space

// Invoice title
$pdf->SetFont('Times', 'B', 14); // Times New Roman, bold, size 16
$pdf->Cell(0, 10, 'Invoice for Transaction No. ' . $transactionNo, 0, 1, 'C');
$pdf->Ln(10); // Add some vertical space

// Invoice table header
$pdf->SetFont('Times', 'B', 10); // Times New Roman, bold, size 12
$pdf->Cell(60, 10, 'Package', 1);
$pdf->Cell(50, 10, 'Item', 1);
$pdf->Cell(40, 10, 'Quantity', 1);
$pdf->Cell(40, 10, 'Line Total', 1);
$pdf->Ln(); // Move to the next row

$pdf->SetFont('Times', '', 10); // Times New Roman, regular, size 12

foreach ($selectedItemsArray as $menu) {
    $menu_id = $menu['menu_id'];
    $menuQuantity = $menu['quantity'];
    $menuPrice = $menu['price'];

    $sum = $menuPrice * $menuQuantity;
    // Fetch the menu details based on the menu ID
    $stmt = $DB_con->prepare("SELECT B.package_name,A.menu_id, A.menu_name, A.menu_price, A.menu_image, A.menu_description
    FROM tbl_menus AS A 
    LEFT JOIN tbl_packages AS B ON A.package_id = B.package_id
    WHERE A.menu_id = :menu_id");

    $stmt->bindParam(':menu_id', $menu_id);
    $stmt->execute();
    $menu = $stmt->fetch(PDO::FETCH_ASSOC);

    // Truncate menu description if it exceeds 50 characters
    $menu_name = $menu['menu_name'];
    if (strlen($menu_name) > 50) {
        $menu_name = substr($menu_name, 0, 48) . '...'; // Truncate and add ellipsis
    }

    // Invoice table rows (sample data)
    $pdf->Cell(60, 10, $menu['package_name'], 1);
    $pdf->Cell(50, 10, $menu_name, 1); // Display truncated description
    $pdf->Cell(40, 10, $menuQuantity, 1);
    $pdf->Cell(40, 10, 'PHP ' . $sum, 1, 0, 'R'); // Align to the right
    $pdf->Ln(); // Move to the next row
}

if ($initial_payment > 0 || $balance > 0) {
    // Total section

    $pdf->Cell(150, 10, 'Subtotal:', 0, 0, 'R');
    $pdf->Cell(40, 10, 'PHP ' . $subtotal, 0, 1, 'R');
    $pdf->Cell(150, 10, 'Tax:', 0, 0, 'R');
    $pdf->Cell(40, 10, 'PHP ' . $tax, 0, 1, 'R');
    $pdf->SetFont('Times', 'B', 10); // Times New Roman, bold, size 12
    $pdf->Cell(150, 10, 'Grand Total:', 0, 0, 'R');
    $pdf->Cell(40, 10, 'PHP ' . $grandTotal, 0, 1, 'R');
    $pdf->SetFont('Times', '', 10); // Reset font style to regular
    $pdf->Cell(150, 10, '', 0, 0, 'R');
    $pdf->Cell(40, 10, '__________________________________', 0, 1, 'R');
    $pdf->Cell(150, 10, 'Initial Payment:', 0, 0, 'R');
    $pdf->Cell(40, 10, 'PHP ' . $initial_payment, 0, 1, 'R');
    $pdf->SetFont('Times', 'B', 10); // Times New Roman, bold, size 12
    $pdf->Cell(150, 10, 'Balance Due:', 0, 0, 'R');
    $pdf->Cell(40, 10, 'PHP ' . $balance, 0, 1, 'R');
    $pdf->SetFont('Times', '', 10); // Reset font style to regular

} else {
    // Total section
    $pdf->Cell(150, 10, 'Subtotal:', 0, 0, 'R');
    $pdf->Cell(40, 10, 'PHP ' . $subtotal, 0, 1, 'R');
    $pdf->Cell(150, 10, 'Tax:', 0, 0, 'R');
    $pdf->Cell(40, 10, 'PHP ' . $tax, 0, 1, 'R');
    $pdf->Cell(150, 10, '', 0, 0, 'R');
    $pdf->Cell(40, 10, '__________________________________', 0, 1, 'R');
    $pdf->SetFont('Times', 'B', 10); // Times New Roman, bold, size 12
    $pdf->Cell(150, 10, 'Grand Total:', 0, 0, 'R');
    $pdf->Cell(40, 10, 'PHP ' . $grandTotal, 0, 1, 'R');
    $pdf->SetFont('Times', '', 10); // Reset font style to regular
}



// Output the PDF
$pdf->Output('Invoice_' . $transactionNo . '.pdf', 'D');
?>