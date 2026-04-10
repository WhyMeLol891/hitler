<?php
include("db.php");
if(!isset($_SESSION["username"]) ||  $_SESSION["username"]==""){
    echo "<script>alert('Please login first'); window.location.href='index.php';<?script";
}

?>