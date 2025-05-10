<div id="cursusModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div style="background:white; padding:20px; border-radius:10px;">
        <form method="POST" action="cursussen.php">
            <label for="cursus_titel">Cursus titel:</label><br>
            <input type="text" name="cursus_titel" id="cursus_titel" required><br><br>
            <button type="submit" name="add_cursus">Toevoegen</button>
            <button type="button"
                onclick="document.getElementById('cursusModal').style.display='none'">Annuleer</button>
        </form>
    </div>
</div>