<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></head>
    <script src="acceuilscript.js" defer></script>
    <style>
        body{background: linear-gradient(135deg, #f8fafd, #c9dafd);}
        #titre,#textdescriptif{text-align: center; }
        .container { margin-top: 40px; }
        .carousel {position: relative;overflow: hidden;}
        .image{ opacity: 100%;max-height: 600PX;width: 100%;}
        #Copyright{ align-self: flex-end;padding-right: 15px;font-size: smaller;}
        .dropdown-menu {display: none; position: absolute; background-color: white;border: 1px solid #ddd; border-radius: 5px; z-index: 1000;}
        .dropdown:hover .dropdown-menu {display: block; }
        #txt{text-align: center;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;font-size: x-large;font-weight: 400;color: cornflowerblue;}
        #title{ text-align: center; color: #00008b; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; font-size: x-large; font-weight: 400;}
        a{color: white;text-decoration: none;}
    </style>

<body>
    <br>
    <h1 id="titre" style="color: #0D6EFD;">Bienvenue sur le site officiel des clubs l’ESSECT</h1>
    <p id="textdescriptif">Rejoindre un club, c'est trouver sa passion, développer ses compétences et contribuer à une communauté dynamique.</p>

    

    <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-primary rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-link-color: var(--bs-white); --bs-nav-pills-link-active-color: var(--bs-primary); --bs-nav-pills-link-active-bg: var(--bs-white);">
        <li class="nav-item" role="presentation">
        <button class="nav-link active rounded-5" id="home-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="true"  >Acceuil</button>
    
        </li>

       

        <li class="nav-item" role="presentation">
            <div class="dropdown">
                <button class="nav-link rounded-5" id="details-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="window.location.href='clubs.html'" >Liste Des Clubs</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="infolab.html">Infolab</a></li>
                    <li><a class="dropdown-item" href="fahmolougia.html">Fahmolougia</a></li>
                    <li><a class="dropdown-item" href="enactus.html">Enactus</a></li>

                </ul>
            </div>
        </li>

        
        <li class="nav-item" role="presentation">
        <button class="nav-link rounded-5 " id="demande-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false"   onclick="window.location.href='demandeadhesion.php'" >Demande D'adhésion</button> 
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-5 " id="connexion-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="window.location.href='login.php'"  >Se Connecter</button>
            
          </li>
          <li class="nav-item" role="presentation">
          <button class="nav-link rounded-5" id="profile-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="window.location.href='register.php'">S'inscrire</button>            </li>  
    </ul>

    
  
<br>
      
    <div class="carousel">
        <div class="slides">
            <img class="image" src="../uploads/1.jpg" alt="" width="100%" height="50%">
        </div> 
    </div>

<br>
    
    <h1 id="txt">"Êtes-vous prêt à créer des souvenirs inoubliables et à tisser des liens durables ? <br> Les clubs vous offrent cette chance unique !"</h1>
<br><br><br>

    <div class="card-group">
        <div class="card">
            <div class="card-body">
            <p class="card-text">  "Les clubs sont le cœur de la vie étudiante : ils vous permettent de vous exprimer, de vous impliquer et de faire entendre votre voix.".</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
            <p class="card-text">"En rejoignant un club, vous participez à la construction d'une communauté dynamique et solidaire, où chacun peut contribuer à un projet commun.".</p>
        </div>

    </div> 
</div>
<br>
<br>
  <h5 id="title">Rejoindre les clubs de l'ESSECT offre aux étudiants l'opportunité de s'impliquer activement dans la vie universitaire, <br> de développer des compétences pratiques et de créer des liens avec d'autres étudiants partageant les mêmes intérêts. <br> Ces clubs favorisent un environnement dynamique et solidaire, essentiel pour le développement personnel et professionnel.</h5>
<br>
<script>
    function navigateTo(page) {
        window.location.href = page;
    }
</script>

    <div id="Copyright">
        <p style=" color:#ffffff; text-align:  center; font-family: Arial, Helvetica, sans-serif;" ><br><br><br><br> <strong>© Copyright 2025 ESSECT</strong></p>
    </div>
</div>
</body>
</html>
