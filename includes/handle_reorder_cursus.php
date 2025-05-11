<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['move_order'])) {
    $id = (int) $_POST['move_id'];
    $direction = $_POST['direction'];

    $currentIndex = null;
    foreach ($cursussen as $index => $cursus) {
        if ($cursus['id'] === $id) {
            $currentIndex = $index;
            break;
        }
    }

    if ($currentIndex !== null) {
        if ($direction === 'up' && $currentIndex > 0) {
            $temp = $cursussen[$currentIndex];
            $cursussen[$currentIndex] = $cursussen[$currentIndex - 1];
            $cursussen[$currentIndex - 1] = $temp;
        } elseif ($direction === 'down' && $currentIndex < count($cursussen) - 1) {
            $temp = $cursussen[$currentIndex];
            $cursussen[$currentIndex] = $cursussen[$currentIndex + 1];
            $cursussen[$currentIndex + 1] = $temp;
        }

        foreach ($cursussen as $index => &$cursus) {
            $cursus['order'] = $index + 1;
        }

        file_put_contents($dataPath, json_encode($cursussen, JSON_PRETTY_PRINT));
        header("Location: cursussen");
        exit;
    }
}
