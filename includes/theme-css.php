<?php
if (isset($_SESSION['user_settings'])) {
    $primaryColor = $_SESSION['user_settings']['websiteColor'] ?? '#050517';
} else {
    $userData = json_decode(file_get_contents(__DIR__ . '/../data/user.json'), true);
    $primaryColor = $userData['userSettings']['websiteColor'] ?? '#050517';
}
?>
<style>
:root {
    --primary-color: <?= htmlspecialchars($primaryColor) ?>;
}
</style>
