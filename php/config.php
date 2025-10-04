<?php
// config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'portail');
define('DB_USER', 'root');
define('DB_PASS', 'Rivotril_362778');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}
?>