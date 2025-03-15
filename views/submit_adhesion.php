<?php
session_start();



if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'etudiant') {
    header("Location: ../views/login.php"); 
    exit();
}

require_once '../config/Database.php';
require_once '../models/ClubModel.php';

$clubModel = new ClubModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nom_prenom = htmlspecialchars($_POST['nom_prenom']);
    $email = htmlspecialchars($_POST['email']);
    $motivation = htmlspecialchars($_POST['motivation']);
    $club = htmlspecialchars($_POST['club']);
    $cv = $_FILES['cv'];

    
    echo "<pre>";
    print_r($cv);
    echo "</pre>";

    $cv_name = $cv['name'];
    $cv_tmp_name = $cv['tmp_name'];
    $cv_size = $cv['size'];
    $cv_error = $cv['error'];

    $upload_dir = '../uploads/';
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            die("Erreur : Impossible de créer le dossier 'uploads'.");
        }
    }

    // Validate file upload
    if ($cv_error === 0) {
        // Check file type and size
        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $max_size = 5 * 1024 * 1024; // 5 MB

        if (!in_array($cv['type'], $allowed_types)) {
            die("Erreur : Type de fichier non autorisé. Seuls les fichiers PDF, DOC, et DOCX sont autorisés.");
        }

        if ($cv_size > $max_size) {
            die("Erreur : La taille du fichier ne doit pas dépasser 5 Mo.");
        }

        // Move the uploaded file to the uploads directory
        $cv_destination = $upload_dir . basename($cv_name);
        if (move_uploaded_file($cv_tmp_name, $cv_destination)) {
            // File uploaded successfully
        } else {
            die("Erreur : Impossible de déplacer le fichier téléchargé.");
        }
    } else {
        die("Erreur : Problème lors du téléchargement du fichier. Code d'erreur : $cv_error");
    }

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        die("Erreur : Aucun utilisateur connecté.");
    }

    // Debugging: Check if the user_id is being retrieved properly
    echo "User ID from session: " . $user_id;  

    // Save the adhesion request to the database
    try {
        $query = "INSERT INTO adhesions (nom_prenom, email, motivation, club, cv, date_demande, user_id) 
                  VALUES (:nom_prenom, :email, :motivation, :club, :cv, NOW(), :user_id)";
        $conn = $clubModel->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nom_prenom', $nom_prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':motivation', $motivation);
        $stmt->bindParam(':club', $club);
        $stmt->bindParam(':cv', $cv_destination);
        $stmt->bindParam(':user_id', $user_id);  // Bind the user_id parameter

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Votre demande a été envoyée avec succès et attend une réponse de la part du responsable.';
            header("Location: acceuilcon.php"); // Redirect to the home page
            exit();
        } else {
            die("Erreur : Impossible d'enregistrer la demande dans la base de données.");
        }
    } catch (PDOException $e) {
        die("Erreur de base de données : " . $e->getMessage());
    }
}
?>
