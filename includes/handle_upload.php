<?php
function handleFileUpload($file)
{
    $uploadsDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadsDir))
        mkdir($uploadsDir);

    $filename = time() . '_' . basename($file['name']);
    $targetPath = $uploadsDir . $filename;

    move_uploaded_file($file['tmp_name'], $targetPath);
    return 'uploads/' . $filename;
}
