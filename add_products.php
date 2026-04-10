<?php include("header.php"); 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    $SKU = $_POST["sku"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $date_created=date("Y-m-d H:i:s");

    // FIX: Ensure we use the specific session key, not the whole array
    $qry=$conn->prepare("INSERT INTO products(sku, price, quantity, date_create) VALUES (?, ?, ?, ?)");
    $qry->bind_param("siis", $SKU, $price, $quantity,$data_created);
    if($qry->execute()){
        echo "<script>alert('Product added successfully');
        window.location.href='product.php';
        </script>";
    } else {
        echo "<script>alert('Failed to add product');
        window.location.href='add_product.php';
        </script>";
    }
}
?>
<div class="container profile-page">
    <div class="profile-card">

        <h1>Product form</h1>
        <form action="" method="post" >
        <div class="form-group">
            <label for="sku">SKU:</label>
            <input type="text" id="sku" name="sku" class="form-control" value="">
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" class="form-control" value="">
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" class="form-control" value="">
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
        <br>
        <br>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='product.php'">Back to Product List</button>
        </form>
    </div>
</div>
<?php include("footer.php") ?>