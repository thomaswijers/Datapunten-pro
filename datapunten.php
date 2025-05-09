<?php include 'includes/auth.php'; ?>

<?php
$pageTitle = "Dashboard | Datapunten";

include 'components/Header.inc.php';
?>
<body class="dashboard datapunten">
    <?php include 'components/Sidebar.inc.php'; ?>

    <div class="dashboard-content">
        <?php
        $userData = include 'includes/auth.php';
        echo "Welcome, " . htmlspecialchars($userData['userLogin']['username']);
        ?>
    </div>
</body>

