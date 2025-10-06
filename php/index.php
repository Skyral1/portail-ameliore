<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/config.php';

// Vérification du rôle admin
$stmt = $mysqli->prepare("SELECT role FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();
if ($role !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// Mise à jour ordre si drag and drop soumis
$notif = '';
if (isset($_POST['site_order'])) {
    foreach ($_POST['site_order'] as $site_id => $nouvel_ordre) {
        $stmt = $mysqli->prepare("UPDATE sites_web SET ordre_apparition = ? WHERE id = ?");
        $stmt->bind_param("ii", $nouvel_ordre, $site_id);
        $stmt->execute();
        $stmt->close();
    }
    $notif = "L'ordre d'apparition a été mis à jour avec succès.";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des sites | Administration</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        #sortable li {
            cursor: grab;
            background: #f8fafc;
            padding: 12px;
            margin-bottom: 7px;
            border-radius: 6px;
            border: 1px solid #d1dee6;
            transition: box-shadow 0.2s;
        }

        #sortable li:hover {
            box-shadow: 0 2px 12px 0 rgba(31, 38, 135, 0.07);
        }
    </style>
</head>

<body>
    <main class="main-container">
        <h1>Liste des sites</h1>
        <?php if ($notif): ?>
            <div class="error" style="margin:0 auto 17px auto;max-width:360px;"><?php echo $notif; ?></div>
        <?php endif; ?>

        <?php
        // Affichage de la liste des sites avec drag-and-drop
        $result = $mysqli->query("SELECT * FROM sites_web ORDER BY ordre_apparition ASC");
        echo '<form method="post"><ol id="sortable">';
        while ($row = $result->fetch_assoc()) {
            $titre = htmlspecialchars($row['titre']);
            $url = htmlspecialchars($row['url']);
            $id = (int) $row['id'];
            echo '<li class="ui-state-default">';
            echo $titre . ' - <a href="' . $url . '" target="_blank">' . $url . '</a>';
            echo '<input type="hidden" name="site_order[' . $id . ']" value="">';
            echo '</li>';
        }
        echo '</ol><button class="button" type="submit" name="update_order">Mettre à jour l\'ordre</button></form>';
        $result->free();
        $mysqli->close();
        ?>
        <nav style="margin-top:15px;">
            <a class="button" href="new-site.php">Ajouter un site</a>
            <a class="button" href="delete.php">Retirer un site</a>
            <a class="button button_return" href="../index.php">Retourner à l'accueil</a>
        </nav>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function () {
            $("#sortable").sortable({
                update: function (event, ui) {
                    $("#sortable li").each(function (index) {
                        // Les input hidden sont dans le même ordre que les <li>
                        $(this).find('input[type=hidden]').val(index + 1);
                    });
                }
            });
            $("#sortable").disableSelection();
            // Au chargement, assigne l'ordre initial (important si pas bougé)
            $("#sortable li").each(function (index) {
                $(this).find('input[type=hidden]').val(index + 1);
            });
            // Dropdown utilisateur
            const dropdown = document.querySelector('.user-dropdown');
            if (dropdown) {
                const button = dropdown.querySelector('.user-btn');
                button.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('show');
                });
                document.addEventListener('click', function () {
                    dropdown.classList.remove('show');
                });
            }
        });
    </script>
</body>

</html>