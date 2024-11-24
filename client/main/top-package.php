<?php
include_once 'functions/fetch-daily-revenue.php';
require_once 'functions/sessions.php';

redirectToLogin();

// Ensure the client_id is set in the session
if (!isset($_SESSION['client_id'])) {
    echo json_encode(['error' => 'Client ID not found in session.']);
    exit;
}

$client_id = $_SESSION['client_id'];

// Default to current month's data if no filter is applied
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t'); // t gives last day of the month

// Initialize results variable
$topPackages = [];

try {
    // Fetch and sanitize input parameters for date range filtering
    $start_date = $startDate;
    $end_date = $endDate;

    // Base SQL query to get top-rated caterers by average rating
    $sql = "SELECT 
            C.username,
            B.package_id,
            D.firstname,
            D.lastname,
            A.package_name, 
            A.package_image,
           B.rate AS average_rate
        FROM 
            tbl_packages AS A
        LEFT JOIN 
            tbl_packagerating AS B 
        ON 
            A.package_id = B.package_id 
        LEFT JOIN tbl_clients AS C ON A.client_id = C.client_id
        LEFT JOIN tbl_users AS D ON B.customer_id = D.user_id
            
            ";

    // Add date range filtering to the query if start_date and end_date are provided
    if ($start_date && $end_date) {
        $sql .= "WHERE 
            B.customer_id <> '' 
            AND B.client_id = :client_id
            AND B.createdAt BETWEEN :start_date AND :end_date ";
    }

    $sql .= "GROUP BY 
            A.package_name, A.package_image
        ORDER BY 
            average_rate DESC"; // Top 5 caterers by average rating

    // Prepare the SQL statement
    $stmt = $DB_con->prepare($sql);

    // Bind parameters if date range filtering is applied
    if ($start_date && $end_date) {
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
    }

    // Execute the query
    $stmt->execute();

    // Fetch the results into an associative array
    $topPackages = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Handle any errors that occur during the process
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
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
                        <li class="breadcrumb-item active">Daily Revenue</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-cube"></i>&nbsp;
                                <b>List of Revenue per day</b>
                                &nbsp; | &nbsp;
                                <button type="button" class="btn-get-main" id="exportButton">
                                    <i class="fa-solid fa-paperclip"></i> Generate Report
                                </button>
                            </div>
                            &nbsp;
                            <form action="top-package.php" method="GET">
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
                        <div class="card-body">
                            <table id="datatablesSimple" class="table">
                                <thead>
                                    <tr>
                                        <th>Customer.</th>
                                        <th>Client</th>
                                        <th>Package</th>
                                        <th>Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($topPackages as $package): ?>
                                        <tr>
                                            <td>
                                                <?php echo $package['firstname'] . $package['lastname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $package['username']; ?>
                                            </td>
                                            <td>
                                                <?php echo $package['package_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $package['average_rate']; ?>
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
            var filename = 'top_package_' + today + '.xlsx';
            XLSX.writeFile(workbook, filename);
        });
    </script>


    <script src="../vendor/js/datatables-simple-demo.js"></script>

</body>

</html>