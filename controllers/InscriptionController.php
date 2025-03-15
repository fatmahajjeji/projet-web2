<?php
require_once '../models/UtilisateurModel.php';

class InscriptionController {
    private $utilisateurModel;

    public function __construct() {
        $this->utilisateurModel = new UtilisateurModel();
    }

    public function handleFormSubmission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_prenom = $_POST['nom_prenom'];
            $email = $_POST['email'];
            $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); // Hash du mot de passe
            $role = $_POST['role'];

            if ($this->utilisateurModel->createUser($nom_prenom, $email, $mot_de_passe, $role)) {
                echo "Inscription réussie!";
            } else {
                echo "Erreur lors de l'inscription.";
            }
        }
    }
}

// Instanciation du contrôleur et gestion de la soumission du formulaire
$controller = new InscriptionController();
$controller->handleFormSubmission();
?>