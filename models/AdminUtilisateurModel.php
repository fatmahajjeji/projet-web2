<?php
require_once '../config/Database.php';

class AdminUtilisateurModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function createUser($nom, $email, $mot_de_passe, $role) {
        $hashed_password = password_hash($mot_de_passe, PASSWORD_BCRYPT);
        $query = "INSERT INTO utilisateur (nom, mail, mot_de_passe, role) VALUES (:nom, :mail, :mot_de_passe, :role)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':mail', $email);
        $stmt->bindParam(':mot_de_passe', $hashed_password);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }


    public function getAllUsers() {
        $query = "SELECT id, nom, mail, role FROM utilisateur";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getUserById($id) {
        $query = "SELECT id, nom, mail, role FROM utilisateur WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   
public function updateUser($id, $nom, $email, $mot_de_passe, $role) {
    
    if (!empty($mot_de_passe)) {
        $hashed_password = password_hash($mot_de_passe, PASSWORD_BCRYPT);
        $query = "UPDATE utilisateur SET nom = :nom, mail = :mail, mot_de_passe = :mot_de_passe, role = :role WHERE id = :id";
    } else {
        $query = "UPDATE utilisateur SET nom = :nom, mail = :mail, role = :role WHERE id = :id";
    }

    $stmt = $this->db->prepare($query);

    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':mail', $email);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':id', $id);

    if (!empty($mot_de_passe)) {
        $stmt->bindParam(':mot_de_passe', $hashed_password);
    }

    return $stmt->execute();
}


    public function deleteUser($id) {
        $query = "DELETE FROM utilisateur WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }


    public function searchUsers($searchTerm) {
        $query = "SELECT id, nom, mail, role FROM utilisateur 
                  WHERE nom LIKE :searchTerm 
                  OR mail LIKE :searchTerm 
                  OR role LIKE :searchTerm";
        $stmt = $this->db->prepare($query);
        $searchTerm = "%$searchTerm%";
        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getUserStatistics() {
        $query = "SELECT role, COUNT(*) as count FROM utilisateur GROUP BY role";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total FROM utilisateur";
        $stmt = $this->db->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
?>