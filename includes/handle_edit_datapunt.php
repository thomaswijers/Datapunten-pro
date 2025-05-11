<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_datapunt'])) {
    $editId = (int) $_POST['edit_id'];
    $newTitle = trim($_POST['edit_title']);
    $newCursus = trim($_POST['edit_cursus']);
    $herkansing = isset($_POST['edit_herkansing']);
    $filePath = null;

    // Handle file upload logic in the edit section (use the handleFileUpload function)
    if (isset($_FILES['edit_file']) && $_FILES['edit_file']['error'] === UPLOAD_ERR_OK) {
        $filePath = handleFileUpload($_FILES['edit_file']);
    }

    // Update the datapunt with new values
    foreach ($datapunten as &$datapunt) {
        if ($datapunt['id'] === $editId) {
            $datapunt['title'] = $newTitle;
            $datapunt['cursus'] = $newCursus;
            $datapunt['herkansing'] = $herkansing;

            // Only update the file if a new file was uploaded
            if ($filePath) {
                $datapunt['file'] = $filePath;
            }

            break;
        }
    }

    // Save the updated datapunten to the file
    file_put_contents($dataPath, json_encode($datapunten, JSON_PRETTY_PRINT));
    header("Location: datapunten?success=edited");
    exit;
}
