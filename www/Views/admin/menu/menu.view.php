<section class="content">
    <h1>Les Menu</h1>

    <div class="content-menu">
        <?php //todo lister les menus ?>
        <!--        --><?php //foreach (($dishes ? $dishes : []) as $dishe) { ?>

        <div class="menu" >
            <div class="div-close">
                <a href="" class="btn-close" onclick="return confirm('Voulez vous supprimer ce plat ?');"><i class="far fa-times-circle"></i></a>
            </div>
            <div class="title-menu">
                <h2> <a href="" class="btn-edit"><i class="fas fa-pen"></i></a></h2>
                <h2>  €</h2>
            </div>
            <hr class="separation-menu">
            <div class="list-plat">
                <?php //todo Lister les plats et/ou les ingredients du menu ?>
<!--                --><?php //foreach (($ingredients ? $ingredients : []) as $ingredient) {
                //                        if($dishe['id'] == $ingredient['idPlat']){
                //                            foreach (($aliments ? $aliments : []) as $aliment){
                //                                if($aliment['id'] == $ingredient["idAliment"]){  ?>
                <div class="plat">

                    <h3>Plat n°1</h3>
                    <ul>
                        <li>Ingredient</li>
                        <li>Ingredient</li>
                    </ul>
                </div>
<!--                --><?php
                //                                }
                //                            }
                //                        }
                //                    }
                //                    ?>


            </div>
            <a href="" style="display: flex;justify-content: center;" class="btn"><i style="display: flex;
    align-items: center;" class="fas fa-plus-circle"></i> &nbsp; Ajouter/Supprimer un Plat / Ingredient</a>
        </div>

        <a href="" class="menu" id="ajout-menu">
            <i  class="fas fa-plus-circle fa-10x"></i>
        </a>
    </div>
</section>