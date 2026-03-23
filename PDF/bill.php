<?php
session_start();
include '../html/connection.php';


$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

// $stmt = $conn->prepare("SELECT * FROM task WHERE TaskID = :id");
// $stmt->execute(['id' => $id]);
// $task = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $conn->prepare("SELECT * FROM project WHERE ProjectID = :id");
$stmt->execute(['id' => $id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);


$sqlTask = "SELECT TaskName, Description, Status  FROM task WHERE ProjectID = ?";
$stmtTask = $conn->prepare($sqlTask);
$stmtTask->execute([$project['ProjectID']]);

$tasks = $stmtTask->fetchAll();
$nb_task = count($tasks);

?>

<html lang="en">
<head>
    <link rel="stylesheet" href="bill1.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
body { font-family: Arial, sans-serif; }
h1 { text-align: center; }
.board { margin: 20px; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
th, td { border: 1px solid #000; padding: 5px; text-align: left; }
th { background-color: #f2f2f2; }
</style>

</head>
<body>

        <div class="logo">
            <img src="../logo_inov.png" alt="">
        </div>

    <h1>REPORT</h1>

    <div class="board">
       <?php if ($project): ?>
    <p><strong>Project Name:</strong> <?= $project['ProjectName'] ?></p>
    <p><strong>Description:</strong> <?= $project['Description'] ?></p>

    <div class="board">
        <table id="tab" width="100%">
            <thead>
                <tr>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['TaskName']) ?></td>
                        <td><?= htmlspecialchars($task['Description']) ?></td>
                        <td><?= htmlspecialchars($task['Status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
   <?php else: ?>
    <p>Project not found.</p>
   <?php endif; ?>
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