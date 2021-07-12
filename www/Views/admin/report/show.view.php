<?php
use App\Core\Framework;
?>
<section class="content">

    <h1>Affichage du signalement pour le commentaire : <?= $report->getReviewId()->getTitle() ?> </h1>
    <?php $this->include('error.tpl') ?>
    <div style="align-items: start" class="form_control">
        <div class="form_group">
            <label for="report_reason">Raison du signalement :</label><br>
            <textarea id="report_reason" style="height: 450px" class="form_input" disabled><?= $report->getReason(); ?></textarea><br><br>
        </div>
        <div class="form_group" style="padding-top: 2rem">
            <label for="review_text">Contenu du commentaire mis en cause :</label><br>
            <textarea id="review_text" style="height: 450px" class="form_input" disabled><?= $report->getReviewId()->getText(); ?></textarea>
        </div>
    </div>

    <div style="padding-top: 2rem; padding-bottom: 3rem">
        <a class="btn btn-bold btn-info" href="<?= Framework::getUrl('app_admin_report_delete', ['id' => $report->getReviewId()->getId()]); ?>">ANNULER LE SIGNALEMENT</a>
        <a class="btn btn-bold btn-danger" href="<?= Framework::getUrl('app_admin_review_delete', ['id' => $report->getReviewId()->getId()]); ?>">SUPRIMER LE COMMENTAIRE</a>
        <br><br>
        <a onclick="window.history.go(-1); return false;">
            <button class="btn btn-primary-outline">
                Retour
            </button>
        </a>
    </div>

</section>