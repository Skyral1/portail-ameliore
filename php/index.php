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
    <title>Liste des sites</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/logo_rounded.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
    <h1>Liste des sites</h1>

    <?php
    // Établir la connexion à la base de données
    $conn = mysqli_connect("localhost", "root", "Rivotril_362778", "portail");

    // Vérifier la connexion
    if (!$conn) {
        die("Erreur de connexion à la base de données: " . mysqli_connect_error());
    }

    // Vérifier si un formulaire de mise à jour a été soumis
    if (isset($_POST['update_order'])) {
        $site_orders = $_POST['site_order'];

        // Mettre à jour l'ordre d'apparition pour chaque site
        foreach ($site_orders as $site_id => $site_order) {
            $site_id = (int) $site_id;
            $site_order = (int) $site_order;
            $query = "UPDATE sites_web SET ordre_apparition = $site_order WHERE id = $site_id";
            mysqli_query($conn, $query);
        }
        echo "<p>L'ordre d'apparition a été mis à jour avec succès.</p>";
    }

    // Récupérer tous les sites de la base de données triés par ordre d'apparition
    $query = "SELECT * FROM sites_web ORDER BY ordre_apparition ASC";
    $result = mysqli_query($conn, $query);

    // Afficher le formulaire de mise à jour de l'ordre d'apparition
    echo '<form method="post">';
    echo '<ol id="sortable">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<li class="ui-state-default" data-order="' . $row['ordre_apparition'] . '">' . $row['titre'] . ' - ' . $row['url'] . '<input type="hidden" name="site_order[' . $row['id'] . ']" value="' . $row['ordre_apparition'] . '"></li>';
    }
    echo '</ol>';
    echo '<button class="button" type="submit" name="update_order">Mettre à jour l\'ordre</button>';
    echo '</form>';

    // Fermer la connexion à la base de données
    mysqli_close($conn);
    ?>

    <!-- Bouton pour ajouter un nouveau site -->
    <a class="button" href="new-site.php">Ajouter un site</a>
    <!-- Bouton pour retirer un site -->
    <a class="button" href="delete.php">Retirer un site</a>

    <br><br>
    <a class="button button_return" href="../">Retourner à la page d'accueil</a>

    <!-- Chargement de la bibliothèque jQuery et jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        // Fonction pour rendre les éléments de la liste "drag and drop"
        $(function () {
            $("#sortable").sortable({
                update: function (event, ui) {
                    // Mettre à jour les attributs data-order des éléments avec leurs nouvelles positions
                    $(this).children().each(function (index) {
                        $(this).attr('data-order', index);
                        $(this).find('input').val(index); // Mettre à jour la valeur du champ caché
                    });
                }
            });
            $("#sortable").disableSelection();
        });
    </script>

</body>

</html>