<?php 
    $slug = $_SERVER["REQUEST_URI"];
    $arrExploded = explode('/', $slug);
    if (!isset($arrExploded[2])) {
        $secondElement = 'admin';
    } else {
        $secondElement = $arrExploded[2];
    }
?>
<?php
$sidebar = [
        0 => [
            'route_name' => \App\Core\Framework::getUrl('app_admin'),
            'icon' => 'fa-tachometer-alt',
            'description' => 'Tableau de bord',
        ],
        20 => [
            'route_name' => \App\Core\Framework::getUrl('app_admin_appearance'),
            'icon' => 'fa-fill-drip',
            'description' => 'Apparence - todo',
        ],
        1 => [
            'route_name' => \App\Core\Framework::getUrl(null),
            'icon' => 'fa-chart-bar',
            'description' => 'Analytics - todo',
        ],
        2 => [
            'route_name' => \App\Core\Framework::getUrl('app_admin_page'),
            'icon' => 'fa-file-alt',
            'description' => 'Mes Pages',
        ],
        10 => [
            'route_name' => \App\Core\Framework::getUrl('app_admin_user'),
            'icon' => 'fa-user',
            'description' => 'Utilisateurs',
        ],
        11 => [
            'route_name' => \App\Core\Framework::getUrl('app_admin_group'),
            'icon' => 'fa-users-cog',
            'description' => 'Groupes',
        ],

        40 => [
            'route_name' => \App\Core\Framework::getUrl('app_admin_menu'),
            'icon' => 'fa-hamburger',
            'description' => 'Mes menus',
        ],
        50 => [
            'route_name' => \App\Core\Framework::getUrl('app_admin_meal'),
            'icon' => 'fas fa-hamburger',
            'description' => 'Mes plats',
        ],
        60 => [
            'route_name' => \App\Core\Framework::getUrl('app_admin_foodstuff'),
            'icon' => 'fa-hamburger',
            'description' => 'Mes produits',
        ],
        70 => [
            'route_name' => \App\Core\Framework::getUrl('app_admin_reservation'),
            'icon' => 'fa-car-side',
            'description' => 'Réservation',
        ],
        71 => [
            'route_name' => \App\Core\Framework::getUrl('app_admin_review'),
            'icon' => 'fa-comment-alt',
            'description' => 'Avis',
        ],
        72 => [
            'route_name' => \App\Core\Framework::getUrl('app_admin_report'),
            'icon' => 'fa-exclamation-circle',
            'description' => 'Signalement',
        ],
]
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
    <link type="text/css" href="<?= \App\Core\Framework::getResourcesPath('styles.css' . '?' . rand()); ?>" rel="stylesheet">

    <!-- CHARTJS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@3.4.1/dist/chart.min.js"></script>
</head>
<body>
<header>
    <div class="nav-top">
        <a href="#" class="logo-link">
            <img class="logo-img" src="<?= \App\Core\Framework::getResourcesPath('images/logoSiteBack.svg'); ?>" alt="Administration">
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
                            <a class="dropdown-links" href="<?= \App\Core\Framework::getUrl('app_home') ?>">Voir le site</a>
                        </div>
                    </div>

                </li>
            </ul>
        </nav>
    </div>
</header>
<main>
    <nav>
        <?php foreach($sidebar as $item) { ?>

        <a <?= \App\Services\Front\Front::isSidebarActive($item['route_name']) ? 'class="active"' : ''; ?> href="<?= $item['route_name']; ?>">
            <i class="fas <?= $item['icon']; ?>"></i>
            <span><?= $item['description']; ?></span>
        </a>
        <?php } ?>

        <div class="animation start-home <?php echo $secondElement?>"></div>
    </nav>
    <!-- afficher la vue -->
    <?php include $this->view ?>

    <footer>
        <a id="parameters" href="<?= \App\Core\Framework::getUrl('app_admin_config'); ?>">
            <i class="fas fa-cog"></i>
            Paramètres - todo
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