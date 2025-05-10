<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int) $_POST['delete_id'];
    $datapunten = array_filter($datapunten, fn($d) => $d['id'] !== $deleteId);
    file_put_contents($dataPath, json_encode(array_values($datapunten), JSON_PRETTY_PRINT));
    header("Location: datapunten.php");
    exit;
}
