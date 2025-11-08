<?php
include 'connection.php';

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

    
    $stmt = $conn->prepare("SELECT * FROM request WHERE RequestID = :id");
    $stmt->execute(['id' => $id]);
    $request = $stmt->fetch(PDO::FETCH_ASSOC);


    
    if (isset($_POST['submit'])) {
        $request_title = $_POST['request_title'];
        $description = $_POST['description'];

    
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = "../image/";
            $fileName = time() . "_" . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName);
            $image = $uploadDir . $fileName;
        } else {
            $image = $request['Image']; 
        }
try{
        $stmt = $conn->prepare("UPDATE request SET Request_Title = :request_title, Description = :description, Image = :image WHERE RequestID = $id");
        $stmt->bindParam(":request_title", $request_title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":image", $image);
        $stmt->execute();
        
}catch(PDOException $e){
    die("Update failed : " . $e->getMessage());
}

       header("Location: dash.php");
    }
?>

<html lang="en">
<head>
  <link rel="stylesheet" href="../css/request.css">
  <link rel="stylesheet" href="../css/dash.css">
  <link rel="stylesheet" href="../Icon/css/all.min.css">
  <meta charset="UTF-8">
  <title>Modify Request</title>
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
        <div class="board">
             <section class="left-side">
                <div class="container">
          
                <h1>REQUEST FORM</h1>
                <div class="image-container">
                  <div class="image"></div>
                </div>

    <div class="image-container">
        <div class="image">
            <img src="<?php echo !empty($request['Image']) ? $request['Image'] : '../avatar.jpeg'; ?>" alt="">
            <!-- <div class="icon"><i class="fa fa-camera"></i></div> -->
        </div>
    </div>

    <div class="content">
        <div class="name">
            <label for="text">Request_Title</label>
            <input type="text" name="request_title" class="int" value="<?= ($request['Request_Title']); ?>" >

            <label for="message">Description</label>
            <input type="text" name="description" class="int" value="<?= ($request['Description']); ?>" >

            <label for="text">Image</label>
            <input type="file" name="image" class="int"><br>
        </div>
    </div>

    <div>
        <input type="submit" name="submit" class="btn-sub" value="SUBMIT">
    </div>
</form>
