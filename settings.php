<?php
include 'includes/auth.php';
include 'includes/handle_Settings.php';

$pageTitle = "Dashboard | Settings";
include 'components/Header.inc.php';

$dataPath = __DIR__ . '/data/user.json';
$userData = file_exists($dataPath) ? json_decode(file_get_contents($dataPath), true) : [];

// Ensure userSettings exists
if (!isset($userData['userSettings'])) {
    $userData['userSettings'] = [];
}
$settings = $userData['userSettings'];
?>

<body>
    <div class="dashboard datapunten">
        <?php include 'components/Sidebar.inc.php'; ?>

        <div class="dashboard-content">
            <h1>Instellingen</h1>
            <?php if (isset($_GET['saved'])): ?>
                <div id="successMessage" class="alert success">
                    <b>Instellingen</b> opgeslagen!
                </div>
                <script>
                    const url = new URL(window.location);
                    url.searchParams.delete('saved');
                    window.history.replaceState({}, document.title, url);
                    setTimeout(() => {
                        const msg = document.getElementById('successMessage');
                        if (msg) msg.style.display = 'none';
                    }, 3000);
                </script>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div id="successMessage" class="alert success">
                    <?php $_SESSION['settings_error'] ?>
                </div>
                <script>
                    const url = new URL(window.location);
                    url.searchParams.delete('error');
                    window.history.replaceState({}, document.title, url);
                    setTimeout(() => {
                        const msg = document.getElementById('successMessage');
                        if (msg) msg.style.display = 'none';
                    }, 3000);
                </script>
            <?php endif; ?>
            <!-- Settings Form -->
            <form method="POST" action="includes/handle_Settings.php" class="settings-form">
                <?php foreach ($settings as $key => $meta): ?>
                    <div class="form-group">
                        <?php if ($meta['type'] === 'checkbox'): ?>
                            <label class="checkbox-container">
                                <span class="checkbox-text"><?= htmlspecialchars($meta['label']) ?></span>
                                <input type="checkbox" name="<?= $key ?>" <?= $meta['value'] ? 'checked' : '' ?>>
                                <span class="checkmark"></span>
                            </label>
                        <?php else: ?>
                            <label for="<?= $key ?>"><?= htmlspecialchars($meta['label']) ?></label>
                            <input type="<?= htmlspecialchars($meta['type']) ?>" id="<?= $key ?>" name="<?= $key ?>"
                                value="<?= htmlspecialchars($meta['value']) ?>">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <div class="form-group">
                    <label for="">Gebruikersnaam wijzigen</label>
                    <button type="button" class="btn secondary-btn setting-btn"
                        onclick="openModal('usernameModal')">Gebruikersnaam
                        wijzigen</button>
                </div>

                <div class="form-group">
                    <label for="">Wachtwoord wijzigen</label>
                    <button type="button" class="btn secondary-btn setting-btn"
                        onclick="openModal('passwordModal')">Wachtwoord
                        wijzigen</button>
                </div>

                <button type="submit" class="btn primary-btn setting-submit-btn"
                    id="setting-submit-btn">Opslaan</button>
            </form>
        </div>

        <!-- Password Modal -->
        <div id="passwordModal" class="modal" style="display: none;">
            <div class="modal-content">
                <h2>Wachtwoord wijzigen</h2>
                <form method="POST" action="includes/handle_Settings.php">
                    <input type="hidden" name="changePassword" value="1">
                    <input type="password" id="newPassword" name="newPassword" placeholder="Nieuw wachtwoord" required>
                    <div class="modal-actions">
                        <button type="submit" class="btn primary-btn">Opslaan</button>
                        <button type="button" onclick="closeModal('passwordModal')" class="close-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                <path
                                    d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Username Modal -->
        <div id="usernameModal" class="modal" style="display: none;">
            <div class="modal-content">
                <h2>gebruikersnaam wijzigen</h2>
                <form method="POST" action="includes/handle_Settings.php">
                    <input type="hidden" name="changeUsername" value="1">
                    <input type="text" id="newUsername" name="newUsername" placeholder="Nieuwe gebruikersnaam" required>
                    <div class="modal-actions">
                        <button type="submit" class="btn primary-btn">Opslaan</button>
                        <button type="button" onclick="closeModal('usernameModal')" class="close-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                <path
                                    d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openModal(id) {
                document.getElementById(id).style.display = 'flex';
            }
            function closeModal(id) {
                document.getElementById(id).style.display = 'none';
            }
        </script>
    </div>
</body>

</html>