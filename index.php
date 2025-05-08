<?php
$dataFile = "data/data.json";
$courseFile = "data/courses.json";
$uploads = [];
$pageTitle = "Home";

include 'components/Header.inc.php';

// Load data.json
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $allData = json_decode($json, true) ?? [];

    if (isset($allData['uploads']) && is_array($allData['uploads'])) {
        $uploads = $allData['uploads'];
    }
}

// Group uploads by course
$grouped = [];
foreach ($uploads as $upload) {
    $course = $upload['course_index'] ?? 'Unknown';
    $grouped[$course][] = $upload;
}

// Reorder grouped uploads based on courses.json
$orderedGrouped = [];

if (file_exists($courseFile)) {
    $orderedCourses = json_decode(file_get_contents($courseFile), true) ?? [];

    foreach ($orderedCourses as $courseName) {
        if (isset($grouped[$courseName])) {
            $orderedGrouped[$courseName] = $grouped[$courseName];
        }
    }

    // Add remaining unknown or extra course uploads at the end
    foreach ($grouped as $course => $files) {
        if (!in_array($course, $orderedCourses)) {
            $orderedGrouped[$course] = $files;
        }
    }
} else {
    $orderedGrouped = $grouped; // fallback
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <style>
        .course-section {
            margin-bottom: 40px;
        }
        .retake {
            color: red;
            font-weight: bold;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <h1>All Course Uploads</h1>

    <?php foreach ($orderedGrouped as $course => $files): ?>
        <div class="course-section">
            <h2><?= htmlspecialchars($course) ?></h2>
            <ul>
                <?php foreach ($files as $file): ?>
                    <li>
                        <strong><?= htmlspecialchars($file['title']) ?></strong>
                        <?php if (!empty($file['retake'])): ?>
                            <span class="retake">(Retake)</span>
                        <?php endif; ?>
                        <br>
                        <a href="uploads/<?= rawurlencode($file['filename']) ?>" target="_blank">
                            <?= htmlspecialchars($file['filename']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</body>
</html>
