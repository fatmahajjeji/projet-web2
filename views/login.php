<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f7faff, #c9dafd);
            color: white;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 40px;
        }
        .form-container {
            background: rgba(64, 137, 239, 0.271);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }
        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: none;
        }
        .btn-custom {
            background: #2468f1;
            color: white;
            font-weight: bold;
        }
        .btn-custom:hover {
            background: #3817f1;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            color: #0D6EFD;
            font-size: 3rem;
            font-family: 'Georgia', serif;
            text-shadow: #0f0801;
            margin-top: 10px;
            animation: pulse 2s infinite;
            font-weight: bold;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Connectez-vous</h1>
    <p class="text-center" style="color: #0D6EFD;">Accédez à votre compte et explorez notre communauté !</p>

    <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-primary rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-link-color: var(--bs-white); --bs-nav-pills-link-active-color: var(--bs-primary); --bs-nav-pills-link-active-bg: var(--bs-white);">
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-5" id="home-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="true" onclick="window.location.href='acceuil.php'">Accueil</button>
        </li>
        <li class="nav-item" role="presentation">
            <div class="dropdown">
                <button class="nav-link rounded-5" id="details-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="window.location.href='clubs.html'">Listes Des Clubs</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="infolab.html">Infolab</a></li>
                    <li><a class="dropdown-item" href="fahmolougia.html">Fahmolougia</a></li>
                    <li><a class="dropdown-item" href="enactus.html">Enactus</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-5" id="demande-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="window.location.href='demandeadhesion.php'">Demande D'adhésion</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-5" id="connexion-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="window.location.href='login.php'">Se Connecter</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-5" id="profile-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="window.location.href='register.php'">S'inscrire</button>
        </li>
    </ul>


    <div class="row justify-content-center mt-4">
        <div class="col-md-6 form-container">
            <h2 class="text-center">Formulaire de connexion</h2>
            
            <form method="post" action="../controllers/LoginController.php">
                <div class="mb-3">
                    <label class="form-label">Adresse Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Entrez votre adresse email" required>
                </div>
    
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="mot_de_passe" placeholder="Entrez votre mot de passe" required>
                </div>
    
                <button type="submit" class="btn btn-custom w-100" name="envoyer">Se Connecter</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Club Universitaire ESSECT | Tous droits réservés</p>
    </footer>
</div>

<script>
    function navigateTo(page) {
        window.location.href = page;
    }
</script>

</body>
</html>