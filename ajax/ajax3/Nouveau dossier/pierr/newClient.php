<?php

// connection avec votre DataBase (db) de MySql/MariaDB, grâce à PDO
$db = new PDO("mysql:host=localhost; dbname=votreSuperbeDataBase", 'VotreSuperbeAdmin', 'VotreSuperbeMotDePasse');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$codeError = true;

try{
    $myRequestSQL = $db->prepare("INSERT INTO client (nom, prenom, adresse, date_naissance) VALUES ( :nom, :prenom, :adresse, :date_naissance )");
    $myRequestSQL->bindParam(':nom', $_POST['fname'], PDO::PARAM_STR);
    $myRequestSQL->bindParam(':prenom', $_POST['lname'], PDO::PARAM_STR);
    $myRequestSQL->bindParam(':adresse', $_POST['adresse'], PDO::PARAM_STR);
    $myRequestSQL->bindParam(':date_naissance', $_POST['date'], PDO::PARAM_STR);
    $myRequestSQL->execute();
}
catch (PDOException $e){
    $codeError = $e->getCode();
}

echo json_encode(["responseMYSQL"=>$codeError]);

?>