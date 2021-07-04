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
                <a href="<?= \App\Core\Framework::getUrl('app_admin_menu_delete',['menuId' => $menu['id']]);?>" class="btn-close" onclick="return confirm('Voulez vous supprimer ce menu ?');"><i class="far fa-times-circle"></i></a>
            </div>
            <div class="title-menu">
                <h2> <?= $menu['name'];?> <a href="<?= \App\Core\Framework::getUrl('app_admin_menu_edit',['menuId' => $menu['id']]);?>" class="btn-edit"><i class="fas fa-pen"></i></a></h2>
                <h2> <?= $menu['price'];?> €</h2>
            </div>
            <hr class="separation-menu">
            <div class="list-plat">
             <?php foreach (($menuMeals ? $menuMeals : []) as $menuMeal) {
                  if($menuMeal['menuId']['id'] == $menu['id']){
                 ?>
                <div class="plat">
                    <h3><?= $menuMeal['mealId']['name']?></h3>
                    <ul>
                        <?php foreach (($mealFoodstuffs ? $mealFoodstuffs :[]) as $foodstuff){
                            if($menuMeal['mealId']['id'] == $foodstuff['mealId']['id']){?>
                                 <li><?= $foodstuff['foodstuffId']['name'];?></li>
                        <?php }
                        }?>
                    </ul>

                </div>
                <?php } }?>
            </div>
            <a href="<?= \App\Core\Framework::getUrl('app_admin_menu_meal_edit',['menuId' => $menu['id']]); ?>" style="display: flex;justify-content: center;" class="btn"><i style="display: flex;align-items: center;" class="fas fa-plus-circle"></i> &nbsp; Ajouter/Supprimer un Plat </a>
        </div>
<?php  }?>
        <a href="<?= \App\Core\Framework::getUrl('app_admin_menu_add');?>" class="menu" id="ajout-menu">
            <i  class="fas fa-plus-circle fa-10x"></i>
        </a>
    </div>
</section>
