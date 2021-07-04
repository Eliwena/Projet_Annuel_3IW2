<div class="contenue" >
    <img class="logo-img" src="Resources/images/logoSiteSignIn.svg">
    <h2>Connectez-vous !</h2>
    <?php $form->render() ?>
    <a href="<?= \App\Core\Framework::getUrl('app_login_oauth', ['client' => 'google']); ?>"><button>Login with google</button></a>
    <br>
    <a href="<?= \App\Core\Framework::getUrl('app_login_oauth', ['client' => 'facebook']); ?>"><button>Login with facebook</button></a>
    <br>
    <little><a rel="stylesheet" type="text/css" href="#">Mot de passe oublié?</a></little>
    </br>
    </br>
    <little><a rel="stylesheet" type="text/css" onclick="window.history.go(-1); return false;">Retour</a></little>
    </br></br>
</div>
<div class="button_div">
    <a href="register">
        <button id="new_account" name="new_account">Créez un compte</button>
    </a>
</div>

