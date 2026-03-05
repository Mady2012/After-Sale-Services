<?php
include 'connection.php';

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($action == 'delete' && $id) {

    $stmtProject = $conn->prepare("SELECT ProjectID FROM project WHERE RequestID = :id");
    $stmtProject->execute(['id' => $id]);
    $project = $stmtProject->fetch(PDO::FETCH_ASSOC);

    if ($project) {
        $stmtDeleteTasks = $conn->prepare("DELETE FROM task WHERE ProjectID = :projectid");
        $stmtDeleteTasks->execute(['projectid' => $project['ProjectID']]);

        // Supprimer le projet
        $stmtDeleteProject = $conn->prepare("DELETE FROM project WHERE ProjectID = :projectid");
        $stmtDeleteProject->execute(['projectid' => $project['ProjectID']]);
    }

    $stmt = $conn->prepare("DELETE FROM request WHERE RequestID = :id");
    $stmt->execute(['id' => $id]);

    header("location: list.php" );
}
