<?php
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
} else {
    header("Location: ../login.php"); // Redirect to login page if not logged in
    exit();
}

//mention database
include 'db.php';

// Retrieve the current highest quotation number
$sql = "SELECT MAX(DOn) AS max_quotation FROM client_delivery";
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
$sqls = "SELECT MAX(INo) AS PO FROM client_delivery";
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
    <title>DO Process</title>
    <link rel="stylesheet" href="DeliveryOr.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#att').on('blur', function() {
        var attValue = $(this).val();

        // Send an AJAX request to fetch tel and email based on att
        $.ajax({
            url: 'client-detail.php', // Create this PHP file
            type: 'POST',
            data: {att: attValue},
            success: function(data) {
                var details = JSON.parse(data);

                // Update the tel and email fields
                $('#tel').val(details.tel);
                $('#email').val(details.email);
            }
        });
    });
});
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
                $('#compState').val(detailsz.compState);
                $('#compPcode').val(detailsz.compPcode);
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
        <p style="font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-weight:bold;">DELIVERY ORDER</p>
    </header>
    <div class="content">
    <div id="innercontent">
    <form action="DeliveryOr2.php" method="post">
        <div class="clientdetail">
            <h5>CLIENT'S DETAIL</h5>
                <table>
                    <tr>
                        <td><p>ATT:</p></td>
                        <td><p><input type="text" name="att" id="att" required></p></td>
                    </tr>
                    <tr>
                        <td><p>TEL:</p></td>
                        <td><p><input type="tel" name="tel" id="tel" required></p></td>
                    </tr>
                    <tr>
                        <td><p>EMAIL:</p></td>
                        <td><p><input type="text" name="email" id="email" required></p></td>
                    </tr>
                    <tr>
                        <td><p>REF:</p></td>
                        <td><p><input type="text" name="reference" required></p></td>
                    </tr>
                </table>
        </div>
        <div class="clientdetail">
                <h5>DELIVERY ORDER'S DETAIL</h5>
                <table>
                    <tr>
                        <!-- NEW -->
                        <td><p>D.O No:</p></td>
                        <td><p><input type="number" name="DOn" value="<?php echo $new_quotation_number; ?>" required readonly></p></td>
                    </tr>
                    <tr>
                        <td><p>Date:</p></td>
                        <td><p><input type="date" name="Dates" required></p></td> 
                    </tr>
                    <tr>
                        <td><p>Terms:</p></td>
                        <!-- <td><p><input type="text" name="Terms" required></p></td> -->
                        <td>
                        <select id="Terms" name="Terms" required>
                            <option value="Cheque / EFT">Cheque / EFT</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                        </td>
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
                        <td><p>Inv No:</p></td>
                        <td><p><input type="number" name="INo" value="<?php echo $new_PO_number; ?>" required readonly></p></td>
                        <!-- NEW -->
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
                        <td><p><input type="text" name="compName" id="compName" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Street:</p></td>
                        <td><p><input type="text" name="compStreet" id="compStreet" required></p></td>
                    </tr>
                    <tr>
                        <td><p>City:</p></td>
                        <td><p><input type="text" name="compCity" id="compCity" required></p></td>
                    </tr>
                    <tr>
                        <td><p>State:</p></td>
                        <td><p><input type="text" name="compState" id="compState" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Postcode:</p></td>
                        <td><p><input type="number" name="compPcode" id="compPcode"  required></p></td>
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
