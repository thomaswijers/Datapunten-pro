<?php
$dataFile = "data/data.json";
$uploads = [];
$pageTitle = "Home";

if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $allData = json_decode($json, true) ?? [];

    // Extract uploads data
    if (isset($allData['uploads']) && is_array($allData['uploads'])) {
        $uploads = $allData['uploads'];
    }

    // Group uploads by course
    $grouped = [];
    foreach ($uploads as $upload) {
        $course = $upload['course_index'] ?? 'Unknown';
        $grouped[$course][] = $upload;
    }
}

include 'components/Header.inc.php'
?>
    <h1>All Course Uploads</h1>

    <?php foreach ($grouped as $course => $files): ?>
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
                        <a href="uploads/<?= str_replace(' ', '%20', $file['filename']) ?>" target="_blank">
                            <?= htmlspecialchars($file['filename']) ?>
                        </a>


                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</body>

</html>