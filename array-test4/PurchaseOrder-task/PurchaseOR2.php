<?php
session_start();

if(isset($_SESSION['username'])){
    $usernames = $_SESSION['username'];
} else {
    header("Location: ../login.php"); // Redirect to login page if not logged in
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Establish a database connection (replace with your actual database credentials)
$host = "localhost";
$username = "root";
$password = "";
$database = "kyrol";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


    //number of quotation
    $numQuotations = $_POST["numQuotations"];

    //client detail
    $POno = $_POST["PO-NO"];
    $Dates = $_POST["Dates"];

    //Shipping information
    // $Req = $_POST["Req"];
    $Req = isset($_POST["Req"]) && !empty($_POST["Req"]) ? $_POST["Req"] : "None";
    $ShipV = isset($_POST["ShipV"]) && !empty($_POST["ShipV"]) ? $_POST["ShipV"] : "None";
    $Fob = isset($_POST["Fob"]) && !empty($_POST["Fob"]) ? $_POST["Fob"] : "None";
    $Sterm = isset($_POST["Sterm"]) && !empty($_POST["Sterm"]) ? $_POST["Sterm"] : "None";
    $Sdate = isset($_POST["Sdate"]) && !empty($_POST["Sdate"]) ? $_POST["Sdate"] : "None";


    //Vendor Address
    $compName = $_POST["compName"];
    $compStreet = $_POST["compStreet"];
    $compCity = $_POST["compCity"];
    $compPcode = $_POST["compPcode"];
    $compState = $_POST["compState"];
    $compTel = $_POST["compTel"];
    $compFax = $_POST["compFax"];

    $years = date("Y", strtotime($Dates));
    $sets = "KSL/$years/PO/$POno";

    // Check if QNo already exists in the database
    $checkQuery = "SELECT PO_Number FROM client_purchaseorder WHERE PO_Number = '$POno'";
    $result = $conn->query($checkQuery); 

    if ($result->num_rows > 0) {
        // QNo already exists, handle accordingly (show an error message or take any other action)
        $conn->close();
    } else {
        $sql = "INSERT INTO client_purchaseorder (PO_Number, Dates, compName, compStreet, compCity, compPcode, compState, compTel, compFax, Requist, ShipVia, FOB, ShipTerm, ShipDate, username, W_PO) VALUES ('$POno','$Dates','$compName','$compStreet','$compCity', '$compPcode','$compState','$compTel', '$compFax','$Req','$ShipV','$Fob','$Sterm','$Sdate','$usernames', '$sets')";
        // ... Construct and execute similar queries for other data ...
        if ($conn->query($sql) === TRUE) {
            // echo "<p style='background-color:#50e991; color:white; text-align:center; font-size:20px; padding:15px;'>Data has entered successfully!</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
    $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PO Process</title>
    <link rel="stylesheet" href="PurchaseOR2.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
</head>
<body>
    <ul>
        <li><a href="../index-test.php"><img src="../kyrol.png" alt=""></a></li>
        <li><a href="../index-test.php">HOME</a></li>
        <li><a href="../invoice-task/invoice.php">INVOICE</a></li>
        <li><a href="../quotation-task/quotation.php">QUOTATION</a></li>
        <li><a href="../PurchaseOrder-task/PurchaseOR.php">P.O</a></li>
        <li><a href="../DeliveryOrder-task/DeliveryOr.php">D.O</a></li>
    </ul>

    <header>
        <img src="../kyrol.png" alt="">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">Purchase Order</p>
    </header>

    <form action="generatepdfOR.php" method="post">

        <!-- Hidden input fields to hold other data -->
    <input type="hidden" name="POno" value="<?php echo $POno ?>">
    <input type="hidden" name="dates" value="<?php echo $Dates ?>">

    <input type="hidden" name="req" value="<?php echo $Req ?>">
    <input type="hidden" name="shipv" value="<?php echo $ShipV ?>">
    <input type="hidden" name="fob" value="<?php echo $Fob ?>">
    <input type="hidden" name="sterm" value="<?php echo $Sterm ?>">
    <input type="hidden" name="sdate" value="<?php echo $Sdate ?>">

    <input type="hidden" name="compName" value="<?php echo $compName ?>">
    <input type="hidden" name="compStreet" value="<?php echo $compStreet ?>">
    <input type="hidden" name="compCity" value="<?php echo $compCity ?>">
    <input type="hidden" name="compPcode" value="<?php echo $compPcode ?>">
    <input type="hidden" name="compState" value="<?php echo $compState ?>">
    <input type="hidden" name="compTel" value="<?php echo $compTel ?>">
    <input type="hidden" name="compFax" value="<?php echo $compFax ?>">
    <input type="hidden" name="set" value="KSL/<?php echo $years ?>/PO/<?php echo $POno ?>">

    
    <div class="content">
        <div id="innercontent">
            <div class="clientdetail">
            <h5>CLIENT'S DETAIL</h5>
                <table>
                    <tr>
                        <td><p>PO NO:</p></td>
                        <td><p><?php echo $POno ?></p></td>
                    </tr>
                    <tr>
                        <td><p>DATE:</p></td>
                        <td><p><?php echo $Dates ?></p></td>
                    </tr>
                </table>
            </div>
            <div class="clientdetail">
                <h5>VENDOR ADDRESS</h5>
                <table>
                    <tr>
                        <td><p>Company:</p></td>
                        <td><p><?php echo $compName ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Street:</p></td>
                        <td><p><?php echo $compStreet ?></p></td>
                    </tr>
                    <tr>
                        <td><p>City:</p></td>
                        <td><p><?php echo $compCity ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Postcode:</p></td>
                        <td><p><?php echo $compPcode ?></p></td>
                    </tr>
                    <tr>
                        <td><p>State:</p></td>
                        <td><p><?php echo $compState ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Telephone:</p></td>
                        <td><p><?php echo $compTel ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Fax:</p></td>
                        <td><p><?php echo $compFax ?></p></td>
                    </tr>
                </table>
            </div>
            <div class="clientdetail">
                <h5>SHIPPING INFORMATION</h5>
                <table>
                    <tr>
                        <td><p>Requistioner:</p></td>
                        <td><p><?php echo $Req ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Ship VIA:</p></td>
                        <td><p><?php echo $ShipV ?></p></td>
                    </tr>
                    <tr>
                        <td><p>F.O.B:</p></td>
                        <td><p><?php echo $Fob ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Shipping Terms:</p></td>
                        <td><p><?php echo $Sterm ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Shipping Date:</p></td>
                        <td><p><?php echo $Sdate ?></p></td>
                    </tr>
                </table>
            </div>
            <hr>
            <div class="Qinput">
            <div class="input-table">
        <table>
        <tr>
            <th>No</th>
            <th>Description</th>
            <th>Date</th>
            <th>Quantity</th>
            <th>U.Price</th>
            <th>GST OPTION</th>
            <th>GST AMOUNT</th>
            <th>Total</th>
        </tr>
        <?php
        for ($i = 1; $i <= $numQuotations; $i++) {
            echo"<tr>";
            echo"<td><input input type='hidden' name='nom[]' value='$i' required></input>$i</td>";
            echo"<td><textarea name='desc[]' cols='30' rows='5' required> </textarea></td>";
            echo "<td><input type='date' name='PODate[]' id='PODate[]'> </input></td>";
            echo"<td><input type='text' name='quantity[]' id='quantity_$i' oninput='formatInput(this); calculateTotal($i)' required></input></td>";
            echo"<td><input type='text' name='unit_price[]' id='unit_price_$i' oninput='calculateTotal($i); formatInputs(this); updateCalculationTotals();' required></input></td>";
            echo"<td>
                    <select name='gst_option[]' id='gst_option_$i' onchange='calculateTotal($i)' oninput='calculateTotal($i); updateCalculationTotals()'>
                        <option value='no'>No</option>
                        <option value='yes'>Yes</option>
                    </select>
                </td>";
            echo"<td><input type='text' name='gst_amount[]' id='gst_amount_$i' readonly></input></td>";
            echo"<input type='hidden' name='discount_percentage[]' id='discount_percentage_$i' oninput='calculateTotal($i)' oninput='calculateTotal($i); updateCalculationTotals()'></input>";
            echo"<td><input type='text' name='item_total[]' id='item_total_$i' readonly ></input></td>";
            echo"";
            echo"";
            echo"";
            echo"<tr>";
        }
        ?>
        </table>
        </div>
    <hr>
    <div id="extras"style="margin:15px; padding:10px;">
        <!-- new input -->
        <label style="padding-bottom:10px">Discount(%)</label><br>
        <input type="text" id="extras_discount" oninput="updateCalculationTotals()"><br>
        <label style="padding-bottom:10px">Other</label><br>
        <input type="text" id="other_input" oninput="formatInput(this); updateCalculationTotals()" value="<?php echo isset($_POST['other_amount']) ? $_POST['other_amount'] : '0.00'; ?>">
    </div>
</div>
    <div class="calculate">
    <hr>
    <h5>Calculation</h5>
        <p>Total Amount:</p>
        <input type="text" id="total_amount" name="total_amount" value='0.00' readonly>

        <p>Total Discount(%):</p>
        <input type="text" id="total_discount" name="total_discount" value='0.00' readonly>

        <p>Total Other:</p>
        <input type="text" id="total_other" name="other_amount" value='0.00' readonly>

        <p>Total Net:</p>
        <input type="text" id="net_amount" name="net_amount" value='0.00' readonly>

        <p>Total GST:</p>
        <input type="text" id="Tgst" name="Tgst" value='0.00' readonly>

        <p>Total Gross:</p>
        <input type="text" id="total_gross" name="gross_amount" value='0.00' readonly>
        <br>
        <button type="submit" id="print-button">Print</button>

        <!-- hidden input to transfer data into generate.pdf -->
        <input type="hidden" name="total_amount_calculated" id="total_amount_calculated">
        <input type="hidden" name="total_discount_calculated" id="total_discount_calculated">
        <input type="hidden" name="net_amount_calculated" id="net_amount_calculated">
        <input type="hidden" name="net_gst_calculated" id="net_gst_calculated">
        <input type="hidden" name="total_gross_calculated" id="total_gross_calculated">
    </form>
    </div>
    <!-- inner content -->
    </div>

    <!-- content end -->
    </div>
    <footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>
</body>
<script>
document.getElementById("print-button").addEventListener("click", function() {
    alert("Are you all set to continue?");
});
function formatInputs(input) {
    let value = input.value.replace(/[^\d.]/g, '');  // Allow digits and decimal point only
    let parts = value.split('.');

    if (parts.length > 1) {
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        value = parts.join('.');
    } else {
        value = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    input.value = value;
    calculateTotal(input.id.split('_')[2]); // Calculate total after formatting
}

function calculateTotal(index) {
    var quantity = parseFloat(document.getElementById('quantity_' + index).value.replace(/,/g, ''));
    var unitPrice = parseFloat(document.getElementById('unit_price_' + index).value.replace(/,/g, ''));
    var gstOption = document.getElementById('gst_option_' + index).value;
    var discountPercentage = parseFloat(document.getElementById('discount_percentage_' + index).value) || 0;
    
    var gstAmount = 0;
    if (gstOption === 'yes') {
        gstAmount = unitPrice * (6 / 100);
    }
    
    var subtotal = quantity * unitPrice;
    var totalBeforeDiscount = subtotal + gstAmount;

    var discountAmount = (discountPercentage / 100) * totalBeforeDiscount;
    var total = totalBeforeDiscount - discountAmount;

    document.getElementById('gst_amount_' + index).value = gstAmount.toFixed(2);
    document.getElementById('item_total_' + index).value = total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Format as currency

    // Recalculate all the totals
    updateCalculationTotals();
}

function updateCalculationTotals() {
    var totalAmount = 0;
    var netAmount = 0;
    var totalGross = 0;
    var totalDiscount = 0;
    var totalGST = 0;

    var otherAmount = parseFloat(document.getElementById('other_input').value.replace(/[^\d.]/g, '')) || 0;

    // Loop through the individual items to accumulate totals
    for (var i = 1; i <= <?php echo $numQuotations; ?>; i++) {
        var itemTotal = parseFloat(document.getElementById('item_total_' + i).value.replace(/,/g, '')); // Remove commas

        totalAmount += itemTotal;

        var discountPercentage = parseFloat(document.getElementById('discount_percentage_' + i).value) || 0;
        var discountAmount = (discountPercentage / 100) * itemTotal;
        totalDiscount += discountAmount; // Accumulate total discount

        var gstAmount = parseFloat(document.getElementById('gst_amount_' + i).value) || 0;
        totalGST += gstAmount; // Accumulate total GST

        var otherAmount = parseFloat(document.getElementById('other_input').value.replace(/[^\d.]/g, '')) || 0;

        document.getElementById('total_other').value = otherAmount.toFixed(2);

        var gstOption = document.getElementById('gst_option_' + i).value;

        netAmount += (itemTotal - discountAmount) - (gstOption === 'yes' ? gstAmount : 0);
    }

    // Additional discount from the "Extras" section
    var extrasDiscount = parseFloat(document.getElementById('extras_discount').value) || 0;
    totalDiscount += (extrasDiscount / 100) * totalAmount; // Apply discount percentage

    // Calculate total gross amount
    netAmount = totalAmount - totalDiscount + totalGST + otherAmount;
    var totalGross = netAmount + totalGST; // Calculate Total Gross

    // Update the input fields with the calculated values
    document.getElementById('total_amount').value = totalAmount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Format as currency
    document.getElementById('total_discount').value = totalDiscount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Format as currency
    document.getElementById('net_amount').value = netAmount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Format as currency
    document.getElementById('Tgst').value = totalGST.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Format as currency
    document.getElementById('total_other').value = otherAmount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Format as currency
    document.getElementById('total_gross').value = totalGross.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Format as currency
}


document.addEventListener("DOMContentLoaded", function() {
    var addQuotationButton = document.getElementById("addQuotationButton");
    var quotationSection = document.querySelector(".Qinput");

    var quotationCounter = <?php echo $numQuotations; ?>;
    
    function formatNumberInput(input) {
        let value = input.value.replace(/[^\d.]/g, ''); // Remove non-numeric characters except decimal point
        value = parseFloat(value.replace(/,/g, '')); // Remove commas and convert to float
        input.value = value.toLocaleString('en-US', { maximumFractionDigits: 2 }); // Format as number with max 2 decimal places
    }

    var otherInput = document.getElementById("other_input");

    otherInput.addEventListener("input", function() {
        formatNumberInput(this);
        updateCalculationTotals();
    });

    addQuotationButton.addEventListener("click", function() {
        quotationCounter++;
        
        var newQuotation = quotationSection.cloneNode(true);
        
        newQuotation.querySelectorAll("input[type='text']").forEach(function(input) {
            input.value = "";
        });
        
        newQuotation.querySelectorAll("select").forEach(function(select) {
            select.value = "no"; // Reset GST option
        });

        newQuotation.querySelectorAll("input[id^='item_total']").forEach(function(input) {
            input.value = "0.00"; // Reset item total
        });
        
        newQuotation.querySelector("h5").textContent = "Quotation input " + quotationCounter;
        
        newQuotation.querySelectorAll("[id^='quantity_'], [id^='unit_price_'], [id^='gst_option_'], [id^='discount_percentage_']").forEach(function(input) {
            input.id = input.id.replace(/\d+$/, quotationCounter);
            input.name = input.name.replace(/\[\d+\]/g, "[" + (quotationCounter - 1) + "]");
        });

        quotationSection.parentNode.insertBefore(newQuotation, addQuotationButton);
    });
});

</script>
</html>

<style>
.Qinput{
    font-family: verdana;
    font-weight: normal;
    font-size: 22px;
    margin-bottom: 20px;
    color: gray;
}

.Qinput p{
    font-size: 17px;
    color:gray;
    font-weight:bold;
}

.Qinput h5{
    font-family: verdana;
    font-weight: normal;
    font-size: 22px;
    margin: 10px 0px 30px 0px;
}

#gst_amount_$i {
    display: none;
}

.Qinput select{
    height:30px;
    width: 165px;
}

#discount_percentage_$i {
    display: none;
}
</style>
