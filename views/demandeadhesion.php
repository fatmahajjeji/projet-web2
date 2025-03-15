<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'Adhésion aux Clubs</title>
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
            padding: 0px;
            border-radius: 25px;
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
            color: #3b78e9;
            font-weight: bold;
        }
        .btn-custom:hover {
            background: #3817f1;
        }
        .file-preview {
            margin-top: 10px;
            font-size: 14px;
        }
        .club-section {
            margin-top: 30px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .club-card {
            background: rgba(54, 142, 230, 0.2);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
        }
        .club-card:hover {
            transform: scale(1.05);
        }
        .club-card i {
            font-size: 40px;
            color: #ffcc00;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        h1 {
            text-align: center;   color: #0D6EFD;  font-size: 3rem;   font-family: 'Georgia', serif;   text-shadow: #0f0801;  margin-top: 10px;   animation: pulse 2s infinite;   font-weight: bold;
        }
        @keyframes pulse {
            0% {
                transform: scale(1); /* Taille normale */
            }
            50% {
                transform: scale(1.1); /* Légèrement agrandi */
            }
            100% {
                transform: scale(1); /* Retour à la taille normale */
            }
        }
        .dropdown-menu {
            display: none; 
            position: absolute; 
            background-color: white;
            border: 1px solid #ddd; 
            border-radius: 5px; 
            z-index: 1000;
        }
        .dropdown:hover .dropdown-menu {
            display: block; 
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Rejoignez un Club Universitaire</h1>
    <p class="text-center" style="color:  #0D6EFD;">Faites partie d'une communauté dynamique et développez vos compétences !</p>

    <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-primary rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-link-color: var(--bs-white); --bs-nav-pills-link-active-color: var(--bs-primary); --bs-nav-pills-link-active-bg: var(--bs-white);">
        <li class="nav-item" role="presentation">
            <button class="nav-link  rounded-5" id="home-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="true" onclick="window.location.href='acceuilcon.php'">Acceuil</button>
        </li>
        <li class="nav-item" role="presentation">
            <div class="dropdown">
                <button class="nav-link  rounded-5" id="details-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="window.location.href='clubs.html'">Listes Des Clubs</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="infolab.html">Infolab</a></li>
                    <li><a class="dropdown-item" href="fahmolougia.html">Fahmolougia</a></li>
                    <li><a class="dropdown-item" href="enactus.html">Enactus</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-5" id="demande-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="window.location.href='demandeadhesion.php'">Demande D'adhésion</button> 
        </li>
        <?php if (isset($_SESSION['email'])): ?>       
        <li class="nav-item" role="presentation">
            <a href="logout.php" class="nav-link rounded-5" id="logout-tab2">Logout</a>
        </li>
        <?php else: ?> 
            <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-5 " id="connexion-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="window.location.href='login.php'"  >Se Connecter</button>
                    
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link rounded-5" id="profile-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="window.location.href='register.php'">S'inscrire</button>            </li> </ul>
                <?php endif; ?> 

    </ul>

    <div class="club-section">
        <h2 class="text-center"><strong>Nos Clubs</strong></h2>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="club-card">
                    <i class="fas fa-laptop-code"></i>
                    <h4>Infolab</h4>
                    <p>Pour les étudiants passionnés par le monde de l'informatique et du numérique. 🚀💻</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="club-card">
                    <i class="fas fa-bullhorn"></i>
                    <h4>Fahmolougia</h4>
                    <p>Pour les étudiants curieux qui aiment partager le savoir dans une ambiance dynamique.📚💡</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="club-card">
                    <i class="fas fa-lightbulb"></i>
                    <h4> Enactus</h4>
                    <p>Pour les jeunes leaders engagés qui veulent innover et entreprendre pour un impact social positif.🌍🚀</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire d'Adhésion -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-6 form-container">
            <h2 class="text-center">Formulaire d'Adhésion</h2>
            <form method="post" action="submit_adhesion.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nom et Prénom</label>
                    <input type="text" class="form-control" name="nom_prenom" placeholder="Entrez votre nom et prénom" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Adresse Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Entrez votre adresse email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Votre intérêt pour les clubs</label>
                    <textarea class="form-control" rows="3" name="motivation" placeholder="Expliquez votre motivation..." required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Choisissez un club</label>
                    <select class="form-control" name="club" required>
                        <option value="">-- Sélectionnez un club --</option>
                        <option value="Infolab">Infolab</option>
                        <option value="Fahmolougia">Fahmolougia</option>
                        <option value="Enactus">Enactus</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Téléchargez votre CV</label>
                    <input type="file" class="form-control" name="cv" id="cvInput" accept=".pdf,.doc,.docx" required>
                    <div id="filePreview" class="file-preview text-light"></div>
                </div>
                <button type="submit" class="btn btn-custom w-100" name="envoyer" style="color: white;">Envoyer la demande</button>
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
<script>
    document.getElementById('cvInput').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            document.getElementById('filePreview').textContent = `Fichier sélectionné : ${file.name}`;
        } else {
            document.getElementById('filePreview').textContent = '';
        }
    });
</script>

</body>
</html>