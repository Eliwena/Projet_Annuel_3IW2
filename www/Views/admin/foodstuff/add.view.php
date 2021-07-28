<section class="content">

    <h1>Ajouter un ingredients </h1>
    <?php $this->include('error.tpl') ?>
    <div>
        <?php $form->render() ?>

        <a onclick="window.history.go(-1); return false;">
            <button class="btn btn-primary-outline">
                Retour
            </button>
        </a>
    </div>

</section>