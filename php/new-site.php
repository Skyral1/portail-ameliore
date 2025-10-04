<?php
session_start();
if (!isset($_SESSION['username'])) { header('Location: login.php'); exit; }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un site</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<main class="main-container">
    <h1>Ajouter un site</h1>
    <?php if (isset($_GET['message'])): ?>
        <div class="error"><?php echo htmlspecialchars($_GET['message']); ?></div>
    <?php endif; ?>
    <form method="post" action="traitement.php" autocomplete="off">
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
    <a class="button button_return" href="index.php">Retour</a>
</main>
</body>
</html>
