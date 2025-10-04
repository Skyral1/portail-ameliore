<?php
session_start();
require_once __DIR__ . '/config.php';

// Redirige si déjà connecté
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $pass_confirm = $_POST['password_confirm'] ?? '';

    if ($username === '' || $password === '' || $pass_confirm === '') {
        $message = "Tous les champs sont obligatoires.";
    } elseif ($password !== $pass_confirm) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifie si l'utilisateur existe déjà
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $message = "Ce nom d'utilisateur existe déjà.";
        } else {
            // Hashage du mot de passe
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt->close();

            $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("s", $username, $hash);
            if ($stmt->execute()) {
                $message = "Compte créé avec succès ! <a href='login.php'>Se connecter</a>";
            } else {
                $message = "Erreur lors de la création du compte.";
            }
        }
        $stmt->close();
    }
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <main class="login-container">
        <h1>Inscription</h1>
        <?php if ($message): ?>
            <div class="error"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required autocomplete="username">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required autocomplete="new-password">
            <label for="password_confirm">Confirmation du mot de passe :</label>
            <input type="password" id="password_confirm" name="password_confirm" required autocomplete="new-password">
            <input type="submit" value="S'inscrire">
        </form>
        <a class="button button_return" href="login.php">Retour à la connexion</a>
    </main>
</body>

</html>