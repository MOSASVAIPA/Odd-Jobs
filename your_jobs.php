<?php
    include "connect.php";
    session_start();

    if(!isset($_SESSION['username'])){
        header('location:login.php');
        exit();
    } 

    if(isset($_POST['update'])){
        $jid = $_POST['jid'];
        $jobname = $_POST['jobname'];
        $description = $_POST['description'];
        
        $sql = "UPDATE jobs SET jobname = '$jobname', description = '$description' WHERE jid = '$jid' AND eid = '".$_SESSION['uid']."'";
        if($conn->query($sql) === TRUE){
            echo "Job updated successfully";
        } else {
            die("Error updating job: " . $conn->connect_error);
        }
    }

    if(isset($_POST['delete'])){
        $jid = $_POST['jid'];
        
        $sql = "DELETE FROM jobs WHERE jid = '$jid' AND eid = '".$_SESSION['uid']."'";
        if($conn->query($sql) === TRUE){
            echo "Job deleted successfully";
        } else {
            die("Error deleting job: " . $conn->connect_error);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="astyle.css">
    <title>Your Jobs</title>
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
    <h2>Your Jobs</h2>
    <table class="content-table">
        <thead>
        <tr>
            <th>Job:</th>
            <th>Description:</th>
            <th>Edit:</th>
            <th>Delete:</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $user_uid = $_SESSION['uid'];
        $sql = "SELECT * FROM jobs WHERE eid = '$user_uid'";
        $result = mysqli_query($conn, $sql);
        while ($rows = mysqli_fetch_array($result)) {
            $jid = $rows['jid'];
            $jobname = $rows['jobname'];
            $description = $rows['description'];
            echo "<tr>
                    <td>$jobname</td>
                    <td>$description</td>
                    <td>
                        <form action='' method='POST'>
                            <input type='hidden' name='jid' value='$jid'>
                            <input type='submit' name='edit' value='Edit'>
                        </form>
                    </td>
                    <td>
                        <form action='' method='POST'>
                            <input type='hidden' name='jid' value='$jid'>
                            <input type='submit' name='delete' value='Delete' onclick=\"return confirm('Are you sure you want to delete this job?');\">
                        </form>
                    </td>
                </tr>";
        }
        ?>
        </tbody>
    </table>

    <?php
    if(isset($_POST['edit'])){
        $jid = $_POST['jid'];
        $sql = "SELECT * FROM jobs WHERE jid = '$jid' AND eid = '$user_uid'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
    ?>
    <div class="edit-form">
        <h2>Edit Job</h2>
        <form action="" method="POST">
            <input type="hidden" name="jid" value="<?php echo $jid; ?>">
            <label for="jobname">Job Name:</label>
            <input type="text" name="jobname" value="<?php echo $row['jobname']; ?>" required><br>
            <label for="description">Description:</label>
            <textarea name="description" class="large-textarea" required><?php echo $row['description']; ?></textarea><br>
            <input type="submit" name="update" value="Update Job">
        </form>
    </div>
    <?php
    }
    ?>
</div>
<br><br>
<a href="logout.php" class="logout-btn">Logout</a>
</body>
</html>