<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_datapunt'])) {
    $title = trim($_POST['titel']);
    $cursus = trim($_POST['cursus']);
    $herkansing = isset($_POST['herkansing']);
    $filePath = null;

    // Handle file upload using the function from handle_upload.php
    if (isset($_FILES['bestand']) && $_FILES['bestand']['error'] === UPLOAD_ERR_OK) {
        $filePath = handleFileUpload($_FILES['bestand']);
    }

    // Adjust the 'order' of existing data points to make space for the new one
    foreach ($datapunten as &$d) {
        $d['order'] += 1;
    }

    // Generate new ID
    $newId = count($datapunten) > 0 ? max(array_column($datapunten, 'id')) + 1 : 1;

    // Add new datapunt to the list
    $datapunten[] = [
        'id' => $newId,
        'title' => $title,
        'cursus' => $cursus,
        'file' => $filePath,
        'herkansing' => $herkansing,
        'order' => 1 // Add it at the top of the list (order = 1)
    ];

    // Sort the datapunten by 'order'
    usort($datapunten, fn($a, $b) => $a['order'] <=> $b['order']);

    // Save the updated datapunten back to the file
    file_put_contents($dataPath, json_encode($datapunten, JSON_PRETTY_PRINT));

    // Redirect with success message
    header("Location: datapunten?success=added");
    exit;
}
