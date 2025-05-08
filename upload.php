<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $courseIndex = $_POST['course_index'] ?? '';
    $retake = isset($_POST['retake']) ? true : false;
    $file = $_FILES['file'] ?? null;

    if ($title && $courseIndex && $file && $file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "uploads/";
        $filename = basename($file['name']);
        $filepath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $dataFile = "data/data.json";
            $allData = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

            // Ensure 'uploads' array exists
            if (!isset($allData['uploads'])) {
                $allData['uploads'] = [];
            }

            $allData['uploads'][] = [
                'title' => $title,
                'course_index' => $courseIndex,
                'retake' => $retake,
                'filename' => $filename,
                'timestamp' => time()
            ];

            file_put_contents($dataFile, json_encode($allData, JSON_PRETTY_PRINT));
        }
    }
    // Redirect back to dashboard regardless of success/failure (can improve later)
    header("Location: dashboard.php");
    exit();
}
?>