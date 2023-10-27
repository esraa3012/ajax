<?php
$clientToShowID = 0;
if (isset($_GET['clientToShowID'])){
    $clientToShowID = intval($_GET['clientToShowID']);
}

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
    $sql2 = $bdd->prepare('SELECT prenom,adresse,date_naissance FROM client WHERE id=:id');

    $sql2->bindParam(':id', $clientToShowID, PDO::PARAM_INT);

    $sql2->execute();

    $fetch = $sql2->fetch((PDO::FETCH_ASSOC));
    echo json_encode($fetch);
}
catch (PDOException $e) {
    echo $e->getCode();
}
