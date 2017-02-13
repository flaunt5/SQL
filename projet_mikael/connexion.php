<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 17/01/2017
 * Time: 08:48
 */
    try {
        $user = "root";
        $pass = "password";

        $pdo = new PDO('mysql:host=localhost;dbname=tryoout', $user, $pass);
        // Normaliser l'affichage des erreurs avec des constantes de la class PDO
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
        die('Erreur: '.$e->getMessage());
    }

?>