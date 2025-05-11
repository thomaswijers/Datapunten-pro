<?php
if (isset($_SESSION['user_settings'])) {
    // Access the 'value' of websiteColor and textColor from userSettings array
    $primaryColor = $_SESSION['user_settings']['websiteColor']['value'] ?? '#050517';
    $textColor = $_SESSION['user_settings']['textColor']['value'] ?? '#ffffff';
} else {
    $userData = json_decode(file_get_contents(__DIR__ . '/../data/user.json'), true);
    $primaryColor = $userData['userSettings']['websiteColor']['value'] ?? '#050517';
    $textColor = $userData['userSettings']['textColor']['value'] ?? '#ffffff';
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