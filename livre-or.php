<?php
    require_once 'config.php';
    require_once 'user.php';
    require_once 'comment.php';

    // Connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();

    // Vérification de la connexion de l'utilisateur
    session_start();
    $isLoggedIn = isset($_SESSION["user_id"]);

    // Récupération des commentaires
    $comment = new Comment($db);
    $comments = $comment->getAllComments();

    // Affichage des commentaires
    function displayComments($comments) {
        echo '<div class="comments-container">'; // Balise div pour contenir les commentaires

        foreach ($comments as $comment) {
            echo '<div class="comment">';
            echo "<p>Posté le " . $comment['date'] . " par " . $comment['login'] . "</p>";
            echo "<p>" . $comment['coment'] . "</p>";
            echo '</div>';
        }
    
        echo '</div>'; // Fermeture de la balise div

    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Livre d'or</title>
    </head>

    <body>
        <main>
            <header>
                <img src="" alt="Un logo personnalisé">

                <nav>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="inscription.php">Inscription</a></li>
                        <li><a href="connexion.php">Connexion</a></li>
                        <li><a href="livre-or.php">Livre d'or</a></li>

                        
                    </ul>
                </nav>
            </header>

            <section>
                <article class="goldenbook">
                    <h1>Livre d'or</h1>
                    <?php
                        if (isset($_SESSION["user_id"])) {
                            echo '<a href="commentaire.php" class="add_comment">Ajouter un commentaire</a>';
                        }   
                    ?>
                    <?php displayComments($comments); ?>
                </article>

            </section>

            <footer>
                <h6>Copyright © 2023-2024, Seifeddine Maachaoui. All Rights Reserved.</h6>
            </footer>
        </main>
    
    </body>


</html>