<?php if(\App\Services\Http\Session::exist('message.error')): ?>
    <?php foreach (\App\Services\Http\Session::flash('message.error') as $message): ?>
        <?= '<span style="text-align: center">' . $message['title'] . ' : ' . $message['message'] . '</span><br>' ?>
    <?php endforeach; ?>
<?php endif ?>