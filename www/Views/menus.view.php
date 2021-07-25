<?php
use \App\Repository\Restaurant\MenuRepository;
use \App\Repository\Restaurant\MenuMealRepository;
use \App\Models\Restaurant\MenuMeal;
use \App\Core\Framework;
?>
<section class="section" style="padding: 2rem; margin-top: 90px">
    <h1 style="font-size: 46px; margin: 0;" >Les menus</h1>
    <div class="menu-display">
        <ul>
            <li class="menu-display-li">
                <div class="image-container"></div>
                <div style="display: flex; flex-direction: column; margin: 0 1rem; max-width: 400px ">
                    <p>Pavé de boeuf sauce maison sur lit de pommes de terre de noirmoutier</p>
                    <span>Prix: 15€</span>
                </div>
            </li>
            <li class="menu-display-li reverse">
                <div class="image-container"></div>
                <div style="display: flex; flex-direction: column; margin: 0 1rem; max-width: 400px ">
                    <p>Pavé de boeuf sauce maison sur lit de pommes de terre de noirmoutier</p>
                    <span>Prix: 15€</span>
                </div>
            </li>
        </ul>
    </div>
</section>


<?php
$menus = \App\Repository\Restaurant\MenuRepository::getMenus();
$menu_meals = \App\Repository\Restaurant\MenuMealRepository::getMeals();

foreach ($menus as $menu) {
    //affichage menu
    \App\Core\Helpers::debug($menu);
    ### generer image
    \App\Core\Helpers::debug(Framework::getResourcesPath("uploads/".$menu["picture"]));
    foreach ($menu_meals as $menu_meal) {
        if($menu_meal['menuId']['id'] == $menu['id']) {
            //affichage plat dans le menu
            \App\Core\Helpers::debug($menu_meal['mealId']);
        }
    }
}
?>
