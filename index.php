<?php
session_start();
$is_connected = isset($_SESSION['username']);
require_once __DIR__ . '/php/config.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bibliothèque Informatique</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <header class="site-header">
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

    <header class="site-header">
        <nav>
            <a href="php/login.php" class="button header-login">Connexion</a>
        </nav>
    </header>

    <main class="main-container">
        <h1>Bibliothèque Informatique</h1>
        <section class="card-container">
            <?php
            $query = "SELECT * FROM sites_web ORDER BY ordre_apparition ASC";
            $result = $mysqli->query($query);
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $titre = htmlspecialchars($row['titre']);
                    $description = htmlspecialchars($row['description']);
                    $image = htmlspecialchars($row['image']);
                    $url = htmlspecialchars($row['url']);
                    echo '<article class="card">';
                    echo $image ? '<img src="' . $image . '" alt="' . $titre . '">' : '';
                    echo '<h2>' . $titre . '</h2>';
                    echo '<p>' . $description . '</p>';
                    echo $url ? '<a href="' . $url . '" class="button" target="_blank">Visiter</a>' : '';
                    echo '</article>';
                }
                $result->free();
            } else {
                echo "<p>Impossible de récupérer les sites.</p>";
            }
            $mysqli->close();
            ?>
        </section>
    </main>
</body>

</html>