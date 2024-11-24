<?php
include_once 'functions/fetch-daily-revenue.php';
require_once 'functions/sessions.php';
require_once '../../config/conn.php'; // Include database connection

redirectToLogin();

// Default to current month's data if no filter is applied
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t'); // t gives last day of the month

// Initialize results variable
$topCaterers = [];

try {
    // Fetch and sanitize input parameters for date range filtering
    $start_date = $startDate;
    $end_date = $endDate;

    // Base SQL query to get top-rated caterers by average rating
    $sql = "SELECT c.username, AVG(f.rate) AS average_rating
            FROM tbl_feedbacks f
            INNER JOIN tbl_clients c ON f.client_id = c.client_id ";

    // Add date range filtering to the query if start_date and end_date are provided
    if ($start_date && $end_date) {
        $sql .= "WHERE f.createdAt BETWEEN :start_date AND :end_date ";
    }

    $sql .= "GROUP BY c.client_id
             ORDER BY average_rating DESC"; // Top 5 caterers by average rating

    // Prepare the SQL statement
    $stmt = $DB_con->prepare($sql);

    // Bind parameters if date range filtering is applied
    if ($start_date && $end_date) {
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
    }

    // Execute the query
    $stmt->execute();

    // Fetch the results into an associative array
    $topCaterers = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                        <li class="breadcrumb-item active">Top Caterers</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="form-group">
                                <i class="fa-solid fa-cube"></i>&nbsp;
                                <b>Top Caterers by Average Rating</b>
                                &nbsp; | &nbsp;
                                <button type="button" class="btn-get-main" id="exportButton">
                                    <i class="fa-solid fa-paperclip"></i> Generate Report
                                </button>
                            </div>
                            &nbsp;
                            <form action="top-cater-permonth.php" method="GET">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="start_date">Start Date:</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control"
                                                required value="<?php echo $startDate; ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="end_date">End Date:</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control"
                                                required value="<?php echo $endDate; ?>">
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
                                        <th>Caterer</th>
                                        <th>Average Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($topCaterers as $caterer): ?>
                                        <tr>
                                            <td>
                                                <?php echo $caterer['username']; ?>
                                            </td>
                                            <td>
                                                <?php echo number_format($caterer['average_rating'], 2); ?>
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

    <!-- Export to excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>

    <script>
        document.getElementById('exportButton').addEventListener('click', function () {
            const table = document.getElementById('datatablesSimple');
            const wb = XLSX.utils.table_to_book(table, { sheet: "Top Caterers" });
            XLSX.writeFile(wb, 'Top_Caterers_Report.xlsx');
        });
    </script>
    <script src="../vendor/js/datatables-simple-demo.js"></script>
</body>

</html>