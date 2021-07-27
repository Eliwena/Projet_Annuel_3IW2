<?php
use \App\Core\Framework;
use \App\Services\Translator\Translator;
?>
<section class="section" style="padding: 2rem;">
    <h1 style="font-size: 46px; margin: 0; text-align: center;" ><?= $menu['name'] ?></h1>
    <div class="menu-display">
        <img class="image-container" src="<?= Framework::getResourcesPath("uploads/".$menu["picture"]) ?>" alt="menu-picture">
        <div class="menu-content" style="margin: 2rem auto 0rem auto; text-align: center;">
            <p style="max-height: 100px; overflow: scroll"><?= $menu['description'] ?></p>
            <?php if($menu_meals) { foreach ($menu_meals as $menu_meal) {
                if($menu_meal['menuId']['id'] == $menu['id']) { ?>
                    <div style="display: flex; justify-content: space-between; padding: 0 2rem;">
                        <span> - <?= $menu_meal['mealId']['name']; ?></span>
                        <span><?= Translator::trans('price_only')?>: <?= $menu_meal['mealId']['price']; ?></span>
                    </div>
                <?php }
            } } ?>
            <span style="margin-top: 1rem;"><?= Translator::trans('price_of_menu')?>: <?= $menu['price'] ?>€</span>
        </div>
    </div>
</section>
<section class="section" style="padding: 0 2rem;">
    <h1 style="margin: 0;">Les avis du menu</h1>
    <div style="max-width: 650px;">
        <ul style="padding: 0;">
            <?php if(!$menuReviews) { ?>
                <div>Aucun avis pour le moment...</div>
            <?php }
            foreach ($menuReviews ? $menuReviews : [] as $review) {
//                if(isset($menuReviews) && !empty($menuReviews) && is_array($menuReviews)) {
//                    $check = !in_array($review['id'], array_column(array_column($menuReviews, 'reviewId'), 'id'));
//                } else {
//                    $check = true;
//                }
                if(true) { ?>
                    <?php \App\Core\Helpers::debug($review) ?>
                    <li class="menu-display-li" style="background-color: var(--tertiary-color); border-radius: 15px; display: flex; align-items: flex-start;">
                        <div style="display: flex; flex-direction:column; align-items: center; margin: 1rem 0 1rem 1rem ;">
                            <img src="<?= 'https://www.gravatar.com/avatar/' . md5($review['userId']['email']) . '.jpg?s=80'; ?>" alt="profile-picture" class="profile-picture-review">
                            <span style="margin-top: 10px;"><?= $review['userId']['firstname']; ?></span>
                        </div>
                        <div style="display: flex; flex-direction: column; margin: 1rem; width: 100%; position: relative;">
                            <?php if(\App\Services\User\Security::isConnected()) { ?><i class="fas fa-duotone fa-flag" style="color: var(--danger-color); position: absolute; top: 0; right: 0; cursor: pointer;"></i><?php } ?>
                            <h1 style="margin: 0 0 0.6rem 0;"><?= $review['title']; ?></h1>
                            <p style="margin: 0;"><?= $review['text']; ?></p>
                            <div style="display: flex; justify-content: space-between; margin-top: 1rem;">
                                <span><?= Front::date($review['createAt'], 'd') . ' ' . Translator::trans(Front::date($review['createAt'], 'F')) . ' ' . Front::date($review['createAt'], 'Y') ?></span>
                                <span><?= \App\Services\Front\Front::generateStars($review['note'])?></span>
                            </div>
                        </div>
                    </li>
                    <?php
                }}
            ?>
        </ul>
    </div>
    <?php if(\App\Services\User\Security::isConnected()) { $form->render(); } ?>
</section>