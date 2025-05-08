<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('data/data.json');
    $data = json_decode($json, true);

    $input_user = $_POST['username'] ?? '';
    $input_pass = $_POST['password'] ?? '';

    $stored_user = $data['userdata']['username'] ?? '';
    $stored_pass = $data['userdata']['password'] ?? '';

    if (
        $input_user === $stored_user &&
        password_verify($input_pass, $stored_pass)
    ) {
        $_SESSION['logged_in'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>

<body>
    <h2>Login</h2>
    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <input type="text" name="username" placeholder="Username" required /><br>
        <input type="password" name="password" placeholder="Password" required /><br>
        <button type="submit">Login</button>
    </form>
</body>

</html>