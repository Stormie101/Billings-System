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
    <title>Quotation Details</title>
    <link rel="stylesheet" href="viewmore.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
    <header>
        <img src="kyrol.png" alt="">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">Quotation Detail</p>
    </header>
    <form action="generatepdf.php" method="post">
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
    $sql = "SELECT * FROM client_quotation WHERE id = $id"; // Adjust the query as per your database structure
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $year = date('Y', strtotime($row["DATES"]));
        echo "<div class='quotation-container'>";
        echo "<h1 class='quotation-details' style='font-size:30px;'>Client Detail</h1>";
        echo "<h1 class='quotation-details'>Quotation ID: KSL/" . $year . "/Q/" . $row["QNo"] . "</h1>";
        echo "<p class='quotation-details'><span>Attention To (ATT) :</span>" . $row["ATT"] . "</p>";
        echo "<p class='quotation-details'><span>Phone Number:</span>" . $row["TEL"] . "</p>";
        echo "<p class='quotation-details'><span>Email:</span>" . $row["EMAIL"] . "</p>";
        echo "<p class='quotation-details'><span>Reference:</span>" . $row["REF"] . "</p>";
        echo "<h1 class='quotation-details' style='font-size:30px;'>Quotation Detail</h1>";
        echo "<p class='quotation-details'><span>Date:</span>" . $row["DATES"] . "</p>";
        echo "<p class='quotation-details'><span>Sale Person:</span>" . $row["SaleP"] . "</p>";
        echo "<p class='quotation-details'><span>Page:</span>" . $row["PAGES"] . "</p>";
        echo "<h1 class='quotation-details' style='font-size:30px;'>Vendor Address</h1>";
        echo "<p class='quotation-details'><span>Company Name:</span>" . $row["compName"] . "</p>";
        echo "<p class='quotation-details'><span>Street:</span>" . $row["compStreet"] . "</p>";
        echo "<p class='quotation-details'><span>City:</span>" . $row["compCity"] . "</p>";
        echo "<p class='quotation-details'><span>State:</span>" . $row["compState"] . "</p>";
        echo "<p class='quotation-details'><span>Postcode:</span>" . $row["compPcode"] . "</p>";

        // Add more details as needed
    
        // Add a button to go back
    // Add a button to go back
    // Add this line to include QNo as a hidden input field
    echo "<input type='hidden' name='QNo' value=".$row['QNo'].">";
    echo "<div class='quotation-footer'><a href='history.php' class='button-primary' id='button'>Go Back</a> <button type='submit' id='print-button' onclick='printPdf()' class='button'>Print</button></div>";

    echo "</div>";
    } else {
        echo "No records found";
    }
} else {
    echo "Invalid ID";
}

$conn->close();
?>
</form>
<footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>
</body>
<script>
function printPdf() {
    var QNo = document.getElementById('QNo').value;
    document.getElementById('QNo').disabled = true; // Disable the input to prevent changes
    document.getElementById('print-button').disabled = true; // Disable the button to prevent multiple submissions
    document.forms[0].submit(); // Submit the form
}
</script>
</html>

<style>
button {
  margin-left:30px;
  font-size: 13px;
  letter-spacing: 2px;
  text-transform: uppercase;
  display: inline-block;
  text-align: center;
  font-weight: bold;
  padding: 10px;
  border: 3px solid #1df071;
  border-radius: 2px;
  position: relative;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.1);
  color: #1df071;
  text-decoration: none;
  transition: 0.3s ease all;
  z-index: 1;
  background-color: white;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  cursor:pointer;
}

button:before {
  transition: 0.5s all ease;
  position: absolute;
  top: 0;
  left: 50%;
  right: 50%;
  bottom: 0;
  opacity: 0;
  content: '';
  background-color: #1df071;
  z-index: -1;
}

button:hover, button:focus {
  color: white;
}

button:hover:before, button:focus:before {
  transition: 0.5s all ease;
  left: 0;
  right: 0;
  opacity: 1;
}

button:active {
  transform: scale(0.9);
}

#button {
  font-size: 13px;
  letter-spacing: 2px;
  text-transform: uppercase;
  display: inline-block;
  text-align: center;
  font-weight: bold;
  padding: 8px;
  border: 3px solid #f01835;
  border-radius: 2px;
  position: relative;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.1);
  color: #f01835;
  text-decoration: none;
  transition: 0.3s ease all;
  z-index: 1;
  background-color: white;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}

#button:before {
  transition: 0.5s all ease;
  position: absolute;
  top: 0;
  left: 50%;
  right: 50%;
  bottom: 0;
  opacity: 0;
  content: '';
  background-color: #f01835;
  z-index: -1;
}

#button:hover, #button:focus {
  color: white;
}

#button:hover:before, #button:focus:before {
  transition: 0.5s all ease;
  left: 0;
  right: 0;
  opacity: 1;
}

#button:active {
  transform: scale(0.9);
}
</style>