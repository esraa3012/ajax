<?php
$servername = "localhost";
$username = "root";
$password = "esraa3012";
$dbname = "test";

$limit = 10;
$errorCode = true;
try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sth = $conn->prepare("SELECT `LastName`, `FirstName`, `adresse`, `date_naissance` FROM `client` ORDER BY `LastName` LIMIT ".$limit);
    $sth->execute();
    $res=$sth->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    $errorCode = $e->getCode();
}
$conn = null;
echo json_encode(["data"=>$res]);

$record=json_encode($res[0]);
header('Record-number: '.$record);
header('Select-number: '.$limit);

?>