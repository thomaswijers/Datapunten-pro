<?php
// Check if $datapunten is available, otherwise include the datapunten data
if (!isset($datapunten)) {
    $dataPath = __DIR__ . '/../data/datapunten.json';
    $datapunten = file_exists($dataPath) ? json_decode(file_get_contents($dataPath), true) : [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int) $_POST['delete_id'];

    // Find the datapunt to delete
    $datapuntToDelete = null;
    foreach ($datapunten as $datapunt) {
        if ($datapunt['id'] === $deleteId) {
            $datapuntToDelete = $datapunt;
            break;
        }
    }

    // If the datapunt has a file, delete the file
    if ($datapuntToDelete && isset($datapuntToDelete['file']) && file_exists(__DIR__ . '/../' . $datapuntToDelete['file'])) {
        unlink(__DIR__ . '/../' . $datapuntToDelete['file']);
    }

    // Remove the datapunt from the array
    $datapunten = array_filter($datapunten, fn($d) => $d['id'] !== $deleteId);

    // Re-index the array to reset the keys
    $datapunten = array_values($datapunten);

    // Save the updated data back to the JSON file
    file_put_contents($dataPath, json_encode($datapunten, JSON_PRETTY_PRINT));

    // Redirect to the datapunten page
    header("Location: datapunten");
    exit;
}
