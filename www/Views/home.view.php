<?php
use App\Core\Framework;
use App\Services\Front\Front;
use App\Services\Translator\Translator;
use \App\Services\User\Security;
function clean($key) {$key = htmlspecialchars($key);$key = strip_tags($key);return $key;}
?>
<section class="section first-section" style="position: relative;">
    <h1 style="font-size: 126px; font-family: 'Great Vibes', cursive; text-align: center"><?= Front::getSiteName() ?? 'RestoGuest'; ?></h1>
    <button class="button-reservation show-btn">
        <span style="color: var(--white-color); font-size: 18px;"><?= Translator::trans('booking') ?></span>
    </button>

</section>
<section class="section" style="padding: 2rem; z-index: 10;">
    <h1 style="font-size: 46px; margin: 0;" >Ils sont venu chez nous ! </h1>

<!--            TO DO : Affichage 10 derniers commentaires  -->
    <div class="section-review-home">
        <div class="container-review">
        <div class="wrapper">
            <?php if ($reviews) $i = 1; { foreach ($reviews as $review ) { ?>

            <div class="card-review">
                <div class="card-thumb-review">
                    <img src="<?= 'https://www.gravatar.com/avatar/' . md5(App\Repository\Users\UserRepository::getUser(clean($review['userId']))->getEmail()) . '.jpg?s=80'; ?>" alt="profile-picture" class="client-img">
                    <span class="client-name"><?= App\Repository\Users\UserRepository::getUser(clean($review['userId']))->getFirstname(); ?></span>
                </div>
                <div class="card-body-review">
                    <h1><?= clean($review['title']); ?></h1>
                    <p class="review-body"><?= clean($review['text']); ?></p>
                    <div class="rating">
                        <span class="star"><?= \App\Services\Front\Front::generateStars(clean($review['note']))?></span>
                    </div>
                </div>
            </div>
            <?php $i++; }} ?>
        </div>
        <?php if($reviews) {
            echo '<div class="indicators">';
            for($u=1; $u<$i;$u++) {
                if($u == 1) { echo '<button class="active"></button>'; } else { echo '<button></button>';}
            }
        }
        ?>
    </div>
    </div>



<!--    <div class="menu-display-li" style="background-color: var(--tertiary-color); border-radius: 15px; display: flex; align-items: flex-start;">-->
<!--        <div style="display: flex; flex-direction:column; align-items: center; margin: 1rem 0 1rem 1rem ;">-->
<!--        </div>-->
<!--        <div style="display: flex; flex-direction: column; margin: 1rem; width: 100%; position: relative;">-->
<!--            <h1 style="margin: 0 0 0.6rem 0;">--><?//= $review['title']; ?><!--</h1>-->
<!--            <p style="margin: 0;">--><?//= $review['text']; ?><!--</p>-->
<!--            <div style="display: flex; justify-content: space-between; margin-top: 1rem;">-->
<!--                <span>--><?//= Front::date($review['createAt'], 'd') . ' ' . Translator::trans(Front::date($review['createAt'], 'F')) . ' ' . Front::date($review['createAt'], 'Y') ?><!--</span>-->
<!--                <span>--><?//= \App\Services\Front\Front::generateStars($review['note'])?><!--</span>-->
<!--            </div>-->
<!--        </div>-->




    <!--            --><?php //if($menus) { foreach ($menus as $menu) { ?>
<!--                <li class="menu-display-li">-->
<!--                    <img class="image-container" src="--><?//= Framework::getResourcesPath("uploads/".$menu["picture"]) ?><!--" alt="menu-picture"></img>-->
<!--                    <div class="menu-content">-->
<!--                        <h1>--><?//= $menu['name'] ?><!--</h1>-->
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

</section>
<section class="section" style="margin-top: 1rem; height: 40vh;">
    <?php
        $address = Front::getAddress() ? Front::getAddress() : '242 rue du faubourg saint antoine PARIS';
        if(isset($address)){
            $address = str_replace(" ", "+", $address);
            ?>
            <iframe width="100%" height="100%" src="https://maps.google.com/maps?q=<?php echo $address; ?>&output=embed"></iframe>
            <?php
        }
    ?>
