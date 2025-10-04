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
    <link rel="shortcut icon" href="../assets/img/logo_rounded.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
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

    // Vérifier si un formulaire de suppression a été soumis
    if (isset($_POST['delete_site'])) {
        $site_id = $_POST['site_id'];
        $query = "DELETE FROM sites_web WHERE id = $site_id";
        if (mysqli_query($conn, $query)) {
            echo "<p>Le site a été supprimé avec succès.</p>";
        } else {
            echo "Une erreur est survenue lors de la suppression du site : " . mysqli_error($conn);
        }
    }

    // Récupérer tous les sites de la base de données triés par ordre d'apparition
    $query = "SELECT * FROM sites_web ORDER BY ordre_apparition ASC";
    $result = mysqli_query($conn, $query); // Exécuter la requête de sélection
    
    // Afficher les sites dans une liste ordonnée
    echo '<ol id="sortable">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<li class="ui-state-default">';
        echo $row['titre'] . ' - ' . $row['url'];
        echo '<input type="hidden" name="site_order[' . $row['id'] . ']" value="' . $row['ordre_apparition'] . '">';
        echo '<form method="post" style="display: inline;">'; // Ajout d'un formulaire pour la suppression
        echo '<input type="hidden" name="delete_site" value="1">';
        echo '<input type="hidden" name="site_id" value="' . $row['id'] . '">';
        echo '<button type="submit" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce site ?\')">Supprimer</button>';
        echo '</form>';
        echo '</li>';
    }
    echo '</ol>';

    // Fermer la connexion à la base de données
    mysqli_close($conn);
    ?>

    <!-- Formulaire de mise à jour de l'ordre d'apparition -->
    <form method="post">
        <!-- Ce formulaire est utilisé pour mettre à jour l'ordre d'apparition, assurez-vous qu'il contient les champs nécessaires -->
        <!-- ... -->
    </form>

    <!-- Bouton pour ajouter un nouveau site -->
    <a href="new-site.php"><button>Ajouter un site</button></a>

    <br><br>
    <a href="../">Retourner à la page d'accueil</a>

    <script>
        function deleteSite(siteId) {
            // Le code pour supprimer le site est désormais géré par le formulaire de suppression directement.
            // On utilise onclick="return confirm(...)" pour demander une confirmation avant la suppression.
            // Le formulaire soumettra la demande de suppression au serveur PHP.
            // ...
        }
    </script>

</body>

</html>