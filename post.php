<?php
    include "connect.php";
    session_start();
    
    if(!isset($_SESSION['username'])){
        header('location:login.php');
        exit();
    } 

    if(isset($_POST['submit'])){
        $jobname = $_POST['jobname'];
        $description = $_POST['description'];
        $eid = $_POST['eid'];

        if(empty($jobname) || empty($description)) {
            echo "<div type='alert'>Job name and description cannot be empty.</div>";
        } else {
            $sql = "INSERT INTO jobs (jobname, description, eid) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $jobname, $description, $eid);
            if($stmt->execute()){
                echo "<div type='alert'>Job posted successfully</div>";
            } else {
                echo "Error in registration. Please try again later.";
            }
            $stmt->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="astyle.css">
    <style>
        .large-textarea {
            width: 100%;
            height: 200px;
            resize: vertical;
        }
    </style>
    <title>ODD JOBS</title>
</head>
<body>
<nav class="navbar">
    <div class="navdiv">
        <div class="logo"><a href="#">ODD JOBS</a></div>
        <div class="header">
            <h1>User: <?php echo $_SESSION['username']?></h1>
            <h2>Email: <?php echo $_SESSION['email']?></h2>
        </div>
        <ul>
            <li><a href="Jobs.php">Jobs</a></li>
            <li><a href="post.php">Post a Job</a></li>
            <li><a href="applicants.php">Applicants</a></li>
            <li><a href="your_jobs.php">Your Jobs</a></li>
            <li><a href="your_applications.php">Your Applications</a></li>
        </ul>
    </div>
</nav>
<div class="container">
    <?php
    $eid = $_SESSION['uid'];
    echo "<form action='' method='POST'>
                <label>Job Name:</label><br>
                <input type='text' name='jobname'><br><br>
                <label>Description:</label><br>
                <textarea name='description' class='large-textarea'></textarea><br><br>
                <input type='hidden' name='eid' value='$eid' >
                <input type='submit' name='submit' value='Post'>
          </form>";
    ?>
</div>
<a href="logout.php" class="logout-btn">Logout</a>
</body>
</html>