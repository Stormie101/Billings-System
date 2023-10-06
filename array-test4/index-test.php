<?php
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
} else {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing System</title>
    <link rel="stylesheet" href="index-test.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
    <header>
        <img src="kyrol.png" alt="">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">Billing System 0.3</p>
    </header>

    <div class="holder">
    <div class="welcome-text"><p>Welcome <?php echo $username; ?></p><a href="logout.php" id="log-out">Log-out</a></div><hr style="margin-bottom:8px;"><!-- Added Welcome text with horizontal rule -->
    <div class="row">
        <a href="CNC.php" class="dashboard-button" style="text-decoration: none;">COMPANY / CLIENT</a>
    </div>
    <div class="row">
        <a href="invoice-task/invoice.php" class="dashboard-button" style="text-decoration: none;">INVOICE</a>
        <a href="quotation-task/quotation.php" class="dashboard-button" style="text-decoration: none;">QUOTATION</a>
    </div>
    <div class="row">
        <a href="PurchaseOrder-task/PurchaseOR.php" class="dashboard-button" style="text-decoration: none;">PURCHASE ORDER</a>
        <a href="DeliveryOrder-task/DeliveryOr.php" class="dashboard-button" style="text-decoration: none;">DELIVERY ORDER</a>
    </div>
    <div class="row">
        <a href="history-save/history.php" class="dashboard-button" style="text-decoration: none;">HISTORY</a>
    </div>
</div>
    <br>
    <br>
    <br>
    <br>
    <footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>
</body>
</html>
