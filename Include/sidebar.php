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

        <ul class= "items">

          <?php if ($role !== 'user'): ?>
            <li><a href="dash.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
          <?php endif; ?> 
            <?php if ($role !== 'technician'): ?>
              <li><a href="list.php"><i class="fa fa-first-aid"></i>Support List</a></li>
              <li><a href="request.php"><i class="fa fa-ticket"></i>Support Request</a></li>
            <?php endif; ?> 
            
            <?php if ($role !== 'user'): ?>
                <li><a href="project.php"><i class="fa fa-diagram-project"></i>Ticket</a></li>
                <!-- <li><i class="fa fa-tasks"></i><a href="task_list.php">Task_List</a></p></li> -->
                <li><a href="progress.php"><i class="fa fa-bars-progress"></i>Progress</a></li>
                <li><a href="report.php"><i class="fa fa-bars-progress"></i>Report</a></li>
            <?php endif; ?>
            <!-- <button><a href="disconnect.php"><i class="fa fa-closed-captioning"></i></a></button> -->
            </ul>
              <a href="disconnect.php"><i class="fa fa-sign-out-alt" style="color: orange; font-size: 30px; padding: 50px;"></i></a>

    </section>

<script>  
    $(document).ready(function() {
    var currentUrl = window.location.href;
    $('#menu .items li a').each(function() {
        if (this.href === currentUrl) {
            $(this).addClass('active-link');
        }
    });
});
</script>