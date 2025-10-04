<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un site</title>
    <link rel="shortcut icon" href="../assets/img/logo_rounded.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../assets/css/new-site.css">
</head>
<body>
    <h1>Ajouter un site</h1>
    <?php
    // Affichage message succès/erreur via GET si besoin
    if (isset($_GET['message'])) {
        echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
    }
    ?>
    <form method="post" action="traitement.php">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" required maxlength="255">

        <label for="image">Lien de l'image :</label>
        <input type="url" id="image" name="image" required maxlength="255" placeholder="https://exemple.com/image.png">

        <label for="description">Description :</label>
        <textarea id="description" name="description" required maxlength="800"></textarea>

        <label for="url">URL :</label>
        <input type="url" id="url" name="url" required maxlength="255" placeholder="https://exemple.com/">

        <input type="submit" value="Ajouter">
    </form>
    <br>
    <a class="button button_return" href="index.php">Retour</a>
</body>
</html>
