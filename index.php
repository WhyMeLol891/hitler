<?php
    include "db.php";

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username=$_POST["username"];
        $password=$_POST["password"];

        $qry=$conn->prepare("SELECT * FROM users WHERE username=?");
        $qry->bind_param("s",$username);
        $qry->execute();
        $result=$qry->get_result();
        if($result->num_rows>0){
            $user=$result->fetch_assoc();

            if (password_verify($password,$user['password'])){
                $_SESSION["username"]=$user["username"];
                $_SESSION["user_id"]=$user["id"];
                echo "<script>alert('Login succesful');
                window.location.href='main.php';
                </script>";
            }else{
                echo "Login Failed";
            }
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
        <h1>Login</h1>
            <div class="card">
                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="username"> Username:</label>
                        <input type="text" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <button type="submit" value="Login"> login </button>
                    <br>
                    <a href="register.php">Did not had account? Click me for register</a>
                </form>
            </div>
    </div>
</body>
</html>