<?php

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function redirectToLogin() {
    if (!isLoggedIn()) {
        header("Location: ../index.php");
        exit();
    }
}

function redirectToClientPage() {
    if (isLoggedIn()) {
        header("Location: main/index.php");
        exit();
    }
}

?>