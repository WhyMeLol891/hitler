<?php
include ('header.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = ("SELECT * FROM products WHERE id = $id");
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();

    if (!$product) {
        die("Product ID $id not found.");
    }
} else {
    die("Error: No product ID provided.");
}

?>

<!DOCTYPE html>
<html>
<body>
    <h2>Edit Product</h2>
    <form action="update_products.php" method="POST">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">

        SKU: <br>
        <input type="text" name="sku" value="<?= $product['sku'] ?>"><br><br>

        Price: <br>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['sku']); ?>"><br><br>

        Quantity: <br>
        <input type="number" name="quantity" value="<?= $product['quantity'] ?>"><br><br>

        <button type="submit">Update Product</button>
    </form>


</body>
</html>
<?php include ('footer.php');