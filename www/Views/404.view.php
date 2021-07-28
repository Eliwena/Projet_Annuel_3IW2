<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh">
    <h1 style="">404 Not Found</h1>
    <a href="<?= \App\Core\Framework::getUrl('app_home'); ?>">
        <button class="btn btn-primary-outline">
            <i class="fas fa-undo"></i>
            <?= \App\Services\Translator\Translator::trans('go_back_to_home'); ?>
        </button>
    </a>
</div>

