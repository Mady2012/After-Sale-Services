<?php
session_start();
include 'connection.php';


$sql1 = "SELECT GroupID, GroupName FROM groupe";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$groups = $stmt1->fetchAll(PDO::FETCH_ASSOC);


if(isset($_POST['submit'])){
if(isset($_POST['username'], $_POST['email'], $_POST['number'], $_POST['password'], $_POST['role'])){
$groupid = $_POST['groupid'];
$username = $_POST['username'];
$email = $_POST['email'];
$number = $_POST['number'];
$password = ($_POST['password']);
$role = $_POST['role'];

$password_hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO user(GroupID, UserName, Email, PhoneNumber, Password, Role) VALUES(:groupid, :username, :email, :number, :password, :role)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':groupid', $groupid);
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
    <link rel="stylesheet" href="../css/signin.css">
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

        <div class="left">
           <P><label for="text" class="log">GoupID</label></P>
          <select name="groupid" id="groupid" class="int" required>
            <option value="">Choose a group</option>
            <?php foreach ($groups as $group): ?>
                <option value="<?php echo $group['GroupID']; ?>"><?php echo $group['GroupName']; ?>
            </option>
           <?php endforeach; ?>
          </select>
        </div>
        <div class="right">
          <P><label for="text" class="log">UserName</label></P>
          <P><input type="text" name="username" class="int" required ></P>
        </div>
        <div class="left">
          <P> <label for="text" class="log">Email</label></P>
          <P><input type="text" name="email" class="int" required></P>
        </div>
        <div class="right">
          <p><label for="text" class="log">Phone Number</label></p>
          <p><input type="number" name="number" class="int" required></p>
        </div>
        <div class="left">
         <p><label for="text" class="log">Password</label></p>
         <input type="password" name="password" class="int" required>
         <p><label for="text" class="log">Role</label></p>
         <select name="role" id="role" class="int">
         <option value=""></option>
         <option value="user">User</option>
         <option value="technician">Technician</option>
         <option value="admin">Administrator</option>
         </select>
        </div>
       <p> <input type="submit" name="submit" class="btn-login" value="SIGN IN"></p>
       <h5><center>Do you have an account? <a href="login.php">Login</a></center></h5>
       </div>
        
     </main>
    </form>
</body>
</html>