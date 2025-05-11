<div class="course-list">
    <?php
    $totalCourses = count($cursussen); // Total number of courses
    
    foreach ($cursussen as $index => $cursus):
        $isFirst = $index === 0;  // Check if it's the first course
        $isLast = $index === $totalCourses - 1;  // Check if it's the last course
        ?>
        <div class="single-course">
            <div class="course-content">
                <!-- Title displayed as text initially -->
                <span id="titleDisplay<?= $cursus['id'] ?>" onclick="enableEdit(<?= $cursus['id'] ?>)">
                    <?= htmlspecialchars($cursus['title']) ?>
                </span>

                <!-- Input field for editing the title -->
                <input type="text" id="titleInput<?= $cursus['id'] ?>" value="<?= htmlspecialchars($cursus['title']) ?>"
                    style="display:none;" onkeydown="handleEditKey(event, <?= $cursus['id'] ?>)"
                    oninput="enableSaveButton(<?= $cursus['id'] ?>)">
            </div>

            <div class="course-actions">
                <!-- Move Up / Down buttons -->
                <div class="order-control">
                    <form method="POST" action="cursussen.php" style="display:inline;">
                        <input type="hidden" name="move_id" value="<?= $cursus['id'] ?>">
                        <input type="hidden" name="direction" value="up">
                        <button type="submit" name="move_order" <?= $isFirst ? 'disabled' : '' ?>>
                            <!-- Up Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path
                                    d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8l256 0c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
                            </svg>
                        </button>
                    </form>
                    <form method="POST" action="cursussen.php" style="display:inline;">
                        <input type="hidden" name="move_id" value="<?= $cursus['id'] ?>">
                        <input type="hidden" name="direction" value="down">
                        <button type="submit" name="move_order" <?= $isLast ? 'disabled' : '' ?>>
                            <!-- Down Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path
                                    d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Edit and Save Buttons -->
                <button type="button" id="editButton<?= $cursus['id'] ?>" onclick="enableEdit(<?= $cursus['id'] ?>)">
                    <!-- Edit Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z" />
                    </svg>
                </button>
                <button type="button" id="saveButton<?= $cursus['id'] ?>" style="display:none;"
                    onclick="submitEdit(<?= $cursus['id'] ?>)">
                    <!-- Save Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path
                            d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-242.7c0-17-6.7-33.3-18.7-45.3L352 50.7C340 38.7 323.7 32 306.7 32L64 32zm0 96c0-17.7 14.3-32 32-32l192 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32L96 224c-17.7 0-32-14.3-32-32l0-64zM224 288a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
                    </svg>
                </button>

                <!-- The form for editing (contains actual inputs for processing) -->
                <form id="editForm<?= $cursus['id'] ?>" method="POST" action="cursussen.php" style="display:none;">
                    <input type="hidden" name="edit_id" value="<?= $cursus['id'] ?>">
                    <input type="hidden" name="edit_cursus" value="1">
                    <input type="hidden" name="edit_title" id="edit_title<?= $cursus['id'] ?>"
                        value="<?= htmlspecialchars($cursus['title']) ?>">
                </form>

                <!-- Delete button -->
                <form method="POST" action="cursussen.php" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?= $cursus['id'] ?>">
                    <button type="submit" onclick="return confirm('Weet je zeker dat je deze cursus wilt verwijderen?')">
                        <!-- Trash Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path
                                d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function enableEdit(cursusId) {
        document.getElementById('titleDisplay' + cursusId).style.display = 'none';
        const input = document.getElementById('titleInput' + cursusId);
        input.style.display = 'inline';
        input.focus();
        document.getElementById('editButton' + cursusId).style.display = 'none';
        document.getElementById('saveButton' + cursusId).style.display = 'inline';
    }
    function enableSaveButton(cursusId) {
        document.getElementById('edit_title' + cursusId).value = document.getElementById('titleInput' + cursusId).value;
    }

    function handleEditKey(event, cursusId) {
        if (event.key === 'Enter') {
            submitEdit(cursusId);
        }
    }

    function submitEdit(cursusId) {
        const form = document.getElementById('editForm' + cursusId);
        form.submit();
    }
</script>