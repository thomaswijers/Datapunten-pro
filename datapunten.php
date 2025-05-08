<?php
$courses = [];
$courseFile = "data/courses.json";
$pageTitle = "Dashboard | Datapunten";

include 'components/Header.inc.php';

if (file_exists($courseFile)) {
    $json = file_get_contents($courseFile);
    $courses = json_decode($json, true) ?? [];
}

include 'components/Sidebar.inc.php';

// Load uploads
$dataFile = "data/data.json";
$uploads = [];

if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $allData = json_decode($json, true) ?? [];

    if (isset($allData['uploads']) && is_array($allData['uploads'])) {
        $uploads = $allData['uploads'];

        // Sort by timestamp descending
        usort($uploads, function ($a, $b) {
            return ($b['timestamp'] ?? 0) - ($a['timestamp'] ?? 0);
        });
    }
}
?>

<h2>Upload Course File</h2>

<form action="upload.php" method="POST" enctype="multipart/form-data">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Course:</label><br>
    <select name="course_index" required>
        <?php foreach ($courses as $course): ?>
            <option value="<?= htmlspecialchars($course) ?>"><?= htmlspecialchars($course) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Upload File:</label><br>
    <input type="file" name="file" required><br><br>

    <label>
        <input type="checkbox" name="retake"> Mark as retake
    </label><br><br>

    <button type="submit">Upload</button>
</form>

<hr>

<h2>Uploaded Datapunten</h2>
<ul>
    <?php foreach ($uploads as $upload): ?>
        <li>
            <strong><?= htmlspecialchars($upload['title']) ?></strong>
            (<?= htmlspecialchars($upload['course_index']) ?>)
            <?php if (!empty($upload['retake'])): ?>
                <em style="color: red;">(Retake)</em>
            <?php endif; ?>
            <br>
            <a href="uploads/<?= rawurlencode($upload['filename']) ?>" target="_blank">
                <?= htmlspecialchars($upload['filename']) ?>
            </a>
            <br>
            <small>Uploaded on: <?= date('Y-m-d H:i:s', (int) ($upload['timestamp'] ?? 0)) ?></small>
            <br>
            <form action="functions/delete_upload.php" method="POST" style="display:inline;">
                <input type="hidden" name="timestamp" value="<?= htmlspecialchars($upload['timestamp']) ?>">
                <button type="submit"
                    onclick="return confirm('Are you sure you want to delete this upload?')">Delete</button>
            </form>

        </li>

    <?php endforeach; ?>
</ul>

<?php include 'components/Footer.inc.php'; ?>