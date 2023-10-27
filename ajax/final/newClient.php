<?php


$db = new PDO("mysql:host=localhost; dbname=test", 'root', 'esraa3012');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$codeError = true;

try{
    $myRequestSQL = $db->prepare("INSERT INTO client (LastName, FirstName, adresse, date_naissance) VALUES ( :nom, :prenom, :adresse, :date_naissance )");
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