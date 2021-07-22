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
        <div class="text">
            Personnes
        </div>
        <div class="slider-reservation">
            <img src="<?= Framework::getResourcesPath('images/arrow-left.svg'); ?>" height="40px" width="40px" alt="arrow" />
            <div style="display: flex; background-color: #D9D9D9;" ></div>
            <img src="<?= Framework::getResourcesPath('images/arrow-right.svg'); ?>" height="40px" width="40px" alt="arrow" />
        </div>
        <div class="close-btn">
            <button>Close Modal</button>
        </div>
    </div>
</div>
<script>
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

    /*Partie MODALE (POPUP RESERVATION)*/
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
    .button-reservation.disabled{
        pointer-events: none;
    }
    .modal{
        z-index: 0;
        position: absolute;
        right: 50%;
        transform: translate(+50%, 0);
        opacity: 0;
        bottom: -100%;
        width: 360px;
        transition: bottom 0.4s, opacity 0.4s;
        box-shadow: 0px 0px 15px rgba(0,0,0,0.3);
    }
    .modal.show{
        bottom: 20%;
        opacity: 1;
    }
    .modal .top-content{
        background: #34495e;
        width: 100%;
        padding: 0 0 30px 0;
    }
    .top-content .left-text{
        text-align: left;
        padding: 10px 15px;
        font-size: 18px;
        color: #f2f2f2;
        font-weight: 500;
        user-select: none;
    }
    .top-content .close-icon{
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 23px;
        color: silver;
        cursor: pointer;
    }
    .close-icon:hover{
        color: #b6b6b6;
    }
    .top-content .fa-camera-retro{
        font-size: 80px;
        color: #f2f2f2;
    }
    .modal .bottom-content{
        background: white;
        width: 100%;
        padding: 15px 20px;
    }
    .bottom-content .text{
        font-size: 28px;
        font-weight: 600;
        color: #34495e;
    }
    .bottom-content p{
        font-size: 18px;
        line-height: 27px;
        color: grey;
    }
    .bottom-content .close-btn{
        padding: 15px 0;
    }
    .button-reservation button,
    .close-btn button{
        padding: 9px 13px;
        background: #27ae60;
        border: none;
        outline: none;
        font-size: 18px;
        text-transform: uppercase;
        border-radius: 3px;
        color: #f2f2f2;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .button-reservation button{
        padding: 12px 15px;
    }
    .button-reservation button:hover,
    .close-btn button:hover{
        background: #26a65b;
    }
</style>
