<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../app/views/dashboard.php");
    exit();
} else {
    header("Location: ../app/views/login.php");
    exit();
}
?>
