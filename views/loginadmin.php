<?php
session_start();

try {
    $pdo = new PDO("mysql:host=localhost;dbname=projetweb", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Rechercher l'utilisateur dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE mail = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<pre>";
print_r($user); // Affiche les données de l'utilisateur
echo "</pre>";

    // Vérifier si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user['mot_de_passe'])){
        echo "Mot de passe correct.<br>";
        if ($user['role'] == 'administrateur') {
            // Démarrer la session admin
            $_SESSION['administrateur'] = $user['email'];
            $_SESSION['role'] = $user['role'];  
            header("Location: C:\wamp64\www\Projetweb2\dashboardadmin.php"); // Rediriger vers le tableau de bord
            exit();
        } else {
            echo "<script>alert('Accès refusé : vous n\'êtes pas administrateur !'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Email ou mot de passe incorrect !'); window.location.href='login.php';</script>";
        exit();
    }
}
?>
