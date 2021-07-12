<section class="content">

    <h1>Affichage du commentaire : <?= $review->getTitle() ?> </h1>
    <?php $this->include('error.tpl') ?>
    <div style="align-items: start" class="form_control">
        <div class="form_group">
            <textarea style="height: 450px" class="form_input" disabled><?= $review->getText(); ?></textarea>
        </div>
    </div>

    <a style="padding-top: 1rem" onclick="window.history.go(-1); return false;">
        <button class="btn btn-primary-outline">
            Retour
        </button>
    </a>

</section>