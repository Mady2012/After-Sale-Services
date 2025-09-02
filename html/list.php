<?php
session_start();
include 'connection.php';

    $user['UserID'] = $_SESSION['user_id'];
    $user['UserName']= $_SESSION['username'];



$sql = "SELECT * FROM request";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll();


if(isset($_GET['delete'])){
    $id = $_GET['user_id'];

    
    $stmt = $conn->prepare("DELETE FROM request WHERE UserID = :user_id");
    $stmt->bindParam(":user_id", $id);
    $stmt->execute();
    header('Location:list.php');

}

?>

<html lang="en">
<head>
    <link rel="stylesheet" href="../Icon/css/all.min.css">
    <link rel="stylesheet" href="../css/list.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <main>
            <header class="top-bar">
                <img src="../logo_inov.png" alt="">
                <nav class="top-nav">
                    <i class="fa fa-first-aid"></i>Support List
                </nav>
                <div class="user">
                    <img src="../avatar.jpeg" alt="">
                </div>
            </header>
            <aside class="side-bar">
                <div class="menu">
                   <p><i class="fa fa-dashboard"></i><a href="C:\wamp64\www\After-Sales\html\dash.php">Dashboard</a></p>
                    <p class="board"><i class="fa fa-first-aid"></i><a href="C:\wamp64\www\After-Sales\html\list.php">Support List</a></p>
                    <p><i class="fa fa-ticket"></i><a href="C:\wamp64\www\After-Sales\html\request.php">Support Request</a></p>
                    <p><i class="fa fa-diagram-project"></i><a href="C:\wamp64\www\After-Sales\html\project.php">Project</a></p>
                    <p><i class="fa fa-bars-progress"></i><a href="#">Progress</a></p>
                    <a href="disconnect.php" class="btn">Disconnect</a>
                </div>
                </aside>
                <!-- <div class="int"> 
                    <i class="fa fa-researchgate"></i><input type="text" placeholder="search">
                </div> -->

                <table>
                    <thead>
                        <tr>
                            <th>RequestID</th>
                            <th>UserID</th>
                            <th>UserName</th>
                            <th>RequestTitle</th>
                            <th>Description</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <?php foreach ($result as $result): ?>
            <tr>

                <td><?= ($result['RequestID']) ?></td>
                <td><?= (($user['UserID'])) ?></td>
                <td><?= (($user['UserName'])) ?></td>
                <td><?= ($result['Request_Title']) ?></td>
                <td><?= ($result['Description']) ?></td>
                
  </td>
  <td>
                <?php if (!empty($result['Image'])): ?>
                    <a href="<?= $result['Image'] ?>" >
                        <img src="<?= $result['Image'] ?>" >
                    </a>
                <?php else: ?>
                    No image
                <?php endif; ?>
                <a href="list.php?delete<?= $user['UserID']?>"onclick="return confirm('Are you sure you want to delete')"><button name="delete" >Delete</button></a>
            </td>
            </tr>
            <?php endforeach; ?>
                </table>
                </section>
</body>
</html>