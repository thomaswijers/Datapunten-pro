<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['delete_course'])) {
    $courseToDelete = $_POST['delete_course'];
    $courseFile = "data/courses.json";

    $courses = [];
    if (file_exists($courseFile)) {
        $json = file_get_contents($courseFile);
        $courses = json_decode($json, true) ?? [];
    }

    $courses = array_filter($courses, function ($c) use ($courseToDelete) {
        return $c !== $courseToDelete;
    });

    file_put_contents($courseFile, json_encode(array_values($courses), JSON_PRETTY_PRINT));
}

header("Location: dashboard.php");
exit();
