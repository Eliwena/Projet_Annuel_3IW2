<div class="container container-centered" style="margin-top: 100px; max-width: 420px;>

        <div class="card" style="width: 100%">
            <div class="card-body">
                <img class="logo-img" src="<?= \App\Core\Framework::getResourcesPath('images/logoSiteSignIn.svg'); ?>">
                <h2><?= $title; ?></h2>

                <?php $this->include('error.tpl') ?>

                <div class="divider"></div>
                <?php $form->render() ?>
            </div>
        </div>

</div>
