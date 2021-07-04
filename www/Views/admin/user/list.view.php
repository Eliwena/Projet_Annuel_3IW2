<section class="content">

    <h1>Les membres</h1>
    <a href="<?= \App\Core\Framework::getUrl('app_admin_user_add'); ?>" class="btn pull-right"><i class="fas fa-plus-circle"></i> Ajouter un membre</a>

    <div class="table-admin">
        <table id="table_members" class="display table" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Email</th>
                <th>Pays</th>
                <th class="center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (($users ? $users : []) as $user) { ?>
                <tr>
                    <td><?= $user['id']; ?></td>
                    <td><?= $user['firstname']; ?></td>
                    <td><?= $user['lastname']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td><?= $user['country']; ?></td>
                    <td class="center action-icon">
                        <a class="edit-icon" href="<?= \App\Core\Framework::getUrl('app_admin_user_edit', ['id' => $user['id']]); ?>"><i class="fas fa-edit"></i></a>
                        <a class="delete-icon" href="<?= \App\Core\Framework::getUrl('app_admin_user_delete', ['id' => $user['id']]); ?>"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <th>ID</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Email</th>
            <th>Pays</th>
            <th class="center">Action</th>
            </tfoot>
        </table>
    </div>

</section>
<script type="text/javascript">
    $(function () {
        var datatable = $('#table_members').DataTable({
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

