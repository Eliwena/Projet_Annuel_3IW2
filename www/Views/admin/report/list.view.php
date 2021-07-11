<?php
use \App\Services\Front\Front;
use \App\Core\Framework;
?>
<section class="content">

    <h1>Les signalements</h1>

    <div class="table-admin">
        <table id="table_reviews" class="display table" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Raison</th>
                <th>Créer le</th>
                <th class="center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (($reports ? $reports : []) as $report) { ?>
                <tr>
                    <td><?= $report['id']; ?></td>
                    <td><?= ucfirst($report['reviewId']['title']); ?></td>
                    <td><?= $report['reason']; ?></td>
                    <td><?= Front::date($report['createAt'], 'd/m/Y à H:i'); ?></td>
                    <td class="center">
                        <a class="btn btn-small btn-warning" href="<?= Framework::getUrl('app_admin_report_show', ['id' => $report['id']]); ?>"><i class="fas fa-edit"></i> Voir le détail</a>
                        <a class="btn btn-small btn-delete-outline" href="<?= Framework::getUrl('app_admin_report_delete', ['id' => $report['id']]); ?>"><i class="fas fa-trash"></i> Supprimer le signalement</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <th>ID</th>
            <th>Titre</th>
            <th>Raison</th>
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
            "order": [ 4, "desc" ],
            "bLengthChange": false,
            "info": false,
            "paginate": false,
            "sDom": 'Bfrtip',
        });
    });
</script>

