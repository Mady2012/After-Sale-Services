<?php
// include 'connection.php';
  

// if ($action == 'view' && $id) {

//     $stmt = $conn->prepare("SELECT * FROM request WHERE RequestID = :id");
//     $stmt->execute(['id' => $id]);
//     $request = $stmt->fetch(PDO::FETCH_ASSOC);

session_start();
include 'connection.php';

// $id = $_GET['id'] ?? '';

// if (!$id) {
//     die("Invalid request ID");
// }

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

$stmt = $conn->prepare("SELECT * FROM request WHERE RequestID = :id");
$stmt->execute(['id' => $id]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$request){
      die("request not found");
    }




?>
<html lang="en">
<head>
  <link rel="stylesheet" href="../css/dash.css">
  <link rel="stylesheet" href="../Icon/css/all.min.css">
  <meta charset="UTF-8">
  <title>View</title>
</head>
<body>

  <!-- side-bar -->
    <?php
    include '../include/sidebar.php'; 
    ?> 

    <section id="interface">

    <!-- navbar -->

    <?php
     include '../include/nav.php';
   ?>

  <form action="list.php" method="post">

     <h3 class="i-name">
            Ticket Information
      </h3>

      <?php if ($request): ?>
                    <?php
                    $sqlUser = "SELECT UserName, Email FROM user WHERE UserID = :id";
                    $stmtUser = $conn->prepare($sqlUser);
                    $stmtUser->execute([':id' => $request['UserID']]);
                    $user = $stmtUser->fetch();

                    if (!$user) {
                        $user = ['UserName' => 'Unknown user', 'Email' => 'Not defined'];
                    }
      ?>
               <P><strong>Name: <?=$user['UserName'] ?></strong></P>
               <P><strong>Email: <?=$user['Email'] ?></strong></P>
               <P><strong>Title: <?= ($request['Request_Title']) ?></strong></P>
               <P><strong>Description: <?= ($request['Description']) ?></strong></P>
               <!-- <P><strong>Status: <?= $request['Status'] ?></strong></P> -->

            <?php endif; ?>


  </form>
   
</body>
</html>