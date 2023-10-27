<?php
$clientToUpdateID = 0;
if (isset($_GET['clientToUpdateId'])){
    $clientToUpdateID = intval($_GET['clientToUpdateId']);
}

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
    $clientUPdate = $bdd->prepare('SELECT * FROM client WHERE id = :id');

    $clientUpdate->bindParam(':id', $clientToUpdateID, PDO::PARAM_INT);

    $clientUpdate->execute();

    $result = array($clientUpdate->rowCount());
    echo json_encode($result);
}
catch (PDOException $e) {
    echo $e->getCode();
}
