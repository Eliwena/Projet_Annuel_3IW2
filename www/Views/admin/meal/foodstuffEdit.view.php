<?php

use App\Core\Helpers;

?>
<section class="content">

    <h1>Edition des aliments du plat</h1>

    <h2> <?= $meal->getName();?></h2>
    <?php $this->include('error.tpl') ?>
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
        <?php foreach (($mealFoodstuffs ? $mealFoodstuffs : []) as $mealFoodstuff) {
                    ?>
                    <tr>
                        <td><?= $mealFoodstuff['foodstuffId']['id']; ?></td>
                        <td><?= $mealFoodstuff['foodstuffId']['name']; ?></td>
                        <td><?= $mealFoodstuff['foodstuffId']['price']; ?></td>
                        <td class="center action-icon">
                            <a class="btn btn-delete-outline"
                               href="<?= \App\Core\Framework::getUrl('app_admin_meal_foodstuff_delete', ['foodstuffId' => $mealFoodstuff['foodstuffId']['id'], 'mealId'=> $meal->getId()]); ?>"><i class="fas fa-trash"></i> SUPPRIMER</a>
                        </td>
                    </tr>
                    <?php
        }
        ?>
        <tr>
            <td colspan="4" class="center"><a  href="<?= \App\Core\Framework::getUrl('app_admin_meal_foodstuff_add', ['mealId'=> $meal->getId()]); ?>" class="btn btn-primary-outline"><i class="fas fa-plus-circle"></i> Ajouter un ingredient</a></td>
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
    <a href="<?= \App\Core\Framework::getUrl('app_admin_foodstuff'); ?>" class="btn btn-primary-outline"><i class="fas fa-undo"></i> Retour </a>
</section>

<script type="text/javascript">

    $('#myBtn').click(function(){
        $('.addIngredient').show();
    })

</script>