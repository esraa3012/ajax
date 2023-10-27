<?php
    require("bdd.php");
    
    $sql = $conn->prepare("SELECT id, LastName FROM client");
    $sql->execute();
    $res=$sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["data"=>$res]);
?>