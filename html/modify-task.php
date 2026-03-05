<?php
include 'connection.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    die("Task ID missing.");
}


$stmt = $conn->prepare("SELECT * FROM task WHERE TaskID = :id");
$stmt->execute(['id' => $id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    die("Task not found.");
}


if (isset($_POST['submit'])) {

    $taskname = $_POST['task_name'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    try {
        $stmt = $conn->prepare("
            UPDATE task 
            SET TaskName = :taskname,
                Description = :description,
                Status = :status
            WHERE TaskID = :id
        ");

        $stmt->bindParam(":taskname", $taskname);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

    } catch(PDOException $e) {
        die("Update failed : " . $e->getMessage());
    }

    header("Location: list_task.php");
    exit;
}
?>
<html lang="en">
<head>
  <link rel="stylesheet" href="../css/request.css">
  <link rel="stylesheet" href="../css/dash.css">
  <link rel="stylesheet" href="../Icon/css/all.min.css">
  <meta charset="UTF-8">
  <title>Modify Request</title>
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

</h3>
<form action="" method="post">

<div class="board">
<section class="left-side">
<div class="container">

<h1>TASK FORM</h1>

<div class="content">
<div class="name">

<label>Task Name</label>
<input type="text" name="task_name" class="int"
       value="<?= $task['TaskName']; ?>">

<label>Description</label>
<input type="text" name="description" class="int"
       value="<?= $task['Description']; ?>">

<label>Status</label>
<select name="status" class="int">
    <option value="Pending" <?= $task['Status']=='Pending'?'selected':'' ?>>Pending</option>
    <option value="In Progress" <?= $task['Status']=='In Progress'?'selected':'' ?>>In Progress</option>
    <option value="Completed" <?= $task['Status']=='Completed'?'selected':'' ?>>Completed</option>
</select>

</div>
</div>

<div>
<input type="submit" name="submit" class="btn-sub" value="UPDATE">
</div>

</div>
</section>
</div>

</form>