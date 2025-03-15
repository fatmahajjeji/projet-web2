<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrateur') {
    header("Location: ../views/login.php"); // Redirect to the login page
    exit();
}

require_once '../config/Database.php';
require_once '../models/ClubModel.php';

$clubModel = new ClubModel();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboardadmin.php"); // Redirect to the dashboard if no ID is provided
    exit();
}

$club_id = $_GET['id'];
$club = $clubModel->getClubById($club_id);

if (!$club) {
    header("Location: dashboardadmin.php"); // Redirect to the dashboard if the club is not found
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_club'])) {
    $nom = $_POST['clubName'];
    $date_creation = $_POST['clubdate'];
    $fondateur = $_POST['clubfondateur'];
    $responsable_id = $_POST['responsable'];

    $clubModel->updateClub($club_id, $nom, $date_creation, $fondateur, $responsable_id);
    header("Location: dashboardadmin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Club</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafd, #c9dafd);
        }
        .container {
            margin-top: 40px;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-primary text-white text-center p-4">
        <h1>Espace Administrateur</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboardadmin.php">Retour à l'Espace Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../controllers/logout.php">Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
       
<form method="post">
    <div class="mb-3">
        <label for="clubName" class="form-label">Nom du club</label>
        <input type="text" class="form-control" id="clubName" name="clubName" value="<?php echo htmlspecialchars($club['nom']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="clubdate" class="form-label">Date de création du club</label>
        <input type="date" class="form-control" id="clubdate" name="clubdate" value="<?php echo htmlspecialchars($club['date_creation']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="clubfondateur" class="form-label">Nom du fondateur</label>
        <input type="text" class="form-control" id="clubfondateur" name="clubfondateur" value="<?php echo htmlspecialchars($club['fondateur']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="responsable" class="form-label">Responsable du club</label>
        <select class="form-control" id="responsable" name="responsable">
            <option value="">Sélectionner un responsable</option>
            <?php
            $responsables = $clubModel->getResponsables();
            foreach ($responsables as $responsable): ?>
                <option value="<?php echo $responsable['id']; ?>" <?php echo ($club['id_responsable'] == $responsable['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($responsable['nom']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" name="update_club" class="btn btn-primary">Mettre à jour</button>
</form>
        </section>
    </main>

  
    <footer class="bg-light text-center p-3">
        <p>&copy; 2025 Espace Administrateur. Tous droits réservés.</p>
    </footer>
</body>
</html>