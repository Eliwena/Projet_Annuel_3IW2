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

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>

    <!-- FONT AWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet">

    <!-- STYLE -->
    <link href="<?= Framework::getResourcesPath('styles.css') ?>" rel="stylesheet">
    <script type="text/javascript" src="<?= Framework::getResourcesPath('script.js'); ?>"></script>

</head>
<body>
<?php include $this->view ?>
</body>
</html>