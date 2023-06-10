<?php
    // Une Classe commentaire
    class Comment {
        //Les propriétés privé
        private $conn;
        private $table_name = "comment";

        //Les propriétés public
        public $id;
        public $coment; 
        public $id_user;
        public $date;

        //Une fonction constructeur
        public function __construct($db) {
            $this->conn = $db;
        }

        // Une méthode qui récupère tous les commentaires du livre d'or
        public function getAllComments() {
            $query = "SELECT c.coment, c.date, u.login FROM " . $this->table_name . " c LEFT JOIN user u ON c.id_user = u.id ORDER BY c.date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Utilisez fetchAll() pour récupérer tous les résultats sous forme de tableau associatif
        }

        // Une méthode qui ajoute un commentaire au livre d'or
        public function addComment() {

            if (empty($this->coment) || empty($this->id_user) || empty($this->date)) {
                return false; // L'un des champs est vide, retourne false
            }
            
            $query = "INSERT INTO " . $this->table_name . " (coment, id_user, date) VALUES (:coment, :id_user, :date)";
            $stmt = $this->conn->prepare($query);

            

            $stmt->bindParam(":coment", $this->coment);
            $stmt->bindParam(":id_user", $this->id_user);
            $stmt->bindParam(":date", $this->date);

            if ($stmt->execute()) {
                return true;
            } else {
                // Afficher les erreurs SQL
                echo "Erreur SQL : " . $stmt->errorInfo()[2];
                return false;
            }
        }
    }


?>