</section>
<section class="contact-section">
    <div style="display: flex; flex-direction: column;">
        <h1><?= Translator::trans('contact_us') ?></h1>
        <address><?= Front::getAddress() ? Front::getAddress() : '242 rue du faubourg saint antoine PARIS'; ?></address>
        <span><?= Front::getPhoneNumber() ? Front::getPhoneNumber() : '01 23 45 67 89' ?></span>
        <span><?= Front::getContactEmail() ? Front::getContactEmail() : 'contact@restoGuest.com' ?></span>
    </div>
    <div style="display: flex; flex-direction: column;">
        <div style="display: flex; align-items: center; margin-bottom: 0.4rem">
            <img src="<?= Framework::getResourcesPath('images/facebook-logo.svg'); ?>" alt="facebook-logo" class="image-network"/>
            <span><?= empty(Front::getSocialLinkFacebook()) ? 'facebook.com/restoGuest' : Front::getSocialLinkFacebook()?></span>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 0.4rem">
            <img src="<?= Framework::getResourcesPath('images/instagram-logo.svg'); ?>" alt="instagram-logo" class="image-network"/>
            <span><?= Front::getSocialLinkInstagram() ? Front::getSocialLinkInstagram() : 'instagram.com/restoGuest'?></span>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 0.4rem">
            <img src="<?= Framework::getResourcesPath('images/tiktok-logo.svg'); ?>" alt="tiktok-logo" class="image-network"/>
            <span><?= Front::getSocialLinkTikTok() ? Front::getSocialLinkTikTok() :'tiktok.com/restoGuest'?></span>
        </div>
        <div style="display: flex; align-items: center">
            <img src="<?= Framework::getResourcesPath('images/snapchat-logo.svg'); ?>" alt="snapchat-logo" class="image-network"/>
            <span><?= Front::getSocialLinkSnapChat() ? Front::getSocialLinkSnapChat() : 'snapchat.com/restoGuest' ?></span>
        </div>
    </div>
</section>

<div class="modal">
    <div class="top-content">
        <div class="left-text">
            <?= Translator::trans('booking') ?>
        </div>
        <span class="close-icon"><i class="fas fa-times"></i></span>
    </div>
    <?php if(Security::isConnected()) {?>
    <div class="bottom-content">
        <div>
            <div class="text">
                <?= Translator::trans('people') ?>
            </div>
            <div class="slider-reservation">
                <img src="<?= Framework::getResourcesPath('images/arrow-left.svg'); ?>" height="25px" width="25px" alt="arrow" />
                <div style="display: flex; justify-content: space-between; width: 360px; overflow: scroll;" >
                    <?php for($i=1; $i<=(Front::getMaxNumberOfPeopleReserv() ? Front::getMaxNumberOfPeopleReserv() : 10 ) ; $i++ ) { ?>
                        <label class="button-reservation-setter" data="<?= $i ?>" onclick="selectNumbPers(this);">
                            <input type="radio" name="pers" value="<?= $i ?>" />
                            <div><?= $i ?></div>
                        </label>
                    <?php } ?>
                </div>
                <img src="<?= Framework::getResourcesPath('images/arrow-right.svg'); ?>" height="25px" width="25px" alt="arrow" />
            </div>
        </div>
        <div id="select-date-reservation">
            <div class="text" style="margin-top: 1rem;">
                <?= Translator::trans('date') ?>
            </div>
            <div class="slider-reservation">
                <img src="<?= Framework::getResourcesPath('images/arrow-left.svg'); ?>" height="25px" width="25px" alt="arrow" />
                <div style="display: flex; justify-content: space-between; width: 360px; overflow: scroll;" >
                    <label class="button-reservation-setter" data="<?= Front::date('now', 'd-m'); ?>" onclick="selectDate(this);">
                        <input type="radio" name="date" value="<?= Front::date('now', 'd-m'); ?>" />
                        <div><?= Translator::trans('today') ?></div>
                    </label>
                    <label class="button-reservation-setter" data="<?= Front::date('now', 'd-m', '+1 day'); ?>" onclick="selectDate(this);">
                        <input type="radio" name="date" value="<?= Front::date('now', 'd-m', '+1 day'); ?>" />
                        <div><?= Translator::trans('tomorrow') ?></div>
                    </label>
                    <?php for($j=2; $j<=7; $j++) { ?>
                        <label class="button-reservation-setter" data="<?= Front::date('now', 'd-m', "+$j day"); ?>" onclick="selectDate(this);">
                            <input type="radio" name="date" value="<?= Front::date('now', 'd-m', "+$j day"); ?>" />
                            <div><?= Front::date('now', 'd-m', "+$j day"); ?></div>
                        </label>
                    <?php } ?>
                </div>
                <img src="<?= Framework::getResourcesPath('images/arrow-right.svg'); ?>" height="25px" width="25px" alt="arrow" />
            </div>
        </div>
        <div id="select-hour-reservation">
            <div class="text" style="margin-top: 1rem;">
                <?= Translator::trans('hour') ?>
            </div>
            <div class="slider-reservation">
                <img src="<?= Framework::getResourcesPath('images/arrow-left.svg'); ?>" height="25px" width="25px" alt="arrow" />
                <div style="display: flex; justify-content: space-between; width: 360px; overflow: scroll;" >
                    <?php for($k=0; $k<4; $k++) {
                        $sum = $k * 30; ?>
                        <label class="button-reservation-setter" data="<?= Front::date('11:30', 'H:i', "+$sum minutes"); ?>" onclick="selectHour(this);">
                            <input type="radio" name="hour" value="<?= Front::date('11:30', 'H:i', "+$sum minutes"); ?>" />
                            <div><?= Front::date('11:30', 'H:i', "+$sum minutes"); ?></div>
                        </label>
                    <?php } ?>
                    <?php for($k=0; $k<3; $k++) {
                        $sum = $k * 30; ?>
                        <label class="button-reservation-setter" data="<?= Front::date('19:30', 'H:i', "+$sum minutes") ?>" onclick="selectHour(this);">
                            <input type="radio" name="hour" value="<?= Front::date('19:30', 'H:i', "+$sum minutes") ?>" />
                            <div><?= Front::date('19:30', 'H:i', "+$sum minutes"); ?></div>
                        </label>
                    <?php } ?>
                </div>
                <img src="<?= Framework::getResourcesPath('images/arrow-right.svg'); ?>" height="25px" width="25px" alt="arrow" />
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; margin-top: 1.5rem;">
            <div class="close-btn">
                <button><?= Translator::trans('cancel') ?></button>
            </div>
            <div class="accept-btn">
                <button><?= Translator::trans('confirmation') ?></button>
            </div>
        </div>
    </div>
    <?php } else { ?>
    <div class="bottom-content">
        <h1 style="text-align: center"><?= Translator::trans('you_need_to_be_connected') ?></h1>
    </div>
    <?php } ?>
