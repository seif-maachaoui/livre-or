<?php
    //Une classe utilisateur
    class User {
        // Les propriétés privées
        private $conn;
        private $table_name = "user";

        //Les propriétés public
        public $id;
        public $login;
        public $password;
        public $passwordConfirmation;

        // Fonction constructeur
        public function __construct($db) {
            $this->conn = $db;
        }

        // Une méthode qui vérifie si un utilisateur existe avec le même login
        public function userExists() {
            $query = "SELECT id FROM " . $this->table_name . " WHERE login = :login";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":login", $this->login);
            $stmt->execute();
            $num = $stmt->rowCount();

            return ($num > 0);
        }

        // Une méthode qui crée un nouvel utilisateur dans la base de données
        public function createUser() {
            $query = "INSERT INTO " . $this->table_name . " (login, password) VALUES (:login, :password)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":login", $this->login);
            $stmt->bindParam(":password", $this->password);

            if ($stmt->execute()) {
                echo "Utilisateur créé avec succès.";
                return true;
            } else {
                echo "Erreur lors de la création de l'utilisateur. Erreur : " . implode(" ", $stmt->errorInfo());
                return false;
            }
        }

        // Une méthode qui vérifie les identifiants de connexion de l'utilisateur
        public function login() {
            $query = "SELECT id, password FROM " . $this->table_name . " WHERE login = :login";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":login", $this->login);
            $stmt->execute();
            $num = $stmt->rowCount();

            if ($num > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $storedPassword = $row["password"];

                if (password_verify($this->password, $storedPassword)) {
                    $this->id = $row["id"];
                    return true;
                }
            }

            return false;
        }

        // Méthode qui met à jour le login de l'utilisateur dans la base de données
        public function updateLogin() {
            $query = "UPDATE " . $this->table_name . " SET login = :new_login WHERE id = :user_id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":new_login", $this->login);
            $stmt->bindParam(":user_id", $this->id);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        // Méthode qui met à jour le mot de passe de l'utilisateur dans la base de données
        public function updatePassword() {
            $query = "UPDATE " . $this->table_name . " SET password = :new_password WHERE id = :user_id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":new_password", $this->password);
            $stmt->bindParam(":user_id", $this->id);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        // Méthode qui récupère le login de l'utilisateur en fonction de son ID
        public function getUserById() {
            $query = "SELECT login FROM " . $this->table_name . " WHERE id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $this->id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->login = $row["login"];
        }

        // Méthode qui ajoute un commentaire pour l'utilisateur dans la base de données
        public function addComment($commentText, $commentDate) {
            $query = "INSERT INTO comment (coment, id_user, date) VALUES (:coment, :id_user, :date)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":coment", $commentText);
            $stmt->bindParam(":id_user", $this->id);
            $stmt->bindParam(":date", $commentDate);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
