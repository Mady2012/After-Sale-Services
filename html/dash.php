<?php
include 'connection.php';
session_start();

function truncate($text,$max = 50){
    return strlen($text) > $max ? substr($text, 0, $max) . "..." : $text;
}

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
$username = $_SESSION['username'];

if ($_SESSION['role'] === 'User') {
    header("Location: list.php");
    exit;
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];


if ($role === 'technician') {
    $sqlTask = "SELECT COUNT(*) AS total_task 
                FROM task 
                WHERE TechnicianID = :id";
    $stmtTask = $conn->prepare($sqlTask);
    $stmtTask->execute(['id' => $user_id]);
    $taskCount = $stmtTask->fetch()['total_task'];

    $sqlProject = "SELECT COUNT(DISTINCT ProjectID) AS total_project
                   FROM task
                   WHERE TechnicianID = :id";
    $stmtProject = $conn->prepare($sqlProject);
    $stmtProject->execute(['id' => $user_id]);
    $projectCount = $stmtProject->fetch()['total_project'];

}else{

$sqlsupport = "SELECT COUNT(*) AS total_support FROM request";
$stmtsupport = $conn->prepare($sqlsupport);
$stmtsupport->execute();

$supportData = $stmtsupport->fetch();
$supportcount = $supportData['total_support'];

$sqlproject = "SELECT COUNT(*) AS total_project FROM project";
$stmtproject = $conn->prepare($sqlproject);
$stmtproject->execute();

$projectData = $stmtproject->fetch();
$projectcount = $projectData['total_project'];


$sqlprogress = "SELECT COUNT(*) total_progress FROM project WHERE (TRIM(Status)) = 'in progress' ";
$stmtprogress = $conn->prepare($sqlprogress);
$stmtprogress->execute();

$progressData = $stmtprogress->fetch(PDO::FETCH_ASSOC);
$progresscount = $progressData['total_progress'];

$sqldone = "SELECT COUNT(*) total_done FROM project WHERE (TRIM(Status)) = 'completed'";
$stmtdone = $conn->prepare($sqldone);
$stmtdone->execute();

$doneData = $stmtdone->fetch(PDO::FETCH_ASSOC);
$donecount = $doneData['total_done'];


}
$result = [];

if ($role === 'technician') {

    $sql = "SELECT * FROM task WHERE TechnicianID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $user_id]);
    $result = $stmt->fetchAll();

} else {

 $sql = "SELECT *, 
            (SELECT Status FROM task WHERE RequestID = request.RequestID ORDER BY TaskID DESC LIMIT 1) AS last_status 
            FROM request ORDER BY RequestID DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

// $sql1 = "SELECT Status FROM project";
// $stmt1 = $conn->prepare($sql);
// $stmt1->execute();

// $status = $stmt1->fetch();


}
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="../css/dash.css">
    <link rel="stylesheet" href="../Icon/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
      <style>
    /* .dataTables_wrapper .dataTables_length {
        margin-bottom: 10px !important;
        display: block !important;
        width: 100% !important;
    } */
    /* .dataTables_wrapper .dataTables_filter {
        display: block !important;
        width: 100% !important;
        margin-bottom: 10px !important;
    } */
        
  </style>

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
            Dashboard
        </h3>

    <?php if ($role === 'technician'): ?>
        <div class="values">
<div class="val-box">
    <i class="fa fa-list-check"></i>
    <div>
        <h3><?= $taskCount ?></h3>
        <span>My Tasks</span>
    </div>
</div>

<div class="val-box">
    <i class="fa fa-diagram-project"></i>
    <div>
        <h3><?= $projectCount ?></h3>
        <span>My Projects</span>
    </div>
</div>

