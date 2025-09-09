<?php
// config.php - DB connection + helpers
session_start();

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "farmbaskets";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

function esc($v) {
    global $conn;
    return $conn->real_escape_string($v);
}

function is_logged_in() {
    return isset($_SESSION['user']);
}
function user_role() {
    return $_SESSION['user']['role'] ?? null;
}
function require_role($role) {
    if (!is_logged_in() || user_role() !== $role) {
        header("Location: /FarmBaskets/auth/login.php?role=$role");
        exit;
    }
}
function require_login() {
    if (!is_logged_in()) {
        header("Location: /FarmBaskets/auth/login.php?role=customer");
        exit;
    }
}

function flash($key, $value=null) {
    if ($value !== null) { $_SESSION['flash'][$key] = $value; return; }
    if (isset($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}
?>
