<?php
use \App\Services\Http\Session;
?>

<?php if(Session::exist('message')):

    foreach (Session::flash('message') as $item): ?>

        <div class="alert alert-<?= $item['type']; ?>">
            <h4><b><?= $item['title']; ?> :</b> <?= $item['message']; ?></h4>
            <a class="close" onclick="$(this).parent().fadeOut();">&times;</a>
        </div>

    <?php endforeach ?>

<?php endif ?>