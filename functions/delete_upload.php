<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['timestamp'])) {
    $dataFile = '../data/data.json';

    if (file_exists($dataFile)) {
        $json = file_get_contents($dataFile);
        $data = json_decode($json, true) ?? [];

        if (isset($data['uploads']) && is_array($data['uploads'])) {
            $timestamp = (int) $_POST['timestamp'];
            $originalCount = count($data['uploads']);

            // Filter out the upload with matching timestamp
            $data['uploads'] = array_filter($data['uploads'], function ($upload) use ($timestamp) {
                return (int) $upload['timestamp'] !== $timestamp;
            });

            // Save only if something was removed
            if (count($data['uploads']) < $originalCount) {
                file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
            }
        }
    }
}

header("Location: ../datapunten.php");
exit();
