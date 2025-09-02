<?php  
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "support";

try{
$conn = new PDO("mysql:servername=localhost;dbname=support", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "connection reussie";
}
catch (PDOException $e){
    die(" Connexion echoue : " . $e->getMessage());
}

?>