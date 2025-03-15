<?php
require_once '../config/Database.php';

class UtilisateurModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function createUser($nom_prenom, $email, $mot_de_passe, $role) {
        $query = "INSERT INTO utilisateur (nom, mail, mot_de_passe, role) VALUES (:nom, :mail, :mot_de_passe, :role)";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':nom', $nom_prenom);
        $stmt->bindParam(':mail', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);
        $stmt->bindParam(':role', $role);
    
        try {
            $result = $stmt->execute();
            if ($result) {
                echo "User added to the database!<br>"; // Debugging
                return true;
            } else {
                echo "Failed to add user to the database.<br>"; // Debugging
                return false;
            }
        } catch (PDOException $e) {
            echo "Erreur SQL: " . $e->getMessage();
            return false;
        }
    }
    public function verifyUser($email, $mot_de_passe) {
        $query = "SELECT id, nom, mot_de_passe, role FROM utilisateur WHERE mail = :mail";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mail', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
                return $user;
            }
        }
        return false;
    }
    
}
?>