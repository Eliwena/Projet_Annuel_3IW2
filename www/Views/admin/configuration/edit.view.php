<section class="content">
    
    <h1><?= \App\Services\Translator\Translator::trans('admin_configuration_edit_title') ?></h1>
    <?php $this->include('error.tpl') ?>
    <div>
        <?php $form->render() ?>

        <a onclick="window.history.go(-1); return false;">
            <button class="btn btn-primary-outline">
                <?= \App\Services\Translator\Translator::trans('return'); ?>
            </button>
        </a>
    </div>

</section>