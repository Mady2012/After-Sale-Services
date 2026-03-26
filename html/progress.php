<?php

session_start();
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$username = $_SESSION['username'] ?? null;

if ($_SESSION['role'] === 'User') {
    header("Location: list.php");
    exit;
}


$sql = "SELECT * FROM project";
$stmt = $conn->query($sql);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);


            
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
        
     <?php foreach($projects as $project): ?>

     <?php

     $projectID = $project['ProjectID'];

    $sqlTasks = "SELECT Status FROM task WHERE ProjectID = ?";
    $stmt = $conn->prepare($sqlTasks);
    $stmt->execute([$projectID]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalTasks = count($tasks);
    $doneTasks = 0;
    $progressSum = 0;

foreach ($tasks as $task) {
    if ($task['Status'] == 'Completed') {
        $progressSum += 100;
        $doneTasks++;
    } elseif ($task['Status'] == 'In Progress') {
        $progressSum += 50;
        $doneTasks++;
    } else { // Pending
        $progressSum += 0;
    }
}

// Calculate average progress
$progress = $totalTasks > 0 ? round($progressSum / $totalTasks) : 0;
    
     $color = $progress < 40 ? '#e74c3c' :
         ($progress < 80 ? '#f39c12' : '#2ecc71');

      ?>

    <div class="progress-item">

        <div class="task-title">
            <?= htmlspecialchars($project['ProjectName']) ?>
        </div>

    <div class="progress-bar">
        <div class="progress-fill" 
         data-progress="<?= $progress ?>" 
         style="width: 0%; background: <?= $color ?>;">
        </div>
     </div>

         <span class="percent"><?= $progress ?>%</span>

         <span class="task-ratio">
           <?= $doneTasks ?>/<?= $totalTasks ?>
         </span>

     </div>

     <?php endforeach; ?>
    </div>
 </section>
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
















