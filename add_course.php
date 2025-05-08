<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_course'])) {
    $newCourse = trim($_POST['new_course']);

    if (!empty($newCourse)) {
        $courseFile = "data/courses.json";
        $courses = [];

        if (file_exists($courseFile)) {
            $courses = json_decode(file_get_contents($courseFile), true) ?? [];
        }

        // Avoid duplicates (case-insensitive)
        foreach ($courses as $existingCourse) {
            if (strcasecmp($existingCourse, $newCourse) === 0) {
                header("Location: dashboard.php");
                exit(); // Don't add duplicate
            }
        }

        $courses[] = $newCourse;

        // Save updated list
        file_put_contents($courseFile, json_encode($courses, JSON_PRETTY_PRINT));
    }
}

header("Location: dashboard.php");
exit();
