<?php
session_start();
include 'connection.php';


if (isset($_POST['submit'])){
$request_title = $_POST['request_title'];
$description = $_POST['description'];
$imagename = $_FILES['image']['name'];

$uploadDir = "../image/";
  $fileName = time() . "_" . basename($imagename);
  $targetFile = $uploadDir . $fileName;

   
  
  move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
  $image = $uploadDir . $fileName;
  
$sql = "INSERT INTO request (Request_Title, Description, Image) VALUES (:request_title, :description, :image)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':request_title', $request_title);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':image', $image);


try{
  $stmt->execute();
  echo "Request is send successfully";
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
    echo "Project Created successfully";
  }
  catch(PDO_Exception $e){
    echo "Erreur" .$sql . "<br>" . $e->getMessage();
  }
  
 }

?>


<html lang="en">
<head>
    <link rel="stylesheet" href="../Icon/css/all.min.css">
    <link rel="stylesheet" href="../css/request.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <form action="" method="post" enctype="multipart/form-data" >
            <header class="top-bar">
              <img src="../logo_inov.png" alt="">
                <nav class="top-nav">
                  <i class="fa fa-ticket"></i>Support Request
                </nav>
                <div class="user">
                    <img src="../avatar.jpeg" alt="">
                </div>
            </header>
            <aside class="side-bar">
                <div class="menu">
                   <p><i class="fa fa-dashboard"></i><a href="dash.php">Dashboard</a></p>
                    <p><i class="fa fa-first-aid"></i><a href="list.php">Support List</a></p>
                    <p class="board"><i class="fa fa-ticket"></i><a href="request.php">Support Request</a></p>
                    <p><i class="fa fa-diagram-project"></i><a href="project.php">Project</a></p>
                    <p><i class="fa fa-bars-progress"></i><a href="#">Progress</a></p>
                    <a href="disconnect.php" class="btn">Disconnect</a>
                </div>
                </aside>
              <main>
                <section class="left-side">
                 <div class="container">
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
              </main>
</body>
</html>