<?php

function handleFileUpload($file)
{
    $uploadsDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true); // Ensure folder exists with proper permissions
    }

    $originalName = basename($file['name']);
    $targetPath = $uploadsDir . $originalName;

    // If file exists, rename it with a number suffix (e.g., file_1.ext, file_2.ext)
    $fileInfo = pathinfo($originalName);
    $baseName = $fileInfo['filename'];
    $extension = isset($fileInfo['extension']) ? '.' . $fileInfo['extension'] : '';
    $counter = 1;

    while (file_exists($targetPath)) {
        $newName = $baseName . '_' . $counter . $extension;
        $targetPath = $uploadsDir . $newName;
        $counter++;
    }

    move_uploaded_file($file['tmp_name'], $targetPath);
    return 'uploads/' . basename($targetPath);
}
