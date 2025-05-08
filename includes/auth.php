<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session only if not already started
}

$userData = json_decode(file_get_contents(__DIR__ . '/../data/user.json'), true);
$validUserId = $userData['userLogin']['id'] ?? null;

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== $validUserId) {
    header("Location: /Projects/datapoint-php/login");
    exit;
}

return $userData;