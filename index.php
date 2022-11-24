<?php

require "dataBase.class.php";
require "personnage.class.php";
require "lede.class.php";

$traitement = $_SERVER["PHP_SELF"];

$joueurs = []

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>TP POO - Jeu de combat</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

    <div class="title">

        <div class="title-img">
            <img src="https://notion-emojis.s3-us-west-2.amazonaws.com/prod/svg-twitter/1f47e.svg" width="80" height="80">
        </div>
        <div class="title-name">
            <h1>TP POO</h1>
            <h2>Q46 - JEU DE COMBAT</h2>
        </div>

    </div>


    <div class="tableau">

        <div class="personnages tb1">
            <form action="<?= $traitement ?>" method="get">

                <h2>Créer un nouveau personnage</h2>
                <?php if (isset($_GET['error'])) {
                    echo "<p>" . $_GET['error'] . "</p>";
                } ?>

                <input class="new-perso" name="personnage" type="text" placeholder="Nom du personnage">
                <input class="new-perso" name="nouveau" type="submit" value="Enregistrer le personnage">

            </form>

        </div>

        <div class="personnages tb2">

            <h2>Liste des personnages disponibles</h2>

            <?php

            $database = new Database("localhost", "root", "q46_fg", "");
            $database->connect();
            $database->prepReq("SELECT * FROM personnages");
            $personnages = $database->fetchData();

            echo "<table>";

            echo "<thead>";

            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nom</th>";
            echo "<th>Point de Vie</th>";
            echo "<th>Force d'attaque</th>";
            echo "<th>Point d'attaque</th>";
            echo "<th>Selection</th>";
            echo "<th colspan='2'>Options</th>";
            echo "</tr>";

            echo "</thead>";

            echo "<tbody>";

            foreach ($personnages as $personnage) {

                echo "<tr>";
                echo "<form method='get' action='$traitement' class='form-1'>";

                echo "<td><input type='hidden' name='id' value='{$personnage['id']}'>{$personnage['id']}</td>";

                echo "<td><input class='name-perso' type='hidden' name='nom' value='{$personnage['nom']}'>{$personnage['nom']}</td>";
                echo "<td>{$personnage['vie']}</td>";
                echo "<td>{$personnage['force_attaque']}</td>";
                echo "<td>{$personnage['point_attaque']}</td>";

                echo "<td><input type='checkbox' name='ajouter[]' value='{$personnage['nom']}' class='check-perso'></td>";
                echo "<td><input type='button' name='modifier' value='Modifier'class='modif-perso'></td>";
                echo "<td><input type='button' name='supprimer' value='Supprimer le personnage' class='red supp-perso'></td>";

            }

            echo "</tr>";

            echo "</tbody>";


            echo "</table>";
            echo "<input class='options lancer-partie' name='start' type='button' value='LANCER LA PARTIE !'>";
            echo "</form>";
            ?>

        </div>

    </div>

<!--    <script src="script.js"></script>-->

    </body>

    </html>

<?php

if (isset($_GET['modifier'])) {
    echo $_GET['nom'];
    $database->modification($_GET['id'], $_GET['nom']);
    echo "Modifier";
    header("location:index.php");

}


if (isset($_GET['start'])) {

    $joueurs = array();

    foreach($_GET['ajouter'] as $nom) {

        $personnage = new Personnage($nom);
        $joueurs[] = $personnage;
//        echo "$nom<br>";
    }

    game($joueurs);

}

if (isset($_GET['supprimer'])) {
    $id = $_GET["id"];
    echo "supprimer";
    $database->supprimer($id);
    header("location:index.php");
}

if (isset($_GET['nouveau']) && !empty($_GET['personnage'])) {
    echo "Nouveau";
    $nom = $_GET['personnage'];
    $database->nouveau($nom);
//    header("location:index.php?error=Personnage existant");
    header("location:index.php");
}

