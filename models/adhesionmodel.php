<?php
class AdhesionModel {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function enregistrerAdhesion($nom_prenom, $email, $interet, $club, $cv_path) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO adhesions (nom_prenom, email, motivation, club, cv) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssb", $nom_prenom, $email, $interet, $club, $cv_path);
        $stmt->bindParam(1, $nom_prenom, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        $stmt->bindParam(3, $interet, PDO::PARAM_STR);
        $stmt->bindParam(4, $club, PDO::PARAM_STR);
        $stmt->bindParam(5, $cv_content, PDO::PARAM_LOB);
        try {
            $result = $stmt->execute();
            return $result;
        } finally {
            $stmt->close(); 
            $conn = null;
        }

        
        
    }
}
?>