<?php
include 'connection.php';

require '../mail/email.php';

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
        
     if ($status !== 'Completed') {
        $update = $conn->prepare("UPDATE task SET TaskName = :name,Description = :description,Status = :status WHERE TaskID = :id");
       
        $update->bindParam(":name", $taskname);
        $update->bindParam(":description", $description);
        $update->bindParam(":status", $status);
        $update->bindParam(":id", $id);

        $update->execute();

 }
    else {

    $tokenAccepted = bin2hex(random_bytes(32)); 
    $tokenRejected   = bin2hex(random_bytes(32));

        $stmt = $conn->prepare("INSERT INTO task_val (TaskID, New_status, Token_confirm, Token_reject) VALUES (:id, :status, :tok1, :tok2)");

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":tok1", $tokenAccepted);
        $stmt->bindParam(":tok2", $tokenRejected);

        $stmt->execute();

$url = "http://localhost/After-Sales/html/validate.php";

         $linkconfirmed = $url . "?token=" . $tokenAccepted . "&action=confirm";
         $linkrejected  = $url . "?token=" . $tokenRejected . "&action=reject";


         $adminEmail = "wendymadissone@gmail.com";
         $subject = "Request for Task Approval: " . $taskname;
        
        $body = "
            <h2>Request for status change</h2>
            <p>The task <b>$taskname</b> request to pass to status <b>$status</b>.</p>
            <p>Decide by clicking on one of the bottons:</p>
            <a href='$linkconfirmed' style='display:inline-block; background:green; color:white; padding:10px; text-decoration:none;'>CONFIRM</a>
            &nbsp;
            <a href='$linkrejected' style='display:inline-block; background:red; color:white; padding:10px; text-decoration:none;'>REJECT</a>
        ";

        sendMail($adminEmail, $subject, $body);
    }
        echo "<script>window.location='project.php';</script>";
        exit;

    } catch(Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }

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
  <form action="" method="post"  enctype="multipart/form-data"> 

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
<input type="submit" name="submit" class="btn-sub" value="SUBMIT">
</div>

</div>
</section>
</div>

</form>