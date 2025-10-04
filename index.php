<?php require_once __DIR__ . '/php/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque Informatique</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<main class="main-container">
    <h1>Bibliothèque Informatique</h1>
    <div style="text-align:center;margin-bottom:16px;">
        <a class="button" href="./php/index.php">Modifier</a>
    </div>
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
                echo $image ? '<img src="'.$image.'" alt="'.$titre.'">' : '';
                echo '<h2>'.$titre.'</h2>';
                echo '<p>'.$description.'</p>';
                echo $url ? '<a href="'.$url.'" class="button" target="_blank">Visiter</a>' : '';
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
