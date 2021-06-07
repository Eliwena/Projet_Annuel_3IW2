<h2>Welcome <?= $pseudo; ?></h2>

<?php if(App\Services\User\Security::isConnected()) { ?>
    <a href="<?= \App\Core\Framework::getUrl() . '/logout'; ?>">déconnexion</a>
    <br>
    <a href="<?= \App\Core\Framework::getUrl() . '/admin'; ?>">admin</a>
<?php } else { ?>
    <a href="<?= \App\Core\Framework::getUrl() . '/login'; ?>">connexion</a>
    <br>
    <a href="<?= \App\Core\Framework::getUrl() . '/register'; ?>">inscription</a>
<?php } ?>

