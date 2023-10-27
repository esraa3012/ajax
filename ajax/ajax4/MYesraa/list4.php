<?php
    require("bdd.php");
    $selectedID = json_decode(file_get_contents('php://input'), true);//Nombre d'enregistrements actuellement affichés
    $sql = $conn->prepare("SELECT id, LastName, adresse, date_naissance FROM client WHERE id = :id");
    $sql->bindParam(':id', $selectedID, PDO::PARAM_INT);
    $sql->execute();
    $res=$sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["data"=>$res]);
?>