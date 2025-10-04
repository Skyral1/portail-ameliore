<?php
// Inclure la configuration (voir suggestion précédente pour config.php)
require_once __DIR__ . '/php/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque Informatique</title>
    <link rel="shortcut icon" href="./assets/img/logo_rounded.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
</head>
<body>
    <h1>Bibliothèque Informatique</h1>

    <!-- Bouton pour accéder à la gestion -->
    <div class="add-button-container">
        <a class="button" href="./php/index.php">Modifier</a>
    </div>

    <div class="card-container">
        <?php
        // Récupérer les sites de la base de données triés
        $query = "SELECT * FROM sites_web ORDER BY ordre_apparition ASC";
        $result = $mysqli->query($query);

        if ($result) {
            // Afficher chaque site en card
            while ($row = $result->fetch_assoc()) {
                // Protection XSS sur l'affichage
                $titre = htmlspecialchars($row['titre'] ?? '');
                $description = htmlspecialchars($row['description'] ?? '');
                $image = htmlspecialchars($row['image'] ?? '');
                $url = htmlspecialchars($row['url'] ?? '#');

                echo '<a href="' . $url . '" target="_blank">';
                echo '  <div class="card">';
                echo '      <img src="' . $image . '" alt="' . $titre . '">';
                echo '      <h2>' . $titre . '</h2>';
                echo '      <p>' . $description . '</p>';
                echo '  </div>';
                echo '</a>';
            }
            $result->free();
        } else {
            echo "<p>Impossible de récupérer les sites. Vérifie la connexion à la base de données.</p>";
        }

        $mysqli->close();
        ?>
    </div>
</body>
</html>
