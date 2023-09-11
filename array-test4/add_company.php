<?php
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
} else {
    header("Location: ../login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kyrol";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $compName = $_POST['compName'];
    $compStreet = $_POST['compStreet'];
    $compCity = $_POST['compCity'];
    $compState = $_POST['compState'];

    $sqlInsert = "INSERT INTO companyinfo (compName, compStreet, compCity, compState) 
                  VALUES ('$compName', '$compStreet', '$compCity', '$compState')";

    if ($conn->query($sqlInsert) === TRUE) {
        header("Location: CNC.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error: " . $sqlInsert . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company</title>
    <link rel="stylesheet" href="CNC.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
<ul>
        <li><a href="index.php"><img src="kyrol.png" alt=""></a></li>
        <li><a href="index.php">HOME</a></li>
        <li><a href="../invoice-task/invoice.php">INVOICE</a></li>
        <li><a href="quotation.php">QUOTATION</a></li>
        <li><a href="about.asp">P.O</a></li>
        <li><a href="about.asp">D.O</a></li>
    </ul>
    <header>
        <img src="kyrol.png" alt="">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">Add Company</p>
    </header>
    <form method="post">
        <label for="compName">Company Name:</label>
        <input type="text" id="compName" name="compName" required><br><br>

        <label for="compStreet">Street:</label>
        <input type="text" id="compStreet" name="compStreet" required><br><br>

        <label for="compCity">City:</label>
        <input type="text" id="compCity" name="compCity" required><br><br>

        <label for="compState">State:</label>
        <input type="text" id="compState" name="compState" required><br><br>

        <input type="submit" value="Add Company">
    </form>
    <footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>
</body>
</html>