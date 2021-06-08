<section class="content">
    <h1>Les ingredients</h1>
    <a href="/admin/ingredients/add" class="btn pull-right"><i class="fas fa-plus-circle"></i> Ajouter un ingredient</a>

<div> <br></div>
        <table id="table_ingredients"  class="display table" style="width:100%">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Categorie</th>
                <th>Quantité</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody class="dt-body-center" >
            <?php foreach ($ingredient as $ingredients) { ?>
            <tr>
                <td><?= $ingredients['id']; ?></td>
                <td><?= $ingredients['nom']; ?></td>
                <td><?= $ingredients['prix']; ?></td>
                <td><?= $ingredients['stock']; ?></td>
                <td><?= $ingredients['activeCommande']; ?></td>
                <td class="center action-icon">
                    <a class="edit-icon" href="/admin/dishes/edit?id=<?= $user['id']; ?>"><i class="fas fa-edit"></i></a>
                    <a class="delete-icon" href="/admin/dishes/delete?id=<?= $user['id']; ?>"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Categorie</th>
                <th>Quantité</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
</section>
<script type="text/javascript">
    $(function () {
        var datatable = $('#table_ingredients').DataTable({
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
