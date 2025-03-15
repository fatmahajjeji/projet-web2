<?php

session_start(); 

require_once '../models/UtilisateurModel.php';

class RegisterController {
    private $utilisateurModel;

    public function __construct() {
        $this->utilisateurModel = new UtilisateurModel();
    }

    public function handleRegistration() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_prenom = $_POST['nom_prenom'];
            $email = $_POST['email'];
            $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); 
            $role = $_POST['role']; // Role is now "etudiant" by default

            
            if ($this->utilisateurModel->createUser($nom_prenom, $email, $mot_de_passe, $role)) {
                echo "Utilisateur enregistré avec succès!";
                header('Location: ../views/acceuilcon.php'); // Redirect to login page after successful registration
                exit();
            } else {
                echo "Erreur lors de l'inscription.";
            }
        } else {
            echo "Méthode de requête non autorisée.";
        }
    }
}

// Instanciation du contrôleur et gestion de la soumission du formulaire
$controller = new RegisterController();
$controller->handleRegistration();
?>