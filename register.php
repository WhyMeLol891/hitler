<?php
    include "db.php";

    if ($_SERVER["REQUEST_METHOD"]==="POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirm_password =$_POST["confirm_password"];

        $qry=$conn->prepare("SELECT * FROM users WHERE username=?");
        $qry->bind_param("s",$username);
        $qry->execute();
        $result=$qry->get_result();
        if($result->num_rows>0){
            echo "Username already exist!";
            exit();
        }

        if($password===$confirm_password){
            $hashed_password=password_hash($password ,PASSWORD_DEFAULT);
            $stmt=$conn->prepare("INSERT INTO users(username, password) VALUES(?,?)");
            $stmt->bind_param("ss",$username,$hashed_password);
            $stmt->execute();
            $stmt->close();
            echo "Resgister successful";
        }else{
            echo "Password does not match";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
     <div class="container">
        <h1>Register</h1>
            <div class="card">
                 <form action="register.php" method="post">
                <div class="form-group">
                     <label for="username"> Username:</label>
                     <input type="text" id="username" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="confirm_password"> Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password">
                </div>
                <button type="submit" value="register">Register</button>
                <br>
                <a href="index.php">Login page</a>
            </form>
        </div>
    </div>
</body>
</html>