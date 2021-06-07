<section class="content">

    <h1>Les membres</h1>
    <a href="/admin/member/add" class="btn_add"><i class="fas fa-plus-circle"></i> Ajouter un membre</a>

    <!-- A Changer -->
    <div> <br></div>
    <table id="table_members" class="display" style="width:100%">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Email</th>
            <th>Pays</th>
            <th>Role</th>
            <th>isDeleted</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) { ?>
        <tr>
            <td><?= $user['firstname']; ?></td>
            <td><?= $user['lastname']; ?></td>
            <td><?= $user['email']; ?></td>
            <td><?= $user['country']; ?></td>
            <td><?= $user['role']; ?></td>
            <td><?= $user['isDeleted']; ?></td>
            <td></td>
            <td><a class="delete_<?= $user['id']; ?>" style="color: black" href="/admin/member/delete?id=<?= $user['id']; ?>">Supprimer</a> </td>
        </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Pays</th>
        <th>Role</th>
        <th>isDeleted</th>
        <th>Modifier</th>
        <th>Supprimer</th>
        </tr>
        </tfoot>
    </table>


</section>
<script type="text/javascript">
    $(document).ready(function () {
        $('#table_members').DataTable();
    });
</script>

