<?php
$DB_HOST= "localhost";
$DB_USER= "test_admin";
$DB_PASS= "1234!letsgo";
$DB_NAME= "test";

try{
    // Initialise l'objet PDO avec les infos de connexion à la BDD
    $bdd = new PDO('mysql:dbname='.$DB_NAME.';host='.$DB_HOST, $DB_USER, $DB_PASS);

}catch (PDOExeption $e){
    echo json_encode("coucou".$e);
}

// Insertion des données dans la BDD 'test' table 'client'
if(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["adresse"]) && isset($_POST["date_naissance"])){

    if(!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["adresse"]) && !empty($_POST["date_naissance"])){

        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $adresse = $_POST["adresse"];
        $dateNaissance = $_POST["date_naissance"];

        // Prépare la requête SQL
        $insertDB = $bdd->prepare(
            "INSERT INTO client (nom,prenom,adresse,date_naissance) 
            VALUES (:nom,:prenom,:adresse,:date_naissance)");
        // $selectClient = $bdd->prepare(
        //     "SELECT nom FROM client"
        // );
        // Ajout d'une sécurité (on précise le type de données attendu)
        $insertDB->bindParam(':nom', $nom, PDO::PARAM_STR);
        $insertDB->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $insertDB->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $insertDB->bindParam(':date_naissance', $dateNaissance, PDO::PARAM_STR);
        
        $insertDB->execute();
        echo json_encode("Insertion réussie");
        // $insertDB->debugDumpParams();
        // $selectClient->execute();
        // $selectClient->debugDumpParams();
    }
}