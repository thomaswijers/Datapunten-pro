<?php
include 'includes/auth.php';

$pageTitle = "Dashboard | Datapunten";
include 'components/Header.inc.php';

$dataPath = __DIR__ . '/data/datapunten.json';
$cursusPath = __DIR__ . '/data/cursussen.json';
$datapunten = file_exists($dataPath) ? json_decode(file_get_contents($dataPath), true) : [];
$cursussen = file_exists($cursusPath) ? json_decode(file_get_contents($cursusPath), true) : [];

include 'includes/handle_add_datapunt.php';
include 'includes/handle_delete_datapunt.php';
include 'includes/handle_edit_datapunt.php';

usort($datapunten, fn($a, $b) => $a['order'] <=> $b['order']);
?>

<body class="dashboard datapunten">
    <?php include 'components/Sidebar.inc.php'; ?>

    <div class="dashboard-content">
        <?php if (isset($_GET['success'])): ?>
            <div id="successMessage" class="alert success">
                <?= $_GET['success'] === 'added' ? 'Datapunt succesvol toegevoegd!' : 'Datapunt succesvol bijgewerkt!' ?>
            </div>

            <script>
                // Immediately remove ?success=... from URL to prevent message on refresh
                const url = new URL(window.location);
                url.searchParams.delete('success');
                window.history.replaceState({}, document.title, url);

                // Then hide the message after 5 seconds
                setTimeout(() => {
                    const msg = document.getElementById('successMessage');
                    if (msg) msg.style.display = 'none';
                }, 5000);
            </script>
        <?php endif; ?>

        <h1>Datapunten</h1>

        <button onclick="document.getElementById('addModal').style.display='flex'">
            Voeg datapunt toe
        </button>

        <?php include 'components/DatapuntModal.inc.php'; ?>

        <ul>
            <?php foreach ($datapunten as $datapunt): ?>
                <li>
                    <?= htmlspecialchars($datapunt['title']) ?> - <?= htmlspecialchars($datapunt['cursus']) ?>
                    <?= $datapunt['herkansing'] ? '(Herkansing)' : '' ?>

                    <?php if (!empty($datapunt['file'])): ?>
                        - <a href="<?= htmlspecialchars($datapunt['file']) ?>" target="_blank">Download</a>
                    <?php endif; ?>

                    <form method="POST" action="datapunten.php" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?= $datapunt['id'] ?>">
                        <button type="submit"
                            onclick="return confirm('Weet je zeker dat je dit datapunt wilt verwijderen?')">Verwijderen</button>
                    </form>

                    <button type="button" onclick='openEditModal(<?= json_encode($datapunt) ?>)'>Bewerken</button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script>
        function openEditModal(datapunt) {
            document.getElementById('edit_id').value = datapunt.id;
            document.getElementById('edit_title').value = datapunt.title;
            document.getElementById('edit_cursus').value = datapunt.cursus || '';
            document.getElementById('edit_herkansing').checked = datapunt.herkansing === true;
            document.getElementById('editModal').style.display = 'flex';
        }

        window.onclick = function (event) {
            const addModal = document.getElementById('addModal');
            const editModal = document.getElementById('editModal');
            if (event.target === addModal) addModal.style.display = "none";
            if (event.target === editModal) editModal.style.display = "none";
        }
    </script>
</body>