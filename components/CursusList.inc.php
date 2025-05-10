<h2>Alle cursussen</h2>
<ul>
    <?php foreach ($cursussen as $cursus): ?>
        <li>
            <?= htmlspecialchars($cursus['title']) ?> (volgorde: <?= $cursus['order'] ?>)

            <form method="POST" action="cursussen.php" style="display:inline;">
                <input type="hidden" name="delete_id" value="<?= $cursus['id'] ?>">
                <button type="submit"
                    onclick="return confirm('Weet je zeker dat je deze cursus wilt verwijderen?')">Verwijderen</button>
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