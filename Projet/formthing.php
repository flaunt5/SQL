<?php

    $database = new PDO('mysql:host=localhost;dbname=tryoout;port=3306;charset=utf8', 'root', '');

    if(isset($_POST['prix']) && isset($_POST['distance']) && isset($_POST['etoiles'])
        && isset($_POST['prix_radio']) && isset($_POST['distance_radio']) && isset($_POST['etoiles_radio'])) {
        $result = array();

        $tabOperator = array();

        $infoPoids = array(
            "prix" => $_POST['prix'],
            "distance" => $_POST['distance'],
            "etoiles" => $_POST['etoiles']
        );
        $infoMinMax = array(
            "prix" => $_POST['prix_radio'],
            "distance" => $_POST['distance_radio'],
            "etoiles" => $_POST['etoiles_radio']
        );

        foreach ($infoMinMax as $minMaxKey => $minMaxValue){
            if($minMaxValue == "MAX"){
                $tabOperator[$minMaxKey] = '>=';
            } else {
                $tabOperator[$minMaxKey] = '<=';
            }
        }

        $theQuery = $database->prepare("SELECT * FROM Hotel H1 WHERE NOT EXISTS 
                                          (SELECT  * FROM Hotel
                                           WHERE (H2.prix :operator1 H1.prix
                                           AND H2.distance :operator2 H1.distance
                                           AND H2.nbet :operator3 H1.nbet)
                                           AND (H2.prix :operator4 H1.prix
                                           OR H2.distance :operator5 H1.distance
                                           OR H2.etoiles :operator6 H1.nbet))");

        $theQuery->execute(
            ':operator1' => $tabOperator['prix'],
            ':operator2' => $tabOperator['distance'],
            ':operator3' => $tabOperator['etoiles'],
            ':operator4' => substr($tabOperator['prix'], 0, 1),
            ':operator5' => substr($tabOperator['distance'], 0, 1),
            ':operator6' => substr($tabOperator['etoiles'], 0, 1),
    );
        
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }

        function minimum($tab, $attribut) {
            $min = $tab[0]["$attribut"];
            for($i = 0; $i < count($tab); ++$i) {
                if($tab[$i]["$attribut"] < $min) {
                    $min = $tab[$i]["$attribut"];
                }
            }
            return $min;
        }

        function maximum($tab, $attribut) {
            $max = $tab[0]["$attribut"];
            for($i = 0; $i < count($tab); ++$i) {
                if($tab[$i]["$attribut"] > $max) {
                    $max = $tab[$i]["$attribut"];
                }
            }
            return $max;
        }

        $result_norm = array();

        for($i = 0; $i < count($result); ++$i) {
            $result_norm[$i]["id"] = $result[$i]["id"];
            $result_norm[$i]["prix"] = round(floatval(($infoMinMax['prix'] == 'MIN') ? minimum($result, "prix")/$result[$i]["prix"] : $result[$i]["prix"]/maximum($result, "prix")),3);
            $result_norm[$i]["distance"] = round(floatval(($infoMinMax['distance'] == 'MIN') ? minimum($result, "distance")/$result[$i]["distance"] : $result[$i]["distance"]/maximum($result, "distance")),3);
            $result_norm[$i]["etoiles"] = round(floatval(($infoMinMax['etoiles'] == 'MIN') ? minimum($result, "etoiles")/$result[$i]["etoiles"] : $result[$i]["etoiles"]/maximum($result, "etoiles")),3);
        }

        $result_pond = array();

        for($i = 0; $i < count($result_norm); ++$i) {
            $result_pond[$i]["id"] = $result_norm[$i]["id"];
            $result_pond[$i]["prix"] = round($infoPoids['prix']*$result_norm[$i]["prix"],2);
            $result_pond[$i]["distance"] = round($infoPoids['distance']*$result_norm[$i]["distance"],2);
            $result_pond[$i]["etoiles"] = round($infoPoids['etoiles']*$result_norm[$i]["etoiles"],2);
        }

        for($i = 0; $i < count($result_norm); ++$i) {
            $result_pond[$i]["score"] = round($result_pond[$i]["prix"]+$result_pond[$i]["distance"]+$result_pond[$i]["etoiles"],2);
        }
    }

 ?>
<table id="formResult" class="table table-bordered">
    <thead>
        <tr>
            <th>
            IdH
            </th>
            <th>
            Prix
            </th>
            <th>
            Distance
            </th>
            <th>
            NbEt
            </th>
            <th>
            Score
            </th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>