<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="shortcut icon" href="../assets/img/logo_rounded.png" type="image/x-icon">
    <title>Actualités Tech & Programmation</title>
</head>

<body>
    <h1>Actualités Tech & Programmation</h1>
    <ul>
        <?php
        // Fonction pour récupérer les actualités depuis l'API Mediastack
        function fetchNews()
        {
            $api_key = '8f634bd15f5bdf5f86ee4c8fbdc18277';
            $languages = 'fr';
            // $keywords = '';
            $categories = 'technology';
            $sort = 'popularity';
            $url = "http://api.mediastack.com/v1/news?access_key={$api_key}&languages={$languages}&categories={$categories}&sort={$sort}";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            return json_decode($response, true);
        }

        try {
            $newsData = fetchNews();

            if (isset($newsData['data']) && count($newsData['data']) > 0) {
                // Afficher les 5 dernières actualités
                $articles = array_slice($newsData['data'], 0, 5);
                foreach ($articles as $article) {
                    echo '<li>' . $article['title'] . '</li>';
                }
            } else {
                echo 'Aucune actualité trouvée.';
            }
        } catch (Exception $e) {
            echo 'Erreur lors de la récupération des actualités : ' . $e->getMessage();
        }
        ?>
    </ul>
</body>

</html>