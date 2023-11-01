<?php
session_start();

// Check if the user is logged in; you can reuse your existing authentication logic here

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kyrol";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' parameter exists in the URL
if (isset($_GET['id'])) {
    $clientId = $_GET['id'];

    // Fetch company details based on the 'id'
    $sql = "SELECT * FROM client WHERE id = $clientId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $clientData = $result->fetch_assoc();
    } else {
        echo "client not found.";
        // Handle the case when the company is not found
        exit();
    }
} else {
    echo "Invalid request.";
    // Handle the case when 'id' is not provided in the URL
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
    <link rel="stylesheet" href="CNC.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
    <ul style="font-family: 'Poppins';">
        <li><a href="../index-test.php"><img src="../kyrol.png" alt=""></a></li>
        <li><a href="../index-test.php">HOME</a></li>
        <li><a href="../invoice-task/invoice.php">INVOICE</a></li>
        <li><a href="../quotation-task/quotation.php">QUOTATION</a></li>
        <li><a href="../purchaseorder-task/purchaseOR.php">P.O</a></li>
        <li><a href="../deliveryorder-task/deliveryOR.php">D.O</a></li>
    </ul>
    <header>
        <img src="kyrol.png" alt="">
        <p style="font-weight:bold; font-family: 'Poppins';">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-weight:bold; font-family: 'Poppins';">Update Client</p>
    </header>
    <!-- Create an edit form with fields pre-filled with $companyData -->
    <form action="update_client.php" method="POST">
        <input type="hidden" name="clientId" value="<?php echo $clientId; ?>">

        <label for="att">Attention To:</label>
        <input type="text" name="att" value="<?php echo $clientData['att']; ?>"><br>

        <label for="ctel">Telephone Number:</label>
        <input type="text" name="tel" value="<?php echo $clientData['tel']; ?>"><br>

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo $clientData['email']; ?>"><br>

        <!-- <label for="compState">State:</label>
        <input type="text" name="compState" value="<?php echo $clientData['compState']; ?>"><br> -->

        <input type="submit" value="Update">
    </form>
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
