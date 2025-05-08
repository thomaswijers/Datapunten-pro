<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$courseFile = 'data/courses.json';
if (!file_exists($courseFile)) {
    header("Location: dashboard.php");
    exit();
}

$courses = json_decode(file_get_contents($courseFile), true);
$index = intval($_POST['index'] ?? -1);
$direction = $_POST['direction'] ?? '';

if ($direction === 'up' && $index > 0) {
    // Swap with the previous item
    [$courses[$index - 1], $courses[$index]] = [$courses[$index], $courses[$index - 1]];
} elseif ($direction === 'down' && $index < count($courses) - 1) {
    // Swap with the next item
    [$courses[$index + 1], $courses[$index]] = [$courses[$index], $courses[$index + 1]];
}

file_put_contents($courseFile, json_encode($courses, JSON_PRETTY_PRINT));
header("Location: dashboard.php");
exit();
