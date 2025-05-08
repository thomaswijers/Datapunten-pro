<?php include 'includes/auth.php'; ?>

<?php include 'components/Sidebar.inc.php'; ?>

<?php
$userData = include 'includes/auth.php';
echo "Welcome, " . htmlspecialchars($userData['userLogin']['username']);
