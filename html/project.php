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

// $role = $_SESSION['role'];
// $user_id = $_SESSION['user_id'];

//     $projects = [];

// if ($role === 'technician') {

//     $sqlTask = "SELECT ProjectID FROM task WHERE TechnicianID = :id";
//     $stmtTask = $conn->prepare($sqlTask);
//     $stmtTask->execute(['id' => $user_id]);

//     $projectIDs = $stmtTask->fetchAll(PDO::FETCH_COLUMN);

//     if (empty($projectIDs)) {
//         $projects = [];
//     } else {

$sql = "SELECT * FROM project";
$stmt = $conn->query($sql);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<html lang="en">
<head>

    <link rel="stylesheet" href="../css/project1.css">
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
   <!-- <form action="" method="post"> -->
        <h3 class="i-name">
            Project
        </h3>

        <div class="values">
                <?php foreach ($projects as $project): ?>
                    <?php
                      $sqltask = "SELECT COUNT(*) AS total_task FROM task WHERE ProjectID = :projectid";

                      $stmttask = $conn->prepare($sqltask);
                      $stmttask->execute(['projectid' => $project['ProjectID']]);

                      $supportData = $stmttask->fetch(PDO::FETCH_ASSOC);
                      $taskcount = $supportData['total_task'];

                    ?>
                       <?php if (strtolower($project['Status']) === 'new'): ?>
                        <div class="val-box" onclick="window.location.href='task_list.php?projectid=<?php echo $project['ProjectID']; ?>'">
                         <i class="fa fa-diagram-project"></i>
                         <div>
                            <h3><?= ($taskcount) ?></h3><br>
                            <span><?= ($project['ProjectName']) ?>
                              <?php if ($role !== 'technician'): ?>
                                </i><a href="task.php?projectid=<?= $project['ProjectID']; ?>" class="view-btn">+</a>
                              <?php endif; ?>
                            </span>
                         </div>                        
                        </div>

                     <?php endif; ?>
                      <?php endforeach; ?>
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