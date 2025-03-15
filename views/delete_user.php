<?php
require_once '../config/Database.php';
require_once '../models/AdminUtilisateurModel.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: usercrud.php"); // Redirect to user management page if no ID is provided
    exit();
}

$user_id = $_GET['id'];
$adminModel = new AdminUtilisateurModel();

$adminModel->deleteUser($user_id);

header("Location: usercrud.php");
exit();
?>