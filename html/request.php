<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if (isset($_POST['submit'])){
$request_title = $_POST['request_title'];
$description = $_POST['description'];
$imagename = $_FILES['image']['name'];


if (!isset($_SESSION['user_id'])) {
  die("Error : No user connected.");
}
$userid = $_SESSION['user_id'];


$uploadDir = "../image/";
  $fileName = time() . "_" . basename($imagename);
  $targetFile = $uploadDir . $fileName;

  
  move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
  $image = $uploadDir . $fileName;



$sql1 = "INSERT INTO request (UserID, Request_Title, Description, Image) VALUES (:user_id, :request_title, :description, :image)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindParam(":user_id", $userid);
$stmt1->bindParam(':request_title', $request_title);
$stmt1->bindParam(':description', $description);
$stmt1->bindParam(':image', $image);


try{
  $stmt1->execute();
}
catch(PDO_Exception $e){
  echo "Erreur" .$sql . "<br>" . $e->getMessage();
}
 

$requestid = $conn->LastInsertId();

$projectname = $request_title;
$description = $description;



$sql2 = "INSERT INTO project(RequestID, ProjectName, Description) VALUES(:requestid, :request_title, :description)";
$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(":requestid", $requestid);
$stmt2->bindParam(":request_title", $projectname);
$stmt2->bindParam(":description", $description);


try{
    $stmt2->execute();
  }
  catch(PDO_Exception $e){
    echo "Erreur" .$sql . "<br>" . $e->getMessage();
  }
  
 }
 ?>

<html lang="en">
<head>
  <link rel="stylesheet" href="../css/request.css">
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
        </h3>
        <form action="" method="post"  enctype="multipart/form-data">
            <div class="container">
              <div class="board">
                <div class="content">
                  <div class="name">

                    <h1>REQUEST FORM</h1>

                    <label for="text">Request Title</label>
                    <input type="text" name="request_title" class="int" required>


                        <label for="message">Description</label>
                        <input type="text" name="description" class="int" required>
                    
                    <label for="text">Image</label>
                    <input type="file" name="image" class="int" required><br>
                  </div> 
                </div>
                <div><input type="submit" name="submit" class="btn-sub" value="SUBMIT"></div>
              </div>
            </div>
    </section>
    <script>
        $('#menu-btn').click(function(){
            $('#menu').toggleClass("active");
        })
    </script>
</form>
</body>
</html>