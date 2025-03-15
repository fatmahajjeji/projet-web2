<?php
require_once '../config/Database.php';
require_once '../models/AdminUtilisateurModel.php';

$adminModel = new AdminUtilisateurModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = $_POST['role'];
    $adminModel->createUser($nom, $email, $mot_de_passe, $role);
}

$users = $adminModel->getAllUsers();

$userStats = $adminModel->getUserStatistics();
$totalUsers = $adminModel->getTotalUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
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
        #userList {
            margin-top: 20px;
        }
        /* Adjust chart size */
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
                            <a class="nav-link" href="dashboardadmin.php">Retour à l'Espace Admin</a>
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

        <section class="mb-5">
            <h2>Créer un Utilisateur</h2>
            <form method="post" class="p-4 border rounded shadow-sm">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="mot_de_passe" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Rôle</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="etudiant">Etudiant</option>
                        <option value="responsable">Responsable</option>
                        <option value="administrateur">Administrateur</option>
                    </select>
                </div>
                <button type="submit" name="create" class="btn btn-primary">Créer</button>
            </form>
        </section>

        <!-- User Statistics -->
        <section class="statistics">
            <h2>Statistiques des Utilisateurs</h2>
            <div id="chartContainer">
                <canvas id="userStatsChart"></canvas>
            </div>
        </section>

        <section class="search-bar">
            <form method="get" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Rechercher par nom, email ou rôle">
                </div>
            </form>
        </section>

        
        <section class="mt-4" id="userList">
            <h2>Liste des Utilisateurs</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4" id="userCards">
                <?php foreach ($users as $user): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($user['nom']); ?></h5>
                                <p class="card-text">
                                    <strong>Email:</strong> <?php echo htmlspecialchars($user['mail']); ?><br>
                                    <strong>Rôle:</strong> <?php echo htmlspecialchars($user['role']); ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Éditer</a>
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>


    <footer class="bg-light text-center p-3">
        <p>&copy; 2025 Espace Administrateur. Tous droits réservés.</p>
    </footer>

    <!-- JavaScript for Dynamic Search and Chart -->
    <script>
        // Dynamic Search
        const searchInput = document.getElementById('searchInput');
        const userCards = document.getElementById('userCards');

        searchInput.addEventListener('input', function () {
            const searchTerm = this.value.trim();

            // Send AJAX request to search users
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `search_users.php?search=${encodeURIComponent(searchTerm)}`, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    userCards.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });

        // Circular Statistics (Pie Chart)
        const ctx = document.getElementById('userStatsChart').getContext('2d');
        const userStatsChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($userStats, 'role')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($userStats, 'count')); ?>,
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