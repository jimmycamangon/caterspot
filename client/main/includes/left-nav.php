<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Control Panel</div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages3"
                    aria-expanded="false" aria-controls="collapsePages3">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                    Reservation &nbsp;


                    <?php
                    require_once '../../config/conn.php';
                    if (isset($_SESSION['client_id'])) {
                        try {
                            // Fetch the username from tbl_caters based on some criteria, for example, where client_id = :client_id
                            $query_username = "SELECT B.cater_name FROM tbl_clients AS A LEFT JOIN tblclient_settings AS B ON A.client_id = B.client_id WHERE A.client_id = :client_id";
                            $stmt_username = $DB_con->prepare($query_username);
                            // Assuming you have a session variable for cater_id
                            $stmt_username->bindParam(':client_id', $_SESSION['client_id']);
                            $stmt_username->execute();
                            $row_username = $stmt_username->fetch(PDO::FETCH_ASSOC);
                            $username = $row_username['cater_name'];

                            // Prepare a SQL query with a parameter placeholder
                            $query = "SELECT COUNT(*) AS unread_count FROM tbl_orders WHERE is_read = 0 AND cater = :username";
                            $stmt = $DB_con->prepare($query);
                            // Bind the username parameter
                            $stmt->bindParam(':username', $username);
                            $stmt->execute();

                            // Fetch the result as an associative array
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                            // Extract the unread count from the result
                            $unread_count = $row['unread_count'];

                            // Check if there are unread items
                            if ($unread_count > 0) {
                                ?>
                                <span
                                    style="background-color:green; color:white; padding: 0.2em 1em; border-radius:0.5em; font-size:0.8rem;">New</span>
                                <?php
                            }
                        } catch (PDOException $e) {
                            // Handle any potential errors
                            echo "Error: " . $e->getMessage();
                        }
                    }
                    ?>

                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages3" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link" href="pendings.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-spinner"></i></div>
                            Pendings
                            &nbsp;
                            <?php
                            require_once '../../config/conn.php';
                            if (isset($_SESSION['client_id'])) {
                                try {
                                    // Fetch the username from tbl_caters based on some criteria, for example, where client_id = :client_id
                                    $query_username = "SELECT B.cater_name FROM tbl_clients AS A LEFT JOIN tblclient_settings AS B ON A.client_id = B.client_id WHERE A.client_id = :client_id";
                                    $stmt_username = $DB_con->prepare($query_username);
                                    // Assuming you have a session variable for cater_id
                                    $stmt_username->bindParam(':client_id', $_SESSION['client_id']);
                                    $stmt_username->execute();
                                    $row_username = $stmt_username->fetch(PDO::FETCH_ASSOC);
                                    $username = $row_username['cater_name'];

                                    // Prepare a SQL query with a parameter placeholder
                                    $query = "SELECT COUNT(*) AS unread_count FROM tbl_orders WHERE is_read = 0 AND status = 'Pending' AND cater = :username";
                                    $stmt = $DB_con->prepare($query);
                                    // Bind the username parameter
                                    $stmt->bindParam(':username', $username);
                                    $stmt->execute();

                                    // Fetch the result as an associative array
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                    // Extract the unread count from the result
                                    $unread_count = $row['unread_count'];

                                    // Check if there are unread items
                                    if ($unread_count > 0) {
                                        ?>
                                        <span
                                            style="background-color:green; color:white; padding: 0.2em 1em; border-radius:0.5em; font-size:0.8rem;">New</span>
                                        <?php
                                    }
                                } catch (PDOException $e) {
                                    // Handle any potential errors
                                    echo "Error: " . $e->getMessage();
                                }
                            }
                            ?>
                        </a>
                        <a class="nav-link" href="booked.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-bookmark"></i></div>
                            Booked
                            &nbsp;
                            <?php
                            require_once '../../config/conn.php';
                            if (isset($_SESSION['client_id'])) {
                                try {
                                    // Fetch the username from tbl_caters based on some criteria, for example, where client_id = :client_id
                                    $query_username = "SELECT B.cater_name FROM tbl_clients AS A LEFT JOIN tblclient_settings AS B ON A.client_id = B.client_id WHERE A.client_id = :client_id";
                                    $stmt_username = $DB_con->prepare($query_username);
                                    // Assuming you have a session variable for cater_id
                                    $stmt_username->bindParam(':client_id', $_SESSION['client_id']);
                                    $stmt_username->execute();
                                    $row_username = $stmt_username->fetch(PDO::FETCH_ASSOC);
                                    $username = $row_username['cater_name'];

                                    // Prepare a SQL query with a parameter placeholder
                                    $query = "SELECT COUNT(*) AS unread_count FROM tbl_orders WHERE is_read = 0 AND status = 'Booked' AND cater = :username";
                                    $stmt = $DB_con->prepare($query);
                                    // Bind the username parameter
                                    $stmt->bindParam(':username', $username);
                                    $stmt->execute();

                                    // Fetch the result as an associative array
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                    // Extract the unread count from the result
                                    $unread_count = $row['unread_count'];

                                    // Check if there are unread items
                                    if ($unread_count > 0) {
                                        ?>
                                        <span
                                            style="background-color:green; color:white; padding: 0.2em 1em; border-radius:0.5em; font-size:0.8rem;">New</span>
                                        <?php
                                    }
                                } catch (PDOException $e) {
                                    // Handle any potential errors
                                    echo "Error: " . $e->getMessage();
                                }
                            }
                            ?>
                        </a>
                        <a class="nav-link" href="completed.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-check-to-slot"></i></div>
                            Completed
                            &nbsp;
                            <?php
                            require_once '../../config/conn.php';
                            if (isset($_SESSION['client_id'])) {
                                try {
                                    // Fetch the username from tbl_caters based on some criteria, for example, where client_id = :client_id
                                    $query_username = "SELECT B.cater_name FROM tbl_clients AS A LEFT JOIN tblclient_settings AS B ON A.client_id = B.client_id WHERE A.client_id = :client_id";
                                    $stmt_username = $DB_con->prepare($query_username);
                                    // Assuming you have a session variable for cater_id
                                    $stmt_username->bindParam(':client_id', $_SESSION['client_id']);
                                    $stmt_username->execute();
                                    $row_username = $stmt_username->fetch(PDO::FETCH_ASSOC);
                                    $username = $row_username['cater_name'];

                                    // Prepare a SQL query with a parameter placeholder
                                    $query = "SELECT COUNT(*) AS unread_count FROM tbl_orders WHERE is_read = 0 AND status = 'Completed' AND cater = :username";
                                    $stmt = $DB_con->prepare($query);
                                    // Bind the username parameter
                                    $stmt->bindParam(':username', $username);
                                    $stmt->execute();

                                    // Fetch the result as an associative array
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                    // Extract the unread count from the result
                                    $unread_count = $row['unread_count'];

                                    // Check if there are unread items
                                    if ($unread_count > 0) {
                                        ?>
                                        <span
                                            style="background-color:green; color:white; padding: 0.2em 1em; border-radius:0.5em; font-size:0.8rem;">New</span>
                                        <?php
                                    }
                                } catch (PDOException $e) {
                                    // Handle any potential errors
                                    echo "Error: " . $e->getMessage();
                                }
                            }
                            ?>
                        </a>
                        <a class="nav-link" href="reject_cancel.php" style="font-size:0.8rem;">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-ban"></i></div>
                            Rejected/ Cancellation
                            &nbsp;
                            <?php
                            require_once '../../config/conn.php';
                            if (isset($_SESSION['client_id'])) {
                                try {
                                    // Fetch the username from tbl_caters based on some criteria, for example, where client_id = :client_id
                                    $query_username = "SELECT B.cater_name FROM tbl_clients AS A LEFT JOIN tblclient_settings AS B ON A.client_id = B.client_id WHERE A.client_id = :client_id";
                                    $stmt_username = $DB_con->prepare($query_username);
                                    // Assuming you have a session variable for cater_id
                                    $stmt_username->bindParam(':client_id', $_SESSION['client_id']);
                                    $stmt_username->execute();
                                    $row_username = $stmt_username->fetch(PDO::FETCH_ASSOC);
                                    $username = $row_username['cater_name'];

                                    // Prepare a SQL query with a parameter placeholder
                                    $query = "SELECT COUNT(*) AS unread_count FROM tbl_orders WHERE is_read = 0 AND status IN ('Request for cancel', 'Rejected', 'Request cancellation approved.') AND cater = :username";
                                    $stmt = $DB_con->prepare($query);
                                    // Bind the username parameter
                                    $stmt->bindParam(':username', $username);
                                    $stmt->execute();

                                    // Fetch the result as an associative array
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                    // Extract the unread count from the result
                                    $unread_count = $row['unread_count'];

                                    // Check if there are unread items
                                    if ($unread_count > 0) {
                                        ?>
                                        <span
                                            style="background-color:green; color:white; padding: 0.2em 1em; border-radius:0.5em; font-size:0.8rem;">New</span>
                                        <?php
                                    }
                                } catch (PDOException $e) {
                                    // Handle any potential errors
                                    echo "Error: " . $e->getMessage();
                                }
                            }
                            ?>
                        </a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                    aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-bell-concierge"></i></div>
                    Service Panel
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link" href="packages.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-cube"></i></div>
                            Packages
                        </a>
                        <a class="nav-link" href="menus.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-bowl-food"></i></div>
                            Menus
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages2"
                    aria-expanded="false" aria-controls="collapsePages2">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Reports
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages2" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link" href="daily-revenue.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Daily Revenue
                        </a>
                        <a class="nav-link" href="monthly-revenue.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-simple"></i></div>
                            Monthly Revenue
                        </a>
                        <a class="nav-link" href="top-package.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-star"></i></div>
                            Top Packages
                        </a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Extras</div>
                <a class="nav-link" href="other_menus.php" style="font-size:0.9rem;">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-camera-retro"></i></div>
                    Additional Menu Image
                </a>
                <a class="nav-link" href="gallery.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-camera-retro"></i></div>
                    Image Gallery
                </a>
                <a class="nav-link" href="settings.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                    Cater Settings
                </a>

                <!-- Action Log will be implement if the panelist ask for it. -->
                <!-- <a class="nav-link" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Activity Log (In-Development)
                </a> -->
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Client
        </div>
    </nav>
</div>