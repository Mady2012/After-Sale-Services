<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
  $user_id = $_SESSION['user_id'];
  $username = $_SESSION['username'];
  $role = $_SESSION['role'] ?? 'User';

if ($role === 'admin' || $role === 'technician') {
   if ($role === 'admin' || $role === 'technician') {
    $sql = "SELECT *, 
            (SELECT Status FROM task WHERE RequestID = request.RequestID ORDER BY TaskID DESC LIMIT 1) AS last_status 
            FROM request ORDER BY RequestID DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
} else {
    $sql = "SELECT *, 
            (SELECT Status FROM task WHERE RequestID = request.RequestID ORDER BY TaskID DESC LIMIT 1) AS last_status 
            FROM request WHERE UserID = :userid ORDER BY RequestID DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['userid' => $user_id]);
}

$result = $stmt->fetchAll();
}

$sqlsupport = "SELECT COUNT(*) AS total_support FROM request";
$stmtsupport = $conn->prepare($sqlsupport);
$stmtsupport->execute();

$supportData = $stmtsupport->fetch();
$supportcount = $supportData['total_support'];

$sqlproject = "SELECT COUNT(*) AS total_project FROM project";
$stmtproject = $conn->prepare($sqlproject);
$stmtproject->execute();

$projectData = $stmtproject->fetch();
$projectcount = $projectData['total_project'];



function truncate($text,$max = 50){
    return strlen($text) > $max ? substr($text, 0, $max) . "..." : $text;
}

?>

<html lang="en">
<head>
    <link rel="stylesheet" href="../css/list.css">
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
            Support List
        </h3>
        
        <div class="board" style="padding: 30px;">
            <table  id= "tab" width="100%">
                <thead>
                    <tr>
                    <td>Name</td>
                    <td>Title</td>
                    <td>Description</td>
                    <td>Status</td>
                    <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $req): ?>
                    <?php
                    $sqlUser = "SELECT UserName, Email FROM user WHERE UserID = :id";
                    $stmtUser = $conn->prepare($sqlUser);
                    $stmtUser->execute([':id' => $req['UserID']]);
                    $user = $stmtUser->fetch();

                    if (!$user) {
                        $user = ['UserName' => 'Unknown user', 'Email' => 'Not defined'];
                    }

                    ?>
                    <tr>
                        <td class="people">
                            <img src="../avatar.jpeg" alt="">
                            <div class="people-de">
                                <h5><?= (($user['UserName'])) ?></h5>
                                <p><?= (($user['Email'])) ?></p>
                            </div>
                        </td>
                        <td class="people-des">
                            <h5><?= ($req['Request_Title']) ?></h5>
                        </td>
                         <td><p><?= (truncate($req['Description'], 40)) ?></p></td>
                        <td class="role">
                            <?php
                             $status = $req['last_status'] ?? 'New'; 

                             $color = "#3498db"; // Bleu (New)
                             if ($status == 'Completed')   $color = "#27ae60"; // Vert
                             if ($status == 'In Progress') $color = "#f39c12"; // Orange
                             if ($status == 'Pending')     $color = "#e74c3c"; // Rouge

                            $bgColor = $statusStyles[$status] ?? "#3498db";
                            ?>
                            <span style="
                                display: inline-block;
                                padding: 4px 12px;
                                background-color: <?= $bgColor ?>;
                                color: white;
                                font-size: 12px;
                                font-weight: bold;
                                font-family: sans-serif;
                                border-radius: 20px;
                                ">
                                <?= htmlspecialchars($status) ?>
                            </span>
                        </td>

                        <td class="edit">
                         <a href="modify.php?action=modify&id=<?php echo $req['RequestID']; ?>"> <i class="fa fa-pencil pencil" ></i></a>
                         <a href="delete.php?action=delete&id=<?php echo $req['RequestID']; ?>" onclick="return confirm('Do you really want to delete this request ?')"> <i class="fa fa-trash trash"></i></a>
                         <a href="view.php?action=view&id=<?php echo $req['RequestID']; ?>"><i class="fa fa-eye eye"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>


    <!-- <style>
        
table#tab.dataTable tbody td,
table#tab.dataTable thead th {
    padding: 15px !important;
}

    </style> -->

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