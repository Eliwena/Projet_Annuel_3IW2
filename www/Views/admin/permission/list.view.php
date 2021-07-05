<section class="content">

    <h1>Les permissions</h1>
    <a href="<?= \App\Core\Framework::getUrl('app_admin_permission_add'); ?>" class="btn pull-right"><i class="fas fa-plus-circle"></i> Ajouter une permission</a>

    <div class="table-admin">
        <table id="table_permissions" class="display table" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Groupe</th>
                <th class="center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (($permissions ? $permissions : []) as $permission) { ?>
                <tr>
                    <td><?= $permission['id']; ?></td>
                    <td><?= $permission['name']; ?></td>
                    <td><?= $permission['groupId']['description']; ?></td>
                    <td class="center action-icon">
                        <a class="edit-icon" href="<?= \App\Core\Framework::getUrl('app_admin_permission_edit', ['id' => $permission['id']]); ?>"><i class="fas fa-edit"></i></a>
                        <a class="delete-icon" href="<?= \App\Core\Framework::getUrl('app_admin_permission_delete', ['id' => $permission['id']]); ?>"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <th>ID</th>
            <th>Nom</th>
            <th>Groupe</th>
            <th class="center">Action</th>
            </tfoot>
        </table>
    </div>

</section>
<script type="text/javascript">
    $(function () {
        var datatable = $('#table_permissions').DataTable({
            "language": {
                "url": "<?= \App\Core\Framework::getResourcesPath('json/fr.datatables.json'); ?>",
                "searchPlaceholder": "Rechercher un élèment"
            },
            "bLengthChange": false,
            "info": false,
            "paginate": false,
            "sDom": 'Bfrtip',
        });
    });
</script>

