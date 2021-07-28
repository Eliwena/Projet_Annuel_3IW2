<?php

use App\Services\Translator\Translator;

?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Qahiri&display=swap" rel="stylesheet">

<section class="content">
    <h1><?= Translator::trans('view_appearance_title')?> </h1>

    <?php $this->include('error.tpl') ?>
    <div class="content-menu">

        <?php foreach (($appearances ? $appearances : []) as $appearance) { ?>
            <div class="menu" >
                <div class="div-close">
                    <a href="<?= \App\Core\Framework::getUrl('app_admin_appearance_delete',['appearanceId'=>$appearance['id']]);?>" class="btn-close" onclick="return confirm('Voulez vous supprimer cette template ?');"><i class="far fa-times-circle"></i></a>
                </div>
                <div class="title-menu">
                    <h2> <?= $appearance['title'];  ?>
                        <?php if($appearance['isActive']==1){?>
                            <a href="" class="btn-valide"><i class="fas fa-check"></i></a>
                        <?php } else { ?>
                            <a href="<?= \App\Core\Framework::getUrl('app_admin_appearance_active',['appearanceId'=>$appearance['id']]);?>" class="btn btn-small btn-success"><?= Translator::trans('view_appearance_active')?></a>
                        <?php }?>
                    </h2>
                </div>
                <hr class="separation-menu">
                <div class="list-plat">
                    <div class="">
                        <p> <b><?= Translator::trans('view_appearance_description')?></b>  <?= $appearance['description'];   ?></p>
                        <p><b><?= Translator::trans('view_appearance_police')?></b> <span style="font-family:<?= $appearance['police'];   ?> "><?= $appearance['police'];   ?></span></p>
                        <p><b><?= Translator::trans('view_appearance_police_color')?></b> <span style="background-color:<?= $appearance['police_color'];?>;color:<?= $appearance['police_color'];?> ">Couleur</span></p>
                        <p><b><?= Translator::trans('view_appearance_background')?></b> <span style="background-color:<?= $appearance['background'];  ?>;color:<?= $appearance['background'];  ?> "> Couleur   </span></p>
                        <p><b><?= Translator::trans('view_appearance_couleur_primary')?></b>  <span style="background-color:<?= $appearance['color_number_1'];?> ;color:<?= $appearance['color_number_1'];?>"> Couleur   </span></p>
                        <p><b><?= Translator::trans('view_appearance_couleur_secondary')?></b> <span style="background-color:<?= $appearance['color_number_2'];?>;color:<?= $appearance['color_number_2'];?>"> Couleur</span></p>
                        <!--                        <input style=" margin: .4rem; padding: 0 ; border-radius: 0;" type="color" id="head" name="head"-->
                        <!--                               value="#e66465">-->
                        <!--                        <label for="head">Head</label>-->
                    </div>


                </div>
                <a href="<?= \App\Core\Framework::getUrl('app_admin_appearance_edit',['appearanceId'=>$appearance['id']]);?>" style="display: flex;justify-content: center;" class="btn btn-primary-outline"><i style="display: flex;
    align-items: center;" class="fas fa-pen"></i> &nbsp;<?= Translator::trans('view_appearance_edit_template')?></a>
            </div>
        <?php } ?>

        <a href="<?= \App\Core\Framework::getUrl('app_admin_appearance_add');?>" class="menu" id="ajout-menu">
            <i  class="fas fa-plus-circle fa-10x"></i>
        </a>
    </div>

</section>

