<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_datapunt'])) {
    $title = trim($_POST['titel']);
    $cursus = trim($_POST['cursus']);
    $herkansing = isset($_POST['herkansing']);
    $filePath = null;

    if (isset($_FILES['bestand']) && $_FILES['bestand']['error'] === UPLOAD_ERR_OK) {
        $uploadsDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadsDir))
            mkdir($uploadsDir);
        $filename = time() . '_' . basename($_FILES['bestand']['name']);
        $targetPath = $uploadsDir . $filename;
        move_uploaded_file($_FILES['bestand']['tmp_name'], $targetPath);
        $filePath = 'uploads/' . $filename;
    }

    foreach ($datapunten as &$d)
        $d['order'] += 1;

    $newId = count($datapunten) > 0 ? max(array_column($datapunten, 'id')) + 1 : 1;

    $datapunten[] = [
        'id' => $newId,
        'title' => $title,
        'cursus' => $cursus,
        'file' => $filePath,
        'herkansing' => $herkansing,
        'order' => 1
    ];

    usort($datapunten, fn($a, $b) => $a['order'] <=> $b['order']);
    file_put_contents($dataPath, json_encode($datapunten, JSON_PRETTY_PRINT));
    header("Location: datapunten.php?success=added");
    exit;
}
