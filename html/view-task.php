<?php
session_start();
include 'connection.php';


$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

//     if (!$task_id) {
//     die("Task ID missing.");
// }

$stmt = $conn->prepare("SELECT * FROM task WHERE TaskID = :id");
$stmt->execute(['id' => $id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    die("Task not found.");
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
            Task Information
      </h3>

      <?php if ($task): ?>
                    <!-- <?php
                    $sqlUser = "SELECT UserName, Email FROM user WHERE UserID = :id";
                    $stmtUser = $conn->prepare($sqlUser);
                    $stmtUser->execute([':id' => $task['UserID']]);
                    $user = $stmtUser->fetch();

                    if (!$user) {
                        $user = ['UserName' => 'Unknown user', 'Email' => 'Not defined'];
                    }
      ?> -->
               
              <p><strong>Project ID:</strong> <?= $task['ProjectID'] ?></p>
              <p><strong>Task Name:</strong> <?= $task['TaskName'] ?></p>
              <p><strong>Description:</strong> <?= $task['Description'] ?></p>
              <p><strong>Status:</strong> <?= $task['Status'] ?></p>
            <?php endif; ?>


  </form>
   
</body>
</html>