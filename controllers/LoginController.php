<?php
session_start(); 

require_once '../models/UtilisateurModel.php';

class LoginController {
    private $utilisateurModel;

    public function __construct() {
        $this->utilisateurModel = new UtilisateurModel();
    }

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'];

            $user = $this->utilisateurModel->verifyUser($email, $mot_de_passe);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nom'];
                $_SESSION['user_role'] = $user['role'];

                

                switch ($user['role']) {
                    case 'administrateur':
                        header('Location: ../views/dashboardadmin.php');
                        exit();
                    case 'responsable_club':
                        header('Location: ../views/dashresponsable.php');
                        exit(); 
                    case 'etudiant':
                        header('Location: ../views/acceuilcon.php');
                        exit(); 
                    default:
                        echo "Rôle non reconnu.";
                        break;
                }
            } else {
                echo "Email ou mot de passe incorrect.";
            }
        } else {
            echo "Méthode de requête non autorisée.";
        }
    }
}

// Instanciation du contrôleur et gestion de la soumission du formulaire
$controller = new LoginController();
$controller->handleLogin();
?>