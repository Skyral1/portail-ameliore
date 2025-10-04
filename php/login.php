<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion | Portail</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
    <h1>Connexion</h1>
    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <p style="color:red;">Mauvais nom d'utilisateur ou mot de passe.</p>
    <?php endif; ?>
    <form method="post" action="login_process.php">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
