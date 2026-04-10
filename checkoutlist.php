<?php include('header.php'); ?>

<?php
$cartId=isset($_GET['carts_id']) ? (int)$_GET['carts_id'] : 0;

$qry="SELECT *,ci.cart_id receipt_id FROM carts_id ci 
JOIN carts c ON ci.id = c.cart_id
JOIN products p ON c.p_id = p.id
WHERE ci.id = ? ORDER BY c.date_created DESC ";
$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $cartId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $receiptId = 'N/A';
    $checkoutItems = [];
    $subtotal = 0;
    $serviceFee = 0;
    $grandTotal = 0;
} else {
    $row = $result->fetch_assoc();
    $receiptId = $row['receipt_id'];

    $checkoutItems = [];
    $subtotal = 0;

    foreach ($result as $item) {
        $lineTotal = (float)$item['price'] * (int)$item['qty'];
        $subtotal += $lineTotal;

        $checkoutItems[] = [
            'id' => (int)$item['p_id'],
            'sku' => htmlspecialchars($item['sku']),
            'price' => (float)$item['price'],
            'qty' => (int)$item['quantity'],
            'line_total' => $lineTotal
        ];
    }

    $serviceFee = round($subtotal * 0.05, 2);
    $grandTotal = round($subtotal + $serviceFee, 2);
}
?>

<div class="product-container checkout-page">
	<div class="header checkout-header">
		<div class="title">Checkout</div>
		<button onclick="window.location.href='cartList.php'" class="btn-add" type="button">Back To Cart</button>
	</div>

	<div class="checkout-card">
		<div class="checkout-section receipt-box">
			<h2>Receipt ID</h2>
			<div class="receipt-id"><?= htmlspecialchars($receiptId) ?></div>
			<p class="receipt-note">Issued on <?= date('d M Y, h:i A') ?></p>
		</div>

		<div class="checkout-section cart-detail-box">
			<h2>Cart Detail</h2>

			<?php if (empty($checkoutItems)) { ?>
				<p class="cart-empty">No items found in your cart.</p>
			<?php } else { ?>
				<div class="cart-table-wrap">
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>SKU</th>
								<th>Qty</th>
								<th>Unit Price</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($checkoutItems as $item) { ?>
								<tr>
									<td><?= $item['id'] ?></td>
									<td><?= htmlspecialchars($item['sku']) ?></td>
									<td><?= $item['qty'] ?></td>
									<td class="price">RM <?= number_format($item['price'], 2) ?></td>
									<td class="price">RM <?= number_format($item['line_total'], 2) ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

				<div class="checkout-summary">
					<div class="summary-row">
						<span>Subtotal</span>
						<strong>RM <?= number_format($subtotal, 2) ?></strong>
					</div>
					<div class="summary-row">
						<span>Service Fee</span>
						<strong>RM <?= number_format($serviceFee, 2) ?></strong>
					</div>
					<div class="summary-row grand">
						<span>Grand Total</span>
						<strong>RM <?= number_format($grandTotal, 2) ?></strong>
					</div>
				</div>
			<?php } ?>
		</div>

		<div class="checkout-section payment-box">
			<h2>Payment Method</h2>
			<form class="payment-method-form" action="#" method="post" enctype="multipart/form-data">
				<label class="payment-option">
					<input type="checkbox" name="payment_method">
					<span>E-Wallet</span>
				</label>
				<div class="payment-details" style="display: none;">
					<p>Pay using your preferred E-Wallet app. We accept major providers for your convenience.</p>
					<img src="./ewallet QR.jpeg" alt="E-Wallet QR Code" width="400" height="400" class="payment-logo">
					<br>
					<input type="file" name="payment_proof" accept="image/*" required>
				</div>
				<button type="button" class="btn-add pay-btn" <?= empty($checkoutItems) ? 'disabled' : '' ?>>Confirm Payment</button>
			</form>

			<script>
				document.querySelector('input[name="payment_method"]').addEventListener('change', function() {
					const paymentDetails = document.querySelector('.payment-details');
					if (this.checked) {
						paymentDetails.style.display = 'block';
					} else {
						paymentDetails.style.display = 'none';
					}
				});
				</script>
		</div>
	</div>
</div>

<?php include('footer.php'); ?>