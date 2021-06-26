<section class="content">
    <h1>Les plats</h1>

    <div class="content-menu">

        <?php foreach (($dishes ? $dishes : []) as $dishe) { ?>
        <div class="menu" >
            <div class="div-close">
                <a href="<?= \App\Core\Framework::getUrl('app_admin_dishes_delete',['idPlat' => $dishe['id']]);?>" class="btn-close" onclick="return confirm('Voulez vous supprimer ce plat ?');"><i class="far fa-times-circle"></i></a>
            </div>
            <div class="title-menu">
                <h2><?= $dishe['nom']; ?></h2>
                <h2> <?= $dishe['prix']; ?> €</h2>
            </div>
            <hr class="separation-menu">
            <div class="list-plat">
                <?php foreach (($ingredients ? $ingredients : []) as $ingredient) {
                    if($dishe['id'] == $ingredient['idPlat']){
                        foreach (($aliments ? $aliments : []) as $aliment){
                            if($aliment['id'] == $ingredient["idAliment"]){  ?>
                            <div class="plat">
                                <h3><?= $aliment['nom']; ?></h3>
                                <ul>
                                    <li>Prix : <?= $aliment['prix']; ?> €</li>
                                    <li>Stock : <?= $aliment['stock']; ?></li>
                                </ul>
                            </div>
                            <?php
                            }
                        }
                    }
                }
                ?>
            </div>
            <a href="<?= \App\Core\Framework::getUrl('app_admin_dishes_ingredient_edit',['idPlat' => $dishe['id']]);?>" style="display: flex;justify-content: center;" class="btn"><i style="display: flex;
    align-items: center;" class="fas fa-plus-circle"></i> &nbsp; Ajouter/Supprimer un Aliment</a>
        </div>
    <?php } ?>

        <a href="<?= \App\Core\Framework::getUrl('app_admin_dishes_add');?>" class="menu" id="ajout-menu">
            <i  class="fas fa-plus-circle fa-10x"></i>
        </a>
    </div>

</section>
