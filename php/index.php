<?php
session_start();
$is_connected = isset($_SESSION['username']);
$username = $is_connected ? $_SESSION['username'] : '';
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/config.php'; // TOUJOURS avant toute utilisation de mysqli

// (Si besoin) Vérification du rôle admin :
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
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des sites | Administration</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="../assets/img/logo.ico" type="image/x-icon">
    <script src="../assets/js/drop-menu.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header class="site-header">
        <nav>
            <?php if ($is_connected): ?>
                <div class="user-menu">
                    <button class="user-button"><?php echo htmlspecialchars($username); ?> ▼</button>
                    <ul class="user-dropdown">
                        <li><a href="php/index.php">Modifier</a></li>
                        <li><a href="php/logout.php">Déconnexion</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="php/login.php" class="button header-login">Connexion</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="main-container">
        <h1>Liste des sites</h1>
        <?php
        if (isset($_POST['update_order'])) {
            $site_orders = $_POST['site_order'];
            foreach ($site_orders as $site_id => $site_order) {
                $stmt = $mysqli->prepare("UPDATE sites_web SET ordre_apparition = ? WHERE id = ?");
                $stmt->bind_param("ii", $site_order, $site_id);
                $stmt->execute();
                $stmt->close();
            }
            echo "<div class='error'>L'ordre d'apparition a été mis à jour avec succès.</div>";
        }
        $result = $mysqli->query("SELECT * FROM sites_web ORDER BY ordre_apparition ASC");
        echo '<form method="post"><ol>';
        while ($row = $result->fetch_assoc()) {
            $titre = htmlspecialchars($row['titre']);
            $url = htmlspecialchars($row['url']);
            $order = (int) $row['ordre_apparition'];
            echo '<li>' . $titre . ' - <a href="' . $url . '" target="_blank">' . $url . '</a>';
            echo '<input type="hidden" name="site_order[' . $row['id'] . ']" value="' . $order . '">';
            echo '</li>';
        }
        echo '</ol><button class="button" type="submit" name="update_order">Mettre à jour l\'ordre</button></form>';
        $result->free();
        $mysqli->close();
        ?>
        <nav style="margin-top:15px;">
            <a class="button" href="new-site.php">Ajouter un site</a>
            <a class="button" href="delete.php">Retirer un site</a>
        </nav>
    </main>
</body>

</html>