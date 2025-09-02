<?php
session_start();
include 'connection.php';

$sql = "SELECT * FROM project";
$stmt = $conn->query($sql);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<html lang="en">
<head>
    <link rel="stylesheet" href="../Icon/css/all.min.css">
    <link rel="stylesheet" href="../css/project.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <main>
            <header class="top-bar">
                   <img src="../logo_inov.png" alt="">
                </div>
                <nav class="top-nav">
                    <i class="fa fa-diagram-project"></i>Project
                </nav>
             <a href="task.php">Add Task</a>
                <div><input type="text" class="search" placeholder="search"></div>
                <div class="user">
                    <img src="../avatar.jpeg" alt="">
                </div>
            </header>
            <aside class="side-bar">
                <div class="menu">
                   <p><i class="fa fa-dashboard"></i><a href="C:\wamp64\www\After-Sales\html\dash.php">Dashboard</a></p>
                    <p><i class="fa fa-first-aid"></i><a href="C:\wamp64\www\After-Sales\html\list.php">Support List</a></p>
                    <p><i class="fa fa-ticket"></i><a href="C:\wamp64\www\After-Sales\html\request.php">Support Request</a></p>
                    <p  class="board"><i class="fa fa-diagram-project"></i><a href="C:\wamp64\www\After-Sales\html\project.php">Project</a></p>
                    <p><i class="fa fa-bars-progress"></i><a href="#">Progress</a></p>
                    <input type="button" class="btn" value="Disconnect">
                </div>
            </aside>
         <section class="left-side">
            <div class="global">
                <div class="new">
                <h3>New project</h3>
                <div class="ticket">
                  <?php foreach ($projects as $project): ?>
                    <?php if (strtolower($project['Status']) === 'new'): ?>
                        <h4><?= ($project['ProjectName']) ?></h4>
                        <p><?= ($project['RequestID']) ?></p>
                        <p><?= ($project['Description']) ?></p>
                        <p>Status : <?= ($project['Status']) ?></p>
                        <a href="task.php">Add Task</a>
                </div>
              <?php endif; ?>
             <?php endforeach; ?>

                </div>

            </div>
            <div class="new">
                <h3>In progress</h3>
                <div class="ticket">
                    <?php foreach ($projects as $project): ?>
                    <?php if (strtolower($project['Status']) === 'in progress'): ?>
                        <h4><?= ($project['ProjectName']) ?></h4>
                        <p><?= ($project['RequestID']) ?></p>
                        <p><?= ($project['Description']) ?></p>
                        <p>Status : <?= ($project['Status']) ?></p>
                        <a href="task.php">Add Task</a>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="new">
                <h3>In review</h3>
                <div class="ticket">
                    <?php foreach ($projects as $project): ?>
                    <?php if (strtolower($project['Status']) === 'in review'): ?>
                        <h4><?= ($project['ProjectName']) ?></h4>
                        <p><?= ($project['RequestID']) ?></p>
                        <p><?= ($project['Description']) ?></p>
                        <p>Status : <?= ($project['Status']) ?></p>
                        <a href="task.php">Add Task</a>

                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="new">
                <h3>Done</h3>
                <div class="ticket">
                    <?php foreach ($projects as $project): ?>
                    <?php if (strtolower($project['Status']) === 'done'): ?>
                        <h4><?= ($project['ProjectName']) ?></h4>
                        <p><?= ($project['RequestID']) ?></p>
                        <p><?= ($project['Description']) ?></p>
                        <p>Status : <?=($project['Status']) ?></p>
                        <a href="task.php">Add Task</a>

                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div> 
        </section>
        </main>
</body>
</html>