<?php
$dataPath = __DIR__ . '/../data/user.json';
$userData = file_exists($dataPath) ? json_decode(file_get_contents($dataPath), true) : [];


if (!isset($userData['userSettings'])) {
    $userData['userSettings'] = [];
}
$settings = $userData['userSettings'];

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changePassword']) && isset($_POST['newPassword'])) {
    $newPassword = $_POST['newPassword'];
    if (!empty($newPassword)) {
        $userData['userLogin']['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        file_put_contents($dataPath, json_encode($userData, JSON_PRETTY_PRINT));
        header("Location: ../settings?saved=1");
        exit;
    }
}

// Handle username change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changeUsername'])) {
    $newUsername = trim($_POST['newUsername']);

    if ($newUsername === '') {
        $_SESSION['settings_error'] = 'Gebruikersnaam mag niet leeg zijn.';
        header('Location: ../settings');
        exit;
    }

    if (!file_exists($dataPath)) {
        $_SESSION['settings_error'] = 'Gebruikersbestand niet gevonden.';
        header('Location: ../settings');
        exit;
    }

    $userData = json_decode(file_get_contents($dataPath), true);
    $userData['userLogin']['username'] = $newUsername;

    file_put_contents($dataPath, json_encode($userData, JSON_PRETTY_PRINT));

    $_SESSION['settings_success'] = 'Gebruikersnaam succesvol gewijzigd.';
    header('Location: ../settings');
    exit;
}

// Handle saving settings (but not password change)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['changePassword'])) {
    foreach ($settings as $key => &$meta) {
        if ($meta['type'] === 'checkbox') {
            $meta['value'] = isset($_POST[$key]);
        } else {
            $meta['value'] = $_POST[$key] ?? '';
        }
    }

    $userData['userSettings'] = $settings;
    file_put_contents($dataPath, json_encode($userData, JSON_PRETTY_PRINT));
    $_SESSION['user_settings'] = array_map(fn($s) => $s['value'], $settings);
    header("Location: ../settings?saved=1");
    exit;
}
