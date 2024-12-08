<?php
require_once '../../config/conn.php';
require_once 'functions/sessions.php';
require '../../assets/vendor/phpspreadsheet/vendor/autoload.php'; // PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

redirectToLogin();

// Initialize variables for date filtering
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';
include_once 'functions/fetch-outstanding.php';

// Fetch cater name and image
$client_id = $_SESSION['client_id'];
$caterName = '';
$clientImagePath = '';
$sql = "SELECT username, client_image FROM tbl_clients WHERE client_id = ?";
$stmt = $DB_con->prepare($sql);
$stmt->execute([$client_id]);
$cater = $stmt->fetch();
$caterName = $cater['username'];
$clientImagePath = '../../assets/img/client-images/' . $cater['client_image'];

// Get extracted date
$extractedDate = date('Y-m-d');

// Handle export functionality
if (isset($_GET['export']) && $_GET['export'] == 'true') {
    if (empty($outstandings)) {
        echo "<script>alert('No data available to export.'); window.history.back();</script>";
        exit();
    }

    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    if (!empty($clientImagePath) && file_exists($clientImagePath)) {
        // Add client logo
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Client Logo');
        $drawing->setPath($clientImagePath);
        $drawing->setHeight(120); // Increased the height for a larger image
        $drawing->setCoordinates('D3'); // Adjusted the position to row 3
        $drawing->setOffsetX(10); // Optional: Adjust horizontal offset if needed
        $drawing->setOffsetY(10); // Optional: Adjust vertical offset if needed
        $drawing->setWorksheet($sheet);
    } else {
        $sheet->setCellValue('A1', 'No Image Available');
    }

    // Add cater name and extracted date
    $sheet->setCellValue('A3', 'Cater Name: ' . $caterName);
    $sheet->setCellValue('A4', 'Extracted Date: ' . $extractedDate);

    // Style cater name and extracted date
    $sheet->getStyle('A3:A4')->applyFromArray([
        'font' => [
            'bold' => true,
            'size' => 14,
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
    ]);

    // Table headers
    $sheet->setCellValue('A10', 'Transaction No.');
    $sheet->setCellValue('B10', 'Customer');
    $sheet->setCellValue('C10', 'Platform Fee');
    $sheet->setCellValue('D10', 'Status');
    $sheet->setCellValue('E10', 'Collection Date');

    // Style table headers
    $headerStyle = [
        'font' => [
            'bold' => true,
            'size' => 12,
            'color' => ['rgb' => 'FFFFFF'],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => '142d4c'],
        ],
    ];
    $sheet->getStyle('A10:E10')->applyFromArray($headerStyle);

    // Populate data rows
    $row = 11;
    $totalPlatformFee = 0;
    foreach ($outstandings as $outstanding) {
        $sheet->setCellValue('A' . $row, $outstanding['transactionNo']);
        $sheet->setCellValue('B' . $row, $outstanding['username']);
        $sheet->setCellValue('C' . $row, $outstanding['tax']);
        $sheet->setCellValue('D' . $row, $outstanding['status'] == 'Not Paid' || $outstanding['status'] == '' ? 'Not Paid' : 'Paid');
        $sheet->setCellValue('E' . $row, $outstanding['month']);

        $totalPlatformFee += $outstanding['tax'];
        $row++;
    }
    // Add total row
    $sheet->setCellValue('B' . $row, 'Total:'); // Label for total
    $sheet->setCellValue('C' . $row, $totalPlatformFee); // Total Platform Fee

    // Style the total row
    $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
        'font' => [
            'bold' => true,
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FFFF00'], // Yellow background color
        ],
        'borders' => [
            'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ]);

    // Optional: Add borders to the total row
    $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ]);

    // Add borders to data rows
    $lastRow = $row - 1;
    $sheet->getStyle('A11:E' . $lastRow)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ]);

    // Set column widths
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);

    // Write file and download
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="outstanding_fee_report_' . date('Y-m-d') . '.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>CaterSpot</title>
    <!-- Favicons -->
    <link href="../../assets/img/favicon.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../vendor/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Toastify -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.5.0/toastify.js"
        integrity="sha512-0M1OKuNQKhBhA/vqxH7OaS1LZlDwSrSbL3QzcmrlNbkWV0U4ewn8SWfVuRS5nLGV9IXsuNnkdqzyXOYXc0Eo9w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.5.0/toastify.css"
        integrity="sha512-1xBbDQd2ydreJtocowqI+QS+xYVYdv96rB4xu/Peb5uD3SEtCJkGjnMCV3m8oH7XW35KsjqcTR6AytS5H8h8NA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.5.0/toastify.min.css"
        integrity="sha512-RJJdSTKOf+e0vTbZvyS5JTWtIBNC44IDUbkH8IF3MkJUP+YfLcK3K2nlxLS8V98m407CUgBdQrbcyRihb9e5gQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.5.0/toastify.min.js"
        integrity="sha512-DxteqSgafF6N5gacKCDX24qeqrYjuzdxQ5pNdmDLd1eJ6gibN7tlo7UD2+9qv1+8+Tu/uiYMdCuvHXlwTwZ+Ew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://www.dukelearntoprogram.com/course1/common/js/image/SimpleImage.js"></script>

