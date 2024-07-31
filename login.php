<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ODD JOBS</title>
</head>
<body>
        <div id="form">
            <h1>Login :  </h1>
            <form name="loginform" action="login.php" method="POST">
                <label>Username: </label></br>
                <input type="text" id="user" name="user"></br></br>
                <label>Email: </label></br>
                <input type="text" id="email" name="email"></br></br>
                <label>Password: </label></br>
                <input type="password" id="pass" name="pass"></br></br>
                <input type="submit" id="btn" value="Login" name="submit"><br><br>
                <a href="registration.php">Dont have and account yet? Sign up here.</a>
            </form>
        </div>
<?php
    include "connect.php";
    $error = "Username/Password incorrect";
    if(isset($_POST['submit'])){
        $username=$_POST['user'];
        $email=$_POST['email'];
        $password=$_POST['pass'];
        $sql = "SELECT * FROM users WHERE username='$username' && email = '$email' && password='$password'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_num_rows($query);
        $fetch = mysqli_fetch_array($query);
        if($row > 0){
            $username = $fetch['username'];
            $email = $fetch['email'];
            $uid = $fetch['uid'];
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['uid'] = $uid;
            header('location: jobs.php');
        }
        else{
            echo '<script>alert("Username/Password incorrect");</script>';
        }

    }
?>
</body>
</html>