<section class="content">
    <h1>Les ingredients</h1>
    <a href="<?= \App\Core\Framework::getUrl('app_admin_foodstuff_add'); ?>" class="btn btn-primary-outline pull-right"><i class="fas fa-plus-circle"></i> Ajouter un ingredient</a>
    <?php $this->include('error.tpl') ?>
<div> <br></div>
        <table id="table_foodstuff"  class="display table" style="width:100%">
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
            <?php foreach (($foodstuffs ? $foodstuffs : []) as $foodstuff) { ?>
            <tr>
                <td><?= $foodstuff['id']; ?></td>
                <td><?= $foodstuff['name']; ?></td>
                <td><?= $foodstuff['price']; ?></td>
                <td><?= $foodstuff['stock']; ?></td>
                <td><?= $foodstuff['isActive']; ?></td>
                <td class="center action-icon">
                    <a class="btn btn-warning" href="<?= \App\Core\Framework::getUrl('app_admin_foodstuff_edit', ['id' => $foodstuff['id']]); ?>"><i class="fas fa-edit"></i> EDITER</a>
                    <a class="btn btn-delete-outline" href="<?= \App\Core\Framework::getUrl('app_admin_foodstuff_delete', ['id' => $foodstuff['id']]); ?>"><i class="fas fa-trash"></i> SUPPRIMER</a>
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
        var datatable = $('#table_foodstuff').DataTable({
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
