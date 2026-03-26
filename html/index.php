<?php
session_start();
$username = $_SESSION['username'] ?? null; // null si pas connecté
?>

<html lang="en">
<head>
     <link rel="stylesheet" href="../css/style1.css">
   <!-- <link rel="stylesheet" href="../css/dash.css"> -->
    <link rel="stylesheet" href="../Icon/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="#" method="post">
        <div class="container">

            <nav class="navigation">
              <img src="../logo_inov.png" class="image" alt="">

             <div class="ref">
              <a href="request.php">Support</a>
              <a href="list.php">Consult my Supports</a>

             
             </div>

             <?php if ($username): ?>
                <span style="font-weight:bold;" class="user-name">HEY, <?= htmlspecialchars($username) ?></span>
          <?php else: ?>
                <span>Welcome, Guest!</span>
                  <a href="login.php" style="color:orange; text-decoration:none;">Log In</a>
            <?php endif; ?>
              <div class="profile">
                <i class="fa fa-bell"></i>
               <i class="fa fa-circle-user"></i>
               <!-- <a href="disconnect.php"><i class="fa fa-sign-out-alt"></i></a> -->

             </div>

            </nav>

           <div class="content">
            <div class="left">
              <h1>WELCOME TO OUR AFTER-SALES SERVICE APPLICATION</h1>
              <p>You are free to express your needs and problems.</p><br>
              <a href="request.php"><input type="button"class="btn" value="Demand a support"></a>
            </div>
              <div class="right">
                <img src="../image.jpg" class="ima" alt="">
              </div>
          </div>

                <!-- <div class="background">
                    <img src="../image.jpg" class="ima" alt="">
                </div> -->
                 

                

        </div>


    </form>
</body>
</html>