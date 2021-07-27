<?php
use \App\Repository\Restaurant\MenuRepository;
use \App\Repository\Restaurant\MenuMealRepository;
use \App\Models\Restaurant\MenuMeal;
use \App\Core\Framework;
$current_menu = null;
foreach ($menus as $menu) {
    if ($menu['id'] == $_GET['menuId']) {
        $current_menu = $menu;
    }
}
?>
<section class="section" style="padding: 2rem;">
    <?php  \App\Core\Helpers::debug($menu);  ?>
    <h1 style="font-size: 46px; margin: 0;" ><?= $menu['name'] ?></h1>
    <div class="menu-display">
<!--        <ul class="menu-display-ul">-->
<!--            --><?php //if($menus) { foreach ($menus as $menu) { ?>
<!--                <li class="menu-display-li">-->
<!--                    <img class="image-container" src="--><?//= Framework::getResourcesPath("uploads/".$menu["picture"]) ?><!--" alt="menu-picture"></img>-->
<!--                    <div class="menu-content">-->
<!--                        <a href="--><?//= Framework::getUrl('app_menus', ['menuId' => $menu['id']]);?><!--"><h1>--><?//= $menu['name'] ?><!--</h1></a>-->
<!--                        <p style="max-height: 100px; overflow: scroll">--><?//= $menu['description'] ?><!--</p>-->
<!--                        --><?php //if($menu_meals) { foreach ($menu_meals as $menu_meal) {
//                            if($menu_meal['menuId']['id'] == $menu['id']) { ?>
<!--                                <span> - --><?//= $menu_meal['mealId']['name']; ?><!--</span>-->
<!--                            --><?php //}
//                        } } ?>
<!--                        <span style="margin-top: 1rem;">Prix: --><?//= $menu['price'] ?><!--€</span>-->
<!--                    </div>-->
<!--                </li>-->
<!--            --><?php //} } ?>
<!--        </ul>-->
<!--    </div>-->
</section>