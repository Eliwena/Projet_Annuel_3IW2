<section class="content">

    <h1>Ajouter un ingredients pour <?= $dishes->getNom(); ?> </h1>

    <div>
        <?php $form->render() ?>

        </br></br>
        <a class="btn" rel="stylesheet" type="text/css" onclick="window.history.go(-1); return false;">Retour</a>

    </div>

</section>