</head>


<body class="sb-nav-fixed">
    <?php require_once 'includes/top-nav.php'; ?>
    <div id="layoutSidenav">
        <?php require_once 'includes/left-nav.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <br>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php" class="link-ref">Dashboard</a></li>
                        <li class="breadcrumb-item active">Outstanding Fee</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-cube"></i>&nbsp;
                                <b>List of Outstanding Fees</b>
                                &nbsp; | &nbsp;
                                <a href="outstanding-fee.php?export=true&start_date=<?php echo $startDate; ?>&end_date=<?php echo $endDate; ?>"
                                    class="btn-get-main" style="text-decoration:none;color:white;">
                                    <i class="fa-solid fa-paperclip"></i> Generate Report
                                </a>
                            </div>
                            &nbsp;
                            <form action="outstanding-fee.php" method="GET" class="form-inline">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="start_date">Start Date:</label>
                                            <input type="date" id="start_date" name="start_date"
                                                class="form-control mx-2" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="end_date">End Date:</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control mx-2"
                                                required>

                                        </div>
                                        <div class="col-md-4 align-self-end">
                                            <button class="btn-get-main" type="submit"><i
                                                    class="fa-solid fa-filter"></i> &nbsp;Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table">
                                <thead>
                                    <tr>
                                        <th>Transaction No.</th>
                                        <th>Customer</th>
                                        <th>Platform Fee</th>
                                        <th>Status</th>
                                        <th>Collection Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($outstandings as $outstanding): ?>
                                        <tr>
                                            <td>
                                                <?php echo $outstanding['transactionNo']; ?>
                                            </td>
                                            <td>
                                                <?php echo $outstanding['username']; ?>
                                            </td>
                                            <td>
                                                <?php echo $outstanding['tax']; ?>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php
                                                    if ($outstanding['status'] == "Not Paid" || $outstanding['status'] == ""): ?>
                                                        <span class="badge bg-danger">Not Paid</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">Paid</span>
                                                    <?php endif; ?>
                                                </center>
                                            </td>
                                            <td>
                                                <?php echo $outstanding['month']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php require_once 'includes/footer.php'; ?>
        </div>
    </div>


    <div class="modal fade" id="editStatus" tabindex="-1" role="dialog" aria-labelledby="editStatusLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusLabel">Edit Status</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div id="editMessage"></div>

                    <!-- Edit form -->
                    <div id="editPackageForm">
                        <!-- Dropdown for availability -->
                        <div class="form-group">
                            <label for="edit_status">Status:</label>
                            <select class="form-control" id="edit_status" name="edit_status">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-del" data-dismiss="modal">Close</button>
                    <button type="button" class="btn-get-main" id="saveChangesBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../vendor/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <!-- Modal CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



    <script src="../vendor/js/datatables-simple-demo.js"></script>
    <script src="functions/js/edit-status.js"></script>

</body>

</html>