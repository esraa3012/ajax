<?php
$user = 'root';
$pass = 'esraa3012';

try {
    $dbh = new PDO('mysql:host=localhost;dbname=CHAUSSURES', $user, $pass);
    
    
   
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . 
    die();
}

function verifyField($field){
    
    if(isset($field) && !empty($field)){
        return htmlspecialchars($field);
    }
}
// if(isset($_POST['color']) && !empty($_POST['color'])){
    //     $color = htmlspecialchars($_POST['color']);//color name for name ih html
    // }
$color = verifyField($_POST['color']);
$size = verifyField($_POST['size']);
$category = verifyField($_POST['category']);
$nameshous = verifyField($_POST['nameshous']);

$requestcolor = "INSERT INTO COULEUR (NOM) VALUES (:colorname)";//couleur name for table ,nomcouleur name for colom in the table ,colorname like i want any think
$requestsize = "INSERT INTO TAILLE (TAILLE) VALUES (:sizename)";
$requestcategory = "INSERT INTO CATEGORIE (NOM) VALUES (:categoryname)";
$requestshous = "INSERT INTO CHAUSSURE (NOM,ID_CATEGORIE,ID_COULEUR,ID_TAILLE) VALUES (:shousname, :id_category, :id_color, :id_size)";

//last index
$requestId = "SELECT LAST_INSERT_ID()";

//insert color
$rescolor = $dbh->prepare($requestcolor);
$rescolor->bindParam('colorname', $color, PDO::PARAM_STR);//colorname like values 
$rescolor->execute();

//get last id
$resIdcolor = $dbh->prepare($requestId);
$resIdcolor->execute();
$idcolor = $resIdcolor->fetch();
//var_dump($idcolor);

$ressize = $dbh->prepare($requestsize);
$ressize->bindParam('sizename', $size, PDO::PARAM_INT);//colorname like values 
$ressize->execute();

$resIdsize = $dbh->prepare($requestId);
$resIdsize->execute();
$idsize = $resIdsize->fetch();
//var_dump($idsize);

$rescategory = $dbh->prepare($requestcategory);
$rescategory->bindParam('categoryname', $category, PDO::PARAM_STR);//colorname like values 
$rescategory->execute();

$resIdcategory = $dbh->prepare($requestId);
$resIdcategory->execute();
$idcategory = $resIdcategory->fetch();
//var_dump($idcategory);

$resshous = $dbh->prepare($requestshous);
$resshous->bindParam('shousname', $nameshous, PDO::PARAM_STR);//colorname like values 
$resshous->bindParam('id_category', $idcategory[0], PDO::PARAM_INT);
$resshous->bindParam('id_color', $idcolor[0], PDO::PARAM_INT);
$resshous->bindParam('id_size', $idsize[0], PDO::PARAM_INT);
$resshous->execute();



echo json_encode($_POST);