function game($joueurs) {

    echo "<div class='text-game'>";

    echo "<div class='text-effect'>";

    echo "<h2>Lancement de la partie</h2>";

    echo "<h3>Définition de la force d'attaque</h3><br>";

    $indice = -1;
    $indiceMemoire = 0;
    $valeurMax = 0;

    foreach ($joueurs as $joueur) {

        $indice++;

        $lanceLeDe = new Lede(6);

        $valeurduDe = $lanceLeDe->lanceLeDe();

        $joueur->set_force_attaque($valeurduDe);

        echo "<h4> Valeur du dé lancé par " . $joueur->get_nom() . " : " . $joueur->get_attaque() . "</h4>" ;

        if ($valeurduDe > $valeurMax) {

            $valeurMax = $valeurduDe;
            $indiceMemoire = $indice;
        }

    }

    echo "<br><h3>" . $joueurs[$indiceMemoire]->get_nom() . " commence la partie !</h3>";


    $id = $indiceMemoire;
    $gaming = true;

    $gamingJava = [];

    while ($gaming) {

        $lanceLeDe = new Lede(6);
        $valeurduDe = $lanceLeDe->lanceLeDe();

        if ($id == 0) {

            echo "<br><h4>" . $joueurs[$id]->get_nom() . " lance le dé, résultat : " . $valeurduDe . "</h4>";

            $attaque = $joueurs[$id]->attaque($valeurduDe);
            $joueurs[$id+1]->degat($attaque);

            echo "<h4>" . $joueurs[$id]->get_nom() . " attaque "  . $joueurs[$id+1]->get_nom() . " avec " . $attaque . " points</h4>";
            echo "<br><h4>Il reste " . $joueurs[$id+1]->get_vie() . " point a " . $joueurs[$id+1]->get_nom() . "</h4>";

            if ($joueurs[$id+1]->get_vie() == 0) {
              $gaming = false;
            }

            $obj = (object) array
            ('de' => $valeurduDe,
                'attaquant' =>  $joueurs[$id]->get_nom(),
                'valeurAttaque' => $attaque,
                'attaque' => $joueurs[$id+1]->get_nom(),
                'DegatAttaque' => $attaque
                );

            $gamingJava[] = $obj;

        } else if ($id == 1) {

//            echo "<br>Valeur du de lancé " . $valeurduDe;

            echo "<br><h4>" . $joueurs[$id]->get_nom() . " lance le dé, résultat : " . $valeurduDe . "</h4>";

            $attaque = $joueurs[$id]->attaque($valeurduDe);
            $joueurs[$id-1]->degat($attaque);

            echo "<h4>" . $joueurs[$id]->get_nom() . " attaque "  . $joueurs[$id-1]->get_nom() . " avec " . $attaque . " points<h4>";
            echo "<br><h4>Il reste " . $joueurs[$id-1]->get_vie() . " point a " . $joueurs[$id-1]->get_nom() . "</h4>";

            if ($joueurs[$id-1]->get_vie() == 0) {
                $gaming = false;
            }

            $obj = (object) array
            ('de' => $valeurduDe,
                'attaquant' =>  $joueurs[$id]->get_nom(),
                'valeurAttaque' => $attaque,
                'attaque' => $joueurs[$id-1]->get_nom(),
                'DegatAttaque' => $attaque
            );

            $gamingJava[] = $obj;

        }



        $id++;
        if ($id > count($joueurs)) {
            $id = 0;
        }



    }

    echo "<br><h2>Fin de la partie !</h2>";

//    var_dump($gamingJava);
    $arr = 11;

    ?>


    <script>

        //let gaming = <?//= $gamingJava ?>//;
        let gaming = <?= json_encode($gamingJava) ?>;

    </script>



    <?php

    echo "</div>";
    echo "</div>";


}

function timer(){

    $max = 5000;

    for ($t = 0 ; i< $max; $t++) {

    }

}

?>
<script src="script.js"></script>