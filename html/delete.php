<?php
include 'connection.php';

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($action == 'delete' && $id) {
    
    $stmt = $conn->prepare("DELETE FROM request WHERE RequestID = :id");
    $stmt->execute(['id' => $id]);

    header("location: request.php" );
}
