<?php
// Check if $datapunten is available, otherwise include the datapunten data
if (!isset($datapunten)) {
    $dataPath = __DIR__ . '/../data/datapunten.json';
    $datapunten = file_exists($dataPath) ? json_decode(file_get_contents($dataPath), true) : [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int) $_POST['delete_id'];
    $datapunten = array_filter($datapunten, fn($d) => $d['id'] !== $deleteId);

    // Re-index the array to reset the keys
    $datapunten = array_values($datapunten);

    file_put_contents($dataPath, json_encode($datapunten, JSON_PRETTY_PRINT));
    header("Location: datapunten");
    exit;
}
