<section class="content">
    <h1>Les ingredients</h1>
    <a href="" class="btn_add"><i class="fas fa-plus-circle"></i> Ajouter un ingredient</a>

<div> <br></div>
        <table id="table_ingredients" class="hover order-column row-border " style="width:100%">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Categorie</th>
                <th>Quantité</th>
                <th>Active</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
            </thead>
            <tbody class="dt-body-center" >
            <tr>
                <td>Coca</td>
                <td>1.5€</td>
                <td>Boisson</td>
                <td>5</td>
                <td>1</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Mayonnaise</td>
                <td>2€</td>
                <td>Condiment</td>
                <td>10</td>
                <td>0</td>
                <td></td>
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
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
            </tfoot>
        </table>
</section>
<script type="text/javascript">
    $(document).ready(function () {
        $('#table_ingredients').DataTable( {
            columnDefs: [
                {
                    targets: -1,
                    className: 'dt-center'
                }
            ]
        } );
    });
</script>
