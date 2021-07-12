<section class="content">
    <h1>Les plats</h1>
    <?php $this->include('error.tpl') ?>
    <div class="content-menu">

        <?php foreach (($meals ? $meals : []) as $mealItem) { ?>
            <div class="menu" >
                <div class="div-close">
                    <a href="<?= \App\Core\Framework::getUrl('app_admin_meal_delete',['mealId' => $mealItem['id']]);?>" class="btn-close" onclick="return confirm('Voulez vous supprimer ce plat ?');"><i class="far fa-times-circle"></i></a>
                </div>
                <div class="title-menu">
                    <h2><?= $mealItem['name']; ?> <a href="<?= \App\Core\Framework::getUrl('app_admin_meal_edit',['mealId' => $mealItem['id']]);?>" class="btn-edit"><i class="fas fa-pen"></i></a></h2>
                    <h2> <?= $mealItem['price']; ?> €</h2>
                </div>
                <hr class="separation-menu">
                <div class="list-plat">
                    <?php
                    foreach (($mealFoodstuffs ? $mealFoodstuffs : []) as $foodstuffItem) {
                        if(isset($foodstuffItem['mealId']['id']) && $foodstuffItem['mealId']['id'] == $mealItem['id']){?>
                            <div class="plat">
                                <h3><?= $foodstuffItem['foodstuffId']['name'] ; ?></h3>
                                <ul>
                                    <li>Prix : <?= $foodstuffItem['foodstuffId']['price']; ?> €</li>
                                    <li>Stock : <?= $foodstuffItem['foodstuffId']['stock']; ?></li>
                                </ul>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <a href="<?= \App\Core\Framework::getUrl('app_admin_meal_foodstuff_edit',['mealId' => $mealItem['id']]);?>" style="display: flex;justify-content: center;" class="btn btn-primary-outline"><i style="display: flex;
    align-items: center;" class="fas fa-plus-circle"></i> &nbsp; Ajouter/Supprimer un Aliment</a>
            </div>
        <?php } ?>

        <a href="<?= \App\Core\Framework::getUrl('app_admin_meal_add');?>" class="menu" id="ajout-menu">
            <i  class="fas fa-plus-circle fa-10x"></i>
        </a>
    </div>

</section>
