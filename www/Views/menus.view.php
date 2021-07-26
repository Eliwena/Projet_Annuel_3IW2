<?php
use \App\Repository\Restaurant\MenuRepository;
use \App\Repository\Restaurant\MenuMealRepository;
use \App\Models\Restaurant\MenuMeal;
use \App\Core\Framework;

$menus = \App\Repository\Restaurant\MenuRepository::getMenus();
$menu_meals = \App\Repository\Restaurant\MenuMealRepository::getMeals();
?>
<section class="section" style="padding: 2rem; margin-top: 90px">
    <h1 style="font-size: 46px; margin: 0;" >Les menus</h1>
    <div class="menu-display">
        <ul>
            <?php foreach ($menus as $menu) {?>
                <li class="menu-display-li reverse">
                    <img class="image-container" src="<?= Framework::getResourcesPath("uploads/".$menu["picture"]) ?>" alt="menu-picture"></img>
                    <div style="display: flex; flex-direction: column; margin: 0 3rem; max-width: 400px ">
                        <h1><?= $menu['name'] ?></h1>
                        <p><?= $menu['description'] ?></p>
                        <?php
                        foreach ($menu_meals as $menu_meal) {
                            if($menu_meal['menuId']['id'] == $menu['id']) { ?>
                                <span> - <?= $menu_meal['mealId']['name']; ?></span>
                            <?php }
                        }
                        ?>
                        <span style="margin-top: 1rem;">Prix: <?= $menu['price'] ?>€</span>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</section>


<?php
//$menus = \App\Repository\Restaurant\MenuRepository::getMenus();
//$menu_meals = \App\Repository\Restaurant\MenuMealRepository::getMeals();
//
//\App\Core\Helpers::debug($menus);

//foreach ($menus as $menu) {
//    //affichage menu
//    \App\Core\Helpers::debug($menu);
//    ### generer image
//    \App\Core\Helpers::debug(Framework::getResourcesPath("uploads/".$menu["picture"]));
//    foreach ($menu_meals as $menu_meal) {
//        if($menu_meal['menuId']['id'] == $menu['id']) {
//            //affichage plat dans le menu
//            \App\Core\Helpers::debug($menu_meal['mealId']);
//        }
//    }
//}
?>
