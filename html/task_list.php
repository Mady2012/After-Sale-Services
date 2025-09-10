<?php
session_start();
include 'connection.php';

$projectid = $_GET['projectid'];

$sql = "SELECT ProjectName FROM project WHERE ProjectID = :projectid";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":projectid", $projectid);
$stmt->execute();
$projects = $stmt->fetch();


$sql = "SELECT TaskID, ProjectID, TaskName, TechnicianID, Status  FROM task WHERE ProjectID = :projectid";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":projectid", $projectid);
$stmt->execute();
$tasks = $stmt->fetchAll();
?>

?>

<html lang="en">
<head>
    <link rel="stylesheet" href="../Icon/css/all.min.css">
    <link rel="stylesheet" href="../css/list.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <main>
            <header class="top-bar">
                <img src="../logo_inov.png" alt="">
                <nav class="top-nav">
                    <i class="fa fa-first-aid"></i>Task_List
                </nav>
            </header>
            <aside class="side-bar">
                <div class="menu">
                   <p><i class="fa fa-dashboard"></i><a href="dash.php">Dashboard</a></p>
                    <p ><i class="fa fa-first-aid"></i><a href="list.php">Support List</a></p>
                    <p><i class="fa fa-ticket"></i><a href="request.php">Support Request</a></p>
                    <p><i class="fa fa-diagram-project"></i><a href="project.php">Project</a></p>
                    <p class="board"><i class="fa "></i><a href="task_list.php">Task_List</a></p>
                    <p><i class="fa fa-bars-progress"></i><a href="#">Progress</a></p>
                    <a href="disconnect.php" class="btn">Disconnect</a>
                </div>
                </aside>

                <table>
                    <thead>
                        <tr>
                            <th>TaskID</th>
                            <th>ProjectID</th>
                            <th>TaskName</th>
                            <th>TechnicianID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <?php foreach ($tasks as $task): ?>
            <tr>

                <td><?= ($task['TaskID']) ?></td>
                <td><?= ($task['ProjectID']) ?></td>
                <td><?= (($task['TaskName'])) ?></td>
                <td><?= ($task['TechnicianID']) ?></td>
                <td><?= ($task['Status']) ?></td>
                
  </td>
        </tr>
            <?php endforeach; ?>

                </table>
                </section>
</body>
</html>