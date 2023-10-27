<?php

$codeError = true;
$db = new PDO("mysql:host=localhost; dbname=test", 'root', 'esraa3012');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_POST["type"] == "simple"){
    try {
        $myRequestSQL = $db->prepare("SELECT id, LastName, FirstName FROM client");
        $myRequestSQL->execute();
    
        $resultSQL = $myRequestSQL->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e){
        $codeError = $e->getCode();
    }
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
} elseif($_POST["type"] == "all") {
    try {
        $myRequestSQL = $db->prepare("SELECT LastName, FirstName, adresse, date_naissance FROM client WHERE id = :whereName");
        $myRequestSQL->bindParam(":whereName", $_POST['where'], PDO::PARAM_INT);
        $myRequestSQL->execute();
    
        $resultSQL = $myRequestSQL->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e){
        $codeError = $e->getCode();
    }
}

echo json_encode($resultSQL);