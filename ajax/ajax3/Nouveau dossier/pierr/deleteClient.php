<?php

$codeError = true;

// connection avec votre DataBase (db) de MySql/MariaDB, grâce à PDO
$db = new PDO("mysql:host=localhost; dbname=votreSuperbeDataBase", 'VotreSuperbeAdmin', 'VotreSuperbeMotDePasse');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    $sth = $db->prepare("DELETE FROM `client` WHERE `id`=:clientId;");
    $sth->bindParam(':clientId', $_POST["where"], PDO::PARAM_STR);
    $sth->execute();
}
catch (PDOException $e){
    $codeError = $e->getCode();
}

echo json_encode($codeError);
?>