<?php
use App\Core\Framework;
?>
<section class="content">

    <h1>Affichage du signalement pour le commentaire : <?= $report->getReviewId()->getTitle() ?> </h1>

    <div>
        <label for="report_reason">Raison du signalement :</label><br>
        <textarea id="report_reason" style="height: 150px; width: 80%" disabled><?= $report->getReason(); ?></textarea><br><br>


        <label for="review_text">Contenu du commentaire mis en cause :</label><br>
        <textarea id="review_text" style="height: 450px; width: 80%" disabled><?= $report->getReviewId()->getText(); ?></textarea>
		</br></br>

        <a class="btn btn-bold btn-blue" href="<?= Framework::getUrl('app_admin_report_delete', ['id' => $report->getReviewId()->getId()]); ?>">ANNULER LE SIGNALEMENT</a>
        <a class="btn btn-bold btn-red" href="<?= Framework::getUrl('app_admin_review_delete', ['id' => $report->getReviewId()->getId()]); ?>">SUPRIMER LE COMMENTAIRE</a>
        <a class="btn btn-bold" rel="stylesheet" type="text/css" onclick="window.history.go(-1); return false;">RETOUR</a>

    </div>

</section>