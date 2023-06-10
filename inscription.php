<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Livre d'or - page d'inscription</title>
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
                <article>
                    <!-- Le formulaire d'inscription -->
                    <form action="traitement-inscription.php" method="post">
                        <h1>S'inscrire</h1>

                        <label for="login">Login :</label>
                        <input type="text" name="login" id="login" placeholder="Login*" required>

                        <label for="password">Password :</label>
                        <input type="password" name="password" id="password" placeholder="Password*" required>

                        <label for="passwordConfirmation">Veuillez confirmer votre mot de passe :</label>
                        <input type="password" name="passwordConfirmation" id="passwordConfirmation" placeholder="Confirm Password*" required>

                        <input class="submit-btn" type="submit" name="submit" value='Envoyer'>
                    </form>

                </article>
            </section>

            <footer>
                <h6>Copyright © 2023-2024, Seifeddine Maachaoui. All Rights Reserved.</h6>
            </footer>
        </main>
    
    </body>


</html>










