<?php include 'includes/auth.php'; ?>

<?php
$pageTitle = "Dashboard | Cursussen";
include 'components/Header.inc.php';

$dataPath = __DIR__ . '/data/cursussen.json';
$cursussen = file_exists($dataPath) ? json_decode(file_get_contents($dataPath), true) : [];

$error = '';

// Handle add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_cursus'])) {
    $title = trim($_POST['cursus_titel']);

    // Check for duplicate title
    $duplicate = false;
    foreach ($cursussen as $cursus) {
        if (strtolower($cursus['title']) === strtolower($title)) {
            $duplicate = true;
            break;
        }
    }

    if ($duplicate) {
        $error = "Deze cursus bestaat al.";
    } else {
        // Shift existing cursussen' order by 1 (to make room for the new first cursus)
        foreach ($cursussen as &$cursus) {
            $cursus['order'] += 1;
        }

        // Add new cursus with order 1 (newest)
        $newId = count($cursussen) > 0 ? max(array_column($cursussen, 'id')) + 1 : 1;

        $cursussen[] = [
            'id' => $newId,
            'title' => $title,
            'order' => 1 // Newest cursus is first
        ];

        // Sort by order after inserting the new cursus at position 1
        usort($cursussen, fn($a, $b) => $a['order'] <=> $b['order']);

        file_put_contents($dataPath, json_encode($cursussen, JSON_PRETTY_PRINT));
        header("Location: cursussen.php");
        exit;
    }
}


// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int) $_POST['delete_id'];
    $cursussen = array_filter($cursussen, fn($c) => $c['id'] !== $deleteId);
    file_put_contents($dataPath, json_encode(array_values($cursussen), JSON_PRETTY_PRINT));
    header("Location: cursussen.php");
    exit;
}

// Handle edit
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
    header("Location: cursussen.php");
    exit;
}

// Handle reordering
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['move_order'])) {
    $id = (int)$_POST['move_id'];
    $direction = $_POST['direction'];

    $currentIndex = null;
    foreach ($cursussen as $index => $cursus) {
        if ($cursus['id'] === $id) {
            $currentIndex = $index;
            break;
        }
    }

    if ($currentIndex !== null) {
        // Move up or down based on direction
        if ($direction === 'up' && $currentIndex > 0) {
            // Swap with the previous item
            $temp = $cursussen[$currentIndex];
            $cursussen[$currentIndex] = $cursussen[$currentIndex - 1];
            $cursussen[$currentIndex - 1] = $temp;
        } elseif ($direction === 'down' && $currentIndex < count($cursussen) - 1) {
            // Swap with the next item
            $temp = $cursussen[$currentIndex];
            $cursussen[$currentIndex] = $cursussen[$currentIndex + 1];
            $cursussen[$currentIndex + 1] = $temp;
        }

        // Reindex the orders
        foreach ($cursussen as $index => $cursus) {
            $cursussen[$index]['order'] = $index + 1; // Reindex orders starting from 1
        }

        file_put_contents($dataPath, json_encode($cursussen, JSON_PRETTY_PRINT));
        header("Location: cursussen.php");
        exit;
    }
}

// Sort by order before displaying
usort($cursussen, fn($a, $b) => $a['order'] <=> $b['order']);
?>

<body class="dashboard datapunten">
<?php include 'components/Sidebar.inc.php'; ?>

<div class="dashboard-content">
    <h1>Cursussen</h1>

    <!-- Error -->
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <!-- Add Cursus Button -->
    <button onclick="document.getElementById('cursusModal').style.display='flex'">
        Voeg cursus toe
    </button>

    <!-- Modal -->
    <div id="cursusModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
        background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
        <div style="background:white; padding:20px; border-radius:10px;">
            <form method="POST" action="cursussen.php">
                <label for="cursus_titel">Cursus titel:</label><br>
                <input type="text" name="cursus_titel" id="cursus_titel" required><br><br>
                <button type="submit" name="add_cursus">Toevoegen</button>
                <button type="button" onclick="document.getElementById('cursusModal').style.display='none'">Annuleer</button>
            </form>
        </div>
    </div>

    <h2>Alle cursussen</h2>
    <ul>
        <?php foreach ($cursussen as $cursus): ?>
            <li>
                <?= htmlspecialchars($cursus['title']) ?> (volgorde: <?= $cursus['order'] ?>)

                <form method="POST" action="cursussen.php" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?= $cursus['id'] ?>">
                    <button type="submit" onclick="return confirm('Weet je zeker dat je deze cursus wilt verwijderen?')">Verwijderen</button>
                </form>
                <form method="POST" action="cursussen.php" style="display:inline;">
                    <input type="hidden" name="edit_id" value="<?= $cursus['id'] ?>">
                    <input type="text" name="edit_title" value="<?= htmlspecialchars($cursus['title']) ?>" required>
                    <button type="submit" name="edit_cursus">Bewerken</button>
                </form>

                <!-- Move Up / Down -->
                <form method="POST" action="cursussen.php" style="display:inline;">
                    <input type="hidden" name="move_id" value="<?= $cursus['id'] ?>">
                    <input type="hidden" name="direction" value="up">
                    <button type="submit" name="move_order" <?= $cursus['order'] === 1 ? 'disabled' : '' ?>>↑</button>
                </form>

                <form method="POST" action="cursussen.php" style="display:inline;">
                    <input type="hidden" name="move_id" value="<?= $cursus['id'] ?>">
                    <input type="hidden" name="direction" value="down">
                    <button type="submit" name="move_order" <?= $cursus['order'] === count($cursussen) ? 'disabled' : '' ?>>↓</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script>
// Close modal on outside click
window.onclick = function(event) {
    const modal = document.getElementById('cursusModal');
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
