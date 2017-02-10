<?php
    require_once("connexion.php");
    if(isset($_POST['poid_prix']) && isset($_POST['poid_distance']) && isset($_POST['poid_nbEt'])
        && isset($_POST['level_prix']) && isset($_POST['level_prix']) && isset($_POST['level_prix'])) {

        $poid_prix = $_POST['poid_prix'];
        $poid_distance = $_POST['poid_distance'];
        $poid_nbEt = $_POST['poid_nbEt'];

        $level_prix = $_POST['level_prix'];
        $level_distance = $_POST['level_distance'];
        $level_nbEt = $_POST['level_nbEt'];

        //var_dump($poid_prix, $poid_distance, $poid_nbEt, $level_prix, $level_distance, $level_nbEt);

        // normalisation des attributs min et max pour l'extraction des attributs skyline
        if($level_prix == "min") {
            $tabOperator["prix"] = "<=";
        } else {
            $tabOperator["prix"] = ">=";
        }

        if($level_distance == "min") {
            $tabOperator["distance"] = "<=";
        } else {
            $tabOperator["distance"] = ">=";
        }

        if($level_nbEt == "min") {
            $tabOperator["nbEt"] = "<=";
        } else {
            $tabOperator["nbEt"] = ">=";
        }

        $query = $pdo->prepare('SELECT * FROM hotel H1 WHERE NOT EXISTS 
                                ( SELECT *
                                  FROM HOTEL H2
                                  WHERE (H2.prix ' . $tabOperator["prix"] . 'H1.prix
                                  AND H2.distance ' . $tabOperator["distance"] . 'H1.distance
                                  AND H2.nbEt ' . $tabOperator["nbEt"] . 'H1.nbEt)
                                  AND (H2.prix ' . substr($tabOperator["prix"], 0, 1) .'H1.prix
                                  OR H2.distance ' . substr($tabOperator["distance"], 0, 1) .'H1.distance
                                  OR H2.nbEt ' . substr($tabOperator["nbEt"], 0, 1) .'H1.nbEt))');

        $query->execute();

        $result = array();

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }

        //var_dump($result);

        // Minimum
        function minimum($tab, $attribut) {
            $min = $tab[0]["$attribut"];
            for($i = 0; $i < count($tab); ++$i) {
                if($tab[$i]["$attribut"] < $min) {
                    $min = $tab[$i]["$attribut"];
                }
            }
            return $min;
        }

        // Maximum
        function maximum($tab, $attribut) {
            $max = $tab[0]["$attribut"];
            for($i = 0; $i < count($tab); ++$i) {
                if($tab[$i]["$attribut"] > $max) {
                    $max = $tab[$i]["$attribut"];
                }
            }
            return $max;
        }

        // Normalisation des critères :
        $result_norm = array();

        for($i = 0; $i < count($result); ++$i) {
            $result_norm[$i]["id"] = $result[$i]["id"];
            $result_norm[$i]["prix"] = round(floatval(($level_prix == 'min') ? minimum($result, "prix")/$result[$i]["prix"] : $result[$i]["prix"]/maximum($result, "prix")),3);
            $result_norm[$i]["distance"] = round(floatval(($level_distance == 'min') ? minimum($result, "distance")/$result[$i]["distance"] : $result[$i]["distance"]/maximum($result, "distance")),3);
            $result_norm[$i]["nbEt"] = round(floatval(($level_nbEt == 'min') ? minimum($result, "nbEt")/$result[$i]["nbEt"] : $result[$i]["nbEt"]/maximum($result, "nbEt")),3);
        }
        //var_dump($result_norm);

        // Pondération des critères
        $result_pond = array();

        for($i = 0; $i < count($result_norm); ++$i) {
            $result_pond[$i]["id"] = $result_norm[$i]["id"];
            $result_pond[$i]["prix"] = round($poid_prix*$result_norm[$i]["prix"],2);
            $result_pond[$i]["distance"] = round($poid_distance*$result_norm[$i]["distance"],2);
            $result_pond[$i]["nbEt"] = round($poid_nbEt*$result_norm[$i]["nbEt"],2);
        }
        //var_dump($result_pond);

        // Agrégation des critères
        for($i = 0; $i < count($result_norm); ++$i) {
            $result_pond[$i]["score"] = round($result_pond[$i]["prix"]+$result_pond[$i]["distance"]+$result_pond[$i]["nbEt"],2);
        }
        //var_dump($result_pond);

        // Fermeture de la connexion
        $pdo = null;

        $score  = array();

        // Tri des score par ordres décroissants
        foreach ($result_pond as $key => $row) {
            $score[$key] = $row['score'];
        }

        //var_dump($score);
        array_multisort($score, SORT_DESC, $result_pond);
        //var_dump($result_pond);

        echo json_encode($result_pond);

        return;
    }
?>