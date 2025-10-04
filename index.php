<?php
session_start();
$is_connected = isset($_SESSION['username']);
$username = $is_connected ? $_SESSION['username'] : '';
require_once __DIR__ . '/php/config.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bibliothèque Informatique</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/logo.ico" type="image/x-icon">
    <script src="./assets/js/drop-menu.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
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