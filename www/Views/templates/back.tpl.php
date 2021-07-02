<?php 
    $slug = $_SERVER["REQUEST_URI"];
    $arrExploded = explode('/', $slug);
    if (!isset($arrExploded[2])) {
        $secondElement = 'admin';
    } else {
        $secondElement = $arrExploded[2];
    }
        
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administration<?= isset($_title) ? ' - ' . $_title : ''; ?></title>

    <!-- JQUERY -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <!-- FONT AWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet">

    <!-- DATATABLES -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.23/datatables.min.js"></script>
    <!--link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.23/datatables.min.css"/-->

    <!-- STYLE -->
    <link type="text/css" href="../../Resources/styles.css" rel="stylesheet">
    
</head>
<body>
<header>
    <div class="nav-top">
        <a href="#" class="logo-link">
            <img class="logo-img" src="../../Resources/images/logoSiteBack.svg" alt="Administration">
        </a>
        <nav class="navigation-top">
            <ul>
                <li>
                    <a id="dropdown" href="#open-dropdown">
                    <span><?= $_user->getFirstname() . ' ' . $_user->getLastname() ?></span>
                        <img class="profil-img" src="<?= 'https://www.gravatar.com/avatar/' . md5($_user->getEmail()) . '.jpg?s=80'; ?>" alt=""/>
                        <i class="fas fa-chevron-down"></i>
                    </a>

                    <div class="dropdown-menu">
                        <div id="dropdown-content" class="dropdown-content">
                            <a class="dropdown-links" href="#">Mon profile</a>
                            <a class="dropdown-links" href="<?= \App\Core\Framework::getUrl('app_logout'); ?>">Déconnexion</a>
                        </div>
                    </div>

                </li>
            </ul>
        </nav>
    </div>
</header>
<main>
    <nav>
        <a href="/admin">
            <i class="fas fa-tachometer-alt"></i>
            Tableau de bord
        </a>

        <a href="/admin/member">
            <i class="fas fa-user"></i>
            Utilisateurs
        </a>
        <a href="/admin/appearance">
            <i class="fas fa-fill-drip"></i>
            Apparence
        </a>
        <a href="#">
            <i class="fas fa-shopping-cart"></i>
            Commande
        </a>

        <a href="/admin/menus">
            <i class="fas fa-hamburger"></i>
            Mes menus
        </a>

        <a href="/admin/dishes">
            <i class="fas fa-hamburger"></i>
            Mes plats
        </a>

        <a href="/admin/ingredients">
            <i class="fas fa-hamburger"></i>
            Mes produits
        </a>

        <a href="#">
            <i class="fas fa-car-side"></i>
            Réservation
        </a>
        <div class="animation start-home <?php echo $secondElement?>"></div>
    </nav>
    <!-- afficher la vue -->
    <?php include $this->view ?>

    <footer>
        <a id="parameters" href="#">
            <i class="fas fa-cog"></i>
            Paramètres
        </a>
    </footer>
</main>
<script>
    let dropdownClick = document.querySelector('#dropdown');
    let dropdownContent = document.querySelector('#dropdown-content');
    dropdownClick.addEventListener('click',()=>{
        if(dropdownContent.style.display===""){
            dropdownContent.style.display="block";
        } else {
            dropdownContent.style.display="";
        }
    })
</script>
</body>
</html>