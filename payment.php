<?php include('header.php');  
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $cartid=$_GET['cart_id'] ?? 0;
    $paymentProof = $_FILES['payment_proof'] ?? null;
    if ($paymentProof) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $payment_type='E-Wallet';
        $payment_amount=$_POST['payment_amount'] ?? 0;
        $payment_date=date('Y-m-d H:i:s');

        $fileName = basename($paymentProof['name']);
        $targetFilePath = $uploadDir .date("Ymd_His") . '_' . $fileName;
        $qry=$conn->prepare("UPDATE cart_id set c_status = ?, payment_amount=?, payment_date=?,payment_type=? where id = ?");
        $qry->bind_param("sdssi",$targetFilePath , $payment_amount, $payment_date, $payment_type, $cartid);
        $qry->execute();
        if (move_uploaded_file($paymentProof['tmp_name'], $targetFilePath)) {
            echo "<script>alert('Payment proof uploaded successfully!'); window.location.href='payment.php?cart_id=$cartid';</script>";
        } else {
            echo "<script>alert('Failed to upload payment proof. Please try again.'); window.location.href='checkoutList.php?cart_id=$cartid';</script>";
        }
    } else {
        echo "<script>alert('No payment proof uploaded or there was an error. Please try again.'); window.location.href='checkoutList.php?cart_id=$cartid';</script>";
    }
}

$qry=$conn->prepare("SELECT * FROM cart_id where id = ?");
$qry->bind_param("i", $_GET['cart_id']);
$qry->execute();
$result = $qry->get_result();
$row = $result->fetch_assoc();

?>
<div class="container">
    <div class="card">
        <div class="card-header">
            
        </div>
        <div class="card-body">
            <div class="form-group">
                <h2>Receipt No:<?= htmlspecialchars($row['cart_id']) ?></h2>
            </div>
           <div class="form-group">
                <img src="./<?= htmlspecialchars($row['c_status']) ?>" alt="Payment Proof" width="400" height=500 />
           </div>
           <div class="payment-info">
                <p><strong>Payment Amount:</strong> RM<?= number_format($row['payment_amount'], 2) ?></p>
                <p><strong>Payment Date:</strong> <?= date('d M Y, h:i A', strtotime($row['payment_date'])) ?></p>
                <p><strong>Payment Type:</strong> <?= htmlspecialchars($row['payment_type']) ?></p>
           </div>
            
        </div>
    </div>

</div>

<?php include('footer.php'); ?>