<?php
    require_once 'config.php';
    require_once 'user.php';

    // Connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Création d'un nouvel utilisateur
        $user = new User($db);

        // Je récupère des données du formulaire
        $user->login = $_POST["login"];
        $user->password = $_POST["password"];

        // Je vérifie des champs du formulaire
        if (empty($user->login) || empty($user->password)) {
            echo "Veuillez remplir tous les champs du formulaire.";
        } else {
            // Je vérifie les identifiants de connexion
            if ($user->login()) {
                // Démarrage de la session
                session_start();

                // Je stock l'ID de l'utilisateur dans la session
                $_SESSION["user_id"] = $user->id;

                // Je le Redirige vers la page de profil
                header('Location: profil.php');
                exit();
            } else {
                echo "Identifiants de connexion invalides.";
            }
        }
    }
?>
