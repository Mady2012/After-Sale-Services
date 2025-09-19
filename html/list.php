<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
  $user['UserID'] = $_SESSION['user_id'];
  $user['UserName']= $_SESSION['username'];

$sql = "SELECT * FROM request";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll();
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
            Support List
        </h3>
        
        <div class="board">
            <table width="100%">
                <thead>
                    <tr>
                    <td>Name</td>
                    <td>Title</td>
                    <td>Role</td>
                    <td>Status</td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $result): ?>
                    <tr>
                        <td class="people">
                            <img src="../   avatar.jpeg" alt="">
                            <div class="people-de">
                                <h5><?= (($user['UserName'])) ?></h5>
                                <p>wendymadissone@gmail.com</p>
                            </div>
                        </td>
                        <td class="people-des">
                            <h5><?= ($result['Request_Title']) ?></h5>
                            <p>Web dev</p>
                        </td>
                        <td class="active"><p>Active</p></td>
                        <td class="role">
                            <p>owner</p>
                        </td>
                        <td class="edit"><a href="#">Edit</a></td>
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