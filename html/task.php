<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if ($_SESSION['role'] === 'technician') {
    die("Access denied");
}

$projectid = $_GET['projectid'] ?? '';

$sql1 = "SELECT ProjectID FROM project";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$projects = $stmt1->fetchAll(PDO::FETCH_ASSOC);


$sql3 = "SELECT UserID, UserName FROM user WHERE Role = 'Technician' ";
$stmt3 = $conn->prepare($sql3);
$stmt3->execute();
$roles = $stmt3->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {

  $projectid = $_POST['projectid'];
  $taskname = $_POST['taskname'];
  $userid = $_POST['userid'];
  $description = $_POST['description'];
  $status = 'Assigned';

  try {

    $sql2 = "INSERT INTO task (ProjectID, TaskName, TechnicianID, Description, Status) VALUES (:projectid, :taskname, :technician_id, :description, :status)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bindParam(':projectid', $projectid);
    $stmt2->bindParam(':taskname', $taskname);
    $stmt2->bindParam(':technician_id', $userid);
    $stmt2->bindParam(':description', $description);
    $stmt2->bindParam(':status', $status);

      $stmt2->execute();
        

      header("Location: project.php");
      exit;

       } catch(PDOException $e){
      echo "Erreur : " . $e->getMessage();
    }
  }

// if ($status === 'in progress') {
//     $sql = "UPDATE project SET Status = 'in progress' WHERE ProjectID = :projectid";
//     $stmt = $conn->prepare($sql);
//     $stmt->execute(['projectid' => $project_id]);
// }
// if ($status === 'in review') {
//     $sql = "UPDATE project SET Status = 'in progress' WHERE ProjectID = :projectid";
//     $stmt = $conn->prepare($sql);
//     $stmt->execute(['projectid' => $project_Id]);
// }
// if ($status === 'done') {
//     $sql = "UPDATE project SET Status = 'done' WHERE ProjectID = :projectid";
//     $stmt = $conn->prepare($sql);
//     $stmt->execute(['projectid' => $project_id]);
// }

// try{
//     $stmt->execute();
//     echo "Status Updated succesffully";
//     header("Location: project.php");
//     exit;
//   }
//   catch(PDO_Exception $e){
//     echo "Erreur" .$sql . "<br>" . $e->getMessage();
//   }


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
           <P><label for="projectid" class="log">ProjectID</label></P>
         <input 
    type="number" 
    name="projectid" 
    id="projectid" 
    class="int" 
    value="<?= ($projectid); ?>" 
    readonly
    required
>
      

          <P><label for="projectid" class="log">TechnicianID</label></P>
          <select name="userid" id="userid" class="int" required>
            <option value="">Choose a technician</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['UserID']; ?>"><?php echo $role['UserName']; ?>
            </option>
        <?php endforeach; ?> 
          </select>

          <P><label for="text" class="log">TaskName</label></P>
          <P><input type="text" name="taskname" class="int" required ></P>
          <P> <label for="text" class="log">Description</label></P>
          <P><input type="text" name="description" class="int" required></P>
          <P> <label for="text" class="log">Status</label></P>
          <P><input type="text" name="status" class="int" required></P>
          <P> <input type="submit" name="submit"  class="btn-login" value="ADD"></P>
          </div>
           
        </main>
       </form>
</body>
</html>