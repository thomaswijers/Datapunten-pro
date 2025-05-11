<?php include 'includes/auth.php'; ?>

<?php
$pageTitle = "Dashboard | Settings";
include 'components/Header.inc.php';

// Path to the settings file
$dataPath = __DIR__ . '/data/user.json';
$userData = file_exists($dataPath) ? json_decode(file_get_contents($dataPath), true) : [];

// Define settings schema for easier future expansion
$settingsSchema = [
    'darkMode' => ['label' => 'Dark mode', 'type' => 'checkbox'],
    'frogCursor' => ['label' => 'Frog Cursor', 'type' => 'checkbox'],
    'adhdMode' => ['label' => 'ADHD Mode', 'type' => 'checkbox'],
    'websiteColor' => ['label' => 'Website Kleur', 'type' => 'color'],
    'textColor' => ['label' => 'Tekst Kleur', 'type' => 'color'],
];

// Initialize settings if missing
if (!isset($userData['userSettings'])) {
    $userData['userSettings'] = [];
}
$settings = $userData['userSettings'];

// Merge defaults from schema
foreach ($settingsSchema as $key => $meta) {
    if (!isset($settings[$key])) {
        $settings[$key] = $meta['type'] === 'checkbox' ? false : '';
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($settingsSchema as $key => $meta) {
        if ($meta['type'] === 'checkbox') {
            $settings[$key] = isset($_POST[$key]);
        } else {
            $settings[$key] = $_POST[$key] ?? '';
        }
    }

    $userData['userSettings'] = $settings;
    file_put_contents($dataPath, json_encode($userData, JSON_PRETTY_PRINT));
    $_SESSION['user_settings'] = $settings;
    header("Location: settings.php?saved=1");
    exit;
}
?>

<body class="dashboard datapunten">
    <?php include 'components/Sidebar.inc.php'; ?>

    <div class="dashboard-content">
        <h1>Instellingen</h1>

        <?php if (isset($_GET['saved'])): ?>
            <div id="successMessage" class="alert success">
                <b>Instellingen</b> opgeslagen!
            </div>

            <script>
                // Immediately remove ?success=... from URL to prevent message on refresh
                const url = new URL(window.location);
                url.searchParams.delete('saved');
                window.history.replaceState({}, document.title, url);

                // Then hide the message after 5 seconds
                setTimeout(() => {
                    const msg = document.getElementById('successMessage');
                    if (msg) msg.style.display = 'none';
                }, 3000);
            </script>
        <?php endif; ?>

        <form method="POST" class="settings-form">
            <?php foreach ($settingsSchema as $key => $meta): ?>
                <div class="form-group">
                    <?php if ($meta['type'] === 'checkbox'): ?>
                        <label class="checkbox-container">
                            <span class="checkbox-text"><?= htmlspecialchars($meta['label']) ?></span>
                            <input type="checkbox" name="<?= $key ?>" <?= $settings[$key] ? 'checked' : '' ?>>
                            <span class="checkmark"></span>
                        </label>
                    <?php elseif ($meta['type'] === 'color'): ?>
                        <label for="<?= $key ?>"><?= htmlspecialchars($meta['label']) ?></label>
                        <input type="color" id="<?= $key ?>" name="<?= $key ?>"
                            value="<?= htmlspecialchars($settings[$key]) ?>">
                    <?php else: ?>
                        <label for="<?= $key ?>"><?= htmlspecialchars($meta['label']) ?></label>
                        <input type="<?= $meta['type'] ?>" id="<?= $key ?>" name="<?= $key ?>"
                            value="<?= htmlspecialchars($settings[$key]) ?>">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="btn primary-btn setting-btn">Opslaan</button>
        </form>
    </div>
</body>