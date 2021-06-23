<section class="content">
    <h1>Les ingredients</h1>
    <a href="<?= \App\Core\Framework::getUrl('app_admin_ingredients_add'); ?>" class="btn pull-right"><i class="fas fa-plus-circle"></i> Ajouter un ingredient</a>

<div> <br></div>
        <table id="table_ingredients"  class="display table" style="width:100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody class="dt-body-center" >
            <?php foreach (($ingredients ? $ingredients : []) as $ingredient) { ?>
            <tr>
                <td><?= $ingredient['id']; ?></td>
                <td><?= $ingredient['nom']; ?></td>
                <td><?= $ingredient['prix']; ?></td>
                <td><?= $ingredient['stock']; ?></td>
                <td><?= $ingredient['activeCommande']; ?></td>
                <td class="center action-icon">
                    <a class="edit-icon" href="<?= \App\Core\Framework::getUrl('app_admin_ingredients_edit', ['id' => $ingredient['id']]); ?>"><i class="fas fa-edit"></i></a>
                    <a class="delete-icon" href="<?= \App\Core\Framework::getUrl('app_admin_ingredients_delete', ['id' => $ingredient['id']]); ?>"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Prix</th>
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
