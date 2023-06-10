<?php
require_once 'config.php';
require_once 'user.php';
require_once 'comment.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Vérification de la connexion de l'utilisateur
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["user_id"])) {
        $user = new User($db);
        $user->id = $_SESSION["user_id"];

        $coment = $_POST["coment"];
        $commentDate = date("Y-m-d H:i:s");

        if (!empty($coment)) {
            if ($user->addComment($coment, $commentDate)) {
                header("Location: livre-or.php");
                exit();
            } else {
                echo "Une erreur est survenue lors de l'ajout du commentaire.";
            }
        } else {
            echo "Veuillez saisir un commentaire.";
        }
    } else {
        echo "Vous devez être connecté pour ajouter un commentaire.";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ajouter un commentaire</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <main>
            <header>
                <img src="" alt="Un logo personnalisé">

                <nav>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="inscription.php">Inscription</a></li>
                        <li><a href="profil.php">Profil</a></li>
                        <li><a href="deconnexion.php?logout=logout" class="btn-logout">Déconnexion</a></li>
                        <li><a href="livre-or.php">Livre d'or</a></li>
                    </ul>
                </nav>
            </header>

            <section>
                <article>
                    <h1>Ajouter un commentaire</h1>
                    <form id="comment_form" class="add_form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <label for="coment">Votre Commentaire :</label>
                        <textarea name="coment" id="coment" placeholder="Saisissez votre commentaire"></textarea>
                        <button type="submit">Ajouter</button>
                    </form>
                </article>
            </section>

            <footer>
                <h6>&copy; 2023-2024, Seifeddine Maachaoui. Tous droits réservés.</h6>
            </footer>
        </main>
    </body>
</html>
