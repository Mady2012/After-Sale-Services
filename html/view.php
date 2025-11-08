<?php
include 'connection.php';
  

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($action == 'view' && $id) {
    $stmt = $conn->prepare("SELECT * FROM request WHERE RequestID = :id");
    $stmt->execute(['id' => $id]);
    $request = $stmt->fetch(PDO::FETCH_ASSOC);

    header("Location: view.php");
}
?>