<?php
    include "connect.php";
    session_start();

    if(!isset($_SESSION['username'])){
        header('location:login.php');
        exit();
    }

    if(isset($_POST['delete'])){
        $eid = $_POST['eid'];
        $uid = $_POST['uid'];
        $jid = $_POST['jid'];
        $sql = "DELETE FROM applicants WHERE uid = '$uid' AND jid = '$jid' AND eid = '$eid'";
        if($conn->query($sql) === TRUE){
            echo "Deleted successfully";
        }
        else{
            die("Connection failed: " . $conn->connect_error);
        }
    }

    if(isset($_POST['accept'])){
        $eid = $_POST['eid'];
        $uid = $_POST['uid'];
        $jid = $_POST['jid'];
        $sql = "UPDATE applicants SET status = 'accepted' WHERE uid = '$uid' AND jid = '$jid' AND eid = '$eid'";
        if($conn->query($sql) === TRUE){
            echo "Accepted successfully";
        }
        else{
            die("Connection failed: " . $conn->connect_error);
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
            <h1>User : <?php echo $_SESSION['username'] ?></h1>
            <h2>Email : <?php echo $_SESSION['email'] ?></h2>
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
            <th>Job Description:</th>
            <th>Username:</th>
            <th>Email:</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $eid = $_SESSION['uid'];
            $sql = "SELECT a.*, j.description AS job_description FROM applicants a INNER JOIN jobs j ON a.jid = j.jid WHERE a.eid = '$eid'";
            $res = mysqli_query($conn, $sql);
            if(mysqli_num_rows($res) > 0){
                while($rows = mysqli_fetch_array($res)){
                    $jobname = $rows["jobname"];
                    $job_description = $rows["job_description"];
                    $username = $rows['username'];
                    $uemail = $rows['email'];
                    $uid = $rows['uid'];
                    $jid = $rows['jid'];
                    $status = $rows['status'];

                    echo "<tr>
                        <td>$jobname</td>
                        <td>$job_description</td>
                        <td>$username</td>
                        <td>$uemail</td>
                        <td>
                            <form action='' method='POST'>
                                <input type='hidden' name='eid' value='$eid'>
                                <input type='hidden' name='uid' value='$uid'>
                                <input type='hidden' name='jid' value='$jid'>";
                                
                                if ($status === 'accepted') {
                                    echo "<input type='button' value='Accepted' disabled>";
                                } else {
                                    echo "<input type='submit' name='accept' value='Accept'>";
                                }
                                
                                echo "<input type='submit' name='delete' value='Delete'>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td>There are no applicants.</td></tr>";
            }
        ?>
        </tbody>
    </table>
</div>
<a href="logout.php" class="logout-btn">Logout</a>
</body>
</html>