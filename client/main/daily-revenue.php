<?php
// Include the database connection file
require_once '../../config/conn.php';

require_once 'functions/sessions.php';
redirectToLogin();
require '../../assets/vendor/phpspreadsheet/vendor/autoload.php'; // Load PhpSpreadsheet library

// Pass filter parameters dynamically
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

// Include fetch logic with parameters
include_once 'functions/fetch-daily-revenue.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// Fetch cater name and image
$client_id = $_SESSION['client_id'];
$caterName = '';
$sql = "SELECT username, client_image FROM tbl_clients WHERE client_id = ?";
$stmt = $DB_con->prepare($sql);
$stmt->execute([$client_id]);
$cater = $stmt->fetch();
$caterName = $cater['username'];
$clientImagePath = '../../assets/img/client-images/' . $cater['client_image'];
$extractedDate = date('Y-m-d'); // Current date

// Check if there's data to export
if (isset($_GET['export']) && $_GET['export'] == 'true') {
    if (empty($revenues)) {
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
        $drawing->setHeight(80);
        $drawing->setCoordinates('D1');
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
            'size' => 14, // Increased font size
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
    ]);

    // Table headers
    $sheet->setCellValue('A10', 'Transaction No.');
    $sheet->setCellValue('B10', 'Customer');
    $sheet->setCellValue('C10', 'Revenue');
    $sheet->setCellValue('D10', 'Collected at');

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
    $sheet->getStyle('A10:D10')->applyFromArray($headerStyle);

    // Populate data rows
    $row = 11;
    foreach ($revenues as $revenue) {

        // Populate the cells
        $sheet->setCellValue('A' . $row, $revenue['transactionNo']);
        $sheet->setCellValue('B' . $row, $revenue['username']);
        $sheet->setCellValue('C' . $row, $revenue['revenue']);
        $sheet->setCellValue('D' . $row, $revenue['collectedAt']);

        // Format the D column as a date
        $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);

        $row++;
    }

    // Add borders to data rows
    $lastRow = $row - 1;
    $sheet->getStyle('A11:D' . $lastRow)->applyFromArray([
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

    // Write file and download
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="revenue_report_' . date('Y-m-d') . '.xlsx"');
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
    <link href="../../assets/img/favicon.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../vendor/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.5.0/toastify.css"
        integrity="sha512-1xBbDQd2ydreJtocowqI+QS+xYVYdv96rB4xu/Peb5uD3SEtCJkGjnMCV3m8oH7XW35KsjqcTR6AytS5H8h8NA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.5.0/toastify.min.js"
        integrity="sha512-DxteqSgafF6N5gacKCDX24qeqrYjuzdxQ5pNdmDLd1eJ6gibN7tlo7UD2+9qv1+8+Tu/uiYMdCuvHXlwTwZ+Ew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                        <li class="breadcrumb-item active">Daily Revenue</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-cube"></i>&nbsp;
                                <b>List of Revenue per day</b>
                                &nbsp; | &nbsp;
                                <!-- Export Button Trigger -->
                                <a href="daily-revenue.php?export=true&start_date=<?php echo $startDate; ?>&end_date=<?php echo $endDate; ?>"
                                    class="btn-get-main" style="text-decoration:none;color:white;">
                                    <i class="fa-solid fa-paperclip"></i> Generate Report
                                </a>

                            </div>
                            &nbsp;
                            <form action="daily-revenue.php" method="GET">
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
                                        <th>Revenue</th>
                                        <th>Collected at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($revenues as $revenue): ?>
                                        <tr>
                                            <td><?php echo $revenue['transactionNo']; ?></td>
                                            <td><?php echo $revenue['username']; ?></td>
                                            <td><?php echo $revenue['revenue']; ?></td>
                                            <td><?php echo date('Y-m-d', strtotime($revenue['collectedAt'])); ?></td>

                                            <!-- Display the calculated date -->
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../vendor/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="../vendor/js/datatables-simple-demo.js"></script>
    <script type="text/javascript">
        // Handle Export Button Click (This is now redundant as we use the URL with ?export=true)
        document.querySelector('.btn-get-main').addEventListener('click', function () {
            window.location.href = 'daily-revenue.php?export=true';
        });
    </script>
</body>

</html>