</div>
<script>
    const wrapper = document.querySelector('.wrapper');
    const indicators = [...document.querySelectorAll('.indicators button')];

    let currentTestimonial = 0;
    indicators.forEach((item, i)=>{
        item.addEventListener('click',()=>{
            indicators[currentTestimonial].classList.remove('active');
            wrapper.style.marginLeft = `-${100 * i}%`;
            item.classList.add('active');
            currentTestimonial=i;
            console.log(currentTestimonial);

        })
    })

</script>
<script>
    let numPers = 0;
    let date = '';
    let service = '';
    let hour = '';
    $('.button-reservation').click(function(){
        $('.modal').toggleClass("show");
        $('.button-reservation').addClass("disabled");
    });
    $('.close-icon').click(function(){
        $('.modal').toggleClass("show");
        $('.button-reservation').removeClass("disabled");
    });
    $('.close-btn').click(function(){
        $('.modal').toggleClass("show");
        $('.button-reservation').removeClass("disabled");
    });
    function selectNumbPers (currentDiv){
        numPers = $(currentDiv).attr("data");
    }
    function selectDate (currentDiv){
        date = $(currentDiv).attr("data");
    }
    function selectService (currentDiv){
        service = $(currentDiv).attr("data");
    }
    function selectHour (currentDiv){
        hour = $(currentDiv).attr("data");
    }
    $('.accept-btn').click(function(){
        $('.modal').toggleClass("show");
        $('.button-reservation').removeClass("disabled");
        console.log(numPers, date,  service, hour);
        $.ajax({
            url: "http://localhost/reservation/add",
            method: "POST",
            data : {
                numPers : numPers,
                date : date,
                service : service,
                hour : hour,
            },
            dataType : "json",
            success : function(data){
                console.log('réservation envoyée', data);
            },
            error : function (data){
                console.log(data);
            }
        })
    });
</script>

<style type="text/css">
    .first-section{
        justify-content: center;
        height: 100vh;
        background-image: url(<?= Framework::getResourcesPath('images/restaurantbg.svg'); ?>);
        background-size: cover;
        background-position: right bottom;
        color: white;
    }
</style>

