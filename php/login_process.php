<?php
session_start();
require_once __DIR__ . '/config.php';

if (!isset($_POST['username'], $_POST['password'])) {
    header('Location: login.php?error=1');
    exit;
}

$username = trim($_POST['username']);
$password = $_POST['password'];

$stmt = $mysqli->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($hashed_password);
if ($stmt->fetch() && password_verify($password, $hashed_password)) {
    $_SESSION['username'] = $username;
    header('Location: index.php');
} else {
    header('Location: login.php?error=1');
}
$stmt->close();
$mysqli->close();
exit;
?>
