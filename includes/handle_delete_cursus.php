<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int) $_POST['delete_id'];
    $cursussen = array_filter($cursussen, fn($c) => $c['id'] !== $deleteId);
    file_put_contents($dataPath, json_encode(array_values($cursussen), JSON_PRETTY_PRINT));
    header("Location: cursussen.php");
    exit;
}
