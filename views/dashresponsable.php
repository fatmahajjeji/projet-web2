<?php
//en cas d'erreur
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Vérifier si l'utilisateur est connecté et a le rôle responsable
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'responsable_club') {
    header("Location: ../views/login.php"); // Rediriger vers la page de connexion
    exit();
}

require_once '../config/Database.php';
require_once '../models/ClubModel.php';

$clubModel = new ClubModel();


$responsable_id = $_SESSION['user_id'];
$club = $clubModel->getClubByResponsable($responsable_id);



if (!$club) {
    die("Aucun club n'est assigné à ce responsable.");
}

$club_id = $club['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accept_adhesion'])) {
        $adhesion_id = $_POST['adhesion_id'];
        $clubModel->acceptAdhesion($adhesion_id);
    } elseif (isset($_POST['decline_adhesion'])) {
        $adhesion_id = $_POST['adhesion_id'];
        $clubModel->declineAdhesion($adhesion_id);
    } elseif (isset($_POST['add_member'])) {
        $user_id = $_POST['user_id'];
        $clubModel->addMember($club_id, $user_id);
    } elseif (isset($_POST['remove_member'])) {
        $user_id = $_POST['user_id'];
        $clubModel->removeMember($club_id, $user_id);
    }
}

$adhesions = $clubModel->getAdhesionsForClub($club_id);
$members = $clubModel->getMembersForClub($club_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Responsable club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="bg-primary text-white text-center p-4">
        <h1>Espace Responsable</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#club-details">Détails du Club</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#demande">Gestion des demandes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#member-management">Gestion des membres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../views/logout.php">Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-4">
        
        <section id="club-details" class="mb-5">
            <h2>Détails du Club</h2>
            <?php if ($club): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($club['nom']); ?></h5>
                        <p class="card-text">
                            <strong>Date de création:</strong> <?php echo htmlspecialchars($club['date_creation']); ?><br>
                            <strong>Fondateur:</strong> <?php echo htmlspecialchars($club['fondateur']); ?><br>
                            <strong>Responsable:</strong> <?php echo htmlspecialchars($clubModel->getResponsableName($club['id_responsable'])['nom']); ?>
                        </p>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">Aucun club n'est assigné à ce responsable.</div>
            <?php endif; ?>
        </section>

        
        <section id="demande" class="mb-5">
            <h2>Gestion des demandes</h2>
            <ul class="list-group">
                <?php foreach ($adhesions as $adhesion): ?>
                    <li class="list-group-item">
                        <?php echo htmlspecialchars($adhesion['nom_prenom']); ?> - <?php echo htmlspecialchars($adhesion['email']); ?>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="adhesion_id" value="<?php echo $adhesion['id']; ?>">
                            <button type="submit" name="accept_adhesion" class="btn btn-success btn-sm">Accepter</button>
                            <button type="submit" name="decline_adhesion" class="btn btn-danger btn-sm">Refuser</button>
                        </form>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($adhesions)): ?>
                    <li class="list-group-item">Aucune demande d'adhésion pour le moment.</li>
                <?php endif; ?>
            </ul>
        </section>

  
        <section id="member-management" class="mb-5">
            <h2>Gestion des membres</h2>
            <ul class="list-group">
                <?php foreach ($members as $member): ?>
                    <li class="list-group-item">
                        <?php echo htmlspecialchars($member['nom']); ?> - <?php echo htmlspecialchars($member['mail']); ?>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?php echo $member['id']; ?>">
                            <button type="submit" name="remove_member" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($members)): ?>
                    <li class="list-group-item">Aucun membre pour le moment.</li>
                <?php endif; ?>
            </ul>
            <form method="post" class="mt-4">
                <div class="mb-3">
                    <label for="user_id" class="form-label">ID de l'utilisateur</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" required>
                </div>
                <button type="submit" name="add_member" class="btn btn-primary">Ajouter un membre</button>
            </form>
        </section>
    </main>

    <footer class="bg-light text-center p-3">
        <p>&copy; 2023 Espace Responsable. Tous droits réservés.</p>
    </footer>
</body>
</html>