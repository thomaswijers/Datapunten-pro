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
        <div class="top-content">
            <h1>Datapunten</h1>

            <button onclick="openAddModal()" class="btn primary-btn">
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path
                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 144L48 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l144 0 0 144c0 17.7 14.3 32 32 32s32-14.3 32-32l0-144 144 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-144 0 0-144z" />
                </svg>
                Voeg datapunt toe
            </button>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div id="successMessage" class="alert success">
                <?= $_GET['success'] === 'added' ? '<b>Datapunt</b> succesvol toegevoegd!' : '<b>Datapunt</b> succesvol bijgewerkt!' ?>
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
                }, 3000);
            </script>
        <?php endif; ?>

        <?php include 'components/DatapuntModal.inc.php'; ?>

        <div class="datapoint-list">
            <?php foreach ($datapunten as $datapunt): ?>
                <div class="single-datapoint">
                    <div class="datapoint-content">
                        <?= htmlspecialchars($datapunt['title']) ?> - <?= htmlspecialchars($datapunt['cursus']) ?>
                    </div>
                    <div class="datapoint-actions">
                        <button type="button" onclick='openEditModal(<?= json_encode($datapunt) ?>)'>
                            <!-- Edit Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path
                                    d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z" />
                            </svg></button>
                        <form method="POST" action="datapunten.php" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?= $datapunt['id'] ?>">
                            <button type="submit"
                                onclick="return confirm('Weet je zeker dat je dit datapunt wilt verwijderen?')">
                                <!-- Trash Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                </svg></button>
                        </form>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function openEditModal(datapunt) {
            resetEditModalForm();
            document.getElementById('edit_id').value = datapunt.id;
            document.getElementById('edit_title').value = datapunt.title;
            document.getElementById('edit_cursus').value = datapunt.cursus || '';
            document.getElementById('edit_herkansing').checked = datapunt.herkansing === true;
            document.getElementById('editModal').style.display = 'flex';
        }

        function resetEditModalForm() {
            const editModal = document.getElementById('editModal');

            // Reset label text
            editModal.querySelectorAll('.custom-file-upload').forEach(function (label) {
                label.innerHTML = '<div class="file-upload-placeholder"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M288 109.3L288 352c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-242.7-73.4 73.4c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l128-128c12.5-12.5 32.8-12.5 45.3 0l128 128c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L288 109.3zM64 352l128 0c0 35.3 28.7 64 64 64s64-28.7 64-64l128 0c35.3 0 64 28.7 64 64l0 32c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64l0-32c0-35.3 28.7-64 64-64zM432 456a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/></svg> <span>Upload een bestand</span></div>';
            });

            // Clear file inputs
            editModal.querySelectorAll('.bestand').forEach(function (input) {
                input.value = '';
            });

            // You can also reset other inputs if needed:
            editModal.querySelectorAll('input[type="text"], select, input[type="checkbox"]').forEach(function (input) {
                if (input.type === 'checkbox') input.checked = false;
                else input.value = '';
            });
        }

        window.onclick = function (event) {
            const addModal = document.getElementById('addModal');
            const editModal = document.getElementById('editModal');
            if (event.target === addModal) addModal.style.display = "none";
            if (event.target === editModal) editModal.style.display = "none";
        }
    </script>
</body>