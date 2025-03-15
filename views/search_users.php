<?php
require_once '../config/Database.php';
require_once '../models/AdminUtilisateurModel.php';

$adminModel = new AdminUtilisateurModel();

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$users = $adminModel->searchUsers($searchTerm);

foreach ($users as $user): ?>
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
<?php endforeach;
?>