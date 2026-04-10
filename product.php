<?php 
include('header.php'); 

$qry=$conn->prepare("SELECT * FROM products");
$qry->execute();
$result=$qry->get_result();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $productId = (int)$_POST['product_id'];
    if ($productId > 0) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += 1;
        } else {
            $_SESSION['cart'][$productId] = 1;
        }

        $json=json_encode($_SESSION['cart']);
        file_put_contents('cart.json', $json);

        echo "<script>alert('Product added to cart'); window.location.href='product.php';</script>";
}else{
        echo "<script>alert('Invalid product ID'); window.location.href='product.php';</script>";
    }
}
?>


<div class="product-container">
    <div class="header">
        <div class="title">Product List</div>
        <button onclick="window.location.href='add_products.php'" class="btn-add">+ Add Product</button>
        <a href="cartlist.php" class="btn-cart">View Cart</a>
    </div>

    <div class="card">
        <div class="search-box">
            <input type="text" placeholder="Search product...">
        </div>
    </div>

    <table>
        <thead>
            <tr>
            <th>ID</th>
            <th>SKU</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Date Created</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row=$result->fetch_assoc()){ ?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=$row['sku']?></td>
                    <td><?=$row['price']?></td>
                    <td><?=$row['quantity']?></td>
                    <td><?=$row['date_create']?></td>
                    <td><?=$row['date_update']?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="product_id" value="<?=$row['id']?>">
                            <button type="submit" class="btn btn-primary" name="add_to_cart">Add to Cart</button>
                        </form>
                    </td>
                    <td>
                        <a href="edit_products.php?id=<?=$row['id']?>" class="btn btn-success">Edit</a>
                       <a href="delete_product.php?id=<?=$row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
</div>

<?php include('footer.php'); ?>