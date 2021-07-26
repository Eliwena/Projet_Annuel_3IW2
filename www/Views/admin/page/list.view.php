<?php
use \App\Core\Framework;
use \App\Services\Translator\Translator;
use App\Services\Front\Front;
?>
<section class="content">

    <h1><?= Translator::trans('admin_page_list_title'); ?></h1>
    <a href="<?= Framework::getUrl('app_admin_page_add'); ?>" class="btn btn-primary-outline pull-right"><i class="fas fa-plus-circle"></i> <?= Translator::trans('admin_page_add'); ?></a>

    <?php $this->include('error.tpl') ?>

    <div class="table-admin">
        <table id="table_pages" class="display table" style="width:100%">
            <thead>
            <tr>
                <th><?= Translator::trans('admin_table_id'); ?></th>
                <th><?= Translator::trans('name_of_the_page'); ?></th>
                <th><?= Translator::trans('admin_page_table_slug'); ?></th>
                <th><?= Translator::trans('admin_page_table_create_at'); ?></th>
                <th class="center"><?= Translator::trans('admin_table_action'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (($pages ? $pages : []) as $page) { ?>
                <tr>
                    <td><?= $page['id']; ?></td>
                    <td><?= $page['name']; ?></td>
                    <td><?= $page['slug']; ?></td>
                    <td><?= Front::date($page['createAt']); ?></td>
                    <td class="center">
                        <a class="btn btn-small btn-info" target="_blank" href="<?= Framework::getUrl('app_page_' . \App\Services\Http\Router::formatSlug($page['slug'])); ?>"><i class="fas fa-eye"></i> VOIR</a>
                        <a class="btn btn-small btn-warning" href="<?= Framework::getUrl('app_admin_page_edit', ['id' => $page['id']]); ?>"><i class="fas fa-edit"></i> EDITER</a>
                        <a class="btn btn-small btn-delete-outline" href="<?= Framework::getUrl('app_admin_page_delete', ['id' => $page['id']]); ?>"><i class="fas fa-trash"></i> SUPPRIMER</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <th><?= Translator::trans('admin_table_id'); ?></th>
            <th><?= Translator::trans('name_of_the_page'); ?></th>
            <th><?= Translator::trans('admin_page_table_slug'); ?></th>
            <th><?= Translator::trans('admin_page_table_create_at'); ?></th>
            <th class="center"><?= Translator::trans('admin_table_action'); ?></th>
            </tfoot>
        </table>
    </div>

</section>
<script type="text/javascript">
    $(function () {
        var datatable = $('#table_pages').DataTable({
            "language": {
                "url": "<?= Framework::getResourcesPath('json/' . Translator::getLocale() . '.datatables.json'); ?>",
                "searchPlaceholder": "Rechercher un élèment"
            },
            "bLengthChange": false,
            "info": false,
            "paginate": false,
            "sDom": 'Bfrtip',
        });
    });
</script>

