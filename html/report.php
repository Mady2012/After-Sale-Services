<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$username = $_SESSION['username'] ?? null;

// $sql = "SELECT * FROM task WHERE ProjectID = ?";
// $stmt = $conn->prepare($sql);
// $stmt->execute();

// $tasks = $stmt->fetchAll();


$sql = "SELECT * FROM project";
$stmt = $conn->prepare($sql);
$stmt->execute();

$report = $stmt->fetchAll();

function truncate($text,$max = 50){
    return strlen($text) > $max ? substr($text, 0, $max) . "..." : $text;
}

$projects = $conn->query("SELECT ProjectID FROM project")->fetchAll(PDO::FETCH_COLUMN);

// 2. Get all tasks
$tasks = $conn->query("SELECT ProjectID, Status FROM task")->fetchAll(PDO::FETCH_ASSOC);

// 3. Initialize the counter
$stats = ['New' => 0, 'Completed' => 0, 'In Progress' => 0, 'Pending' => 0];

// 4. Group tasks by ProjectID for easy counting
$projectTasks = [];
foreach ($tasks as $t) {
    $projectTasks[$t['ProjectID']][] = $t['Status'];
}

// 5. Calculate Status for each project
foreach ($projects as $id) {
    if (!isset($projectTasks[$id])) {
        $stats['New']++;
        continue;
    }

    $currentTasks = $projectTasks[$id];
    $total = count($currentTasks);
    $done = count(array_filter($currentTasks, fn($s) => $s == 'Completed'));

    if ($done === $total) {
        $stats['Completed']++;
    } elseif ($done > 0) {
        $stats['In Progress']++;
    } else {
        $stats['Pending']++;
    }
}

// 6. Data for Chart.js
$labels = array_keys($stats);
$counts = array_values($stats);
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="../css/report.css">
    <link rel="stylesheet" href="../css/dash.css">
    <link rel="stylesheet" href="../Icon/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
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
            Report And Analytics
        </h3>

        <div class="board" style="padding: 30px;">
            <table  id= "tab" width="100%">
                <thead>
                    <tr>
                    <th>ID</td>
                    <th>Title</td>
                    <th>Description</td>
                    <th>Status</td>
                    <th>Actions</td>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach ($report as $rep): ?>
                    <tr>
                        <td class="people-des">
                            <h5><?= ($rep['RequestID']) ?></h5>
                        </td>

                        <td class="people-des">
                            <h5><?= ($rep['ProjectName']) ?></h5>
                        </td>

                        <td><p><?= (truncate($rep['Description'], 40)) ?></p></td>

                        <td class="people-des">
                            <h5><?= ($rep['Status']) ?></h5>
                        </td>

                       <td class="edit">
                        <a href="../PDF/index.php?id=<?= $rep['ProjectID'] ?>" onclick="return confirm('Do you really want to download')"> <i class="fa fa-download"></i></a>
                        <a href="delete.php?action=delete&id=<?php echo $rep['ProjectID']; ?>" onclick="return confirm('Do you really want to delete this request ?')"> <i class="fa fa-trash trash"></i></a>
                        <!-- <a href="view.php?action=view&id=<?php echo $rep['ProjectID']; ?>"><i class="fa fa-eye eye"></i></a> -->
                       </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="board" style="padding: 30px; margin-top: 20px; width: 50%;">
    <h3>Project Status Overview</h3>
    <canvas id="chartShippers"></canvas>
</div>
    </section>


                <script>
                 $('#menu-btn').click(function(){
                     $('#menu').toggleClass("active");
                 })
                </script>

        <script>
         $(document).ready(function () {
             $('#tab').DataTable({
                 "language": {
                     "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
                 }
             });
         });
        </script>

<script>
$(document).ready(function() {
    const ctx = document.getElementById('chartShippers').getContext('2d');
    
    new Chart(ctx, {
        type: 'doughnut', // Pie or Doughnut looks great for status
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'tasks',
                data: <?= json_encode($counts) ?>,
                backgroundColor: [
                    '#3498db',  // Blue for New
                    '#27ae60', // Green for Completed
                    '#f39c12', // Orange for In Progress
                    '#e74c3c', // Red for Pending
                    
                ],
                hoverOffset: 10,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>
    </body>
</html>