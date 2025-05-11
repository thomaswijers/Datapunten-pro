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
        <div class="top-content">
            <h1>Cursussen</h1>

            <!-- Add Button -->
            <button onclick="document.getElementById('cursusModal').style.display='flex'" class="btn primary-btn"><svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path
                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 144L48 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l144 0 0 144c0 17.7 14.3 32 32 32s32-14.3 32-32l0-144 144 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-144 0 0-144z" />
                </svg> Voeg cursus toe</button>
        </div>

        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

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