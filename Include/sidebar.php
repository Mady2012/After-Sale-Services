<?php

if (!isset($_SESSION)) {
    session_start();
}
$role = $_SESSION['role'] ?? 'user';
$role = $_SESSION['role'] ?? 'technician';

?>

<section id="menu">
        <div class="logo">
            <img src="../logo_inov.png" alt="">
        </div><br>

            <?php if ($username): ?>
                <center><span class="user-welcome">Welcome, <?= htmlspecialchars($username) ?>!</span></center>
            <?php endif; ?>

        <div class= "items">

          <?php if ($role !== 'user'): ?>
            <a href="dash.php" class="item"><li><i class="fa fa-dashboard"></i>Dashboard</p></li></a>
          <?php endif; ?> 
            <?php if ($role !== 'technician'): ?>
             <a href="list.php" class="item"><li><i class="fa fa-first-aid"></i>Support List</p></li></a>
             <a href="request.php" class="item"><li><i class="fa fa-ticket"></i>Support Request</p></li></a>
            <?php endif; ?> 
            
            <?php if ($role !== 'user'): ?>
                <a href="project.php" class="item"><li><i class="fa fa-diagram-project"></i>Project</p></li></a>
                <!-- <li><i class="fa fa-tasks"></i><a href="task_list.php">Task_List</a></p></li> -->
                <a href="progress.php" class="item"><li><i class="fa fa-bars-progress"></i>Progress</p></li></a>
                <a href="report.php" class="item"><li><i class="fa fa-bars-progress"></i>Report</p></li></a>
            <?php endif; ?>

            <!-- <button><a href="disconnect.php"><i class="fa fa-closed-captioning"></i></a></button> -->

        </div>
    </section>