<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Utilisation du fichier de config global pour la connexion
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des sites | Administration</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/logo_rounded.png" type="image/x-icon">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
    <h1>Liste des sites</h1>
    <?php
    // Mise à jour de l'ordre d'apparition
    if (isset($_POST['update_order'])) {
        $site_orders = $_POST['site_order'];
        foreach ($site_orders as $site_id => $site_order) {
            $stmt = $mysqli->prepare("UPDATE sites_web SET ordre_apparition = ? WHERE id = ?");
            $stmt->bind_param("ii", $site_order, $site_id);
            $stmt->execute();
            $stmt->close();
        }
        echo "<p>L'ordre d'apparition a été mis à jour avec succès.</p>";
    }

    // Récupérer tous les sites
    $query = "SELECT * FROM sites_web ORDER BY ordre_apparition ASC";
    $result = $mysqli->query($query);

    // Afficher le formulaire pour réorganiser les sites
    echo '<form method="post">';
    echo '<ol id="sortable">';
    while ($row = $result->fetch_assoc()) {
        $titre = htmlspecialchars($row['titre']);
        $url = htmlspecialchars($row['url']);
        $order = (int)$row['ordre_apparition'];
        echo '<li class="ui-state-default" data-order="' . $order . '">';
        echo $titre . ' - ' . $url;
        echo '<input type="hidden" name="site_order[' . $row['id'] . ']" value="' . $order . '">';
        echo '</li>';
    }
    echo '</ol>';
    echo '<button class="button" type="submit" name="update_order">Mettre à jour l\'ordre</button>';
    echo '</form>';

    $result->free();
    $mysqli->close();
    ?>
    <!-- Boutons d'action -->
    <a class="button" href="new-site.php">Ajouter un site</a>
    <a class="button" href="delete.php">Retirer un site</a>
    <br><br>
    <a class="button button_return" href="../">Retourner à la page d'accueil</a>
    <!-- jQuery UI pour le drag and drop -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        // Drag & drop pour réorganisation
        $(function () {
            $("#sortable").sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        $(this).find('input').val(index);
                    });
                }
            });
            $("#sortable").disableSelection();
        });
    </script>
</body>
</html>
