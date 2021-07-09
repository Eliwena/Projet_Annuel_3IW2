<?php
use \App\Services\Front\Front;
use \App\Core\Framework;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= isset($title) ? $title : 'Page du framework RestoGuest'; ?></title>
	<meta name="description" content="description de la page de front">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>

    <!-- FONT AWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet">

    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.23/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.23/datatables.min.js"></script>

    <!-- STYLE -->
    <link href="<?= Framework::getResourcesPath('styles.css'); ?>" rel="stylesheet">
    <link href="<?= Framework::getResourcesPath('logincss.css'); ?>" rel="stylesheet"/>
</head>
<body>

    <?php include 'error.tpl.php'; ?>

	<?php include $this->view ?>

    <?= Front::getGoogleAnalyticsJS(); ?>
</body>
</html>