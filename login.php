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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <h2>Welcome</h2>

    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
    <a href="./">Naar de website</a>
</body>

</html>