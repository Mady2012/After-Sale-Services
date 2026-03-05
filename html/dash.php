<?php
include 'connection.php';
session_start();

function truncate($text,$max = 50){
    return strlen($text) > $max ? substr($text, 0, $max) . "..." : $text;
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

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

}
$result = [];

if ($role === 'technician') {

    $sql = "SELECT * FROM task WHERE TechnicianID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $user_id]);
    $result = $stmt->fetchAll();

} else {

$sql = "SELECT * FROM request";
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
                    <h3>200</h3>
                    <span>Projects In review</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-bars-progress"></i>
                <div>
                    <h3>200</h3>
                    <span>Project In Progress</span>
                </div>
            </div>
        </div>
 <?php endif; ?>
        <div class="board">
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
                      <th>Role</th>
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
                        </td>

                       <td class="edit">
                        <a href="modify.php?action=modify&id=<?php echo $req['RequestID']; ?>"> <i class="fa fa-pencil pencil" ></i></a>
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



</body>
</html>