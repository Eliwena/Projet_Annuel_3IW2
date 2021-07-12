<section class="content">
    <?php
    $date = date(' d-m-Y');
    $hour = array();
    ?>

    <h1>Les reservation du <?php echo $date ?></h1>

    <?php
    $time = '00:00:00';
    ?>

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
                    if(date("Y-m-d H:i:s" , strtotime('00:00:00'))  == $reservation['date']){?>

                <tr>
                    <td><?= $reservation['hour'] ?></td>
                    <td> <?= $reservation['userId']['lastname'];?></td>
                    <td> <?= $reservation['nbPeople'] ;?></td>
                    <td class="center">
                        <a class="btn btn-small btn-warning" href=""><i class="fas fa-edit"></i> EDITER</a>
                        <a class="btn btn-small btn-delete-outline" href=""><i class="fas fa-trash"></i> SUPPRIMER</a>
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

</section>

