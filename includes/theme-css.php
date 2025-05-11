<?php
$userData = json_decode(file_get_contents(__DIR__ . '/../data/user.json'), true);
$primaryColor = $userData['userSettings']['websiteColor']['value'] ?? '#050517';
$textColor = $userData['userSettings']['textColor']['value'] ?? '#ffffff';
$labelColor = $userData['userSettings']['labelColor']['value'] ?? '#f3080d';
$labelTextColor = $userData['userSettings']['labelTextColor']['value'] ?? '#ffffff';

?>
<style>
    :root {
        --primary-color:
            <?= htmlspecialchars($primaryColor, ENT_QUOTES, 'UTF-8') ?>
        ;
        --text-color:
            <?= htmlspecialchars($textColor, ENT_QUOTES, 'UTF-8') ?>
        ;
        --label-color:
            <?= htmlspecialchars($labelColor, ENT_QUOTES, 'UTF-8') ?>
        ;
        --label-text-color:
            <?= htmlspecialchars($labelTextColor, ENT_QUOTES, 'UTF-8') ?>
        ;
    }
</style>