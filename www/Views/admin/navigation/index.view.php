

<?php
use \App\Core\Framework;
use \App\Services\Translator\Translator;
use \App\Repository\Users\UserGroupRepository;
?>
<section class="content">

    <h1><?= Translator::trans('admin_navigation_form_list_title'); ?></h1>
    <a href="<?= Framework::getUrl('app_admin_navigation_add'); ?>" class="btn btn-primary-outline pull-right"><i class="fas fa-plus-circle"></i> Ajouter une navigation</a>

    <?php $this->include('error.tpl') ?>

    <div class="table-admin">
        <table id="table_nav" class="display table" style="width:100%">
            <thead>
            <tr>
                <th><?= Translator::trans('admin_table_id'); ?></th>
                <th><?= Translator::trans('admin_navigation_form_order'); ?></th>
                <th><?= Translator::trans('value'); ?></th>
                <th class="center"><?= Translator::trans('admin_table_action'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (($navigations ? $navigations : []) as $navigation) { ?>
                <tr>
                    <td><?= $navigation['id']; ?></td>
                    <td><?= $navigation['navOrder']; ?></td>
                    <td><?= $navigation['value']; ?></td>
                    <td class="center">
                        <a class="btn btn-small btn-danger-outline" href="<?= Framework::getUrl('app_admin_navigation_delete', ['id' => $navigation['id']]); ?>"><i class="fas fa-delete"></i> SUPPRIMER</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <th><?= Translator::trans('admin_table_id'); ?></th>
            <th><?= Translator::trans('admin_navigation_form_order'); ?></th>
            <th><?= Translator::trans('value'); ?></th>
            <th class="center"><?= Translator::trans('admin_table_action'); ?></th>
            </tfoot>
        </table>
    </div>

</section>
<script type="text/javascript">
    $(function () {
        var datatable = $('#table_nav').DataTable({
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


