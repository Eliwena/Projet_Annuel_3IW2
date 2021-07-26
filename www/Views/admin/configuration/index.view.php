<?php
use \App\Core\Framework;
use \App\Services\Translator\Translator;
use \App\Repository\Users\UserGroupRepository;
?>
<section class="content">

    <h1><?= Translator::trans('admin_configuration_list_title'); ?></h1>

    <?php $this->include('error.tpl') ?>

    <div class="table-admin">
        <table id="table_configuration" class="display table" style="width:100%">
            <thead>
            <tr>
                <th><?= Translator::trans('admin_table_id'); ?></th>
                <th><?= Translator::trans('admin_configuration_table_description'); ?></th>
                <th><?= Translator::trans('value'); ?></th>
                <th class="center"><?= Translator::trans('admin_table_action'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (($configurations ? $configurations : []) as $configuration) { ?>
                <tr>
                    <td><?= $configuration['id']; ?></td>
                    <td><?= $configuration['description']; ?></td>
                    <td><?= strpos($configuration['name'], 'password') ? '*********' : (($configuration['value'] == 'true' or $configuration['value'] == 'false') ? ($configuration['value'] == 'true' ? Translator::trans('enable') : Translator::trans('disable')) : $configuration['value']); ?>
                    </td>
                    <td class="center">
                        <a class="btn btn-small btn-warning" href="<?= Framework::getUrl('app_admin_config_edit', ['id' => $configuration['id']]); ?>"><i class="fas fa-edit"></i> EDITER</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <th><?= Translator::trans('admin_table_id'); ?></th>
            <th><?= Translator::trans('admin_configuration_table_description'); ?></th>
            <th><?= Translator::trans('value'); ?></th>
            <th class="center"><?= Translator::trans('admin_table_action'); ?></th>
            </tfoot>
        </table>
    </div>

</section>
<script type="text/javascript">
    $(function () {
        var datatable = $('#table_configuration').DataTable({
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

