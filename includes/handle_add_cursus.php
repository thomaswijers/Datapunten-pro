<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_cursus'])) {
    $title = trim($_POST['cursus_titel']);

    foreach ($cursussen as $cursus) {
        if (strtolower($cursus['title']) === strtolower($title)) {
            $error = "Deze cursus bestaat al.";
            return;
        }
    }

    foreach ($cursussen as &$cursus) {
        $cursus['order'] += 1;
    }

    $newId = count($cursussen) > 0 ? max(array_column($cursussen, 'id')) + 1 : 1;
    $cursussen[] = ['id' => $newId, 'title' => $title, 'order' => 1];

    file_put_contents($dataPath, json_encode($cursussen, JSON_PRETTY_PRINT));
    header("Location: cursussen.php");
    exit;
}
