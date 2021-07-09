<section class="content">

    <h1>Affichage du commentaire : <?= $review->getTitle() ?> </h1>

    <div>
        <textarea style="height: 450px; width: 80%" disabled><?= $review->getText(); ?></textarea>
		</br></br>
        <a class="btn" rel="stylesheet" type="text/css" onclick="window.history.go(-1); return false;">Retour</a>

    </div>

</section>