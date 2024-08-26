<?php
require_once '../../config/conn.php';
// Include FPDF library
require ('../../assets/vendor/fpdf/fpdf.php');

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
$grandTotal = $_GET['grand_total'];
$address = $_GET['address'];
$selected_items = $_GET['selected_items'];


$selectedItemsSerialized = $selected_items;
$selectedItemsArray = unserialize($selectedItemsSerialized);

// Create a new PDF instance
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 14); // Times New Roman, bold, size 16
$pdf->Cell(0, 10, $cater, 0, 1);
// Set font to Times New Roman
$pdf->SetFont('Times', '', 10); // Times New Roman, regular, size 12

// Logo
// $pdf->Image('path/to/logo.png', 10, 10, 30); // Adjust the path and coordinates as needed

// Catering address
$pdf->Cell(0, 10, $address, 0, 1); // Adjust the address text and formatting as needed
$pdf->Ln(10); // Add some vertical space

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

$pdf->Ln(10); // Add some vertical space

// Invoice title
$pdf->SetFont('Times', 'B', 14); // Times New Roman, bold, size 16
$pdf->Cell(0, 10, 'Invoice for Transaction No. ' . $transactionNo, 0, 1, 'C');
$pdf->Ln(10); // Add some vertical space

// Invoice table header
$pdf->SetFont('Times', 'B', 10); // Times New Roman, bold, size 12
$pdf->Cell(60, 10, 'Package', 1);
$pdf->Cell(90, 10, 'Item', 1);
$pdf->Cell(40, 10, 'Line Total', 1);
$pdf->Ln(); // Move to the next row

$pdf->SetFont('Times', '', 10); // Times New Roman, regular, size 12

foreach ($selectedItemsArray as $menu_id) {
    // Fetch the menu details based on the menu ID
    $stmt = $DB_con->prepare("SELECT A.menu_id, A.menu_name, A.menu_price, A.menu_image, A.menu_description
                                    FROM tbl_menus AS A 
                                    WHERE A.menu_id = :menu_id");
    $stmt->bindParam(':menu_id', $menu_id);
    $stmt->execute();
    $menu = $stmt->fetch(PDO::FETCH_ASSOC);

    // Truncate menu description if it exceeds 50 characters
    $menuDescription = $menu['menu_description'];
    if (strlen($menuDescription) > 50) {
        $menuDescription = substr($menuDescription, 0, 48) . '...'; // Truncate and add ellipsis
    }

    // Invoice table rows (sample data)
    $pdf->Cell(60, 10, $menu['menu_name'], 1);
    $pdf->Cell(90, 10, $menuDescription, 1); // Display truncated description
    $pdf->Cell(40, 10, $menu['menu_price'], 1, 0, 'R'); // Align to the right
    $pdf->Ln(); // Move to the next row
}



// Total section
$pdf->SetFont('Times', 'B', 10); // Times New Roman, bold, size 12
$pdf->Cell(150, 10, 'Subtotal:', 0, 0, 'R');
$pdf->Cell(40, 10, $grandTotal, 0, 1, 'R');
$pdf->Cell(150, 10, 'Tax:', 0, 0, 'R');
$pdf->Cell(40, 10, $tax, 0, 1, 'R');
$pdf->Cell(150, 10, '', 0, 0, 'R');
$pdf->Cell(40, 10, '__________________________________', 0, 1, 'R');
$pdf->Cell(150, 10, 'Grand Total:', 0, 0, 'R');
$pdf->Cell(40, 10, $grandTotal, 0, 1, 'R');

// Output the PDF
$pdf->Output('Invoice_' . $transactionNo . '.pdf', 'D');
?>