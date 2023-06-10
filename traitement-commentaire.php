<?php
    session_start();
    require_once 'config.php';
    require_once 'comments.php';

    // Connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();

    // Traitement du formulaire d'ajout de commentaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();

        //On vérifie si une session utilisateur est en cours
        if (isset($_SESSION["user_id"])) {
            $comment = new Comment($db);
            $comment->coment = $_POST["coment"];
            $comment->id_user = $_SESSION["user_id"];
            $comment->date = date("Y-m-d H:i:s");

            //Si un commentaire est vide alors...
            if (empty($comment->coment)) {
                echo "Veuillez remplir le champ de commentaire.";
            } else {
                if ($comment->addComment()) {
                    echo "Commentaire ajouté avec succès !";
                } else {
                    echo "Une erreur est survenue lors de l'ajout du commentaire.";
                }
            }
        } else {
            // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
            header("Location: connexion.php");
            exit();
        }
    }
?>
