<?php
// Connexion à la base de données
$host = "localhost";
$user = "root";
$pass = "Rivotril_362778";
$dbname = "portail";

// Récupérer les données soumises depuis le formulaire
$titre = $_POST['titre'];
$image = $_POST['image'];
$description = $_POST['description'];
$url = $_POST['url'];

// Connexion à la base de données avec mysqli
$mysqli = new mysqli($host, $user, $pass, $dbname);

// Vérifier la connexion
if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

// Récupérer la valeur de "ordre_apparition" la plus élevée dans la base de données
$query_max_ordre = "SELECT MAX(ordre_apparition) AS max_ordre FROM sites_web";
$result_max_ordre = $mysqli->query($query_max_ordre);
$row_max_ordre = $result_max_ordre->fetch_assoc();
$max_ordre = $row_max_ordre['max_ordre'];

// Incrémenter la valeur de "ordre_apparition" pour le nouveau site
$nouvel_ordre = $max_ordre + 1;

// Préparer et exécuter la requête d'insertion avec l'ordre d'apparition
$query = "INSERT INTO sites_web (titre, image, description, url, ordre_apparition) VALUES (?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssssi", $titre, $image, $description, $url, $nouvel_ordre);
$stmt->execute();

// Vérifier si l'insertion a réussi
if ($stmt->affected_rows === 1) {
    echo "Le site a été ajouté avec succès.";
    echo "<a href=\"../\"><button>Retourner à la page d'accueil</button></a>";
} else {
    echo "Une erreur est survenue lors de l'ajout du site.";
}

// Fermer la connexion
$stmt->close();
$mysqli->close();
?>