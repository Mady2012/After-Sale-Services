<?php
include 'connection.php';

require '../mail/email.php';

$token = $_GET['token'];
$action = $_GET['action'];

if (!$token || !$action) {
    die("Invalid link.");
}
try {
    $stmt = $conn->prepare("SELECT * FROM task_val WHERE Token_confirm = :tok1 OR Token_reject = :tok2 LIMIT 1 ");
    $stmt->bindParam(":tok1", $token);
    $stmt->bindParam(":tok2", $token);

    $stmt->execute();
    $request = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$request) {
        die("This request has already been processed or does not exist.");
    }

    $taskId = $request['TaskID'];
    $newStatus = $request['New_status'];
    $internalId = $request['ID'];

       if ($action === 'confirm' && $token === $request['Token_confirm']) {
        $update = $conn->prepare("UPDATE task SET Status = :status WHERE TaskID = :id");
        $update ->bindParam(":status", $newStatus);
        $update ->bindParam(":id", $taskId);

        $update->execute();

        $msg = "Task $taskId has been successfully updated to: $newStatus.";
    } 
    else {
        $msg = "The status change for Task #$taskId has been rejected.";
    }
   $delete = $conn->prepare("DELETE FROM task_val WHERE ID = :id"); 
   $delete->bindParam(":id", $internalId);
    $delete->execute();

     echo "<script>
            alert('$msg');
            window.location.href='project.php';
          </script>";
}catch (PDOException $e) {
   die("Database error: " . $e->getMessage());
}







?>