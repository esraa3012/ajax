<?php
$servname = "localhost"; $dbname = "test"; $user = "root"; $pass = "esraa3012";

try{
    $conn = new PDO("mysql:host=$servname;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}  
catch(PDOException $e){
    echo "Erreur SQL : " . $e->getMessage();
}
?>