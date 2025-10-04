<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

// Afficher un message de bienvenue
// echo 'Bienvenue, ' . $_SESSION['username'] . '!';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ajouter un site</title>
    <link rel="shortcut icon" href="../assets/img/logo_rounded.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../assets/css/new-site.css">
</head>

<body>
    <h1>Ajouter un site</h1>
    <form method="post" action="./traitement.php">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" required>
        <br>
        <label for="image">Lien de l'image :</label>
        <input type="text" id="image" name="image" required>
        <br>
        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>
        <br>
        <label for="url">URL :</label>
        <input type="text" id="url" name="url" required>
        <br>
        <input type="submit" value="Ajouter">
    </form>
</body>

</html>