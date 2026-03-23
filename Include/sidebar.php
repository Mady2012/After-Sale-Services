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
        </div>
        <div class= "items">

          <?php if ($role !== 'user'): ?>
            <li><i class="fa fa-dashboard"></i><a href="dash.php">Dashboard</a></p></li>
          <?php endif; ?> 
            <?php if ($role !== 'technician'): ?>
             <li><i class="fa fa-first-aid"></i><a href="list.php">Support List</a></p></li>
             <li><i class="fa fa-ticket"></i><a href="request.php">Support Request</a></p></li>
            <?php endif; ?> 
            
            <?php if ($role !== 'user'): ?>
                <li><i class="fa fa-diagram-project"></i><a href="project.php">Project</a></p></li>
                <!-- <li><i class="fa fa-tasks"></i><a href="task_list.php">Task_List</a></p></li> -->
                <li><i class="fa fa-bars-progress"></i><a href="progress.php">Progress</a></p></li>
                <li><i class="fa fa-bars-progress"></i><a href="report.php">Report</a></p></li>
            <?php endif; ?>

            <!-- <button><a href="disconnect.php"><i class="fa fa-closed-captioning"></i></a></button> -->

        </div>
    </section>