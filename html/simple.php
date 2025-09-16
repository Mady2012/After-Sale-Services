<?php
session_start();
include 'connection.php';

$sql = "SELECT * FROM project";
$stmt = $conn->query($sql);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<html lang="en">
<head>
  <link rel="stylesheet" href="../css/project.css">
  <link rel="stylesheet" href="../css/dash.css">
    <link rel="stylesheet" href="../Icon/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
   <form action="" method="post">
        <h3 class="i-name">
            Project
        </h3>
        
        <section class="leftside">
             <div class="container">
                <!-- <div class="new">
                <h3>New project</h3> -->
                <?php foreach ($projects as $project): ?>
                    <div class="card" onclick="window.location.href='task_list.php?projectid=<?php echo $project['ProjectID']; ?>'">
                    <?php if (strtolower($project['Status']) === 'new'): ?>
                        <h3><?= ($project['ProjectName']) ?></h4>
                        <p><?= ($project['RequestID']) ?></p>
                        <p><?= ($project['Description']) ?></p>
                        <p>Status : <?= ($project['Status']) ?></p>
                        <a href="task_list.php?projectid=<?php echo $project['ProjectID']; ?>" class="view-btn">View Task</a>
              <?php endif; ?>
              <?php endforeach; ?>

                </div>

          
        </div> 
        </section>

    <script>
        $('#menu-btn').click(function(){
            $('#menu').toggleClass("active");
        })
    </script>
</form>
</body>
</html>