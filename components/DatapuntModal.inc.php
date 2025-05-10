<div id="addModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div style="background:white; padding:20px; border-radius:10px;">
        <form method="POST" action="datapunten.php" enctype="multipart/form-data">
            <label for="titel">Titel:</label><br>
            <input type="text" name="titel" id="titel" required><br><br>

            <label for="cursus">Cursus:</label><br>
            <select name="cursus" id="cursus" required>
                <option value="">Kies een cursus</option>
                <?php foreach ($cursussen as $cursus): ?>
                    <option value="<?= htmlspecialchars($cursus['title']) ?>"><?= htmlspecialchars($cursus['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="bestand">Bestand:</label><br>
            <input type="file" name="bestand" id="bestand"><br><br>

            <label><input type="checkbox" name="herkansing"> Herkansing</label><br><br>

            <button type="submit" name="add_datapunt">Toevoegen</button>
            <button type="button" onclick="document.getElementById('addModal').style.display='none'">Annuleer</button>
        </form>
    </div>
</div>

<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div style="background:white; padding:20px; border-radius:10px;">
        <form method="POST" action="datapunten.php" enctype="multipart/form-data">
            <input type="hidden" name="edit_id" id="edit_id">

            <label for="edit_title">Titel:</label><br>
            <input type="text" name="edit_title" id="edit_title" required><br><br>

            <label for="edit_cursus">Cursus:</label><br>
            <select name="edit_cursus" id="edit_cursus" required>
                <option value="">Kies een cursus</option>
                <?php foreach ($cursussen as $cursus): ?>
                    <option value="<?= htmlspecialchars($cursus['title']) ?>"><?= htmlspecialchars($cursus['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="edit_file">Bestand:</label><br>
            <input type="file" name="edit_file" id="edit_file"><br><br>

            <label><input type="checkbox" name="edit_herkansing" id="edit_herkansing"> Herkansing</label><br><br>

            <button type="submit" name="edit_datapunt">Opslaan</button>
            <button type="button" onclick="document.getElementById('editModal').style.display='none'">Annuleer</button>
        </form>
    </div>
</div>