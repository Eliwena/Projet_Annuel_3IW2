<?php
use \App\Services\Http\Session;
use \App\Services\Front\Front;
?>
<div class="container container-centered" style="margin-top: 100px">

    <div class="col-4">

        <div class="card">
            <div class="card-body">
                <h2>Modifier mon profil</h2>

                <?php $this->include('error.tpl') ?>

                <div class="divider"></div>

                <?= $form->render(); ?>

            </div>
        </div>

    </div>
</div>