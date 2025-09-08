<?php
session_start();
include 'connection.php';

if(isset($_POST['submit'])){
    $projet_id = $_GET['projet_id'];
    $taskname = $_POST['taskname'];
    $status = $_POST['status'];

    $lastProjectId = $conn->lastInsertId();

$sql = "INSERT INTO task (ProjectID, TaskName, Status) VALUES (:projectid, :taskname, :status)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':projectid', $lastProjectId);
$stmt->bindParam(':taskname', $taskname);
$stmt->bindParam(':status', $status);


try{
  $stmt->execute();
  echo "Task Added successfully";
  header("Location: project.php");
  exit;
}
catch(PDO_Exception $e){
  echo "Erreur" .$sql . "<br>" . $e->getMessage();
}
if ($status === 'in progress') {
    $sql = "UPDATE project SET Status = 'in progress' WHERE ProjectID = :pid";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['pid' => $projectId]);
}
if ($status === 'in review') {
    $sql = "UPDATE project SET Status = 'in progress' WHERE ProjectID = :pid";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['pid' => $projectId]);
}
if ($status === 'done') {
    $sql = "UPDATE project SET Status = 'done' WHERE ProjectID = :pid";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['pid' => $projectId]);
}

try{
    $stmt->execute();
    echo "Task Added successfully";
    header("Location: project.php");
    exit;
  }
  catch(PDO_Exception $e){
    echo "Erreur" .$sql . "<br>" . $e->getMessage();
  }
}

?>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/task.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="#" method="post">
        <main>
           <div class="infos">
           <P><label for="text" class="log">TaskName</label></P>
           <P><input type="text" name="taskname" class="int" required ></P>
          <P> <label for="text" class="log">Status</label></P>
           <P><input type="text" name="status" class="int" required></P>
          <P> <input type="submit" name="submit"  class="btn-login" value="ADD"></P>
          </div>
           
        </main>
       </form>
</body>
</html>