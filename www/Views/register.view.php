<?php
use \App\Services\Http\Session;
use \App\Services\Front\Front;
?>
<div class="container container-centered">

    <div class="col-4">

        <div class="card">
            <div class="card-body">
                <img class="logo-img" src="<?= \App\Core\Framework::getResourcesPath('images/logoSiteSignIn.svg'); ?>">
                <h2>Inscription sur <?= Front::getSiteName(); ?></h2>

                <?php $this->include('error.tpl') ?>

                <div class="divider"></div>

                <?php $form->render() ?>

                <?php if(_OAUTH_ENABLED): if(!\App\Services\Http\Session::exist('oauth_data')): ?>
                <div class="divider"></div>
                <a href="<?= \App\Core\Framework::getUrl('app_login_oauth', ['client' => 'google']); ?>">
                    <button style="" class="btn btn-social-google-outline btn-small w-60">
                        <i style="padding: 0 5px" class="fab fa-google"></i>
                        S'inscrire avec Google</button>
                </a>
                <?php endif; endif; ?>

                <div class="divider"></div>
                <a href="<?= \App\Core\Framework::getUrl('app_login'); ?>">
                    <button class="btn btn-primary-outline w-60">
                        <i style="padding: 0 5px" class="fas fa-user-check"></i>
                        Déja un compte? Connectez-vous!</button>
                </a>
            </div>
        </div>

    </div>
</div>