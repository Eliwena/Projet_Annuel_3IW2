<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Qahiri&display=swap" rel="stylesheet">

<section class="content">
    <h1>Les appearances</h1>

    <?php $this->include('error.tpl') ?>
    <div class="content-menu">

        <?php foreach (($appearances ? $appearances : []) as $appearance) { ?>
            <div class="menu" >
                <div class="div-close">
                    <a href="" class="btn-close" onclick="return confirm('Voulez vous supprimer ce plat ?');"><i class="far fa-times-circle"></i></a>
                </div>
                <div class="title-menu">
                    <h2> <?= $appearance['title'];  ?>
                    <?php if($appearance['isActive']==1){?>
                        <a href="" class="btn-valide"><i class="fas fa-check"></i></a>
                    <?php } else { ?>
                        <a href="" class="btn btn-small btn-success"> Activer</a>
                    <?php }?>
                    </h2>
                </div>
                <hr class="separation-menu">
                <div class="list-plat">
                    <div class="">
                        <p> <b>Description :</b>  <?= $appearance['description'];   ?></p>
                        <p><b>Police :</b> <span style="font-family:<?= $appearance['police'];   ?> "><?= $appearance['police'];   ?></span></p>
                        <p><b>Background :</b> <span style="background-color:<?= $appearance['background'];  ?>;color:<?= $appearance['background'];  ?> "> Couleur   </span></p>
                        <p><b>Color 1 :</b>  <span style="background-color:<?= $appearance['color_number_1'];?> ;color:<?= $appearance['color_number_1'];?>"> Couleur   </span></p>
                        <p><b>Color 2 :</b> <span style="background-color:<?= $appearance['color_number_2'];?>;color:<?= $appearance['color_number_2'];?>"> Couleur</span></p>
<!--                        <input style=" margin: .4rem; padding: 0 ; border-radius: 0;" type="color" id="head" name="head"-->
<!--                               value="#e66465">-->
<!--                        <label for="head">Head</label>-->
                    </div>


                </div>
                <a href="" style="display: flex;justify-content: center;" class="btn btn-primary-outline"><i style="display: flex;
    align-items: center;" class="fas fa-pen"></i> &nbsp; Modifier la template</a>
            </div>
        <?php } ?>

        <a href="" class="menu" id="ajout-menu">
            <i  class="fas fa-plus-circle fa-10x"></i>
        </a>
    </div>

</section>

