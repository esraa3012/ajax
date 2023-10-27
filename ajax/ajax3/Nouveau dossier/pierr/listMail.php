<?php

$codeError = true;

// connection avec votre DataBase (db) de MySql/MariaDB, grâce à PDO
$db = new PDO("mysql:host=localhost; dbname=votreSuperbeDataBase", 'VotreSuperbeAdmin', 'VotreSuperbeMotDePasse');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Si c'est la première request (donc simple), on récupère juste le nom du client
if ($_POST["type"] == "simple"){
    try {
        $myRequestSQL = $db->prepare("SELECT id, nom FROM client");
        $myRequestSQL->execute();
    
        $resultSQL = $myRequestSQL->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e){
        $codeError = $e->getCode();
    }

// Si c'est une request après avoir cliquer sur showMore, alors on récupère le reste des info
} elseif($_POST["type"] == "more"){
    try {
        $myRequestSQL = $db->prepare("SELECT adresse, date_naissance FROM client WHERE id = :whereName");
        $myRequestSQL->bindParam(":whereName", $_POST['where'], PDO::PARAM_INT);
        $myRequestSQL->execute();
    
        $resultSQL = $myRequestSQL->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e){
        $codeError = $e->getCode();
    }
}

echo json_encode($resultSQL, $codeError);