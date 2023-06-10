<?php
    require_once 'config.php';
    require_once 'user.php';

    // Connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();

    // Je vérifie si l'utilisateur est connecté
    session_start();
    if (!isset($_SESSION["user_id"])) {
        // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
        header("Location: connexion.php");
        exit();
    }

    // Je récupère les informations de l'utilisateur
    $user = new User($db);
    $user->id = $_SESSION["user_id"];
    $user->getUserById();

    // Les variables pour les messages de confirmation
    $loginMessage = "";
    $passwordMessage = "";

    // Le traitement du formulaire de modification du profil
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newLogin = $_POST["new_login"];
        $newPassword = $_POST["new_password"];

        if (empty($newLogin) && empty($newPassword)) {
            echo "Veuillez remplir au moins un champ pour mettre à jour votre profil.";
        } else {
            // La mise à jour du login si un nouveau login est fourni
            if (!empty($newLogin)) {
                $user->login = $newLogin;
                if ($user->updateLogin()) {
                    $_SESSION["login_message"] = "Login mis à jour avec succès !";
                } else {
                    $_SESSION["login_message"] = "Une erreur est survenue lors de la mise à jour du login.";
                }
            }

            // La mise à jour du mot de passe si un nouveau mot de passe est fourni
            if (!empty($newPassword)) {
                $user->password = password_hash($newPassword, PASSWORD_DEFAULT);
                if ($user->updatePassword()) {
                    $_SESSION["password_message"] = "Mot de passe mis à jour avec succès !";
                } else {
                    $_SESSION["password_message"] = "Une erreur est survenue lors de la mise à jour du mot de passe.";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Livre d'or - page de profil</title>
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
                        <li><a href="connexion.php">Connexion</a></li>
                        <li><a href="livre-or.php">Livre d'or</a></li>
                        <li><a href="deconnexion.php?logout=logout" class="btn-logout">Déconnexion</a></li>
                    </ul>
                </nav>
            </header>

            <section>
                <article>
                    <h1>Bienvenue, <?php echo $user->login; ?> !</h1>
                    <h2>Modifier son profil</h2>

                    <!-- Champ pour ajouter un nouveau login -->
                    <form id="update_form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <label for="new_login">Nouveau login :</label>
                        <input type="text" name="new_login" id="new_login" placeholder="Nouveau login"
                            value="<?php echo $user->login; ?>">

                        <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($newLogin)) {
                                echo "<p>" . $_SESSION["login_message"] . "</p>";
                                unset($_SESSION["login_message"]); // Je supprime la variable de session après l'affichage
                            }
                        ?>

                        <!-- Champ pour ajouter un nouveau mot de passe -->
                        <label for="new_password">Nouveau mot de passe :</label>
                        <input type="password" name="new_password" id="new_password" placeholder="Nouveau mot de passe">

                        <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($newPassword)) {
                                echo "<p>" . $_SESSION["password_message"] . "</p>";
                                unset($_SESSION["password_message"]); // Je supprime la variable de session après l'affichage
                            }
                        ?>

                        <button type="submit">Modifier</button>
                    </form>
                </article>
            </section>

            <footer>
                <h6>&copy; 2023-2024, Seifeddine Maachaoui. Tous droits réservés.</h6>
            </footer>

        </main>
    </body>
</html>
