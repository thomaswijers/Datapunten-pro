<?php include 'includes/auth.php'; ?>
<?php
$pageTitle = "Dashboard | Cursussen";
include 'components/Header.inc.php';

$dataPath = __DIR__ . '/data/cursussen.json';
$cursussen = file_exists($dataPath) ? json_decode(file_get_contents($dataPath), true) : [];
$error = '';
?>

<?php
include 'includes/handle_add_cursus.php';
include 'includes/handle_delete_cursus.php';
include 'includes/handle_edit_cursus.php';
include 'includes/handle_reorder_cursus.php';
usort($cursussen, fn($a, $b) => $a['order'] <=> $b['order']);
?>

<body class="dashboard datapunten">
    <?php include 'components/Sidebar.inc.php'; ?>

    <div class="dashboard-content">
        <h1>Cursussen</h1>

        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- Add Button -->
        <button onclick="document.getElementById('cursusModal').style.display='flex'">Voeg cursus toe</button>

        <?php include 'components/CursusModal.inc.php'; ?>
        <?php include 'components/CursusList.inc.php'; ?>
    </div>

    <script>
        window.onclick = function (event) {
            const modal = document.getElementById('cursusModal');
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>