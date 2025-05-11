<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <!-- STYLESHEETS -->
    <?php include 'includes/theme-css.php'; ?>

    <link rel="stylesheet" href="css/stylesheet.min.css">

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <?php
    $userData = json_decode(file_get_contents(__DIR__ . '/../data/user.json'), true);
    $frogCursor = $userData['userSettings']['frogCursor']['value'] ?? false;
    ?>

    <!-- Dynamically load JS file if frogCursor is true -->
</head>

<div id="frog-cursor"></div>

<?php if ($frogCursor): ?>
    <script src="js/frog-cursor.js"></script>
<?php endif; ?>