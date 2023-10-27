<?php

include('database.php');
$db=$conn;// database connection  

//legal input values
 $lastName     = legal_input($_POST['LastName']);
 $firstName     = legal_input($_POST['FristName']);
 $address = legal_input($_POST['address']);

   
if(!empty($lastName) && !empty($firstName) && !empty($address) ){
    //  Sql Query to insert user data into database table
    Insert_data($lastName,$firstName,$address);
}else{
 echo "All fields are required";
}
 
// convert illegal input value to ligal value formate
function legal_input($value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}

// // function to insert user data into database table
 function insert_data($lastName,$firstName,$address){
 
     global $db;

      $query="INSERT INTO client(LastName,FirstName,adresse) VALUES('$lastName','$firstName','$address')";

     $execute=mysqli_query($db,$query);
     if($execute==true)
     {
       echo "User data was inserted successfully";
     }
     else{
      echo  "Error: " . $sql . "<br>" . mysqli_error($db);
     }
 }

?>