<?php

include("db.php");

$pdo = new PDO("mysql:host=localhost;dbname=ecommerce", "root", "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $sku = $_POST['sku'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Prepare the update query
    $sql = "UPDATE products 
            SET sku = :sku, 
                price = :price, 
                quantity = :quantity, 
                date_update = CURRENT_TIMESTAMP 
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    
    $result = $stmt->execute([
        ':sku' => $sku,
        ':price' => $price,
        ':quantity' => $quantity,
        ':id' => $id
    ]);

    if ($result) {
        echo "Product updated successfully! <a href=product.php>Go back</a>";
    } else {
        echo "Error updating record.";
    }
}
?>