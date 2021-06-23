<section class="content">
    <h1>Les plats</h1>

    <div class="content-menu">

        <?php foreach (($dishes ? $dishes : []) as $dishe) { ?>
        <div class="menu" >
            <div class="title-menu">
                <h2><?= $dishe['nom']; ?></h2>
                <h2> <?= $dishe['prix']; ?> €</h2>
            </div>
            <hr class="separation-menu">
            <div class="list-plat">
                <?php foreach (($ingredients ? $ingredients : []) as $ingredient) {
                    if($dishe['id'] == $ingredient['idPlat']){
                        foreach (($aliments ? $aliments : []) as $aliment){
                            if($aliment['id'] == $ingredient["idAliment"]){  ?>
                            <div class="plat">
                                <h3><?= $aliment['nom']; ?></h3>
                                <ul>
                                    <li>Prix : <?= $aliment['prix']; ?> €</li>
                                    <li>Stock : <?= $aliment['stock']; ?></li>
                                </ul>
                            </div>
                            <?php
                            }
                        }
                    }
                }
                ?>
            </div>
            <button class="ajout-plat"><i class="fas fa-plus-circle"></i> Ajouter un Aliment</button>
        </div>
    <?php } ?>

        <a href="#" class="menu" id="ajout-menu">
            <i  class="fas fa-plus-circle fa-10x"></i>
        </a>
    </div>

</section>
