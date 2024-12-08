<?php
require_once '../../config/conn.php';
// Include necessary files and libraries
require_once 'functions/sessions.php';
redirectToLogin();
require '../../assets/vendor/phpspreadsheet/vendor/autoload.php'; // Load PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

$totalGrandTotal = 0;
$totalIncome = 0;
$totalClientRevenue = 0;

// Default to current month's data if no filter is applied
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

include_once 'functions/fetch-income-details.php';

// Fetch admin name
$adminName = '';
$sql = "SELECT username FROM tbl_admin WHERE admin_id = ?";
$stmt = $DB_con->prepare($sql);
$stmt->execute([$_SESSION['admin_id']]);
$admin = $stmt->fetch();
$adminName = $admin['username'];

// Check if there's data to export
if (isset($_GET['export']) && $_GET['export'] == 'true') {
    if (empty($completed_orders)) {
        echo "<script>alert('No data available to export.'); window.history.back();</script>";
        exit();
    }

    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add cater name and extracted date
    $sheet->setCellValue('A3', 'Caterspot Income');
    $sheet->setCellValue('A4', 'Exported Date: ' . date('Y-m-d'));


    // Style cater name and extracted date
    $sheet->getStyle('A3:A4')->applyFromArray([
        'font' => [
            'bold' => true,
            'size' => 14, // Increased font size
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
    ]);

    // Table headers
    $sheet->setCellValue('A6', 'Transaction No.');
    $sheet->setCellValue('B6', 'Customer');
    $sheet->setCellValue('C6', 'Grand Total');
    $sheet->setCellValue('D6', 'Income');
    $sheet->setCellValue('E6', 'Cater Income');
    $sheet->setCellValue('F6', 'Collected at');

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
    $sheet->getStyle('A6:F6')->applyFromArray($headerStyle);

    // Populate data rows
    $row = 7;
    foreach ($completed_orders as $order) {
        $total_price = $order['total_price'];
        $tax = $order['tax'];
        $grand_total = $total_price + $tax;
        $client_revenue = $total_price;

        $totalGrandTotal += $grand_total;
        $totalIncome += $tax;
        $totalClientRevenue += $client_revenue;

        // Populate the cells
        $sheet->setCellValue('A' . $row, $order['transactionNo']);
        $sheet->setCellValue('B' . $row, $order['full_name']);
        $sheet->setCellValue('C' . $row, $grand_total);
        $sheet->setCellValue('D' . $row, $tax);
        $sheet->setCellValue('E' . $row, $client_revenue);
        $sheet->setCellValue('F' . $row, $order['created_at']);

        // Format the F column as a date
        $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);

        $row++;
    }
    // Add totals row
    $sheet->setCellValue('A' . $row, 'Total:');
    $sheet->setCellValue('C' . $row, $totalGrandTotal);
    $sheet->setCellValue('D' . $row, $totalIncome);
    $sheet->setCellValue('E' . $row, $totalClientRevenue);

    // Style the totals row with borders and yellow background color
    $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray([
        'font' => [
            'bold' => true,
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
        ],
        'borders' => [
            'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FFFF00'], // Yellow background color
        ],
    ]);


    $spreadsheet->getActiveSheet()
        ->getStyle('A1')
        ->getNumberFormat()
        ->setFormatCode('#,##0.00'); // Custom format for currency


    // Add borders to data rows
    $lastRow = $row - 1;
    $sheet->getStyle('A7:F' . $lastRow)->applyFromArray([
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
    $sheet->getColumnDimension('F')->setAutoSize(true);

    // Write file and download
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="income_details_report_' . date('Y-m-d') . '.xlsx"');
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
                        <li class="breadcrumb-item active">Actual Income</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-cube"></i>&nbsp;
                                <b>List of Actual Income</b>
                                &nbsp; | &nbsp;
                                <a href="income-details.php?export=true&start_date=<?php echo $startDate; ?>&end_date=<?php echo $endDate; ?>"
                                    class="btn-get-main" style="text-decoration:none;color:white;">
                                    <i class="fa-solid fa-paperclip"></i> Generate Report
                                </a>
                            </div>
                            &nbsp;
                            <form action="income-details.php" method="GET">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="start_date">Start Date:</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="end_date">End Date:</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control"
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
                        <hr>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table">
                                <thead>
                                    <tr>
                                        <th>Transaction No.</th>
                                        <th>Customer</th>
                                        <th>Cater Name</th>
                                        <th>Grand Total</th>
                                        <th>Income</th>
                                        <th>Cater Income</th>
                                        <th>Collected at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($completed_orders as $order): ?>
                                        <?php
                                        // Extracting the values from the current order
                                        $total_price = $order['total_price'];  // Amount that the caterer will receive
                                        $tax = $order['tax'];                  // Tax amount (admin's share)
                                    
                                        // Calculate grand total
                                        $grand_total = $total_price + $tax;   // Total amount paid by the customer
                                    
                                        // Calculate the client's revenue (which is the total price minus the tax)
                                        $client_revenue = $total_price;       // Client's revenue (total price only, excluding tax)
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $order['transactionNo']; ?>
                                            </td>
                                            <td>
                                                <?php echo $order['full_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $order['cater_name']; ?>
                                            </td>
                                            <td>
                                                ₱<?php echo number_format($grand_total, 2); ?>
                                                <!-- Grand Total (customer's total payment) -->
                                            </td>
                                            <td>
                                                ₱<?php echo number_format($tax, 2); ?> <!-- Tax (admin's share) -->
                                            </td>
                                            <td>
                                                ₱<?php echo number_format($client_revenue, 2); ?>
                                                <!-- Client's Revenue (caterer's actual revenue) -->
                                            </td>
                                            <td>
                                                <?php echo $order['created_at']; ?>
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


    <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeleteModalLabel">Delete Confirmation</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    Are you sure you want to delete this Customer?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-main" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn-get-del" id="confirmDeleteBtn">Delete</button>
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

</body>

</html>