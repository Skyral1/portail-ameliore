<!DOCTYPE html>
<html>

<head>
    <title>Bibliothèque Informatique</title>
    <link rel="shortcut icon" href="./assets/img/logo_rounded.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
</head>

<body>
    <h1>Bibliothèque Informatique</h1>

    <!-- Div parente pour aligner le bouton -->
    <div class="add-button-container">
        <!-- Bouton pour accéder à la page d'ajout de site -->
        <a class="button" href="./php/index.php">Modifier</a>
    </div>

    <div class="card-container">

        <?php
        // Connexion à la base de données
        $host = "localhost";
        $user = "root";
        $pass = "Rivotril_362778";
        $dbname = "portail";

        // Connexion à la base de données avec mysqli
        $mysqli = new mysqli($host, $user, $pass, $dbname);

        // Vérifier la connexion
        if ($mysqli->connect_error) {
            die("Erreur de connexion : " . $mysqli->connect_error);
        }
        ?>

        <?php
        // Récupérer tous les sites de la base de données triés par ordre d'apparition
        $query = "SELECT * FROM sites_web ORDER BY ordre_apparition ASC";
        $result = $mysqli->query($query);

        // Afficher les cards pour chaque site
        while ($row = $result->fetch_assoc()) {
            echo '<a href="' . $row['url'] . '" target="_blank">';
            echo '<div class="card">';
            echo '<img src="' . $row['image'] . '" alt="' . $row['titre'] . '">';
            echo '<h2>' . $row['titre'] . '</h2>';
            echo '<p>' . $row['description'] . '</p>';
            echo '</div>';
            echo '</a>';
        }
        ?>

        <?php
        // Fermer la connexion à la base de données
        $mysqli->close();
        ?>
    </div>

</body>

</html>