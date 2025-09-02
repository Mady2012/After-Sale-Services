<?php
session_start();
include 'connection.php';

if(isset($_POST['submit'])){
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
if(isset($_POST['username'], $_POST['email'], $_POST['number'], $_POST['password'], $_POST['role'])){
$username = $_POST['username'];
$email = $_POST['email'];
$number = $_POST['number'];
$password = ($_POST['password']);
$role = $_POST['role'];

$password_hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO user(UserName, Email, PhoneNumber, Password, Role) VALUES(:username, :email, :number, :password, :role)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':number', $number);
$stmt->bindParam(':password', $password_hashed);
$stmt->bindParam(':role', $role);

try{
    $stmt->execute();
    echo 'Your account have been created successfully !';
}
catch(PDO_Exception $e){
    echo "Erreur" .$sql . "<br>" . $e->getMessage();
  }

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
           <P class="for">SIGN_IN FORM</P>
           </div>
        </header>
        <div class="infos">
        <P><label for="text" class="log">UserName</label></P>
        <P><input type="text" name="username" class="int" required ></P>
       <P> <label for="text" class="log">Email</label></P>
        <P><input type="text" name="email" class="int" required></P>
        <p><label for="text" class="log">Phone Number</label></p>
    <input type="number" name="number" class="int" required>
    <p><label for="text" class="log">Password</label></p>
    <input type="password" name="password" class="int" required>
    <p><label for="text" class="log">Role</label></p>
    <select name="role" id="role" class="int">
    <option value=""></option>
    <option value="user">User</option>
    <option value="technician">Technician</option>
    <option value="admin">Administrator</option>
    </select>
       <P> <input type="submit" name="submit" class="btn-login" value="SIGN IN"></P>
       </div>
        
     </main>
    </form>
</body>
</html>