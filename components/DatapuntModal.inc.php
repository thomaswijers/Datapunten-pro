<?php
$userData = json_decode(file_get_contents(__DIR__ . '/../data/user.json'), true);
$frogCursor = $userData['userSettings']['frogCursor']['value'] ?? false;
?>

<div id="addModal" class="modal">
    <div class="modal-content">
        <form method="POST" action="datapunten.php" enctype="multipart/form-data">
            <input type="text" name="titel" id="titel" placeholder="Datapunten titel" required>

            <select name="cursus" id="cursus" required>
                <option value="">Kies een cursus</option>
                <?php foreach ($cursussen as $cursus): ?>
                    <option value="<?= htmlspecialchars($cursus['title']) ?>"><?= htmlspecialchars($cursus['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="bestand" class="custom-file-upload">
                Custom Upload
            </label>
            <input type="file" name="bestand" id="bestand" class="bestand" placeholder="Bestand">
            <?php
            if ($frogCursor) {
                echo '<div class="alert info" style="display: none;"><img src="images/frog-loader.gif">Bestand wordt geüpload...</div>';
            } else {
                echo '<div class="alert info" style="display: none;">📤 Bestand wordt geüpload...</div>';
            }
            ?>

            <label class="checkbox-container">
                <span class="checkbox-text">Herkansing</span>
                <input type="checkbox" name="herkansing" checked="checked">
                <span class="checkmark"></span>
            </label>

            <button type="submit" name="add_datapunt" class="btn primary-btn">Toevoegen</button>
            <button type="button" onclick="document.getElementById('addModal').style.display='none'"
                class="close-btn"><svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path
                        d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                </svg></button>
        </form>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <form method="POST" action="datapunten.php" enctype="multipart/form-data">
            <input type="hidden" name="edit_id" id="edit_id">

            <input type="text" name="edit_title" id="edit_title" placeholder="Cursus titel" required>

            <select name="edit_cursus" id="edit_cursus" aria-placeholder="Cursus" required>
                <option value="">Kies een cursus</option>
                <?php foreach ($cursussen as $cursus): ?>
                    <option value="<?= htmlspecialchars($cursus['title']) ?>"><?= htmlspecialchars($cursus['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="bestand-edit" class="custom-file-upload">
                Custom Upload
            </label>
            <input type="file" name="edit_file" id="bestand-edit" class="bestand" placeholder="Bestand">

            <?php
            if ($frogCursor) {
                echo '<div class="alert info" style="display: none;"><img src="images/frog-loader.gif">Bestand wordt geüpload...</div>';
            } else {
                echo '<div class="alert info" style="display: none;">📤 Bestand wordt geüpload...</div>';
            }
            ?>

            <label class="checkbox-container">
                <span class="checkbox-text">Herkansing</span>
                <input type="checkbox" name="herkansing" name="edit_herkansing" checked="checked" id="edit_herkansing">
                <span class="checkmark"></span>
            </label>

            <button type="submit" name="edit_datapunt" class="btn primary-btn">Opslaan</button>
            <button type="button" onclick="document.getElementById('editModal').style.display='none'"
                class="close-btn"><svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path
                        d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                </svg></button>
        </form>
    </div>
</div>

<script>
    function resetAddModalForm() {
        const addModal = document.getElementById('addModal');

        // Reset label text
        addModal.querySelectorAll('.custom-file-upload').forEach(function (label) {
            label.innerHTML = '<div class="file-upload-placeholder"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M288 109.3L288 352c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-242.7-73.4 73.4c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l128-128c12.5-12.5 32.8-12.5 45.3 0l128 128c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L288 109.3zM64 352l128 0c0 35.3 28.7 64 64 64s64-28.7 64-64l128 0c35.3 0 64 28.7 64 64l0 32c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64l0-32c0-35.3 28.7-64 64-64zM432 456a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/></svg> <span>Upload een bestand</span></div>';
        });

        // Clear file inputs
        addModal.querySelectorAll('.bestand').forEach(function (input) {
            input.value = '';
        });

        // You can also reset other inputs if needed:
        addModal.querySelectorAll('input[type="text"], select, input[type="checkbox"]').forEach(function (input) {
            if (input.type === 'checkbox') input.checked = false;
            else input.value = '';
        });
    }

    function openAddModal() {
        resetAddModalForm();
        document.getElementById('addModal').style.display = 'flex'
    }

    // Update file label on change
    document.querySelectorAll('.bestand').forEach(function (fileInput) {
        fileInput.addEventListener('change', function () {
            const label = this.previousElementSibling;
            const fileName = this.files.length > 0 ? this.files[0].name : 'Custom Upload';
            label.textContent = fileName;
        });
    });

    document.querySelectorAll('.modal form').forEach(function (form) {
        form.addEventListener('submit', function () {
            const uploadingMessage = form.querySelector('.alert');

            // Hide any existing message (just in case)
            if (uploadingMessage) uploadingMessage.style.display = 'none';

            // Show after 1 second if page hasn't reloaded yet
            setTimeout(() => {
                if (uploadingMessage) uploadingMessage.style.display = 'flex';
            }, 100);
        });
    });

</script>