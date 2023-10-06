<?php
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
} else {
    header("Location: ../login.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P.O Detail</title>
    <link rel="stylesheet" href="viewmore.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
<header>
        <img src="kyrol.png" alt="">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">Purchase Order Detail</p>
    </header>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kyrol";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM client_purchaseorder WHERE id = $id"; // Adjust the query as per your database structure
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display the detailed information here
        echo "<div class='quotation-container'>";
        echo "<h1 class='quotation-details' style='font-size:30px;'>Client Detail</h1>";
        echo "<h1 class='quotation-details'>Purchase Order NO: " . $row["PO_Number"] . "</h1>";
        echo "<p class='quotation-details'><span>Date:</span>" . $row["Dates"] . "</p>";


        echo "<h1 class='quotation-details' style='font-size:30px;'>Vendor Address</h1>";
        echo "<p class='quotation-details'><span>Company Name:</span>" . $row["compName"] . "</p>";
        echo "<p class='quotation-details'><span>Street:</span>" . $row["compStreet"] . "</p>";
        echo "<p class='quotation-details'><span>City:</span>" . $row["compCity"] . "</p>";
        echo "<p class='quotation-details'><span>State:</span>" . $row["compState"] . "</p>";

        echo "<h1 class='quotation-details' style='font-size:30px;'>Shipping Information</h1>";
        echo "<p class='quotation-details'><span>Company Name:</span>" . $row["Requist"] . "</p>";
        echo "<p class='quotation-details'><span>State:</span>" . $row["ShipDate"] . "</p>";
        echo "<p class='quotation-details'><span>Street:</span>" . $row["ShipVia"] . "</p>";
        echo "<p class='quotation-details'><span>City:</span>" . $row["FOB"] . "</p>";
        echo "<p class='quotation-details'><span>State:</span>" . $row["ShipTerm"] . "</p>";
        echo "<div class='quotation-footer'><a href='history.php' class='button-primary'>Go Back</a></div>";
        echo "</div>";
    } else {
        echo "No records found";
    }
} else {
    echo "Invalid ID";
}

$conn->close();
?>
<footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>
</body>
</html>
