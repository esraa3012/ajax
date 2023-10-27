<?php
$servername = "localhost";
$username = "root";
$password = "esraa3012";
$dbname = "test";
    
  

    // GET variables from xmlhttpCreate
    $lName = $_POST['LastName'];
    $fName = $_POST['FristName'];
    $adresse = $_POST['addresse'];
    $date_naissance = $_POST['date_naissance'];

    // Connect to the database
    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $sql = $conn->prepare("INSERT INTO client(LastName,FirstName,adresse,date_naissance) VALUES(:LastName,:FristName,:addresse,:date_naissance)");
        $sql->bindParam(':LastName', $lName, PDO::PARAM_STR);
        $sql->bindParam(':FristName', $fName, PDO::PARAM_STR);
        $sql->bindParam(':addresse', $adresse, PDO::PARAM_STR);
        $sql->bindParam(':date_naissance', $date_naissance, PDO::PARAM_STR);
        $sql->execute();
        echo json_encode("ok");
    }
    catch(PDOException $e){
        echo $e->getCode();
    }

  
?>