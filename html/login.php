<?php
session_start();
include 'connection.php';

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    try{
    $sql = "SELECT UserID, UserName, Password, Role  FROM user WHERE UserName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

            if ($user && password_verify($password, $user['Password'])){
                $_SESSION['user_id'] = $user['UserID'];
                $_SESSION['username'] = $user['UserName'];
                $_SESSION['role'] = $user['Role']; 

             if ($user['Role'] === 'user') {
               header("Location: list.php");
             } else {
               header("Location: dash.php");
             }
              exit();

            }else{
                $_SESSION['error'] = "Incorrect username or password.";
                header("Location: login.php");
                exit();
            }
            
    }catch(PDOException $e){
        $_SESSION['error'] = "Error : " . $e->getMessage();
        header("Location: login.php");
        exit();
     
    }
}
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="../css/login1.css">
    <link rel="stylesheet" href="../Icon/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


    <form action="" method="post">
     <main>
        <header>
            <div class="head">
           <P class="for">LOGIN FORM</P>
           </div>
        </header>
        <div class="infos">
        <P><label for="text" class="log">UserName</label></P>
        <P><input type="text" name="username" class="int" required ></P>
       <P> <label for="text" class="log">Password</label></P>
        <P><input type="password" name="password" class="int" required></P>
       <P> <input type="submit" name="submit"  class="btn-login" value="LOGIN"></P>
       <h5><center>Don't have an account? <a href="sign in" class="sign">Sign In</a></center></h5>
       </div>
        
     </main>
    </form>
</body>
</html>