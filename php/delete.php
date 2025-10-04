<?php
// Vérifie que l'utilisateur est admin
$stmt = $mysqli->prepare("SELECT role FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();
if ($role !== 'admin') {
    header('Location: ../index.php');
    exit;
}
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Supprimer un site</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="../assets/img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <nav>
            <?php if (!$is_connected): ?>
                <a href="php/login.php" class="button header-login">Connexion</a>
            <?php else: ?>
                <?php
                // Chercher le rôle utilisateur si nécessaire
                $stmt = $mysqli->prepare("SELECT role FROM users WHERE username = ?");
                $stmt->bind_param("s", $_SESSION['username']);
                $stmt->execute();
                $stmt->bind_result($role);
                $stmt->fetch();
                $stmt->close();
                ?>
                <?php if ($role === 'admin'): ?>
                    <a href="php/index.php" class="button header-login">Modifier</a>
                <?php endif; ?>
                <a href="php/logout.php" class="button header-logout">Déconnexion</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="main-container">
        <h1>Suppression d’un site</h1>
        <?php
        if (isset($_POST['delete_site'], $_POST['site_id'])) {
            $site_id = (int) $_POST['site_id'];
            $stmt = $mysqli->prepare("DELETE FROM sites_web WHERE id = ?");
            $stmt->bind_param("i", $site_id);
            echo $stmt->execute() ?
                "<div class='error'>Le site a été supprimé avec succès.</div>"
                : "<div class='error'>Erreur lors de la suppression du site.</div>";
            $stmt->close();
        }
        $result = $mysqli->query("SELECT id, titre, url FROM sites_web ORDER BY ordre_apparition ASC");
        if ($result->num_rows > 0) {
            echo '<ul>';
            while ($row = $result->fetch_assoc()) {
                $titre = htmlspecialchars($row['titre']);
                $url = htmlspecialchars($row['url']);
                echo '<li>';
                echo "$titre - <a href=\"$url\" target=\"_blank\">$url</a>";
                echo '<form method="post" style="display:inline;margin-left:10px;">';
                echo '<input type="hidden" name="delete_site" value="1">';
                echo '<input type="hidden" name="site_id" value="' . (int) $row['id'] . '">';
                echo '<button type="submit" class="button" onclick="return confirm(\'Supprimer ce site ?\')">Supprimer</button>';
                echo '</form>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo "<p>Aucun site à afficher.</p>";
        }
        $mysqli->close();
        ?>
        <a class="button button_return" href="index.php">Retour</a>
    </main>
</body>

</html>