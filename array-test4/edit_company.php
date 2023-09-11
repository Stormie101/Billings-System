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
    $companyId = $_GET['id'];

    // Fetch company details based on the 'id'
    $sql = "SELECT * FROM companyinfo WHERE id = $companyId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $companyData = $result->fetch_assoc();
    } else {
        echo "Company not found.";
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
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">Update Company</p>
    </header>
    <!-- Create an edit form with fields pre-filled with $companyData -->
    <form action="update_company.php" method="POST">
        <input type="hidden" name="companyId" value="<?php echo $companyId; ?>">

        <label for="compName">Company Name:</label>
        <input type="text" name="compName" value="<?php echo $companyData['compName']; ?>"><br>

        <label for="compStreet">Street:</label>
        <input type="text" name="compStreet" value="<?php echo $companyData['compStreet']; ?>"><br>

        <label for="compCity">City:</label>
        <input type="text" name="compCity" value="<?php echo $companyData['compCity']; ?>"><br>

        <label for="compState">State:</label>
        <input type="text" name="compState" value="<?php echo $companyData['compState']; ?>"><br>

        <input type="submit" value="Update">
    </form>
    <footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>
</body>
</html>

<style>
    body {
    font-family: Arial, sans-serif;
    text-align: center;
}
</style>