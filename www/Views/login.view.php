<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Login</title>
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    <!-- FONT AWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet">
    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.23/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.23/datatables.min.js"></script>
    <!-- STYLE -->
    <link href="Resources/styles.css" rel="stylesheet">
    <link href="Views/logincss.css" rel="stylesheet"/>
</head>
<body>


    <?php if(\App\Services\Http\Session::exist('message.error')): ?>
        <?= \App\Services\Http\Session::flash('message.error'); ?>
    <?php endif ?>

	<div class="contenue" >
		<img class="logo-img" src="Resources/images/logoSiteSignIn.svg">
		<h2>Connectez-vous !</h2>
		<?php $form->render() ?>
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


</body>
</html>

