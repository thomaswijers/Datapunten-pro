<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<aside class="dashboard-sidebar">
    <div class="side-menu">
        <a href="datapunten.php">Datapunten</a>
        <a href="cursussen.php">Cursussen</a>
    </div>

    <div class="side-actions">
        <div class="menu-icon">
            <a href="settings.php">Settings</a>
        </div>
        <div class="menu-icon">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</aside>