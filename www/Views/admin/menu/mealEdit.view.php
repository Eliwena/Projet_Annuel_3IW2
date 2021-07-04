<?php

use App\Core\Helpers;

?>
<section class="content">

    <h1>Edition des plats du menu</h1>

    <h2> <?= $menu->getName();?></h2>

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
        <?php foreach (($menuMeals ? $menuMeals : []) as $menuMeal) {
            ?>
            <tr>
                <td><?= $menuMeal['mealId']['id']; ?></td>
                <td><?= $menuMeal['mealId']['name']; ?></td>
                <td><?= $menuMeal['mealId']['price']; ?></td>
                <td class="center action-icon">
                    <a class="delete-icon" href="<?= \App\Core\Framework::getUrl('app_admin_menu_meal_delete', ['mealId' => $menuMeal['mealId']['id'], 'menuId'=> $menu->getId()]); ?>"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="4" class="center"><a href="<?= \App\Core\Framework::getUrl('app_admin_menu_meal_add', ['menuId'=> $menu->getId()]); ?>" class="btn "><i class="fas fa-plus-circle"></i> Ajouter un plat</a></td>
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