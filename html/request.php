<?php
session_start();
include 'connection.php';


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



$sql = "INSERT INTO request (UserID, Request_Title, Description, Image) VALUES (:user_id, :request_title, :description, :image)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":user_id", $userid);
$stmt->bindParam(':request_title', $request_title);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':image', $image);


try{
  $stmt->execute();
}
catch(PDO_Exception $e){
  echo "Erreur" .$sql . "<br>" . $e->getMessage();
}
  

$requestid = $conn->LastInsertId();

$projectname = 'projectname';
$description = 'description';



$sql = "INSERT INTO project(RequestID, ProjectName, Description) VALUES(:requestid, :projectname, :description)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":requestid", $requestid);
$stmt->bindParam(":projectname", $projectname);
$stmt->bindParam(":description", $description);


try{
    $stmt->execute();
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
        
        <div class="board">
             <section class="left-side">
                <div class="container">
                <form action="" method="post"  enctype="multipart/form-data">
                <h1>REQUEST FORM</h1>
                <div class="image-container">
                  <div class="image">
                  <img src="../avatar.jpeg" alt="">
                  <div class="icon"><i class="fa fa-camera"></i></div>
                </div>
                </div>
                <div class="content">
                <div class="name">
                    <label for="text">Request_Title</label>
                    <input type="text" name="request_title" class="int" required>


                        <label for="message">Description</label>
                        <input type="text" name="description" class="int" required>
                    
                    <label for="text">Image</label>
                    <input type="file" name="image" class="int" required><br>
                </div> 
                </div>
                <div><input type="submit" name="submit" class="btn-sub" value="SUBMIT"></div>
            </section>
        </div>
        <main>
           
        </main>
    </section>
    <script>
        $('#menu-btn').click(function(){
            $('#menu').toggleClass("active");
        })
    </script>
</form>
</body>
</html>