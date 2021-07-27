<?php
use \App\Services\Front\Front;
?>
<div class="container container-centered" style="margin-top: 100px">

    <div class="col-4">

        <div class="card">
            <div class="card-body">
                <img class="logo-img" src="<?= \App\Core\Framework::getResourcesPath('images/logoSiteSignIn.svg'); ?>">
                <h2>Mot de passe oublié</h2>

                <?php $this->include('error.tpl') ?>

                <div class="divider"></div>

                <?php $form->render() ?>
            </div>
        </div>

    </div>
</div>