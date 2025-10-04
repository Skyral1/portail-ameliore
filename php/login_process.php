<?php
// Vérifier les informations de connexion
$username = $_POST['username'];
$password = $_POST['password'];

// Vérifier si les informations sont correctes
if ($username === 'Skyral' && $password === 'motdecode') {
    // Informations de connexion correctes
    session_start();
    $_SESSION['username'] = $username;
    header('Location: ./');
} else {
    // Informations de connexion incorrectes
    header('Location: login.php?error=1');
}
?>