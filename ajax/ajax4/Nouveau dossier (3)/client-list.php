<?php

$DB_HOST= "localhost";
$DB_USER= "root";
$DB_PASS= "esraa3012";
$DB_NAME= "test";

try{
    // Initialise l'objet PDO avec les infos de connexion à la BDD
    $bdd = new PDO('mysql:dbname='.$DB_NAME.';host='.$DB_HOST, $DB_USER, $DB_PASS);

}catch (PDOExeption $e){
    echo $e->getCode();
}

try {
    $sql2 = $bdd->prepare('SELECT id, LastName FROM client');
    $sql2->execute();
}
catch (PDOException $e) {
    echo $e->getCode();
}
$fetch = $sql2->fetchAll((PDO::FETCH_ASSOC));
echo json_encode($fetch);