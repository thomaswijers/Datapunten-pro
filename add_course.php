<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['new_course'])) {
    $newCourse = trim($_POST['new_course']);
    $dataFile = "data/data.json";

    $allData = [];
    if (file_exists($dataFile)) {
        $json = file_get_contents($dataFile);
        $allData = json_decode($json, true) ?? [];
    }

    // If uploads section exists, add a new course there
    if (isset($allData['uploads'])) {
        // Make sure the course is not already in the uploads (or course list elsewhere)
        $allData['uploads'][] = [
            'title' => $newCourse, // Temporary add the course name as title for later management
            'course_index' => $newCourse,
            'retake' => false,
            'filename' => '',
            'timestamp' => time()
        ];

        file_put_contents($dataFile, json_encode($allData, JSON_PRETTY_PRINT));
    }
}

header("Location: dashboard.php");
exit();
