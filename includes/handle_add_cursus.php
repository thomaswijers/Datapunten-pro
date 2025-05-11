<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_cursus'])) {
    $title = trim($_POST['cursus_titel']);

    // Check if the cursus already exists
    foreach ($cursussen as $cursus) {
        if (strtolower($cursus['title']) === strtolower($title)) {
            $error = "Deze cursus bestaat al.";
            return;
        }
    }

    // Add the new cursus at the beginning
    $newId = count($cursussen) > 0 ? max(array_column($cursussen, 'id')) + 1 : 1;
    $newCursus = [
        'id' => $newId,
        'title' => $title,
        'order' => 1 // Set the order for the new cursus to the top
    ];

    // Insert the new cursus at the beginning
    array_unshift($cursussen, $newCursus);

    // Reassign order values after inserting the new cursus at the top
    foreach ($cursussen as $index => &$cursus) {
        $cursus['order'] = $index + 1;  // Ensure correct order for each cursus
    }

    // Save the updated cursussen list
    file_put_contents($dataPath, json_encode($cursussen, JSON_PRETTY_PRINT));

    // Redirect to the cursussen page
    header("Location: cursussen");
    exit;
}
