<?php
session_start();
include 'connection.php';

if(isset($_POST['submit'])){
$groupname = $_POST['groupname'];
$description = $_POST['description'];


$sql = "INSERT INTO groupe (GroupName, Description) VALUES(:groupname, :description)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':groupname', $groupname);
$stmt->bindParam(':description', $description);

try{
    $stmt->execute();
    echo 'Your group have been created !';
}
catch(PDO_Exception $e){
    echo "Erreur" .$sql . "<br>" . $e->getMessage();
  }

}


?>

<html lang="en">
<head>
    <link rel="stylesheet" href="../css/sign in.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="#" method="post">
     <main>
        <header>
            <div class="head">
           <P class="for">Group Form</P>
           </div>
        </header>
        <div class="infos">
        <P><label for="text" class="log">GroupeName</label></P>
        <P><input type="text" name="groupname" class="int" required ></P>
       <P> <label for="text" class="log">Description</label></P>
        <P><input type="text" name="description" class="int" required></P>
       <P> <input type="submit" name="submit" class="btn-login" value="SIGN IN"></P>
       </div>
        
     </main>
    </form>
</body>
</html>