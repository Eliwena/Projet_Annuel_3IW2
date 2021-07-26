<?php

use App\Core\FormValidator;

?>
<section class="section" style="padding: 2rem; margin-top: 90px">
    <h1 style="font-size: 46px; margin: 0;" >Ils parlent de nous!</h1>
    <div style="max-width: 650px;">
        <ul style="padding: 0;">
<!--            TO DO : BOUCLE FOR EACH ICI qui récupère tous les avis liés au restau      -->
            <li class="menu-display-li" style="background-color: var(--tertiary-color); border-radius: 15px; display: flex; align-items: flex-start;">
                <div style="display: flex; flex-direction:column; align-items: center; margin: 1rem 0 1rem 1rem ;">
                    <img src="https://zupimages.net/up/21/29/oqls.jpg" alt="profile-picture" class="profile-picture-review">
                    <span style="margin-top: 10px;">Julie</span>
                </div>
                <div style="display: flex; flex-direction: column; margin: 1rem; width: 100%;">
                    <h1 style="margin: 0 0 0.6rem 0;">Succulent</h1>
                    <p style="margin: 0;">Repas de famille dans un salon du restaurant privatisé pour l’occasion. Nous nous sommes régalés, du début à la fin du menu dégustation, et le service a été impeccable, malgré quelques petites maladresses que nous pardonnons bien volontiers. Mention spéciale pour le choix du plateau de fromage. Repas de famille dans un salon du restaurant privatisé pour l’occasion. Nous nous sommes régalés, du début à la fin du menu dégustation, et le service a été impeccable, malgré quelques petites maladresses que nous pardonnons bien volontiers. Mention spéciale pour le choix du plateau de fromage.</p>
                    <div style="display: flex; justify-content: space-between; margin-top: 1rem;">
                        <span>24 Juillet 2021</span>
                        <span><?= \App\Services\Front\Front::generateStars(5)?></span>
                    </div>
                </div>
            </li>
            <li class="menu-display-li" style="background-color: var(--tertiary-color); border-radius: 15px; display: flex; align-items: flex-start;">
                <div style="display: flex; flex-direction:column; align-items: center; margin: 1rem 0 1rem 1rem ;">
                    <img src="https://zupimages.net/up/21/29/ehp8.jpg" alt="profile-picture" class="profile-picture-review">
                    <span style="margin-top: 10px;">Pierre</span>
                </div>
                <div style="display: flex; flex-direction: column; margin: 1rem; width: 100%;">
                    <h1 style="margin: 0 0 0.6rem 0;">A refaire</h1>
                    <p style="margin: 0;">Déjeuner extraordinaire ! L’échaînement des plats est une musique ! Tout est délicieux , et le service est impeccable</p>
                    <div style="display: flex; justify-content: space-between; margin-top: 1rem;">
                        <span>26 Juillet 2021</span>
                        <span><?= \App\Services\Front\Front::generateStars(4)?></span>
                    </div>
                </div>
            </li>

        </ul>
    </div>
    <?php
    $form_review = new \App\Form\Admin\Review\ReviewForm();
    echo $form_review->render();
    ?>
    <?php if(isset($_POST)){
        $validator = FormValidator::validate($form_review, $_POST);

        if($validator) {
            \App\Core\Helpers::debug($_POST);
        } else {
            echo "Veuillez remplir le formulaire comme il faut";
        }
    } ?>
<!--    TO DO : FAIRE LA ROUTE QUI PERMET DE PUBLIER UN AVIS et l'ajouter au href du bouton ici  -->
    <button id="button_publish_review" class="btn btn-primary-outline" style="margin-top: 1rem;">Laisser un avis</button>
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
    $('#button_publish_review').click(function (e) {
        $(' <li class="menu-display-li" style="background-color: var(--tertiary-color); border-radius: 15px; display: flex; align-items: flex-start;"> <div style="display: flex; flex-direction:column; align-items: center; margin: 1rem 0 1rem 1rem ;"> <img src="<?= 'https://www.gravatar.com/avatar/' . md5($_user->getEmail()) . '.jpg?s=80'; ?>" alt="profile-picture" class="profile-picture-review"> <span style="margin-top: 10px;"><?= $_user->getFirstname()?></span> </div> <div style="display: flex; flex-direction: column; margin: 1rem; width: 100%"> <h1 style="margin: 0 0 0.6rem 0;"><?= $_POST['title'] ?></h1> <p style="margin: 0;"><?= $_POST['text'] ?></p> <div style="display: flex; justify-content: space-between; margin-top: 1rem;"> <span>26 Juillet 2021</span> <span><?= \App\Services\Front\Front::generateStars($_POST['note'])?></span> </div> </div>' +
            '</li>').insertAfter($("li").last());
    });
</script>