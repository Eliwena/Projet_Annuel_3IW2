<?php
use App\Core\Framework;
use App\Services\Front\Front;
use App\Services\Translator\Translator;
use \App\Services\User\Security;
?>
<section class="section first-section" style="position: relative;">
    <h1 style="font-size: 126px; font-family: 'Great Vibes', cursive; text-align: center"><?= Front::getSiteName() ?? 'RestoGuest'; ?></h1>
    <button class="button-reservation show-btn">
        <span style="color: var(--white-color); font-size: 18px;"><?= Translator::trans('booking') ?></span>
    </button>

</section>
<section class="section" style="padding: 2rem; z-index: 10;">
    <h1 style="font-size: 46px; margin: 0;" >Les menus</h1>
    <div class="menu-display">
        <ul>
<!--            TO DO : BOUCLE FOR QUI N'AFFICHE QUE 3 MENUS  -->
            <?php if($menus) { foreach ($menus as $menu) { ?>
                <li class="menu-display-li">
                    <img class="image-container" src="<?= Framework::getResourcesPath("uploads/".$menu["picture"]) ?>" alt="menu-picture"></img>
                    <div class="menu-content">
                        <h1><?= $menu['name'] ?></h1>
                        <p style="max-height: 100px; overflow: scroll"><?= $menu['description'] ?></p>
                        <?php if($menu_meals) { foreach ($menu_meals as $menu_meal) {
                            if($menu_meal['menuId']['id'] == $menu['id']) { ?>
                                <span> - <?= $menu_meal['mealId']['name']; ?></span>
                            <?php }
                        } } ?>
                        <span style="margin-top: 1rem;">Prix: <?= $menu['price'] ?>€</span>
                    </div>
                </li>
            <?php } } ?>
        </ul>
    </div>
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
