<?php
require_once '../../config/conn.php';
require_once 'functions/sessions.php';
require '../../assets/vendor/phpspreadsheet/vendor/autoload.php'; // Load PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

redirectToLogin();

// Default to current month's data if no filter is applied
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t'); // t gives last day of the month
include_once 'functions/fetch-monthly-revenue.php';
// Fetch admin name
$adminName = '';
$sql = "SELECT username FROM tbl_admin WHERE admin_id = ?";
$stmt = $DB_con->prepare($sql);
$stmt->execute([$_SESSION['admin_id']]);
$admin = $stmt->fetch();
$adminName = $admin['username'];

// Check if there's data to export (if export query parameter is set)
if (isset($_GET['export']) && $_GET['export'] == 'true') {
    if (empty($taxs)) {
        echo "<script>alert('No data available to export.'); window.history.back();</script>";
        exit();
    }

    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add admin name and exported date to the spreadsheet
    $sheet->setCellValue('A2', 'Monthly Revenue');
    $sheet->setCellValue('A3', 'Name: ' . $adminName);
    $sheet->setCellValue('A4', 'Exported Date: ' . date('Y-m-d'));

    // Style admin name and date
    $sheet->getStyle('A2:A4')->applyFromArray([
        'font' => [
            'bold' => true,
            'size' => 14, // Increased font size
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
    ]);

    // Table headers for export (now starting at row 6 instead of 10)
    $sheet->setCellValue('A6', 'Cater');
    $sheet->setCellValue('B6', 'Revenue');
    $sheet->setCellValue('C6', 'Platform Fee');
    $sheet->setCellValue('D6', 'Collection Date');

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
    $sheet->getStyle('A6:D6')->applyFromArray($headerStyle);

    // Populate data rows for export (starting from row 7)
    $row = 7;
    $totalRevenue = 0;
    $totalPlatformFee = 0;
    foreach ($taxs as $tax) {
        $sheet->setCellValue('A' . $row, $tax['username']);
        $sheet->setCellValue('B' . $row, $tax['client_revenue']);
        $sheet->setCellValue('C' . $row, $tax['total_tax']);
        $sheet->setCellValue('D' . $row, $tax['month']);

        $totalRevenue += $tax['client_revenue'];
        $totalPlatformFee += $tax['total_tax'];
        $row++;
    }

    $sheet->setCellValue('A' . $row, 'Total');
    $sheet->setCellValue('B' . $row, $totalRevenue);
    $sheet->setCellValue('C' . $row, $totalPlatformFee);

    
    $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray([
        'font' => [
            'bold' => true,
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
        ],
        'borders' => [
            'allBorders' => [ // Adds borders for all sides
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FFFF00'], // Yellow background color
        ],
    ]);
    
    // Add borders to data rows
    $lastRow = $row - 1;
    $sheet->getStyle('A7:D' . $lastRow)->applyFromArray([
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
    header('Content-Disposition: attachment;filename="monthly_revenue_report_' . date('Y-m-d') . '.xlsx"');
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
                        <li class="breadcrumb-item active">Monthly Revenue</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-cube"></i>&nbsp;
                                <b>List of Revenue per month</b>
                                &nbsp; | &nbsp;
                                <a href="monthly-revenue.php?export=true&start_date=<?php echo $startDate; ?>&end_date=<?php echo $endDate; ?>" class="btn-get-main"
                                    style="text-decoration:none;color:white;">
                                    <i class="fa-solid fa-paperclip"></i> Generate Report
                                </a>
                            </div>
                            &nbsp;
                            <form action="monthly-revenue.php" method="GET" class="form-inline">
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
                                        <th>Cater</th>
                                        <th>Revenue</th>
                                        <th>Platform Fee</th>
                                        <th>Collection Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($taxs as $tax): ?>
                                        <tr>
                                            <td>
                                                <?php echo $tax['username']; ?>
                                            </td>
                                            <td>
                                                <?php echo $tax['client_revenue']; ?>
                                            </td>
                                            <td>
                                                <?php echo $tax['total_tax']; ?>
                                            </td>
                                            <td>
                                                <?php echo $tax['month']; ?>
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