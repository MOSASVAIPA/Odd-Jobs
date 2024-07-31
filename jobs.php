<?php
include "connect.php";
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit();
}

if (isset($_POST["apply"])) {
    $applicant_name = $_SESSION['username'];
    $applicant_email = $_SESSION['email'];
    $applicant_uid = $_SESSION['uid'];
    $jobname = $_POST['jobname'];
    $eid = $_POST['eid'];
    $uid = $_POST['uid'];
    $jid = $_POST['jid'];
    $description = $_POST['description'];


    $sql_check = "SELECT * FROM applicants WHERE uid = '$applicant_uid' AND jid = '$jid'";
    $result_check = mysqli_query($conn, $sql_check);
    if (mysqli_num_rows($result_check) == 0) {
        $sql = "INSERT INTO applicants (username, email, jobname, eid, uid, jid, description) VALUES (?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $applicant_name, $applicant_email, $jobname, $eid, $uid, $jid, $description);
        if ($stmt->execute()) {
            echo "";
        } else {
            echo "<div class='alert alert-danger'>Error in registration. Please try again later.</div>";
        }
        $stmt->close();
    } else {

        echo "<script>alert('You have already applied for this job');</script>";
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
            <div class="header"><h1>User : <?php echo $_SESSION['username']?></h1>
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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $uid = $_SESSION['uid'];
                $sql = "select * from jobs where eid != '$uid'";
                $result = mysqli_query($conn, $sql);
                while ($rows = mysqli_fetch_array($result)) {
                    $eid = $rows['eid'];
                    $jobname = $rows['jobname'];
                    $description = $rows["description"];
                    $jid = $rows['jid'];

                    $sql_check = "SELECT * FROM applicants WHERE uid = '$uid' AND jid = '$jid'";
                    $result_check = mysqli_query($conn, $sql_check);
                    if (mysqli_num_rows($result_check) == 0) {
                        echo "<tr>
                                <td>$jobname</td>
                                <td>$description</td>
                                <td>
                                    <form action='' method='POST'>
                                        <input type='hidden' name='eid' value='$eid'>
                                        <input type='hidden' name='jobname' value='$jobname'>
                                        <input type='hidden' name='uid' value='$uid'>
                                        <input type='hidden' name='jid' value='$jid'>
                                        <input type='hidden' name='description' value='$description'>
                                        <input type='submit' name='apply' value='Apply'>
                                    </form>
                                </td>
                            </tr>";
                    } else {
                        echo "<tr>
                                <td>$jobname</td>
                                <td>$description</td>
                                <td>Applied</td>
                            </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <br><br>
    <a href="logout.php" class="logout-btn">Logout</a>
</body>

</html>