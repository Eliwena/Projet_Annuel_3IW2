<?php
use App\Core\Framework;
use App\Services\Front\Front;
?>
<section class="section first-section">
    <h1 style="font-size: 76px;" ><marquee direction="left" scrollamount="15">Bienvenue sur <?= Front::getSiteName() ?? 'Nom du site'; ?></marquee></h1>
    <div class="button-reservation show-btn">
        <span>Réservation</span>
    </div>
</section>
<section class="section" style="padding: 2rem">
    <h1 style="font-size: 46px;" >La carte</h1>
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
<section class="contact-section">
    <div style="display: flex; flex-direction: column;">
        <h1>Nous contacter</h1>
        <span>16 rue petit, 75005, Paris</span>
        <span>01 23 45 67 89</span>
        <span>contact@friendly.com</span>
        <span>pagesjaunes.com/friendly</span>
    </div>
    <div style="display: flex; flex-direction: column;">
        <div style="display: flex; align-items: center; margin-bottom: 0.4rem">
            <img src="<?= Framework::getResourcesPath('images/facebook-logo.svg'); ?>" alt="facebook-logo" class="image-network"/>
            <span>facebook.com/friendly</span>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 0.4rem">
            <img src="<?= Framework::getResourcesPath('images/instagram-logo.svg'); ?>" alt="instagram-logo" class="image-network"/>
            <span>instagram.com/friendly</span>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 0.4rem">
            <img src="<?= Framework::getResourcesPath('images/tiktok-logo.svg'); ?>" alt="tiktok-logo" class="image-network"/>
            <span>tiktok.com/friendly</span>
        </div>
        <div style="display: flex; align-items: center">
            <img src="<?= Framework::getResourcesPath('images/snapchat-logo.svg'); ?>" alt="snapchat-logo" class="image-network"/>
            <span>snapchat.com/friendly</span>
        </div>
    </div>
</section>

<div class="modal">
    <div class="top-content">
        <div class="left-text">
            Réservation
        </div>
        <span class="close-icon"><i class="fas fa-times"></i></span>
    </div>
    <div class="bottom-content">
        <div>
            <div class="text">
                Personnes
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
                Date
            </div>
            <div class="slider-reservation">
                <img src="<?= Framework::getResourcesPath('images/arrow-left.svg'); ?>" height="25px" width="25px" alt="arrow" />
                <div style="display: flex; justify-content: space-between; width: 360px; overflow: scroll;" >
    <!-- ************  TO DO BOUCLE FOR (DEMANDER LA COMPOSITION DUNE RESERVATION COTE ADMIN (ici: le min et max de délais pr 1 résa)) ************ -->
                    <label class="button-reservation-setter" data="Aujourd'hui" onclick="selectDate(this);">
                        <input type="radio" name="date" value="Aujourd'hui" />
                        <div>Aujourd'hui</div>
                    </label>
                    <label class="button-reservation-setter" data="Demain" onclick="selectDate(this);">
                        <input type="radio" name="date" value="Demain" />
                        <div>Demain</div>
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
                Heure
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
                <button>Annuler</button>
            </div>
            <div class="accept-btn">
                <button>Confirmation</button>
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
    .section{
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }
    .first-section{
        justify-content: center;
        height: 100vh;
        background-image: url(<?= Framework::getResourcesPath('images/restaurantbg.svg'); ?>);
        background-size: cover;
        background-position: right bottom;
        color: white;
    }
    .contact-section{
        display: flex;
        padding: 1rem;
        background-color: #D9D9D9;
        justify-content: space-around;
    }
    .button-reservation{
        border: 4px solid #ffffff;
        width: auto;
        height: auto;
        padding: 1rem 2rem;
        cursor: pointer;
    }
    .menu-display{
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 2rem;
        width: 100%;
    }
    .image-container{
        width: 390px;
        height: 280px;
        border: solid 2px #030303;
        border-radius: 15px;
        box-shadow: 0 +0.4em .4em #030303;;
    }
    .image-network{
        width: 40px;
        height: 40px;
        margin-right: 0.8rem;
    }
    .menu-display-li{
        display: flex;
        align-items: center;
        margin: 1rem 0;
    }
    .reverse :nth-child(1) {
        order: 2;
    }

    @media (max-width: 890px) {
        .menu-display-li{
            flex-direction: column;
        }
        .reverse :nth-child(1) {
            order: 0;
        }
    }
</style>
