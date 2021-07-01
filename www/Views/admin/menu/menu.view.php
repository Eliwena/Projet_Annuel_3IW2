<section class="content">
    <h1>Les Menu</h1>

    <div class="content-menu">
        <?php //todo lister les menus ?>

                <?php
                //\App\Core\Helpers::debug($menus);

                foreach (($menus ? $menus : []) as $menu) {
?>
        <div class="menu" >
            <div class="div-close">
                <a href="" class="btn-close" onclick="return confirm('Voulez vous supprimer ce plat ?');"><i class="far fa-times-circle"></i></a>
            </div>
            <div class="title-menu">
                <h2> <?= $menu['nom'];?> <a href="" class="btn-edit"><i class="fas fa-pen"></i></a></h2>
                <h2> <?= $menu['prix'];?> €</h2>
            </div>
            <hr class="separation-menu">
            <div class="list-plat">
             <?php foreach (($menuPlats ? $menuPlats : []) as $menuPlat) {
                  if($menuPlat['idMenu']['id'] == $menu['id']){
                 ?>
                <div class="plat">
                    <h3><?= $menuPlat['idPlat']['nom']?></h3>
                    <ul>
                        <?php foreach (($plats ? $plats :[]) as $plat){
                            if($menuPlat['idPlat']['id'] == $plat['idPlat']['id']){?>
                                 <li><?= $plat['idAliment']['nom'];?></li>
                        <?php }
                        }?>
                    </ul>

                </div>
                <?php } }?>
            </div>
            <a href="" style="display: flex;justify-content: center;" class="btn"><i style="display: flex;
    align-items: center;" class="fas fa-plus-circle"></i> &nbsp; Ajouter/Supprimer un Plat / Ingredient</a>
        </div>
<?php  }?>
        <a href="<?= \App\Core\Framework::getUrl('app_admin_menu_add');?>" class="menu" id="ajout-menu">
            <i  class="fas fa-plus-circle fa-10x"></i>
        </a>
    </div>
</section>
