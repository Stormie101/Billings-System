<?php
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
} else {
    header("Location: ../login.php");
    exit();
}

//mention database
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $compName = $_POST['compName'];
    $compStreet = $_POST['compStreet'];
    $compCity = $_POST['compCity'];
    $compState = $_POST['compState'];
    $compPcode = $_POST['compPcode'];
    $compTel = $_POST['compTel'];
    $compFax = $_POST['compFax'];

    $sqlInsert = "INSERT INTO companyinfo (compName, compStreet, compCity, compState, compPcode, compTel, compFax) 
                  VALUES ('$compName', '$compStreet', '$compCity', '$compState', '$compPcode','$compTel','$compFax')";

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
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
<ul>
        <li><a href="../index-test.php"><img src="../kyrol.png" alt=""></a></li>
        <li><a href="../index-test.php">HOME</a></li>
        <li><a href="../invoice-task/invoice.php">INVOICE</a></li>
        <li><a href="../quotation-task/quotation.php">QUOTATION</a></li>
        <li><a href="../purchaseorder-task/purchaseOR.php">P.O</a></li>
        <li><a href="../deliveryorder-task/deliveryOR.php">D.O</a></li>
    </ul>
    <header>
        <img src="kyrol.png" alt="">
        <p style="font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-weight:bold;">Add Company</p>
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

        <label for="compState">Postcode:</label>
        <input type="text" id="compPcode" name="compPcode" required><br><br>

        <label for=" compTel">Tel:</label>
        <input type="text" id=" compTel" name=" compTel" required><br><br>

        <label for="compFax">Fax:</label>
        <input type="text" id="compFax" name="compFax" required><br><br>

        <input type="submit" value="Add Company">
    </form>
    <footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>
</body>
</html>
