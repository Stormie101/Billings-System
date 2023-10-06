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
    <title>Invoice Detail</title>
    <link rel="stylesheet" href="viewmore.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
<header>
        <img src="kyrol.png" alt="">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">Invoice Detail</p>
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
    $sql = "SELECT * FROM client_invoice WHERE id = $id"; // Adjust the query as per your database structure
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display the detailed information here
        echo "<div class='quotation-container'>";
        echo "<h1 class='quotation-details' style='font-size:30px;'>Client Detail</h1>";
        echo "<h1 class='quotation-details'>Quotation ID: " . $row["INo"] . "</h1>";
        echo "<p class='quotation-details'><span>Attention To (ATT) :</span>" . $row["ATT"] . "</p>";
        echo "<p class='quotation-details'><span>Phone Number:</span>" . $row["TEL"] . "</p>";
        echo "<p class='quotation-details'><span>Email:</span>" . $row["EMAIL"] . "</p>";
        echo "<p class='quotation-details'><span>Reference:</span>" . $row["REF"] . "</p>";

        echo "<h1 class='quotation-details' style='font-size:30px;'>Invoice Detail</h1>";
        echo "<p class='quotation-details'><span>Date:</span>" . $row["Dates"] . "</p>";
        echo "<p class='quotation-details'><span>Terms:</span>" . $row["Terms"] . "</p>";
        echo "<p class='quotation-details'><span>Sale Person:</span>" . $row["SaleP"] . "</p>";
        echo "<p class='quotation-details'><span>P/O No:</span>" . $row["PO_no"] . "</p>";
        echo "<p class='quotation-details'><span>L/O Date:</span>" . $row["LO_date"] . "</p>";
        echo "<p class='quotation-details'><span>Page:</span>" . $row["Pages"] . "</p>";

        echo "<h1 class='quotation-details' style='font-size:30px;'>Vendor Address</h1>";
        echo "<p class='quotation-details'><span>Company Name:</span>" . $row["compName"] . "</p>";
        echo "<p class='quotation-details'><span>Street:</span>" . $row["compStreet"] . "</p>";
        echo "<p class='quotation-details'><span>City:</span>" . $row["compCity"] . "</p>";
        echo "<p class='quotation-details'><span>State:</span>" . $row["compState"] . "</p>";

        // Add more details as needed

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
