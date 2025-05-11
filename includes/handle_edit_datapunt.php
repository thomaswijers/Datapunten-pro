<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_datapunt'])) {
    $editId = (int) $_POST['edit_id'];
    $newTitle = trim($_POST['edit_title']);
    $newCursus = trim($_POST['edit_cursus']);
    $herkansing = isset($_POST['edit_herkansing']);
    $filePath = null;

    if (isset($_FILES['edit_file']) && $_FILES['edit_file']['error'] === UPLOAD_ERR_OK) {
        $uploadsDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadsDir))
            mkdir($uploadsDir);
        $filename = time() . '_' . basename($_FILES['edit_file']['name']);
        $targetPath = $uploadsDir . $filename;
        move_uploaded_file($_FILES['edit_file']['tmp_name'], $targetPath);
        $filePath = 'uploads/' . $filename;
    }

    foreach ($datapunten as &$datapunt) {
        if ($datapunt['id'] === $editId) {
            $datapunt['title'] = $newTitle;
            $datapunt['cursus'] = $newCursus;
            $datapunt['herkansing'] = $herkansing;
            if ($filePath)
                $datapunt['file'] = $filePath;
            break;
        }
    }

    file_put_contents($dataPath, json_encode($datapunten, JSON_PRETTY_PRINT));
    header("Location: datapunten?success=edited");
    exit;
}