<?php else: ?>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-ticket"></i>
                <div>
                    <h3><?= ($supportcount) ?></h3>
                    <span>Total Support</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-diagram-project"></i>
                <div>
                    <h3><?= ($projectcount) ?></h3>
                    <span>New projects</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-critical-role"></i>
                <div>
                    <h3><?= ($progresscount) ?></h3>
                    <span>Projects In progress</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-bars-progress"></i>
                <div>
                    <h3><?= ($donecount) ?></h3>
                    <span>Project Completed</span>
                </div>
            </div>


        </div>
 <?php endif; ?>
        <div class="board" style="padding: 30px;">
            <table id="tab" width="100%">
                <thead>
                    <tr>

                     <?php if ($role === 'technician'): ?>
                      <th>Task Name</th>
                      <th>Description</th>
                      <th>Status</th>
                      <th>Actions</th>

                     <?php else: ?>

                      <th>Name</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Status</th>
                      <th>Actions</th>

                     <?php endif; ?>

                    </tr>
                </thead>
                <tbody>

                <?php if ($role === 'technician'): ?>

                 <?php foreach ($result as $task): ?>
        <tr>
            <td><?= $task['TaskName'] ?></td>
            <td><?= substr($task['Description'],0,40) ?>...</td>
            <td><?= $task['Status'] ?></td>

                        <td class="edit">
                            <a href="modify-task.php?action=modify&id=<?php echo $task['TaskID']; ?>"> <i class="fa fa-pencil pencil" ></i></a>
                            <a href="delete.php?action=delete&id=<?php echo $task['TaskID']; ?>" onclick="return confirm('Do you really want to delete this request ?')"> <i class="fa fa-trash trash"></i></a>
                            <a href="view-task.php?action=view&id=<?php echo $task['TaskID']; ?>"><i class="fa fa-eye eye"></i></a>
                        </td>

        </tr>
    <?php endforeach; ?>

    <?php else: ?>


                <?php foreach ($result as $req): ?>
                    <?php
                    $sqlUser = "SELECT UserName, Email FROM user WHERE UserID = :id";
                    $stmtUser = $conn->prepare($sqlUser);
                    $stmtUser->execute([':id' => $req['UserID']]);
                    $user = $stmtUser->fetch();

                    if (!$user) {
                        $user = ['UserName' => 'Unknown user', 'Email' => 'Not defined'];
                    }

                    ?>
                    <tr>
                        <td class="people">
                            <img src="../avatar.jpeg" alt="">
                            <div class="people-de">
                                <h5><?= (($user['UserName'])) ?></h5>
                                <p><?= (($user['Email'])) ?></p>
                            </div>
                        </td>
                        <td class="people-des">
                            <h5><?= ($req['Request_Title']) ?></h5>
                        </td>
                        <td><p><?= (truncate($req['Description'], 40)) ?></p></td>
                        <td class="role">
                            <?php
                              $status = $req['last_status'] ?? 'New'; 

                             $color = "#3498db"; // Bleu (New)
                             if ($status == 'Completed')   $color = "#27ae60"; // Vert
                             if ($status == 'In Progress') $color = "#f39c12"; // Orange
                             if ($status == 'Pending')     $color = "#e74c3c"; // Rouge
                          

                             $bgColor = $statusStyles[$status] ?? "#3498db";
                            ?>
                            <span style="
                                display: inline-block;
                                padding: 4px 12px;
                                background-color: <?= $bgColor ?>;
                                color: white;
                                font-size: 12px;
                                font-weight: bold;
                                font-family: sans-serif;
                                border-radius: 20px;
                                ">
                                <?= htmlspecialchars($status) ?>
                            </span>
                        </td>

                       <td class="edit">
                        <!-- <a href="modify.php?action=modify&id=<?php echo $req['RequestID']; ?>"> <i class="fa fa-pencil pencil" ></i></a> -->
                        <a href="delete.php?action=delete&id=<?php echo $req['RequestID']; ?>" onclick="return confirm('Do you really want to delete this request ?')"> <i class="fa fa-trash trash"></i></a>
                        <a href="view.php?action=view&id=<?php echo $req['RequestID']; ?>"><i class="fa fa-eye eye"></i></a>
                      </td>
                    </tr>
                <?php endforeach; ?>

                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </section>


    <!-- <style>
        
table#tab.dataTable tbody td,
table#tab.dataTable thead th {
    padding: 15px !important;
}

    </style> -->
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
$(document).ready(function(){
    $(".user-welcome").hide().fadeIn(1000);
});
</script>



</body>
</html>