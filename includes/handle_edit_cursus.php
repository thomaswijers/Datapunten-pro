<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_cursus'])) {
    $editId = (int) $_POST['edit_id'];
    $newTitle = trim($_POST['edit_title']);

    foreach ($cursussen as &$cursus) {
        if ($cursus['id'] === $editId) {
            $cursus['title'] = $newTitle;
            break;
        }
    }

    file_put_contents($dataPath, json_encode($cursussen, JSON_PRETTY_PRINT));
    header("Location: cursussen");
    exit;
}
