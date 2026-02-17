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

$projectid = $_POST['projectid'] ?? $_GET['projectid'] ?? null;

// if (!$projectid) {
//     die("Missing ID!");
// }


$sql = "SELECT ProjectName FROM project WHERE ProjectID = :projectid";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":projectid", $projectid);
$stmt->execute();
$projects = $stmt->fetch();


if(!empty($projectid)){
$sql = "SELECT TaskID, ProjectID, TaskName, TechnicianID, Description, Status  FROM task WHERE ProjectID = :projectid";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":projectid", $projectid);
$stmt->execute();
$tasks = $stmt->fetchAll();
$stmt->execute(['projectid' => $projectid]);

} else {

    $sql = "SELECT TaskID, ProjectID, TaskName, TechnicianID, Description, Status FROM task";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<html lang="en">
<head>
    <script type="text/javascript" src='DataTables/media/js/jquery.js'></script>

    <script type="text/javascript" src="DataTables/media/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="tableau.js"></script>

    <link rel="stylesheet" type="text/css" href="DataTables/media/css/jquery.dataTables.min.css">

    <!-- <link rel="stylesheet" href="../css/task_list.css"> -->
    <!-- <link rel="stylesheet" href="list.css"> -->
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
            Task List
        </h3>
        
        <!-- <table id="tab" class="display" style="width:100%"> -->
    <div class="board">
        <table id="tab" width="100%">
                    <thead>
                        <tr>
                            <th>TaskID</th>
                            <th>ProjectID</th>
                            <th>TaskName</th>
                            <th>TechnicianID</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <?php foreach ($tasks as $task): ?>
                <tr>

                    <td><?= ($task['TaskID']) ?></td>
                    <td><?= ($task['ProjectID']) ?></td>
                    <td><?= (($task['TaskName'])) ?></td>
                    <td><?= ($task['TechnicianID']) ?></td>
                    <td><?= ($task['Description']) ?></td>
                    <td><?= ($task['Status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
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

</form>
</body>
</html>