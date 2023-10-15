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
$sql = "SELECT MAX(PO_Number) AS max_quotation FROM client_purchaseOrder";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_quotation_number = $row['max_quotation'];
    $new_quotation_number = $current_quotation_number + 1;
} else {
    // If there are no records yet, start from 1
    $new_quotation_number = 1;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PO Process</title>
    <link rel="stylesheet" href="PurchaseOR.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
    $('#compName').on('blur', function() {
        var CNValue = $(this).val();

        // Send an AJAX request to fetch tel and email based on att
        $.ajax({
            url: 'company-details.php', // Create this PHP file
            type: 'POST',
            data: {compName: CNValue},
            success: function(data) {
                var detailsz = JSON.parse(data);

                // Update the tel and email fields
                $('#compStreet').val(detailsz.compStreet);
                $('#compCity').val(detailsz.compCity);
                $('#compPcode').val(detailsz.compPcode);
                $('#compState').val(detailsz.compState);
                $('#compTel').val(detailsz.compTel);
                $('#compFax').val(detailsz.compFax);
            }
        });
    });
});
    </script>
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
        <img src="../kyrol.png" alt="">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">PURCHASE ORDER</p>
    </header>
    <div class="content">
    <div id="innercontent">
    <form action="PurchaseOR2.php" method="post">
        <div class="clientdetail">
            <h5>CLIENT'S DETAIL</h5>
                <table>
                    <tr>
                        <td><p>PO NO:</p></td>
                        <td><p><input type="number" name="PO-NO" id="att" value="<?php echo $new_quotation_number; ?>" required readonly></p></td>
                    </tr>
                    <tr>
                        <td><p>Date</p></td>
                        <td><p><input type="date" name="Dates" required></p></td>
                    </tr>
                </table>
        </div>
        <div class="clientdetail">
                <h5>VENDOR ADDRESS</h5>
                <table>
                    <tr>
                        <td><p>Company:</p></td>
                        <td><p><input type="text" name="compName" id="compName" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Street:</p></td>
                        <td><p><input type="text" name="compStreet" id="compStreet"  required></p></td>
                    </tr>
                    <tr>
                        <td><p>City:</p></td>
                        <td><p><input type="text" name="compCity" id="compCity"  required></p></td>
                    </tr>
                    <tr>
                        <td><p>Postcode:</p></td>
                        <td><p><input type="number" name="compPcode" id="compPcode"  required></p></td>
                    </tr>
                    <tr>
                        <td><p>State:</p></td>
                        <td><p><input type="text" name="compState" id="compState"  required></p></td>
                    </tr>
                    <tr>
                        <td><p>Telephone:</p></td>
                        <td><p><input type="text" name="compTel" id="compTel"  required></p></td>
                    </tr>
                    <tr>
                        <td><p>Fax:</p></td>
                        <td><p><input type="text" name="compFax" id="compFax"  required></p></td>
                    </tr>
                </table>
            </div>
        <div class="clientdetail">
                <h5>SHIPPING INFORMATION</h5>
                <table>
                    <tr>
                        <td><p>Requistioner:</p></td>
                        <td><p><input type="text" name="Req"></p></td>
                    </tr>
                    <tr>
                        <td><p>Ship VIA:</p></td>
                        <td><p><input type="text" name="ShipV"></p></td> 
                    </tr>
                    <tr>
                        <td><p>F.O.B:</p></td>
                        <td><p><input type="text" name="Fob"></p></td>
                    </tr>
                    <tr>
                        <td><p>Shipping Terms:</p></td>
                        <td><p><input type="text" name="Sterm"></p></td>
                    </tr>
                    <tr>
                        <td><p>Shipping Date:</p></td>
                        <td><p><input type="date" name="Sdate"></p></td>
                    </tr>
                </table>
            </div>
        
        <label>Enter the number of item (10 max):</label>
        <input type="number" name="numQuotations" min="1" max="10" style="width:500px;" required>
        <button type="submit" onclick="test()">Proceed</button>
    </form>
    </div>
    </div>
    <footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>
</body>
<script>
function test() {
  alert("Continue?");
}
</script>
</html>
