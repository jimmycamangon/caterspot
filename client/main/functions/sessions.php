<?php

function isLoggedIn() {
    return isset($_SESSION['client_id']);
}

function redirectToLogin() {
    if (!isLoggedIn()) {
        header("Location: ../index.php");
        exit();
    }
}

function redirectToClientPage() {
    if (isLoggedIn()) {
        header("Location: index.php");
        exit();
    }
}

?>