<?php

use App\Core\Helpers;

?>
<section class="content">

    <h1>Edition d'un plat</h1>

    <h2> <?= $dishes->getNom(); ?></h2>

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
        <?php foreach (($platIngredients ? $platIngredients : []) as $platIngredient) {
            foreach (($ingredients ? $ingredients : []) as $ingredient) {
                if ($ingredient['id'] == $platIngredient["idAliment"]) {
                    ?>
                    <tr>
                        <td><?= $ingredient['id']; ?></td>
                        <td><?= $ingredient['nom']; ?></td>
                        <td><?= $ingredient['prix']; ?></td>
                        <td class="center action-icon">
                            <a class="delete-icon"
                               href="<?= \App\Core\Framework::getUrl('app_admin_dishes_ingredient_delete', ['id' => $ingredient['id'], 'idPlat'=> $dishes->getId()]); ?>"><i
                                        class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
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


</section>