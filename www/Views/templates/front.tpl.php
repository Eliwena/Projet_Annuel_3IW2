<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= is_null($title) ? 'Page du framework RestoGuest' : $title; ?></title>
	<meta name="description" content="description de la page de front">
</head>
<body>

    <?php if(\App\Services\Http\Session::exist('message.error')): ?>
        <?php foreach (\App\Services\Http\Session::flash('message.error') as $message) { ?>
            <?php \App\Core\Helpers::debug($message) ?>
        <?php } ?>
    <?php endif ?>

	<?php include $this->view ?>

</body>
</html>