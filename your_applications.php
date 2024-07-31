<?php
    include "connect.php";
    session_start();

    if(!isset($_SESSION['username'])){
        header('location:login.php');
        exit();
    } 
    if(isset($_POST['delete'])){
        $applicant_uid = $_SESSION['uid'];
        $jobname = $_POST['jobname'];
        $description = $_POST['description'];
        $sql = "DELETE FROM applicants WHERE uid = '$applicant_uid' AND jobname = '$jobname' AND description = '$description'";
        if($conn->query($sql) === TRUE){
            echo "Application deleted successfully";
        } else {
            echo "Error deleting application: " . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="astyle.css">
    <title>ODD JOBS</title>
</head>
<body>
<nav class="navbar">
    <div class="navdiv">
        <div class="logo"><a href="#">ODD JOBS</a></div>
        <div class="header">
            <h1>User : <?php echo $_SESSION['username']?></h1>
            <h2>Email : <?php echo $_SESSION['email']?></h2>
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
    <table class="content-table">
        <thead>
        <tr>
            <th>Job:</th>
            <th>Description:</th>
            <th>Status:</th>
            <th>Action:</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $applicant_uid = $_SESSION['uid'];
        $sql = "SELECT * FROM applicants WHERE uid = '$applicant_uid'";
        $result = mysqli_query($conn, $sql);
        while ($rows = mysqli_fetch_array($result)) {
            $jobname = $rows['jobname'];
            $description = $rows['description'];
            $status = $rows['status'];
            echo "<tr>
                    <td>$jobname</td>
                    <td>$description</td>
                    <td>$status</td>
                    <td>
                        <form action='' method='POST'>
                            <input type='hidden' name='jobname' value='$jobname'>
                            <input type='hidden' name='description' value='$description'>
                            <input type='submit' name='delete' value='Delete' onclick=\"return confirm('Are you sure you want to delete this application?');\">
                        </form>
                    </td>
                </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<br><br>
<a href="logout.php" class="logout-btn">Logout</a>
</body>
</html>