<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="../Icon/css/all.min.css">
    <link rel="stylesheet" href="../css/dash.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <form action="" method="post">
        <main>
            <header class="top-bar">
                   <img src="../logo_inov.png" alt="">
                </div>
                <nav class="top-nav">
                    <i class="fa fa-dashboard"></i>Dashboard
                </nav>
                <div class="user">
                    <?php
                    echo "WELCOME ".$_SESSION['username'].' !!!'; 
                    ?>
                    <!-- <img src="../avatar.jpeg" alt=""> -->
                </div>
            </header>
            <aside class="side-bar">
                <div class="menu">
                   <p class="board"><i class="fa fa-dashboard"></i><a href="dash.php">Dashboard</a></p>
                    <p><i class="fa fa-first-aid"></i><a href="list.php">Support List</a></p>
                    <p><i class="fa fa-ticket"></i><a href="request.php">Support Request</a></p>
                    <p><i class="fa fa-diagram-project"></i><a href="project.php">Project</a></p>
                    <p><i class="fa fa-bars-progress"></i><a href="#">Progress</a></p>
                    <a href="disconnect.php" class="btn">Disconnect</a>
                </div>
                </aside>
            <section class="left-side">
                <div class="status">
                    <div class="sup">
                        <p>200</p>
                         <h4>Support Request</h3>
                    </div>
                    <div class="done">
                        <p>100</p>
                         <h4>Project Done</h3>
                    </div>
                    <div class="review">
                        <p>100</p>
                           <h4>Project in review</h3>
                    </div>
                    <div class="prog">
                        <p>200</p>
                           <h4>Project in progress</h3>
                    </div>
                    <div class="new">
                        <p>20</p>
                         <h4>New project</h3>
                    </div>
                </div>
            </section>
            <div class="join">
                <div class="list">
                    <h3>Support List Summary</h3>
                    <canvas id="myChart" width="200" height="200"></canvas>
                </div>
                <div class="table">
                <table>
                    <h3>Recent Support Request</h3>
                    <thead>
                        <tr>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                </table>
                </div>
            </div>
            <div>
            </div>
        </main>
    </form>
    <script src="../javascript/dash.js"></script>
</body>
</html>