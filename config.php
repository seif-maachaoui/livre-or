<?php

    // Je créer une classe Database pour la connexion à la base de donnée.
    class Database {
        private $host = "localhost";
        private $dbname = "livreor";
        private $username = "root";
        private $password = "Dragonball1996*";
        public $conn;

        //Une méthode qui permet de récupérer la connexion à la base de donnée.
        public function getConnection() {
            $this->conn = null;

            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            } catch(PDOException $exception) {
                echo "Erreur de connexion à la base de données : " . $exception->getMessage();
            }

            return $this->conn;
        }
    }
?>
