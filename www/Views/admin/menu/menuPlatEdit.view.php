<?php

use App\Core\Helpers;

?>
<section class="content">

    <h1>Edition des plats du menu</h1>

    <h2> <?= $menu->getNom();?></h2>

    <table id="table_ingredients" class="display table" style="width:100%">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody class="dt-body-center">
        <?php foreach (($menuPlat ? $menuPlat : []) as $menuPlats) {
            ?>
            <tr>
                <td><?= $menuPlats['idPlat']['id']; ?></td>
                <td><?= $menuPlats['idPlat']['nom']; ?></td>
                <td><?= $menuPlats['idPlat']['prix']; ?></td>
                <td class="center action-icon">
                    <a class="delete-icon"
                       href="<?= \App\Core\Framework::getUrl('app_admin_menu_plat_delete', ['idPlat' => $menuPlats['idPlat']['id'], 'idMenu'=> $menu->getId()]); ?>"><i
                            class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="4" class="center"><a  href="" class="btn "><i class="fas fa-plus-circle"></i> Ajouter un plat</a></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>
    <a href="<?= \App\Core\Framework::getUrl('app_admin_menu'); ?>" class="btn"><i class="fas fa-undo"></i> Retour </a>
</section>

<script type="text/javascript">

    $('#myBtn').click(function(){
        $('.addIngredient').show();
    })

</script>