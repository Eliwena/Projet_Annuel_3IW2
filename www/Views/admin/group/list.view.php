<?php
use \App\Core\Framework;
use App\Repository\Users\GroupPermissionRepository;
use App\Services\Translator\Translator;
?>
<section class="content">

    <h1>Les groupes</h1>
    <a href="<?= Framework::getUrl('app_admin_group_add'); ?>" class="btn pull-right"><i class="fas fa-plus-circle"></i> Ajouter un groupe</a>

    <div class="table-admin">
        <table id="table_groupes" class="display table" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Permission</th>
                <th class="center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (($groups ? $groups : []) as $group) { ?>
                <tr>
                    <td><?= $group['id']; ?></td>
                    <td><?= $group['description']; ?></td>
                    <td>
                        <?= _SUPER_ADMIN_GROUP == $group['name'] ? '<span class="badge">*</span>' : ''; ?>
                        <?php foreach(GroupPermissionRepository::getPermissionByGroupId($group['id']) ? GroupPermissionRepository::getPermissionByGroupId($group['id']) : [] as $permission) { echo '<span class="badge">' . $permission['permissionId']['description'] . '</span>' ?? null; }?>
                    </td>
                    <td class="center action-icon">
                       <?php if($group['name'] != _SUPER_ADMIN_GROUP) { ?>
                           <a class="edit-icon" href="<?= Framework::getUrl('app_admin_group_edit', ['id' => $group['id']]); ?>"><i class="fas fa-edit"></i></a>
                           <a class="delete-icon" href="<?= Framework::getUrl('app_admin_group_delete', ['id' => $group['id']]); ?>"><i class="fas fa-trash"></i></a>
                       <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <th>ID</th>
            <th>Nom</th>
            <th>Permission</th>
            <th class="center">Action</th>
            </tfoot>
        </table>
    </div>

</section>
<script type="text/javascript">
    $(function () {
        var datatable = $('#table_groupes').DataTable({
            "language": {
                "url": "<?= Framework::getResourcesPath('json/'. Translator::getLocale() .'.datatables.json'); ?>",
                "searchPlaceholder": "Rechercher un élèment"
            },
            "bLengthChange": false,
            "info": false,
            "paginate": false,
            "sDom": 'Bfrtip',
        });
    });
</script>

