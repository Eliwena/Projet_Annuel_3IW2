<?php
use \App\Core\Framework;


?>

<section class="content">
    <?php
    $date = date(' d-m-Y');
    $hour = array();
    ?>

    <h1>Les reservation du <?php echo $date ?></h1>
    <a href="" class="btn btn-primary-outline pull-right"><i class="fas fa-plus-circle"></i> Ajouter une reservation</a>

    <?php
    $time = '00:00:00';
    ?>
    <div>
    <table id="table_reservation" class="display table" style="width:100%">
        <thead>


        <tr>
            <th>Heure</th>
            <th>Nom réservation</th>
            <th>Nombre de personne</th>
            <th> Action</th>
        </tr>
        </thead>
        <tbody>

        <?php
//        for ($i = 0; $i < 24; $i = $i + 0.5) {
//            $new_time = date('H:i:s', strtotime($time . '+ 30 minutes'));
//            if ($i >= 11 && $i <= 14 || $i >= 18.5 && $i <= 22.5) {
//                array_push($hour , $new_time);
//             }
//            $time = $new_time;
//        }
                foreach (($reservations ? $reservations : []) as $reservation) {
                    if(date("Y-m-d H:i:s" , strtotime('00:00:00'))  == $reservation['date_reservation']){?>

                <tr>
                    <td><?= $reservation['hour'] ?></td>
                    <td> <?= $reservation['userId']['firstname'] ?> <?= $reservation['userId']['lastname'];?></td>
                    <td> <?= $reservation['nbPeople'] ;?></td>
                    <td class="center">
                        <a class="btn btn-small btn-warning" href=""><i class="fas fa-edit"></i> EDITER</a>
                        <a class="btn btn-small btn-delete-outline" href="<?= Framework::getUrl('app_admin_reservation_delete', ['id' => $reservation['id']]); ?>"><i class="fas fa-trash"></i> SUPPRIMER</a>
                    </td>
                </tr>
            <?php  }}?>

        </tbody>
        <tfoot>
        <th>Heure</th>
        <th>Nom réservation</th>
        <th>Nombre de personne</th>
        <th> Action</th>
        </tfoot>

    </table>
    </div>
</section>
<script type="text/javascript">
    $(function () {
        var datatable = $('#table_reservation').DataTable({
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