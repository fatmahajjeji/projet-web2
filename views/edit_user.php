<?php
require_once '../config/Database.php';
require_once '../models/AdminUtilisateurModel.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: usercrud.php"); // Redirect to user management page if no ID is provided
    exit();
}

$user_id = $_GET['id'];
$adminModel = new AdminUtilisateurModel();

$user = $adminModel->getUserById($user_id);

if (!$user) {
    header("Location: usercrud.php"); // Redirect to user management page if the user is not found
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = $_POST['role'];

    $adminModel->updateUser($user_id, $nom, $email, $mot_de_passe, $role);
    header("Location: usercrud.php"); // Redirect back to user management page after updating
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'Utilisateur</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
                            <a class="nav-link" href="../controllers/logout.php">Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
<section class="form-container">
    <h2>Modifier l'Utilisateur</h2>
    <form method="post">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['mail']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" placeholder="Laissez vide pour ne pas modifier">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select class="form-control" id="role" name="role" required>
                <option value="etudiant" <?php echo $user['role'] === 'etudiant' ? 'selected' : ''; ?>>Etudiant</option>
                <option value="responsable" <?php echo $user['role'] === 'responsable' ? 'selected' : ''; ?>>Responsable</option>
                <option value="administrateur" <?php echo $user['role'] === 'administrateur' ? 'selected' : ''; ?>>Administrateur</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Mettre à jour</button>
    </form>
</section>
</main>

 
    <footer class="bg-light text-center p-3">
        <p>&copy; 2025 Espace Administrateur. Tous droits réservés.</p>
    </footer>
</body>
</html>