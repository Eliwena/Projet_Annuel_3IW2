<?php

use App\Core\FormValidator;
use App\Services\Front\Front;
use \App\Services\Translator\Translator;

?>
<section class="section" style="padding: 2rem; margin-top: 90px">
    <h1 style="font-size: 46px; margin: 0;" ><?= Translator::trans('reviews_of_restaurant') ?></h1>
    <div style="max-width: 650px;">
        <ul style="padding: 0;">
            <?php
            foreach ($reviews as $review) {
                if(isset($menuReviews) && !empty($menuReviews) && is_array($menuReviews)) {
                    $check = !in_array($review['id'], array_column(array_column($menuReviews, 'reviewId'), 'id'));
                } else {
                    $check = true;
                }
                if($check) { ?>

                    <li class="menu-display-li" style="background-color: var(--tertiary-color); border-radius: 15px; display: flex; align-items: flex-start;">
                        <div style="display: flex; flex-direction:column; align-items: center; margin: 1rem 0 1rem 1rem ;">
                            <img src="<?= 'https://www.gravatar.com/avatar/' . md5($review['userId']['email']) . '.jpg?s=80'; ?>" alt="profile-picture" class="profile-picture-review">
                            <span style="margin-top: 10px;"><?= $review['userId']['firstname']; ?></span>
                        </div>
                        <div style="display: flex; flex-direction: column; margin: 1rem; width: 100%; position: relative;">
                            <i class="fas fa-duotone fa-flag" style="color: var(--danger-color); position: absolute; top: 0; right: 0; cursor: pointer;"></i>
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
    <?= $form->render(); ?>
</section>
<style>
    .profile-picture-review{
        border-radius: 50%;
        width: 100px;
    }
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

<script>
    $("#form_review").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        const form = $(this);
        const url = form.attr('action');
        const type = form.attr('method');

        $.ajax({
            type: type,
            url: url,
            data: form.serialize(),
            success: function(response) {
                console.log(response);
                if(response.status === 'success') {
                    $('#form_review').remove();
                    $('<li class="menu-display-li" style="background-color: var(--tertiary-color); border-radius: 15px; display: flex; align-items: flex-start;"><div style="display: flex; flex-direction:column; align-items: center; margin: 1rem 0 1rem 1rem ;"><img src="<?= 'https://www.gravatar.com/avatar/' . md5($_user->getEmail()) . '.jpg?s=80'; ?>" alt="profile-picture" class="profile-picture-review"><span style="margin-top: 10px;"><?= $_user->getFirstname() ?></span></div><div style="display: flex; flex-direction: column; margin: 1rem; width: 100%; position: relative"><i class="fas fa-duotone fa-flag" style="color: var(--danger-color); position: absolute; top: 0; right: 0; cursor: pointer;"></i> <h1 style="margin: 0 0 0.6rem 0;">' + response.data.title + '</h1> <p style="margin: 0;">' + response.data.text + '</p> <div style="display: flex; justify-content: space-between; margin-top: 1rem;"> <span>' + response.data.create_at + '</span> <span>'+ response.data.note +'</span></div></div>' +
                        '</li>').insertAfter($("li").last());
                    $('.alert').remove();
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

</script>




