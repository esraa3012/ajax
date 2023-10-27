<?php

$DB_HOST= "localhost";
$DB_USER= "test_admin";
$DB_PASS= "1234!letsgo";
$DB_NAME= "test";

try{
    // Initialise l'objet PDO avec les infos de connexion à la BDD
    $bdd = new PDO('mysql:dbname='.$DB_NAME.';host='.$DB_HOST, $DB_USER, $DB_PASS);

}catch (PDOExeption $e){
    echo $e->getCode();
}

try {
    $sql2 = $bdd->prepare('SELECT id, nom FROM client');
    $sql2->execute();
}
catch (PDOException $e) {
    echo $e->getCode();
}
$fetch = $sql2->fetchAll((PDO::FETCH_ASSOC));
echo json_encode($fetch);