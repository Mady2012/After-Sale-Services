<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
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

$sql = "SELECT * FROM request";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll();

// $sql1 = "SELECT Status FROM project";
// $stmt1 = $conn->prepare($sql);
// $stmt1->execute();

// $status = $stmt1->fetch();

function truncate($text,$max = 50){
    return strlen($text) > $max ? substr($text, 0, $max) . "..." : $text;
}

?>

<html lang="en">
<head>
    <link rel="stylesheet" href="../css/dash.css">
    <link rel="stylesheet" href="../Icon/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
            Dashboard
        </h3>
        <div class="values">
            <div class="val-box">
                <i class="fa fa-ticket"></i>
                <div>
                    <h3><?= ($supportcount) ?></h3>
                    <span>Total Support</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-diagram-project"></i>
                <div>
                    <h3><?= ($projectcount) ?></h3>
                    <span>New projects</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-critical-role"></i>
                <div>
                    <h3>200</h3>
                    <span>Projects In review</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-bars-progress"></i>
                <div>
                    <h3>200</h3>
                    <span>Project In Progress</span>
                </div>
            </div>
        </div>
        <div class="board">
            <table width="100%">
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
                        <td class="edit"><a href="modify.php?action=modify&id=<?php echo $req['RequestID']; ?>">Edit</a></td>
                        <td class="edit"><a href="delete.php?action=delete&id=<?php echo $req['RequestID']; ?>" onclick="return confirm('Do you really want to delete this request ?')">Delete</a></td>
                        <td class="edit"><a href="view.php">View</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <script>
        $('#menu-btn').click(function(){
            $('#menu').toggleClass("active");
        })
    </script>
</body>
</html>