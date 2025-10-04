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
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="../assets/img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>

<body>
    <main class="login-container">
        <h1>Connexion</h1>
        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
            <div class="error">Mauvais nom d'utilisateur ou mot de passe.</div>
        <?php endif; ?>
        <form method="post" action="login_process.php">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required autocomplete="username">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required autocomplete="current-password">
            <input type="submit" value="Se connecter">
        </form>
        <a href="register.php" class="button button_return" style="margin-top:14px;text-align:center;">Créer un
            compte</a>
    </main>

</body>

</html>