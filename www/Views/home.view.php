<?php if(App\Services\User\Security::isConnected()) { ?>
    <a href="<?= \App\Core\Framework::getBaseUrl() . '/logout'; ?>">déconnexion</a>
    <br>
    <a href="<?= \App\Core\Framework::getBaseUrl() . '/admin'; ?>">admin</a>
<?php } else { ?>
    <a href="<?= \App\Core\Framework::getBaseUrl() . '/login'; ?>">connexion</a>
    <br>
    <a href="<?= \App\Core\Framework::getBaseUrl() . '/register'; ?>">inscription</a>
<?php } ?>

