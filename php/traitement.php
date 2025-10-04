<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/config.php';

// Validation des champs obligatoires
$fields = ['titre', 'image', 'description', 'url'];
foreach ($fields as $field) {
    if (empty($_POST[$field])) {
        header('Location: new-site.php?message=Champs manquant');
        exit;
    }
}

// Récupère et nettoie les données POST
$titre = trim($_POST['titre']);
$image = trim($_POST['image']);
$description = trim($_POST['description']);
$url = trim($_POST['url']);

// Récupérer la valeur max de ordre_apparition
$query_max = "SELECT MAX(ordre_apparition) AS max_ordre FROM sites_web";
$result_max = $mysqli->query($query_max);
$row_max = $result_max ? $result_max->fetch_assoc() : ['max_ordre' => 0];
$ordre_apparition = (int)$row_max['max_ordre'] + 1;

// Requête préparée pour insertion
$stmt = $mysqli->prepare("INSERT INTO sites_web (titre, image, description, url, ordre_apparition) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    header('Location: new-site.php?message=Erreur préparation requête');
    exit;
}
$stmt->bind_param("ssssi", $titre, $image, $description, $url, $ordre_apparition);

if ($stmt->execute()) {
    // Succès : redirection
    header('Location: new-site.php?message=Le site a été ajouté avec succès');
} else {
    // Échec insertion
    header('Location: new-site.php?message=Erreur lors de l\'ajout du site');
}

$stmt->close();
$mysqli->close();
exit;
?>
