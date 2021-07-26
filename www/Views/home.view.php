<?php
use App\Core\Framework;
use App\Services\Front\Front;
use App\Services\Translator\Translator;
?>
<section class="section first-section" style="position: relative;">
    <h1 style="font-size: 126px; font-family: 'Great Vibes', cursive; text-align: center"><?= Front::getSiteName() ?? 'RestoGuest'; ?></h1>
    <button class="button-reservation show-btn">
        <span style="color: var(--white-color); font-size: 18px;"><?= Translator::trans('booking') ?></span>
    </button>
    <nav style="position: absolute; top: 90px; right: 10px;">
        <ul id="list-pages">
            <li><a href="<?= Framework::getUrl('app_contact') ?>"><?= Translator::trans('contact') ?></a></li>
            <li><a href="<?= Framework::getUrl('app_reviews') ?>"><?= Translator::trans('reviews') ?></a></li>
            <li><a href="<?= Framework::getUrl('app_menus') ?>"><?= Translator::trans('the_menus') ?></a></li>
        </ul>
    </nav>
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
    <div class="bottom-content">
        <div>
            <div class="text">
                <?= Translator::trans('people') ?>
            </div>
            <div class="slider-reservation">
                <img src="<?= Framework::getResourcesPath('images/arrow-left.svg'); ?>" height="25px" width="25px" alt="arrow" />
                <div style="display: flex; justify-content: space-between; width: 360px; overflow: scroll;" >
    <!-- ************  TO DO BOUCLE FOR (DEMANDER LA COMPOSITION DUNE RESERVATION COTE ADMIN (ici: le min et max de clients pr 1 résa)) ************ -->
                    <label class="button-reservation-setter" data="1" onclick="selectNumbPers(this);">
                        <input type="radio" name="pers" value="1" />
                        <div>1</div>
                    </label>
                    <label class="button-reservation-setter" data="2" onclick="selectNumbPers(this);">
                        <input type="radio" name="pers" value="2" />
                        <div>2</div>
                    </label>
                    <label class="button-reservation-setter" data="3" onclick="selectNumbPers(this);">
                        <input type="radio" name="pers" value="3" />
                        <div>3</div>
                    </label>
                    <label class="button-reservation-setter" data="4" onclick="selectNumbPers(this);">
                        <input type="radio" name="pers" value="4" />
                        <div>4</div>
                    </label>
                    <label class="button-reservation-setter" data="5" onclick="selectNumbPers(this);">
                        <input type="radio" name="pers" value="5" />
                        <div>5</div>
                    </label>
    <!-- ************************************************************************************************************************************************ -->
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
    <!-- ************  TO DO BOUCLE FOR (DEMANDER LA COMPOSITION DUNE RESERVATION COTE ADMIN (ici: le min et max de délais pr 1 résa)) ************ -->
                    <label class="button-reservation-setter" data="Aujourd'hui" onclick="selectDate(this);">
                        <input type="radio" name="date" value="Aujourd'hui" />
                        <div><?= Translator::trans('today') ?></div>
                    </label>
                    <label class="button-reservation-setter" data="Demain" onclick="selectDate(this);">
                        <input type="radio" name="date" value="Demain" />
                        <div><?= Translator::trans('tomorrow') ?></div>
                    </label>
                    <label class="button-reservation-setter" data="21-07" onclick="selectDate(this);">
                        <input type="radio" name="date" value="21-07" />
                        <div>21-07</div>
                    </label>
    <!-- ************************************************************************************************************************************************ -->
                </div>
                <img src="<?= Framework::getResourcesPath('images/arrow-right.svg'); ?>" height="25px" width="25px" alt="arrow" />
            </div>
        </div>
        <div id="select-service-reservation">
            <div class="text" style="margin-top: 1rem;">
                Service
            </div>
            <div class="slider-reservation">
                <img src="<?= Framework::getResourcesPath('images/arrow-left.svg'); ?>" height="25px" width="25px" alt="arrow" />
                <div style="display: flex; justify-content: space-between; width: 360px; overflow: scroll;" >
    <!-- ************  TO DO BOUCLE FOR (DEMANDER LA COMPOSITION DUNE RESERVATION COTE ADMIN (ici: quels services assure le restaurant)) ************ -->
                    <label class="button-reservation-setter" data="Petit_Déjeuner" onclick="selectService(this);">
                        <input type="radio" name="service" value="Petit_Déjeuner" />
                        <div>Petit Déjeuner</div>
                    </label>
                    <label class="button-reservation-setter" data="Déjeuner" onclick="selectService(this);">
                        <input type="radio" name="service" value="Déjeuner" />
                        <div>Déjeuner</div>
                    </label>
                    <label class="button-reservation-setter" data="Diner" onclick="selectService(this);">
                        <input type="radio" name="service" value="Diner" />
                        <div>Diner</div>
                    </label>
    <!-- ************************************************************************************************************************************************ -->
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
    <!-- ************  TO DO BOUCLE FOR (DEMANDER LA COMPOSITION DUNE RESERVATION COTE ADMIN (ici: quels horaires assure le restaurant)) ************ -->
                    <label class="button-reservation-setter" data="11:30" onclick="selectHour(this);">
                        <input type="radio" name="hour" value="11:30" />
                        <div>11:30</div>
                    </label>
                    <label class="button-reservation-setter" data="12:00" onclick="selectHour(this);">
                        <input type="radio" name="hour" value="12:00" />
                        <div>12:00</div>
                    </label>
                    <label class="button-reservation-setter" data="12:30" onclick="selectHour(this);">
                        <input type="radio" name="hour" value="12:30" />
                        <div>12:30</div>
                    </label>
    <!-- ************************************************************************************************************************************************ -->
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
</div>
<script>
    let numPers = 0;
    let date = '';
    let service = '';
    let hour = '';
    $('.button-reservation').click(function(){
        $('.modal').toggleClass("show");
        $('.button-reservation').addClass("disabled");
        // $('.modal').removeClass("display-none");
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
        // TO DO REQUETE QUI ENVOIE LA DEMANDE DE RESERVATION
        // $.ajax({
        //     url: "<url>",
        //     method: "POST",
        //     data : {
        //         numPers : $numPers,
        //         date : $date,
        //         service : $service,
        //         hour : $hour,
        //     },
        //     dataType : "json",
        //     success : function(data){
        //         console.log('résa envoyée', data);
        //     }
        // })
    });
</script>

<style type="text/css">
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
    .first-section{
        justify-content: center;
        height: 100vh;
        background-image: url(<?= Framework::getResourcesPath('images/restaurantbg.svg'); ?>);
        background-size: cover;
        background-position: right bottom;
        color: white;
    }
    #list-pages{
        display: flex;
    }
    #list-pages > li {
        margin-left: 0.5rem;
        cursor: pointer;
    }
    .menu-content{
        display: flex;
        flex-direction: column;
        margin: 0 3rem;
        max-width: 400px;
        align-self: flex-start
    }
    @media (max-width: 890px) {
        .menu-display-li{
            flex-direction: column;
        }
        .reverse :nth-child(1) {
            order: 0;
        }
        .menu-content{
            align-self: center;
            text-align: center;
        }
    }
    @media (min-width: 890px) {
        li:nth-child(2n){
            display: flex;
            flex-direction: row-reverse;
        }
    }
</style>
