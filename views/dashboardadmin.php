<?php
session_start();

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrateur') {
    header("Location: ../views/login.php"); // Redirect to the login page
    exit();
}

require_once '../config/Database.php';
require_once '../models/ClubModel.php';

$clubModel = new ClubModel();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_club'])) {
    $nom = $_POST['clubName'];
    $date_creation = $_POST['clubdate'];
    $fondateur = $_POST['clubfondateur'];
    $responsable_id = $_POST['responsable'];

    $clubModel->addClub($nom, $date_creation, $fondateur, $responsable_id);
}

if (isset($_GET['delete_club'])) {
    $club_id = $_GET['delete_club'];
    $clubModel->deleteClub($club_id);
}

// Handle Search
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$clubs = $searchTerm ? $clubModel->searchClubs($searchTerm) : $clubModel->getAllClubs();

// Get Club Statistics
$clubStats = $clubModel->getClubStatistics();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Administrateur</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            color: #0d6efd;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-text {
            color: #555;
        }
        .card-footer {
            background-color: rgba(0, 0, 0, 0.03);
            border-top: 1px solid rgba(0, 0, 0, 0.125);
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .statistics {
            background: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        #clubList {
            margin-top: 20px;
        }
        #chartContainer {
            width: 300px;
            height: 300px;
            margin: 0 auto;
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
                            <a class="nav-link" href="#club-management">Gestion des clubs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#statistics">Statistiques</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="usercrud.php">Gestion des Utilisateurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../views/acceuil.php">Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        
        <section id="club-management" class="mb-5">
            <h2>Gestion des clubs</h2>
            
            <form method="post" class="p-4 border rounded shadow-sm mb-4">
    <div class="mb-3">
        <label for="clubName" class="form-label">Nom du club</label>
        <input type="text" class="form-control" id="clubName" name="clubName" required>
    </div>
    <div class="mb-3">
        <label for="clubdate" class="form-label">Date de création du club</label>
        <input type="date" class="form-control" id="clubdate" name="clubdate" required>
    </div>
    <div class="mb-3">
        <label for="clubfondateur" class="form-label">Nom du fondateur</label>
        <input type="text" class="form-control" id="clubfondateur" name="clubfondateur" required>
    </div>
    <div class="mb-3">
        <label for="responsable" class="form-label">Responsable du club</label>
        <select class="form-control" id="responsable" name="responsable">
            <option value="">Sélectionner un responsable</option>
            <?php
            $responsables = $clubModel->getResponsables();
            foreach ($responsables as $responsable): ?>
                <option value="<?php echo $responsable['id']; ?>"><?php echo htmlspecialchars($responsable['nom']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" name="add_club" class="btn btn-primary">Ajouter Club</button>
</form>
            
            <form method="get" class="search-bar mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" name="search" placeholder="Rechercher par nom ou fondateur" value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>

          
           <div class="row row-cols-1 row-cols-md-3 g-4" id="clubList">
    <?php foreach ($clubs as $club): ?>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($club['nom']); ?></h5>
                    <p class="card-text">
                        <strong>Date de création:</strong> <?php echo htmlspecialchars($club['date_creation']); ?><br>
                        <strong>Fondateur:</strong> <?php echo htmlspecialchars($club['fondateur']); ?><br>
                        <strong>Responsable:</strong> 
                        <?php
                        if ($club['id_responsable']) {
                            $responsable = $clubModel->getResponsableName($club['id_responsable']);
                            echo htmlspecialchars($responsable['nom']);
                        } else {
                            echo "Aucun responsable assigné";
                        }
                        ?>
                    </p>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="edit_club.php?id=<?php echo $club['id']; ?>" class="btn btn-warning btn-sm">Éditer</a>
                    <a href="?delete_club=<?php echo $club['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce club ?');">Supprimer</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
        </section>

        <!-- Statistics -->
        <section id="statistics" class="mb-5">
            <h2>Statistiques</h2>
            <div class="statistics">
                <canvas id="clubStatsChart"></canvas>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center p-3">
        <p>&copy; 2025 Espace Administrateur. Tous droits réservés.</p>
    </footer>

    <!-- pour le cercle des stats -->
    <script>
        
        const ctx = document.getElementById('clubStatsChart').getContext('2d');
        const clubStatsChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($clubStats, 'nom')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($clubStats, 'members')); ?>,
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>