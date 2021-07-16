<?php
use \App\Core\Framework;
use \App\Services\Translator\Translator;
use App\Services\Front\Front;
?>
<section class="content">

    <h1><?= Translator::trans('admin_page_add_title'); ?></h1>
    <?php $this->include('error.tpl') ?>
    <div>
		<?php $form->render() ?>

        <a onclick="window.history.go(-1); return false;">
            <button class="btn btn-primary-outline">
                <?= Translator::trans('return'); ?>
            </button>
        </a>

    </div>

</section>
<script src="<?= Framework::getResourcesPath('tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript">
    var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

    tinymce.init({
        selector: '#content',
        plugins: 'print preview autolink save directionality fullscreen image link media template table hr anchor toc lists help emoticons',
        mobile: {
            plugins: 'print preview autolink save directionality fullscreen image link media template table hr anchor toc lists help emoticons'
        },

        menubar: 'file edit view insert format tools table tc help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',

        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        content_css: useDarkMode ? 'dark' : 'default',
        //remove tiny message
        init_instance_callback : function(editor) {
            var freeTiny = document.querySelector('.tox .tox-notification--in');
            freeTiny.style.display = 'none';
        }
    });
</script>