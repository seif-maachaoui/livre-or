<?php
    require_once 'config.php';
    require_once 'user.php';
    
    // Connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Création d'un nouvel utilisateur
        $user = new User($db);
        
        // La récupération des données du formulaire
        $user->login = htmlspecialchars($_POST["login"]);
        $password = htmlspecialchars($_POST["password"]);
        $user->passwordConfirmation = htmlspecialchars($_POST["passwordConfirmation"]);
    
        // Je vérifie les champs du formulaire
        if (empty($user->login) || empty($password) || empty($user->passwordConfirmation)) {
            echo "Veuillez remplir tous les champs du formulaire.";
        } else {
            // Je vérifie si le login existe déjà
            if ($user->userExists()) {
                echo "Ce login est déjà utilisé. Veuillez en choisir un autre.";
            } else {
                // Je vérifie si les mots de passe correspondent
                if ($password !== $user->passwordConfirmation) {
                    echo "Les mots de passe ne correspondent pas.";
                } else {
                    // Je vérifie la complexité du mot de passe
                    if (!isStrongPassword($password)) {
                        echo "Le mot de passe doit contenir au moins 8 caractères, inclure au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.";
                    } else {
                        // Je procède au hachage du mot de passe
                        $user->password = password_hash($password, PASSWORD_DEFAULT);
    
                        // J'appelle la méthode de la classe User pour la création de l'utilisateur
                        if ($user->createUser()) {
                            // Redirection vers la page de connexion
                            header('Location: connexion.php');
                            exit();
                        } else {
                            echo "Une erreur est survenue lors de l'inscription.";
                        }
                    }
                }
            }
        }
    }
    
    // Je vérifie de la complexité du mot de passe
    function isStrongPassword($password) {
        if (strlen($password) < 8) {
            return false;
        }
    
        if (!preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[^A-Za-z0-9]/", $password)) {
            return false;
        }
    
        return true;
    }
    
?>
