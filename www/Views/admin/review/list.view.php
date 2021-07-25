<?php
use \App\Services\Front\Front;
use \App\Core\Framework;
?>
<section class="content">

    <h1>Les avis</h1>
    <?php $this->include('error.tpl') ?>
    <a href="<?= Framework::getUrl('app_admin_review_add'); ?>" class="btn btn-primary-outline pull-right"><i
                class="fas fa-plus-circle"></i> Ajouter un avis</a>
    <div class="table-admin">
        <table id="table_reviews" class="display table" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Note</th>
                <th>Créer le</th>
                <th class="center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (($reviews ? $reviews : []) as $review) { ?>
                <tr>
                    <td><?= $review['id']; ?></td>
<!--                    <td>--><?//= ucfirst($review['title']); ?><!--</td>-->
<!--                    <td>--><?//= Front::generateStars($review['note']); ?><!--</td>-->
                    <td><?= Front::date($review['createAt'], 'd/m/Y à H:i'); ?></td>
                    <td class="center">
                        <a class="btn btn-small btn-info" href="<?= Framework::getUrl('app_admin_review_show', ['id' => $review['id']]); ?>"><i class="fas fa-eye"></i> VOIR</a>
                        <a class="btn btn-small btn-delete-outline" href="<?= Framework::getUrl('app_admin_review_delete', ['id' => $review['id']]); ?>"><i class="fas fa-trash"></i> SUPPRIMER</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <th>ID</th>
            <th>Titre</th>
            <th>Note</th>
            <th>Créer le</th>
            <th class="center">Action</th>
            </tfoot>
        </table>
    </div>

</section>
<script type="text/javascript">
    $(function () {
        var datatable = $('#table_reviews').DataTable({
            "language": {
                "url": "<?= Framework::getResourcesPath('json/fr.datatables.json'); ?>",
                "searchPlaceholder": "Rechercher un élèment"
            },
            "order": [[ 4, "desc" ]],
            "bLengthChange": false,
            "info": false,
            "paginate": false,
            "sDom": 'Bfrtip',
        });
    });
</script>

