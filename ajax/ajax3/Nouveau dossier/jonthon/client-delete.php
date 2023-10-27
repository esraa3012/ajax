<?php
$clientToDeleteID = 0;
if (isset($_GET['clientToDeleteID'])){
    $clientToDeleteID = intval($_GET['clientToDeleteID']);
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
    $clientSup = $bdd->prepare('DELETE FROM client WHERE id=:id');

    $clientSup->bindParam(':id', $clientToDeleteID, PDO::PARAM_INT);

    $clientSup->execute();

    $result = array($clientSup->rowCount());
    echo json_encode($result);
}
catch (PDOException $e) {
    echo $e->getCode();
}