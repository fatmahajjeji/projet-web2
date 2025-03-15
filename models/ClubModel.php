<?php
require_once '../config/Database.php';

class ClubModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    public function getConnection() {
        return $this->db;
    }
    

    public function addClub($nom, $date_creation, $fondateur, $responsable_id = null) {
        $query = "INSERT INTO clubs (nom, date_creation, fondateur, id_responsable) VALUES (:nom, :date_creation, :fondateur, :responsable_id)";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':date_creation', $date_creation);
        $stmt->bindParam(':fondateur', $fondateur);
        $stmt->bindParam(':responsable_id', $responsable_id);
    
        return $stmt->execute();
    }

    
    public function getAllClubs() {
        $query = "SELECT * FROM clubs";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getClubById($id) {
        $query = "SELECT * FROM clubs WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    

public function updateClub($id, $nom, $date_creation, $fondateur, $responsable_id = null) {
    $query = "UPDATE clubs SET nom = :nom, date_creation = :date_creation, fondateur = :fondateur, id_responsable = :responsable_id WHERE id = :id";
    $stmt = $this->db->prepare($query);

    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':date_creation', $date_creation);
    $stmt->bindParam(':fondateur', $fondateur);
    $stmt->bindParam(':responsable_id', $responsable_id);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}

    public function deleteClub($id) {
        $query = "DELETE FROM clubs WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    //  chercher un club a partir dun fondateur ou d'un nom
    public function searchClubs($searchTerm) {
        $query = "SELECT * FROM clubs WHERE nom LIKE :searchTerm OR fondateur LIKE :searchTerm";
        $stmt = $this->db->prepare($query);
        $searchTerm = "%$searchTerm%";
        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // statistics: nbr des membres pour chaque club
    public function getClubStatistics() {
        $query = "SELECT c.nom, COUNT(m.id_utilisateur) as members 
                  FROM clubs c 
                  LEFT JOIN membre m ON c.id = m.id_club 
                  GROUP BY c.id";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // attribuer un responsable pour un club
public function assignResponsable($club_id, $responsable_id) {
    $query = "UPDATE clubs SET id_responsable = :responsable_id WHERE id = :club_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':responsable_id', $responsable_id);
    $stmt->bindParam(':club_id', $club_id);
    return $stmt->execute();
}


public function getResponsables() {
    $query = "SELECT id, nom FROM utilisateur WHERE role = 'responsable_club'";
    $stmt = $this->db->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getResponsableName($responsable_id) {
    $query = "SELECT nom FROM utilisateur WHERE id = :responsable_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':responsable_id', $responsable_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


//  avoir les demandes de chaque club
public function getAdhesionsForClub($club_id) {
    $query = "SELECT a.* FROM adhesions a 
              JOIN clubs c ON a.club = c.nom 
              WHERE c.id = :club_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':club_id', $club_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Accepter adhesion 
public function acceptAdhesion($adhesion_id) {
    // afficher les adhesions
    $query = "SELECT * FROM adhesions WHERE id = :adhesion_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':adhesion_id', $adhesion_id);
    $stmt->execute();
    $adhesion = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$adhesion) {
        die("Erreur : Demande d'adhésion non trouvée.");
    }

    // verifie si utilisateur est deja membre
    $user_id = $adhesion['user_id'];
    $club_name = $adhesion['club'];
    $club_query = "SELECT id FROM clubs WHERE nom = :club_name";
    $club_stmt = $this->db->prepare($club_query);
    $club_stmt->bindParam(':club_name', $club_name);
    $club_stmt->execute();
    $club = $club_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$club) {
        die("Erreur : Club non trouvé.");
    }

    $club_id = $club['id'];

    
    $check_member_query = "SELECT * FROM membre WHERE id_utilisateur = :user_id AND id_club = :club_id";
    $check_member_stmt = $this->db->prepare($check_member_query);
    $check_member_stmt->bindParam(':user_id', $user_id);
    $check_member_stmt->bindParam(':club_id', $club_id);
    $check_member_stmt->execute();

    if ($check_member_stmt->rowCount() > 0) {
        die("Erreur : L'utilisateur est déjà membre du club.");
    }

    // ajouter un etudiant comme un membre
    $add_member_query = "INSERT INTO membre (id_utilisateur, id_club, date_confirmation) 
                         VALUES (:user_id, :club_id, NOW())";
    $add_member_stmt = $this->db->prepare($add_member_query);
    $add_member_stmt->bindParam(':user_id', $user_id);
    $add_member_stmt->bindParam(':club_id', $club_id);

    if ($add_member_stmt->execute()) {
       
        $delete_adhesion_query = "DELETE FROM adhesions WHERE id = :adhesion_id";
        $delete_adhesion_stmt = $this->db->prepare($delete_adhesion_query);
        $delete_adhesion_stmt->bindParam(':adhesion_id', $adhesion_id);
        $delete_adhesion_stmt->execute();

        return true;
    } else {
        die("Erreur : Impossible d'ajouter l'étudiant comme membre.");
    }
}


// refuser une demande
public function declineAdhesion($adhesion_id) {
    $query = "DELETE FROM adhesions  WHERE id = :adhesion_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':adhesion_id', $adhesion_id);
    return $stmt->execute();
}

// ajouter un membre
public function addMember($club_id, $user_id) {
    // verifie si le membre est deja membre en club
    $query = "SELECT * FROM membre WHERE id_utilisateur = :user_id AND id_club = :club_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':club_id', $club_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        
        return false; // membre est deja membre
    }

    // si nest pas membre il l'ajoute
    $query = "INSERT INTO membre (id_utilisateur, id_club, date_confirmation) 
              VALUES (:user_id, :club_id, NOW())";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':club_id', $club_id);
    return $stmt->execute();
}


// supprimer un membre d'un club
public function removeMember($club_id, $user_id) {
    $query = "DELETE FROM membre WHERE id_utilisateur = :user_id AND id_club = :club_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':club_id', $club_id);
    return $stmt->execute();
}

// lesmembres de chaque club
public function getMembersForClub($club_id) {
    $query = "SELECT u.id, u.nom, u.mail 
              FROM membre m 
              JOIN utilisateur u ON m.id_utilisateur = u.id 
              WHERE m.id_club = :club_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':club_id', $club_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getClubByResponsable($responsable_id) {
    $query = "SELECT * FROM clubs WHERE id_responsable = :responsable_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':responsable_id', $responsable_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
?>