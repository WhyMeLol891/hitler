<?php
include("db.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Using $conn to match your db.php
    $sql = "DELETE FROM products WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the correct filename: product.php
        header("Location: product.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>