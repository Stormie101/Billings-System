<?php
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
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
    $att = $_POST["att"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];
    $reference = $_POST["reference"];

    //Quotation detail
    $QNo = $_POST["QNo"];
    $Date = $_POST["Dates"];
    $SaleP = $_POST["SaleP"];
    $Page = $_POST["Pages"];

    //Vendor Address
    $compName = $_POST["compName"];
    $compStreet = $_POST["compStreet"];
    $compCity = $_POST["compCity"];
    $compState = $_POST["compState"];

    $sql = "INSERT INTO client_quotation (att, tel, email, ref, QNo, DATES, SaleP, PAGES, compName, compStreet, compCity, compState) VALUES ('$att', '$tel', '$email', '$reference', '$QNo', '$Date', '$SaleP', '$Page', '$compName', '$compStreet', '$compCity', '$compState' )";
    // ... Construct and execute similar queries for other data ...
    if ($conn->query($sql) === TRUE) {
        // echo "<p style='background-color:#50e991; color:white; text-align:center; font-size:20px; padding:15px;'>Data has entered successfully!</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

$conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="quotation2.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
</head>
<body>
    <ul>
        <li><a href="../index.html"><img src="../kyrol.png" alt=""></a></li>
        <li><a href="../index.html">HOME</a></li>
        <li><a href="news.asp">INVOICE</a></li>
        <li><a href="quotation.php">QUOTATION</a></li>
        <li><a href="about.asp">P.O</a></li>
        <li><a href="about.asp">D.O</a></li>
    </ul>

    <header>
        <img src="../kyrol.png" alt="">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">QUOTATION</p>
    </header>

    <form action="generatepdf.php" method="post">

        <!-- Hidden input fields to hold other data -->
    <input type="hidden" name="att" value="<?php echo $att ?>">
    <input type="hidden" name="tel" value="<?php echo $tel ?>">
    <input type="hidden" name="email" value="<?php echo $email ?>">
    <input type="hidden" name="reference" value="<?php echo $reference ?>">
    <input type="hidden" name="QNo" value="<?php echo $QNo ?>">
    <input type="hidden" name="Date" value="<?php echo $Date ?>">
    <input type="hidden" name="SaleP" value="<?php echo $SaleP ?>">
    <input type="hidden" name="Page" value="<?php echo $Page ?>">
    <input type="hidden" name="compName" value="<?php echo $compName ?>">
    <input type="hidden" name="compStreet" value="<?php echo $compStreet ?>">
    <input type="hidden" name="compCity" value="<?php echo $compCity ?>">
    <input type="hidden" name="compState" value="<?php echo $compState ?>">
    
    <div class="content">
        <div id="innercontent">
            <div class="clientdetail">
            <h5>CLIENT'S DETAIL</h5>
                <table>
                    <tr>
                        <td><p>ATT:</p></td>
                        <td><p><?php echo $att ?></p></td>
                    </tr>
                    <tr>
                        <td><p>TEL:</p></td>
                        <td><p><?php echo $tel ?></p></td>
                    </tr>
                    <tr>
                        <td><p>EMAIL:</p></td>
                        <td><p><?php echo $email ?></p></td>
                    </tr>
                    <tr>
                        <td><p>REF:</p></td>
                        <td><p><?php echo $reference ?></p></td>
                    </tr>
                </table>
            </div>
            <div class="clientdetail">
                <h5>QUOTATION DETAIL</h5>
                <table>
                    <tr>
                        <td><p>Quotation No:</p></td>
                        <td><p><?php echo $QNo ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Date:</p></td>
                        <td><p><?php echo $Date ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Sales Per:</p></td>
                        <td><p><?php echo $SaleP ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Pages:</p></td>
                        <td><p><?php echo $Page ?></p></td>
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
                        <td><p>State:</p></td>
                        <td><p><?php echo $compState ?></p></td>
                    </tr>
                </table>
            </div>
        <div class="Qinput">
        <?php
for ($i = 1; $i <= $numQuotations; $i++) {
    echo "<hr>";
    echo "<h5><b>QUOTATION INPUT $i</b></h5>";
    echo "<table>";
    echo "<tr>";
    echo "<td><p style='display:none;'>No</p></td>";
    echo "<td><input type='hidden' name='nom[]' value='$i' required> </input></td>";
    echo "</tr>";
    echo "<td><p>Name</p></td>";
    echo "<td><input type='text' name='title[]' required> </input></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><p>Description</p></td>";
    echo "<td><textarea name='desc[]' cols='30' rows='5' required> </textarea></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><p>Quantity</p></td>";
    echo "<td><input type='text' name='quantity[]' id='quantity_$i' value='" . (isset($_POST['quantity'][$i - 1]) ? $_POST['quantity'][$i - 1] : "") . "' oninput='calculateTotal($i)' oninput='calculateTotal($i); updateCalculationTotals()' required></input></td>";    
    echo "</tr>";
    echo "<tr>";
    echo "<td><p>U.Price</p></td>";
    echo "<td><input type='text' name='unit_price[]' id='unit_price_$i' oninput='calculateTotal($i)' oninput='calculateTotal($i); updateCalculationTotals()' required></input></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><p>GST</p></td>";
    echo "<td>
        <select name='gst_option[]' id='gst_option_$i' onchange='calculateTotal($i)' oninput='calculateTotal($i); updateCalculationTotals()'>
            <option value='no'>No</option>
            <option value='yes'>Yes</option>
        </select>
        <td><input type='text' name='gst_amount[]' id='gst_amount_$i' readonly></input></td>

         </td>";
    echo "<tr>";
    echo "<td><p style='display:none;'>Discount (%)</p></td>";
    echo "<td><input type='hidden' name='discount_percentage[]' id='discount_percentage_$i' oninput='calculateTotal($i)' oninput='calculateTotal($i); updateCalculationTotals()'></input></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><p>Quotation $i Total </p></td>";
    echo "<td><input type='text' name='item_total[]' id='item_total_$i' readonly ></input></td>";
    echo "</tr>";
    echo "</table>";
}
?>
    <hr>
    <div id="extras"style="margin:15px; padding:10px;">
        <!-- new input -->
        <label style="padding-bottom:10px">Discount</label><br>
        <input type="text" id="extras_discount" oninput="updateCalculationTotals()">
    </div>
</div>
    <div class="calculate">
    <hr>
    <h5>Calculation</h5>
        <p>Total Amount:</p>
        <input type="text" id="total_amount" name="total_amount" value='0.00' readonly>
        <p>Total Discount:</p>
        <input type="text" id="total_discount" name="total_discount" value='0.00' readonly>

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
function calculateTotal(index) {
    var quantity = parseFloat(document.getElementById('quantity_' + index).value);
    var unitPrice = parseFloat(document.getElementById('unit_price_' + index).value);
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
    document.getElementById('item_total_' + index).value = total.toFixed(2);

    // Recalculate all the totals
    updateCalculationTotals();
}

function updateCalculationTotals() {
    var totalAmount = 0;
    var netAmount = 0;
    var totalGross = 0;
    var totalDiscount = 0;
    var totalGST = 0;

    // Loop through the individual items to accumulate totals
    for (var i = 1; i <= <?php echo $numQuotations; ?>; i++) {
        var itemTotal = parseFloat(document.getElementById('item_total_' + i).value);
        totalAmount += itemTotal;

        var discountPercentage = parseFloat(document.getElementById('discount_percentage_' + i).value) || 0;
        var discountAmount = (discountPercentage / 100) * itemTotal;
        totalDiscount += discountAmount; // Accumulate total discount

        var gstAmount = parseFloat(document.getElementById('gst_amount_' + i).value) || 0;
        totalGST += gstAmount; // Accumulate total GST

        var gstOption = document.getElementById('gst_option_' + i).value;

        netAmount += (itemTotal - discountAmount) - (gstOption === 'yes' ? gstAmount : 0);
    }

    // Additional discount from the "Extras" section
    var extrasDiscount = parseFloat(document.getElementById('extras_discount').value) || 0;
    totalDiscount += extrasDiscount;

    // Calculate total gross amount
    netAmount = totalAmount - totalDiscount + totalGST;
    totalGross = netAmount + totalGST;

    // Update the input fields with the calculated values
    document.getElementById('total_amount').value = totalAmount.toFixed(2);
    document.getElementById('total_discount').value = totalDiscount.toFixed(2); // Display total discount as actual amount
    document.getElementById('net_amount').value = netAmount.toFixed(2);
    document.getElementById('Tgst').value = totalGST.toFixed(2); // Set total GST value
    document.getElementById('total_gross').value = totalGross.toFixed(2);
}

document.addEventListener("DOMContentLoaded", function() {
    var addQuotationButton = document.getElementById("addQuotationButton");
    var quotationSection = document.querySelector(".Qinput");

    var quotationCounter = <?php echo $numQuotations; ?>;
    
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
