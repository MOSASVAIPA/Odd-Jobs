<?php
    include "connect.php";
    if (isset($_POST["submit"])){
        $username = $_POST["user"];
        $email = $_POST["email"];
        $password = $_POST["pass"];

        $check = "select * from users where email = '$email'";
        $result = mysqli_query($conn, $check);
        $count = mysqli_num_rows($result);

        $errors = array();

        if($count>0){
            array_push($errors, "email is already taken.");
        }
        if(empty($username) OR empty($email) OR empty($password)){
            array_push($errors, "All fields are required.");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "email is not valid.");    
        }
        if(strlen($password)<8){
            array_push($errors, "password must be at least 8 characters long.");
        }

        if(count($errors)>0){
            foreach ($errors as $error){
                echo "<script>alert('$error');</script>";
            }
            
        }else{
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            if($stmt->execute()){
                   header("location: login.php");
            } else {
                echo "<div class='alert alert-danger'>Error in registration. Please try again later.</div>";
            }
            $stmt->close();
          
            
        }
        
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>ODD JOBS</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div id="form">
            <h1>Register :  </h1>
            <form name="form" action="registration.php" method="POST">
                <label>Username: </label></br>
                <input type="text" id="user" name="user"></br></br>
                <label>Email: </label></br>
                <input type="email" id="email" name="email"></br></br>
                <label>Password: </label></br>
                <input type="password" id="pass" name="pass"></br></br>
                <input type="hidden" id="uid" name="uid">
                <input type="submit" id="btn" value="Register" name="submit"><br><br>
                <a href="login.php">Already have an account? Sign in here.</a>
            </form>
        </div>
    </body>
</html>