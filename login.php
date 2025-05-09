<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: datapunten"); // Redirect if already logged in
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Load users data from the JSON file
    $userData = json_decode(file_get_contents('data/user.json'), true);

    // Check if login credentials are valid
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password match
    if ($userData['userLogin']['username'] === $username && password_verify($password, $userData['userLogin']['password'])) {
        // Correct credentials, set session
        $_SESSION['user_id'] = $userData['userLogin']['id']; // Since you're allowing only one user, set the ID statically
        $_SESSION['user_settings'] = $userData['userSettings']; // Store the settings in the session for later use
        header("Location: datapunten");
        exit;
    } else {
        // If credentials are wrong
        $error_message = "Wachtwoord of gebruikersnaam ongeldig!";
    }
}

?>

<?php
$pageTitle = "Inloggen";

include 'components/Header.inc.php';
?>
<body class="login">
    <div class="login-box">
        <h2>Welcome</h2>
        
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Gebruikersnaam" required>
            
            <input type="password" name="password" placeholder="Wachtwoord" required>
            
            <button type="submit" class="btn primary-btn">Login</button>
        </form>
        <a href="./">Naar website</a>
    </div>
</body>

</html>