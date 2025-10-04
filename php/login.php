<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="shortcut icon" href="../assets/img/logo_rounded.png" type="image/x-icon">
    <title>Paris | Jeu</title>
</head>

<body>
    <main>
        <h3>
            <?php
            $url = $_SERVER['REQUEST_URI'];

            if ($url == '/php/login.php?error=1') {
                echo ("Mauvais pseudo et/ou mot de passe");
            }
            ?>
        </h3>
        <form action="login_process.php" method="post">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Se connecter">
        </form>
    </main>
    <footer>
        <p class="copyright">&copy;Thibault Soquette - Tous droits réservés</p>
    </footer>
</body>

</html>