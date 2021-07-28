<?php
use \App\Core\Framework;
use \App\Services\Translator\Translator;
use \App\Services\Front\Front;
?>
<section class="section" style="padding: 2rem;">
    <h1 style="font-size: 46px; margin: 0; text-align: center;" ><?= $menu->getName() ?></h1>
    <div class="menu-display">
        <img class="image-container" src="<?= Framework::getResourcesPath("uploads/".$menu->getPicture()) ?>" alt="menu-picture">
        <div class="menu-content" style="margin: 2rem auto 0rem auto; text-align: center;">
            <p style="max-height: 100px; overflow: scroll"><?= $menu->getDescription() ?></p>
            <?php foreach ($menuMeals ? $menuMeals : [] as $menuMeal) { ?>
                <div style="display: flex; justify-content: space-between; padding: 0 2rem;">
                    <span> - <?= $menuMeal['mealId']['name']; ?></span>
                    <span><?= Translator::trans('price_only')?>: <?= $menuMeal['mealId']['price']; ?>€</span>
                </div>
            <?php } ?>
            <span style="margin-top: 1rem;"><?= Translator::trans('price_of_menu')?>: <?= $menu->getPrice() ?>€</span>
        </div>
    </div>
</section>

<section class="section" style="padding: 0 2rem 2rem 2rem;">
    <h1 style="margin: 0;"><?= Translator::trans('view_menu_review_title')?></h1>
    <div style="max-width: 650px; width: 100%;">
        <ul style="padding: 0;">
            <?php if(!$menuReviews) { ?>
                <div id="info-no-review"><?= Translator::trans('view_menu_review_none')?></div>
            <?php }  ?>
            <?php
            foreach($menuReviews ? $menuReviews : [] as $review)    {
                $user = \App\Repository\Users\UserRepository::getUser($review['reviewId']['userId']);
                ?>
                    <li class="menu-display-li" style="background-color: var(--tertiary-color); border-radius: 15px; display: flex; align-items: flex-start;">
                        <div style="display: flex; flex-direction:column; align-items: center; margin: 1rem 0 1rem 1rem ;">
                            <img src="<?= 'https://www.gravatar.com/avatar/' . md5($user->getEmail()) . '.jpg?s=80'; ?>" alt="profile-picture" class="profile-picture-review">
                            <span style="margin-top: 10px;"><?= $user->getFirstname(); ?></span>
                        </div>
                        <div style="display: flex; flex-direction: column; margin: 1rem; width: 100%; position: relative;">
                            <?php if(\App\Services\User\Security::isConnected()) { ?><i class="fas fa-duotone fa-flag" style="color: var(--danger-color); position: absolute; top: 0; right: 0; cursor: pointer;"></i><?php } ?>
                            <h1 style="margin: 0 0 0.6rem 0;"><?= $review['reviewId']['title']; ?></h1>
                            <p style="margin: 0;"><?= $review['reviewId']['text']; ?></p>
                            <div style="display: flex; justify-content: space-between; margin-top: 1rem;">
                                <span><?= Front::date($review['reviewId']['createAt'], 'd') . ' ' . Translator::trans(Front::date($review['reviewId']['createAt'], 'F')) . ' ' . Front::date($review['reviewId']['createAt'], 'Y') ?></span>
                                <span><?= \App\Services\Front\Front::generateStars($review['reviewId']['note'])?></span>
                            </div>
                        </div>
                    </li>
                    <?php
                }
            ?>
            <div id="info-no-review"></div>
        </ul>
    </div>
    <div style="background-color: var(--tertiary-color); width: 100%; max-width: 650px; border-radius: 15px;">
        <?php if(\App\Services\User\Security::isConnected()) { $form->render(); } ?>
    </div>
</section>
<script>
    <?php if(\App\Services\User\Security::isConnected()) { ?>
    $("#form_review").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        const form = $(this);
        const url = form.attr('action');
        const type = form.attr('method');
        console.log(form);
        $.ajax({
            type: type,
            url: url,
            data: form.serialize(),
            success: function(response) {
                console.log(response);
                if(response.status === 'success') {
                    $('#form_review').remove();
                    if($('#info-no-review')){
                        $('<li class="menu-display-li" style="background-color: var(--tertiary-color); border-radius: 15px; display: flex; align-items: flex-start;"><div style="display: flex; flex-direction:column; align-items: center; margin: 1rem 0 1rem 1rem ;"><img src="<?= 'https://www.gravatar.com/avatar/' . md5($_user->getEmail()) . '.jpg?s=80'; ?>" alt="profile-picture" class="profile-picture-review"><span style="margin-top: 10px;"><?= $_user->getFirstname() ?></span></div><div style="display: flex; flex-direction: column; margin: 1rem; width: 100%; position: relative"><i class="fas fa-duotone fa-flag" style="color: var(--danger-color); position: absolute; top: 0; right: 0; cursor: pointer;"></i> <h1 style="margin: 0 0 0.6rem 0;">' + response.data.title + '</h1> <p style="margin: 0;">' + response.data.text + '</p> <div style="display: flex; justify-content: space-between; margin-top: 1rem;"> <span>' + response.data.create_at + '</span> <span>'+ response.data.note +'</span></div></div>' +
                            '</li>').insertAfter($("#info-no-review").last());
                        $('.alert').remove();
                        $('#info-no-review').remove();
                    } else {
                        $('<li class="menu-display-li" style="background-color: var(--tertiary-color); border-radius: 15px; display: flex; align-items: flex-start;"><div style="display: flex; flex-direction:column; align-items: center; margin: 1rem 0 1rem 1rem ;"><img src="<?= 'https://www.gravatar.com/avatar/' . md5($_user->getEmail()) . '.jpg?s=80'; ?>" alt="profile-picture" class="profile-picture-review"><span style="margin-top: 10px;"><?= $_user->getFirstname() ?></span></div><div style="display: flex; flex-direction: column; margin: 1rem; width: 100%; position: relative"><i class="fas fa-duotone fa-flag" style="color: var(--danger-color); position: absolute; top: 0; right: 0; cursor: pointer;"></i> <h1 style="margin: 0 0 0.6rem 0;">' + response.data.title + '</h1> <p style="margin: 0;">' + response.data.text + '</p> <div style="display: flex; justify-content: space-between; margin-top: 1rem;"> <span>' + response.data.create_at + '</span> <span>'+ response.data.note +'</span></div></div>' +
                            '</li>').insertAfter($("li").last());
                        $('.alert').remove();
                    }
                } else {
                    if(response.message) {
                        for(const i of response.message) {
                            $('<div class="alert alert-error"><h4><b>' + i.title + ' :</b> ' + i.message + '</h4><a class="close" onclick="$(this).parent().fadeOut();">&times;</a></div>').insertAfter($("li").last());
                        }
                    }
                }

            }
        });
    });
    <?php } ?>
</script>
<style>
    #form_review{
        background-color: var(--tertiary-color);
        border-radius: 10px;
        width: 100%;
        max-width: 650px;
        padding: 1rem;
    }
    .form_group{
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        align-items: center;
        width: 100%;
    }
    .form_input{
        border-radius: 10px;
    }
    #note {
        width: 60px;
    }
    #text{
        height: 100px;
    }
</style>