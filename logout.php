<?php
session_start();

// Only unset login-related session variable
unset($_SESSION['user_id']);

// Do NOT call session_destroy() so that user_settings stays available

header("Location: login");
exit;
