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
            <tr>
                <td>Coca</td>
                <td>1.5€</td>
                <td>Boisson</td>
                <td>5</td>
                <td>1</td>
                <td class="center action-icon">
                    <a class="edit-icon" href="/admin/dishes/edit?id=<?= $user['id']; ?>"><i class="fas fa-edit"></i></a>
                    <a class="delete-icon" href="/admin/dishes/delete?id=<?= $user['id']; ?>"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <tr>
                <td>Mayonnaise</td>
                <td>2€</td>
                <td>Condiment</td>
                <td>10</td>
                <td>0</td>
                <td></td>
            </tr>
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
