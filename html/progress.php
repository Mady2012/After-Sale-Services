<?php

session_start();
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if ($_SESSION['role'] === 'User') {
    header("Location: list.php");
    exit;
}


$sql = "SELECT TaskName, Status FROM task";
$stmt = $conn->query($sql);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);


            
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="../css/progress.css">
    <link rel="stylesheet" href="../css/dash.css">
    <link rel="stylesheet" href="../Icon/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <h3 class="i-name">
            PROGRESS
        </h3>
        
<div class="progress-list">

<?php foreach($tasks as $task): ?>

    <?php
    if ($task['Status'] == 'Assigned') {
      $progress = 0;
    }elseif  ($task['Status'] == 'In Progress'){
      $progress = 50;
    }else{
      $progress = 100;
    }
   
    
$color = $progress < 40 ? '#e74c3c' :
         ($progress < 80 ? '#f39c12' : '#2ecc71');

    ?>

    <div class="progress-item">

        <div class="task-title">
            <?= htmlspecialchars($task['TaskName']) ?>
        </div>

        <div class="progress-bar">
            <div class="progress-fill"
                style="width: <?= $progress ?>%; background: <?= $color ?>;">
            </div>
        </div>

         <span class="percent"><?= $progress ?>%</span>

    </div>

    <?php endforeach; ?>
</div>

</body>
</html>

<script>
document.addEventListener("DOMContentLoaded", function(){

    document.querySelectorAll(".progress-fill")
        .forEach((bar, index) => {

            let value = bar.dataset.progress;

            setTimeout(()=>{
                bar.style.width = value + "%";
            }, index * 200);

        });

});
</script>
















