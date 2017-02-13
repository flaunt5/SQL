<?php

try {
    $database = new PDO('mysql:host=localhost;dbname=tryoout;port=3306;charset=utf8', 'test', 'password');
    $database->setAttribute(PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    return $e->getMessage();
}

if(isset($_POST['prix']) && isset($_POST['distance']) && isset($_POST['etoiles'])
    && isset($_POST['prix_radio']) && isset($_POST['distance_radio']) && isset($_POST['etoiles_radio'])) :
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
    try {
        $database->exec("ALTER VIEW The_Prix AS SELECT ".$infoMinMax['prix']."(Prix) The_Prix FROM hotel_sky;");
        $database->exec("ALTER VIEW The_Distance AS SELECT ".$infoMinMax['distance']."(Distance) The_Distance FROM hotel_sky;");
        $database->exec("ALTER VIEW The_NbEt AS SELECT ".$infoMinMax['etoiles']."(NbEt) The_NbEt FROM hotel_sky;");
    } catch (PDOException $e) {
        return $e->getMessage();
    }


    try {
        $theSecondQuery = $database->exec("ALTER VIEW hotel_sky AS SELECT IdH, Prix, Distance, NbEt 
                                        FROM Hotel H1 WHERE NOT EXISTS
                                            (SELECT  * FROM Hotel H2
                                                WHERE (H2.Prix ".$tabOperator['prix']." H1.Prix
                                                AND H2.Distance ".$tabOperator['distance']." H1.Distance
                                                AND H2.NbEt ".$tabOperator['etoiles']." H1.NbEt)
                                            AND (H2.Prix ".substr($tabOperator['prix'], 0, 1)." H1.Prix
                                            OR H2.Distance ".substr($tabOperator['distance'], 0, 1)." H1.Distance
                                            OR H2.NbEt ".substr($tabOperator['etoiles'], 0, 1)." H1.NbEt))");
    } catch (PDOException $e) {
        return $e->getMessage();
    }

    $operatorOrder = array();

    foreach ($infoMinMax as $minMaxKey => $minMaxValue){
        if($minMaxKey == "etoiles") {
            $key = "NbEt";
        } else {
            $key = $minMaxKey;
        }

        if($minMaxValue == "MAX"){
            $operatorOrder[$minMaxKey] = "The_" . $key . " / " . $key . "_norm";
        } else {
            $operatorOrder[$minMaxKey] = $key . "_norm" . " / " . "The_" . $key;
        }
    }

    try {
        $theThirdQuery = $database->exec("ALTER VIEW hotel_norm AS SELECT IdH,
                                               ".$operatorOrder['prix'].",
                                               ".$operatorOrder['distance'].",
                                               ".$operatorOrder['etoiles']."
                                             FROM hotel_sky, The_Prix, The_Distance, The_NbEt;");
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    $poidsPond = array();

    foreach ($infoPoids as $infoKey => $infoVal) {
        $poidsPond["$infoKey"] = round(floatval($infoVal)) * 0.01;
    }

    try {
        $theFourthQuery = $database->exec("ALTER VIEW hotel_pond AS
                                            SELECT IdH, TRUNCATE(".$poidsPond['prix']."*Prix_norm, 3) Prix_pond, TRUNCATE(".$poidsPond['distance']."*Distance_norm, 2) Distance_pond,
                                            TRUNCATE(".$poidsPond['etoiles']."*NbEt_norm, 3) NbEt_pond
                                            FROM hotel_norm;");
    } catch (PDOException $e) {
        return $e->getMessage();
    }

    try {
        $theFifthQuery = $database->exec("ALTER VIEW hotel_score AS
                            SELECT IdH, Prix_pond, Distance_pond, NbEt_pond,
                            TRUNCATE((Prix_pond+Distance_pond+NbEt_pond), 3) Score
                            FROM hotel_pond;");
    } catch (PDOException $e) {
        return $e->getMessage();
    }

    try {
        $theLastQuery = $database->exec("SELECT * FROM Hotel");
    } catch (PDOException $e) {
        return $e->getMessage();
    }


    /*while($row = $theLastQuery->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }*/

    echo "<pre>";
    var_export($database);
    die();


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
        $result_norm[$i]["IdH"] = $result[$i]["IdH"];
        $result_norm[$i]["Prix"] = round(floatval(($infoMinMax['prix'] == 'MIN') ? minimum($result, "Prix")/$result[$i]["Prix"] : $result[$i]["Prix"]/maximum($result, "Prix")),3);
        $result_norm[$i]["Distance"] = round(floatval(($infoMinMax['distance'] == 'MIN') ? minimum($result, "Distance")/$result[$i]["Distance"] : $result[$i]["Distance"]/maximum($result, "Distance")),3);
        $result_norm[$i]["NbEt"] = round(floatval(($infoMinMax['etoiles'] == 'MIN') ? minimum($result, "NbEt")/$result[$i]["NbEt"] : $result[$i]["NbEt"]/maximum($result, "NbEt")),3);
    }

    echo "<pre>";
    echo print_r($result_norm);
    return;

    $result_pond = array();

    for($i = 0; $i < count($result_norm); ++$i) {
        $result_pond[$i]["IdH"] = $result_norm[$i]["IdH"];
        $result_pond[$i]["Prix"] = round($infoPoids['prix']*$result_norm[$i]["Prix"],2);
        $result_pond[$i]["Distance"] = round($infoPoids['distance']*$result_norm[$i]["Distance"],2);
        $result_pond[$i]["NbEt"] = round($infoPoids['etoiles']*$result_norm[$i]["NbEt"],2);
    }

    for($i = 0; $i < count($result_norm); ++$i) {
        $result_pond[$i]["score"] = round($result_pond[$i]["Prix"]+$result_pond[$i]["Distance"]+$result_pond[$i]["NbEt"],2);
    }

    $database = null;

    $score  = array();

    foreach ($result_pond as $key => $row) {
        $score[$key] = $row['score'];
    }

    array_multisort($score, SORT_DESC, $result_pond);
    $guk = false;

    echo "<pre>";
    echo print_r($score) ;
    echo "\n" ;
    echo print_r($result_pond);
    return;
    ?>
    <table id="formResult" class="table table-striped table-hover">
        <thead class="result">
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
        <?php
        foreach ($result as $result_val) : ?>
            <tr <?php if($guk === false) :?> class="success"<?php $guk = true; endif; ?> >
                <td><?php echo $result_val['IdH'];?></td>
                <td><?php echo $result_val['Prix'];?></td>
                <td><?php echo $result_val['Distance'];?></td>
                <td><?php echo $result_val['NbEt'];?></td>
                <td><?php echo $result_val['score'];?></td>
            </tr>
            <?php
        endforeach;
        ?>
        </tbody>
    </table>
    <?php
    //end main
endif;
?>
