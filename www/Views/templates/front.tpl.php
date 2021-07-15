<?php
use \App\Services\Front\Front;
use \App\Core\Framework;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= isset($title) ? $title : 'Page du framework RestoGuest'; ?></title>
	<meta name="description" content="description de la page de front">

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>

    <!-- FONT AWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet">

    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.23/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.23/datatables.min.js"></script>

    <!-- STYLE -->
    <link href="<?= Framework::getResourcesPath('styles.css'); ?>" rel="stylesheet">
    <script type="text/javascript" src="<?= Framework::getResourcesPath('script.js'); ?>"></script>

</head>
<body>

<header>
     <div class="nav-top">
        <a href="#" class="logo-link">
            <img class="logo-img" src="<?= \App\Core\Framework::getResourcesPath('images/logoSiteBack.svg'); ?>" alt="Administration">
        </a>
        <nav class="navigation-top">
            <ul>
                <?php if(\App\Services\User\Security::isConnected()): ?>
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
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<main>
	<?php include $this->view ?>
    <?= Front::getGoogleAnalyticsJS(); ?>
</main>
</body>
</html>