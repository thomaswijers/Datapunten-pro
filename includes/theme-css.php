<?php
if (isset($_SESSION['user_settings'])) {
    $primaryColor = $_SESSION['user_settings']['websiteColor'] ?? '#050517';
    $textColor = $_SESSION['user_settings']['textColor'] ?? '#ffffff';
} else {
    $userData = json_decode(file_get_contents(__DIR__ . '/../data/user.json'), true);
    $primaryColor = $userData['userSettings']['websiteColor'] ?? '#050517';
    $textColor = $userData['userSettings']['textColor'] ?? '#ffffff';
}
?>
<style>
    :root {
        --primary-color:
            <?= htmlspecialchars($primaryColor, ENT_QUOTES, 'UTF-8') ?>
        ;
        --text-color:
            <?= htmlspecialchars($textColor, ENT_QUOTES, 'UTF-8') ?>
        ;
    }
</style>