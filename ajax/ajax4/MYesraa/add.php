<?php
require("bdd.php");
$champs=["name","firstname","address","birthdate"];
$nbchamps=count($champs);
$res=[];
$inputsErrors=0;

foreach ($champs as $key => $value) {
    // $res[$key]=$value;
    if (isset($_POST[$value])) {
        $res[$value] = ["isset" => 1];
        $inputsErrors++;
        if (!empty($_POST[$value])) {
            $res[$value] += ["empty" => 1];
            $inputsErrors++;
        }else{
            $res[$value] += ["empty" => 0];
            $inputsErrors--;
        }
        
    }else{
        $res[$value] = ["isset" => 0];
        $inputsErrors--;
    }
}
// print_r($res);
if ($nbchamps*2===$inputsErrors) {
    $lastname = htmlspecialchars($_POST['name']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $caddress = htmlspecialchars($_POST['address']);
    $birthdate = htmlspecialchars($_POST['birthdate']);
    
    $error=true;
    try{
        $sql = $conn->prepare("INSERT INTO client (LastName, FirstName, adresse, date_naissance) VALUES ( :lastname, :firstname, :caddress, :birthdate )");
        $sql->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $sql->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $sql->bindParam(':caddress', $caddress, PDO::PARAM_STR);
        $sql->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
        $sql->execute();
    }
    catch(PDOException $error){
        echo "Erreur SQL : " . $error->getMessage();
    }
    $conn = null;
    echo json_encode(["responseServer"=>true, "responseDB"=>$error]);

} else {
    echo json_encode(["responseServer"=>$res]);
}
?>