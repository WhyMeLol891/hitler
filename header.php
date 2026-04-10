<?php
include("db.php");
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
    <nav class="navbar">
        <div class="logo img">
            <img src="https://th.bing.com/th/id/OIP.TjTT8BxCbY-YaDkkdEj4twHaE0?w=279&h=181&c=7&r=0&o=7&pid=1.7&rm=3" alt="logo">
        </div>
        <ul class="nav-links">
            <li><a href="main.php">Home</a></li>
            <li><a href="product.php">Product</a></li>
            <li><a href="cartlist.php">Cart</a></li>
            <li><a href="checkoutlist.php">Checkout list</a></li>
            <li>
                <?php if(isset($_SESSION["username"]) && $_SESSION["username"]){ ?>
                    <a href="#"><?=$_SESSION['username']?> </a>
                    <div class="submenu">
                        <ul class="dropdown">
                            <li><a href="profile.php">Profile</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>      
                <?php }else{ ?>
                    <a href="index.php">Login</a>
                    <a href="register.php">Register</a>
                <?php } ?>
        </ul>
    </nav>
</body>
</html>