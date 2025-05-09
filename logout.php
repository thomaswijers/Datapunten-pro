<?php
session_start();

// Only unset login-related session variable
unset($_SESSION['user_id']);

header("Location: login");
exit;
