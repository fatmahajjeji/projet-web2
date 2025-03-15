<?php
class AdhesionController {
    private $adhesionModel;

    public function __construct(AdhesionModel $adhesionModel) {
        $this->adhesionModel = $adhesionModel;
    }

    public function traiterFormulaire() {
        if (isset($_POST['envoyer'])) {
            $nom_prenom = $_POST['nom_prenom'];
            $email = $_POST['email'];
            $interet = $_POST['interet'];
            $club = $_POST['club'];
            $cv_content = null;

            // Vérifier si le fichier a été envoyé
            if (isset($_FILES['cvInput']) && $_FILES['cvInput']['error'] == UPLOAD_ERR_OK) {
                $fileType = strtolower(pathinfo($_FILES['cvInput']['name'], PATHINFO_EXTENSION));

                if ($fileType == "pdf" || $fileType == "doc" || $fileType == "docx") {
                    // Lire le fichier en tant que données binaires
                    $cv_content = file_get_contents($_FILES['cvInput']['tmp_name']);
                } else {
                    return "Seuls les fichiers PDF, DOC et DOCX sont autorisés.";
                }
            } else {
                // Afficher l'erreur spécifique
                $error_message = "Erreur lors du téléchargement du fichier : ";
                if (isset($_FILES['cvInput'])) {
                    switch ($_FILES['cvInput']['error']) {
                        case UPLOAD_ERR_INI_SIZE:
                            $error_message .= "Le fichier dépasse la taille maximale autorisée.";
                            break;
                        case UPLOAD_ERR_FORM_SIZE:
                            $error_message .= "Le fichier dépasse la taille maximale spécifiée dans le formulaire.";
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            $error_message .= "Le fichier n'a été que partiellement téléchargé.";
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            $error_message .= "Aucun fichier n'a été téléchargé.";
                            break;
                        case UPLOAD_ERR_NO_TMP_DIR:
                            $error_message .= "Le dossier temporaire est manquant.";
                            break;
                        case UPLOAD_ERR_CANT_WRITE:
                            $error_message .= "Échec de l'écriture du fichier sur le disque.";
                            break;
                        case UPLOAD_ERR_EXTENSION:
                            $error_message .= "Une extension PHP a arrêté le téléchargement du fichier.";
                            break;
                        default:
                            $error_message .= "Erreur inconnue.";
                            break;
                    }
                } else {
                    $error_message .= "Aucun fichier n'a été envoyé.";
                }
                return $error_message;
            }

            // Enregistrement dans la base de données
            if ($this->adhesionModel->enregistrerAdhesion($nom_prenom, $email, $interet, $club, $cv_content)) {
                return "Votre demande a été enregistrée avec succès.";
            } else {
                return "Erreur lors de l'enregistrement.";
            }
        }
    }
}
?>