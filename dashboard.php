<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Load courses
$courses = [];
$courseFile = "data/courses.json";
$pageTitle = "Dashboard";

include 'components/Header.inc.php';

if (file_exists($courseFile)) {
    $json = file_get_contents($courseFile);
    $courses = json_decode($json, true) ?? [];
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

    <h3>Add New Course</h3>
    <form action="add_course.php" method="POST">
        <input type="text" name="new_course" placeholder="New course name" required>
        <button type="submit">Add Course</button>
    </form>
    <hr>
    <h3>Existing Courses</h3>
    <ul>
        <?php foreach ($courses as $index => $course): ?>
            <li>
                <?= htmlspecialchars($course) ?>
                
                <!-- Move Up -->
                    <form action="move_course.php" method="POST" style="display:inline;">
                        <input type="hidden" name="direction" value="up">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <button type="submit" <?php if ($index == 0): ?>disabled<?php endif; ?>>↑</button>
                    </form>

                <!-- Move Down -->
                    <form action="move_course.php" method="POST" style="display:inline;">
                        <input type="hidden" name="direction" value="down">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <button type="submit" <?php if ($index == count($courses) - 1): ?>disabled<?php endif; ?>>↓</button>
                    </form>

                <!-- Delete -->
                <form action="delete_course.php" method="POST" style="display:inline;">
                    <input type="hidden" name="delete_course" value="<?= htmlspecialchars($course) ?>">
                    <button type="submit" onclick="return confirm('Delete this course?')">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

</body>

</html>