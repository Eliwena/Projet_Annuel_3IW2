<section class="content">

    <h1>Les groupes</h1>
    <a href="<?= \App\Core\Framework::getUrl('app_admin_group_add'); ?>" class="btn pull-right"><i class="fas fa-plus-circle"></i> Ajouter un groupe</a>

    <div class="table-admin">
        <table id="table_groupes" class="display table" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th class="center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (($groups ? $groups : []) as $group) { ?>
                <tr>
                    <td><?= $group['id']; ?></td>
                    <td><?= $group['description']; ?></td>
                    <td class="center action-icon">
                       <?php if($group['name'] != _SUPER_ADMIN_GROUP) { ?>
                           <a class="edit-icon" href="<?= \App\Core\Framework::getUrl('app_admin_group_edit', ['id' => $group['id']]); ?>"><i class="fas fa-edit"></i></a>
                           <a class="delete-icon" href="<?= \App\Core\Framework::getUrl('app_admin_group_delete', ['id' => $group['id']]); ?>"><i class="fas fa-trash"></i></a>
                       <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <th>ID</th>
            <th>Nom</th>
            <th class="center">Action</th>
            </tfoot>
        </table>
    </div>

</section>
<script type="text/javascript">
    $(function () {
        var datatable = $('#table_groupes').DataTable({
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

