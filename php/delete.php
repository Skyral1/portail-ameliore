<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un site</title>
    <link rel="shortcut icon" href="../assets/img/logo_rounded.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
    <h1>Suppression d’un site</h1>
    <?php
    // Gestion suppression
    if (isset($_POST['delete_site'], $_POST['site_id'])) {
        $site_id = (int)$_POST['site_id'];
        $stmt = $mysqli->prepare("DELETE FROM sites_web WHERE id = ?");
        $stmt->bind_param("i", $site_id);
        if ($stmt->execute()) {
            echo "<p>Le site a été supprimé avec succès.</p>";
        } else {
            echo "<p>Erreur lors de la suppression du site.</p>";
        }
        $stmt->close();
    }

    // Récupération des sites
    $result = $mysqli->query("SELECT id, titre, url FROM sites_web ORDER BY ordre_apparition ASC");
    if ($result->num_rows > 0) {
        echo '<ul>';
        while ($row = $result->fetch_assoc()) {
            $titre = htmlspecialchars($row['titre']);
            $url = htmlspecialchars($row['url']);
            echo '<li>';
            echo "$titre - $url";
            echo '<form method="post" style="display:inline;margin-left:10px;">';
            echo '<input type="hidden" name="delete_site" value="1">';
            echo '<input type="hidden" name="site_id" value="' . (int)$row['id'] . '">';
            echo '<button type="submit" onclick="return confirm(\'Supprimer ce site ?\')">Supprimer</button>';
            echo '</form>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo "<p>Aucun site à afficher.</p>";
    }
    $mysqli->close();
    ?>
    <br>
    <a class="button button_return" href="index.php">Retour</a>
</body>
</html>
