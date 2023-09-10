<?php
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
} else {
    header("Location: ../login.php"); // Redirect to login page if not logged in
    exit();
}

// Establish a database connection (assuming you're using MySQL)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kyrol";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the current highest quotation number
$sql = "SELECT MAX(INo) AS max_quotation FROM client_invoice";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_quotation_number = $row['max_quotation'];
    $new_quotation_number = $current_quotation_number + 1;
} else {
    // If there are no records yet, start from 1
    $new_quotation_number = 1;
}

// Retrieve the current highest quotation number
$sqls = "SELECT MAX(PO_no) AS PO FROM client_invoice";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
    $rows = $results->fetch_assoc();
    $current_PO_number = $rows['PO'];
    $new_PO_number = $current_PO_number + 1;
} else {
    // If there are no records yet, start from 1
    $new_PO_number = 1;
}

$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Process</title>
    <link rel="stylesheet" href="invoice.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
</head>
<body>
    <ul>
        <li><a href="../index.html"><img src="../kyrol.png" alt=""></a></li>
        <li><a href="../index.html">HOME</a></li>
        <li><a href="news.asp">INVOICE</a></li>
        <li><a href="../quotation-task/quotation.php">QUOTATION</a></li>
        <li><a href="about.asp">P.O</a></li>
        <li><a href="about.asp">D.O</a></li>
    </ul>
    <header>
        <img src="../kyrol.png" alt="">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">INVOICE</p>
    </header>
    <div class="content">
    <div id="innercontent">
    <form action="invoice2.php" method="post">
        <div class="clientdetail">
            <h5>CLIENT'S DETAIL</h5>
                <table>
                    <tr>
                        <td><p>ATT:</p></td>
                        <td><p><input type="text" name="att" id="att" required></p></td>
                    </tr>
                    <tr>
                        <td><p>TEL:</p></td>
                        <td><p><input type="tel" name="tel" required></p></td>
                    </tr>
                    <tr>
                        <td><p>EMAIL:</p></td>
                        <td><p><input type="text" name="email" required></p></td>
                    </tr>
                    <tr>
                        <td><p>REF:</p></td>
                        <td><p><input type="text" name="reference" required></p></td>
                    </tr>
                </table>
        </div>
        <div class="clientdetail">
                <h5>INVOICES'S DETAIL</h5>
                <table>
                    <tr>
                        <td><p>Invoice No:</p></td>
                        <td><p><input type="number" name="INo" value="<?php echo $new_quotation_number; ?>" required readonly></p></td>
                    </tr>
                    <tr>
                        <td><p>Date:</p></td>
                        <td><p><input type="date" name="Dates" required></p></td> 
                    </tr>
                    <tr>
                        <td><p>Terms:</p></td>
                        <td><p><input type="text" name="Terms" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Sales Per:</p></td>
                        <!-- <td><p><input type="text" name="SaleP" required></p></td> -->
                        <td>
                        <select id="SaleP" name="SaleP" required>
                            <option value="Elle">Elle</option>
                            <option value="Syaf">Syaf</option>
                            <option value="Fatin">Fatin</option>
                            <option value="Nizam">Nizam</option>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td><p>P/O No:</p></td>
                        <td><p><input type="number" name="Pno" value="<?php echo $new_PO_number; ?>" required readonly></p></td>
                    </tr>
                    <tr>
                        <td><p>L/O Date:</p></td>
                        <td><p><input type="date" name="Ldate" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Pages:</p></td>
                        <!-- <td><p><input type="number" name="Pages" required></p></td> -->
                        <td>
                        <select id="Pages" name="Pages" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="clientdetail">
                <h5>VENDOR ADDRESS</h5>
                <table>
                    <tr>
                        <td><p>Company:</p></td>
                        <td><p><input type="text" name="compName" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Street:</p></td>
                        <td><p><input type="text" name="compStreet" required></p></td>
                    </tr>
                    <tr>
                        <td><p>City:</p></td>
                        <td><p><input type="text" name="compCity" required></p></td>
                    </tr>
                    <tr>
                        <td><p>State:</p></td>
                        <td><p><input type="text" name="compState" required></p></td>
                    </tr>
                </table>
            </div>
        
        <label>Enter the number of quotations (10 max):</label>
        <input type="number" name="numQuotations" min="1" max="10" style="width:500px;" required>
        <button type="submit">Proceed</button>
    </form>
    </div>
    </div>
    <footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>
</body>
</html>
