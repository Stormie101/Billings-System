<?php
session_start();

// 1. Connect to the Database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kyrol";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $role = $_SESSION['adminrole'];

    // 2. Retrieve User Role
    $sql = "SELECT adminrole FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $role = $row['adminrole'];
    }
} else {
    header("Location: login.php");
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
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
    <header>
        <img src="kyrol.png" alt="">
        <p style="font-weight:bold; padding-bottom:5px;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-weight:bold;">Billing System 0.5</p>
    </header>

    <div class="holder">
    <div class="welcome-text"><p style="text-decoration:uppercase;">Welcome <?php echo $username; ?></p><a href="logout.php" id="log-out">Log-out</a></div><hr style="margin-bottom:8px;"><!-- Added Welcome text with horizontal rule -->
    <div class="row">
        <a href="CompanyClient/CNC.php" class="dashboard-button" style="text-decoration: none;">COMPANY / CLIENT</a>
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
    <div class="row">
    <?php if($role == 'Admin'): ?>
        <a href="manageAdmin/manages.php" class="dashboard-button" style="text-decoration: none;">MANAGE</a>
    <?php endif; ?>
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
<?php
$conn->close();
?>