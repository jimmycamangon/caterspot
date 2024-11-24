<?php
include_once 'functions/fetch-monthly-revenue.php';
include_once 'functions/fetch-monthly-revenue-outstanding.php';
require_once 'functions/sessions.php';

redirectToLogin();

// Initialize variables for date filtering
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

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
                                <button type="button" class="btn-get-main" id="exportButton">
                                    <i class="fa-solid fa-paperclip"></i> Generate Report
                                </button>
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
                                            &nbsp; | &nbsp;
                                            <span class="btn-get-del" data-toggle="modal" data-target="#ListofUnpaid"
                                                style="cursor:pointer;"><i class="fa-solid fa-list"></i>
                                                &nbsp;View Outstanding Fees</span>
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
                                        <th>Cater</th>
                                        <th>Revenue</th>
                                        <th>Platform Fee</th>
                                        <th>Status</th>
                                        <th>Collection Date</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($taxs as $tax): ?>
                                        <tr>
                                            <td>
                                                <?php echo $tax['transactionNo']; ?>
                                            </td>
                                            <td>
                                                <?php echo $tax['username']; ?>
                                            </td>
                                            <td>
                                                <?php echo $tax['client_revenue']; ?>
                                            </td>
                                            <td>
                                                <?php echo $tax['tax']; ?>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php
                                                    if ($tax['status'] == "Not Paid" || $tax['status'] == ""): ?>
                                                        <span class="badge bg-danger">Not Paid</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">Paid</span>
                                                    <?php endif; ?>
                                                </center>
                                            </td>
                                            <td>
                                                <?php echo $tax['month']; ?>
                                            </td>
                                            <td>
                                                <button class="btn-get-main edit-btn" data-toggle="modal"
                                                    data-target="#editStatus" data-status-id="<?php echo $tax['id'] ?>"><i
                                                        class="fa-solid fa-pen-to-square"></i>
                                                    Edit Status</button>
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


    <div class="modal fade" id="ListofUnpaid" tabindex="-1" role="dialog" aria-labelledby="ListofUnpaidLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ListofUnpaidLabel">Outstanding Catering Platform Fees</h5>
                    <i class="fa-solid fa-xmark" style="font-size:20px; cursor:pointer;" data-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <!-- Table form -->
                    <div id="listofunpaid">
                        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                            <?php if (!empty($outstandings)): ?>
                                <table class="table" style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="background-color: #f8f9fa; color: #333;">
                                            <th style="padding: 10px; border: 1px solid #ddd;">Transaction No.</th>
                                            <th style="padding: 10px; border: 1px solid #ddd;">Cater</th>
                                            <th style="padding: 10px; border: 1px solid #ddd;">Platform Fee</th>
                                            <th style="padding: 10px; border: 1px solid #ddd;">Status</th>
                                            <th style="padding: 10px; border: 1px solid #ddd;">Collection Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($outstandings as $outstanding): ?>
                                            <tr>
                                                <td style="padding: 10px; border: 1px solid #ddd;">
                                                    <?php echo htmlspecialchars($outstanding['transactionNo']); ?>
                                                </td>
                                                <td style="padding: 10px; border: 1px solid #ddd;">
                                                    <?php echo htmlspecialchars($outstanding['username']); ?>
                                                </td>
                                                <td style="padding: 10px; border: 1px solid #ddd;">
                                                    <?php echo htmlspecialchars($outstanding['tax']); ?>
                                                </td>
                                                <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                                    <center>
                                                        <?php
                                                        if ($outstanding['status'] == "Not Paid" || $outstanding['status'] == ""): ?>
                                                            <span class="badge bg-danger">Not Paid</span>
                                                        <?php endif; ?>
                                                    </center>
                                                </td>
                                                <td style="padding: 10px; border: 1px solid #ddd;">
                                                    <?php echo htmlspecialchars($outstanding['month']); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p style="text-align: center; padding: 20px; color: #6c757d;">No outstanding platform fees.
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-get-del" data-dismiss="modal">Close</button>
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

    <!-- Export to excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>


    <script>
        document.getElementById('exportButton').addEventListener('click', function () {
            // Get table data
            var table = document.getElementById('datatablesSimple');
            var sheet = XLSX.utils.table_to_sheet(table);

            // Convert sheet to Excel file
            var workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, sheet, 'Revenue Report');

            // Save the Excel file
            var today = new Date().toISOString().slice(0, 10); // Get today's date
            var filename = 'revenue_report_' + today + '.xlsx';
            XLSX.writeFile(workbook, filename);
        });
    </script>


    <script src="../vendor/js/datatables-simple-demo.js"></script>
    <script src="functions/js/edit-status.js"></script>

</body>

</html>