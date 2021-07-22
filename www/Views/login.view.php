<div class="container container-centered" style="margin-top: 100px">
    <div class="col-4">

        <div class="card">
            <div class="card-body">
                <img class="logo-img" src="<?= \App\Core\Framework::getResourcesPath('images/logoSiteSignIn.svg'); ?>">
                <h2>Connectez-vous !</h2>

                <?php $this->include('error.tpl') ?>

                <div class="divider"></div>

                <?php $form->render() ?>

                <?php if(_OAUTH_ENABLED): ?>
                    <div class="divider"></div>
                    <a href="<?= \App\Core\Framework::getUrl('app_login_oauth', ['client' => 'google']); ?>">
                        <button style="" class="btn btn-social-google-outline btn-small w-60">
                            <i style="padding: 0 5px" class="fab fa-google"></i>
                            Se connecter avec Google</button>
                    </a>
                <?php endif; ?>

                <div class="divider"></div>

                <a href="<?= \App\Core\Framework::getUrl('app_register'); ?>">
                    <button class="btn btn-primary-outline w-60">
                        <i style="padding: 0 5px" class="fas fa-user-plus"></i>
                        Créer un compte</button>
                </a>

            </div>
        </div>

    </div>
</div>