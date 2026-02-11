<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
  $user['UserID'] = $_SESSION['user_id'];
  $user['UserName']= $_SESSION['username'];


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

$sql = "SELECT * FROM request";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll();

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
        
        <div class="board">
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
                             <p></p>
                        </td>

                        <td class="edit">
                         <a href="modify.php?action=modify&id=<?php echo $req['RequestID']; ?>"><i class="fa fa-pencil"></i></a>
                         <a href="delete.php?action=delete&id=<?php echo $req['RequestID']; ?>" onclick="return confirm('Do you really want to delete this request ?')"><i class="fa fa-trash trash"></i></a>
                         <a href="view.php?id=<?= $req['RequestID'] ?>"> <i class="fa fa-eye eyes"></i></a>
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