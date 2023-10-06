<?php
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
} else {
    header("Location: ../login.php"); // Redirect to login page if not logged in
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

$sql = "SELECT * FROM client_quotation ORDER BY id DESC";
$result = $conn->query($sql);

 $sqls = "SELECT * FROM client_invoice ORDER BY id DESC";
 $results = $conn->query($sqls);

 $sqlsz = "SELECT * FROM client_purchaseorder ORDER BY id DESC";
 $resultsz = $conn->query($sqlsz);

 $sqlszs = "SELECT * FROM client_delivery ORDER BY id DESC";
 $resultszs = $conn->query($sqlszs);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company / Client</title>
    <link rel="stylesheet" href="history.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
    <ul>
        <li><a href="../index-test.php"><img src="kyrol.png" alt=""></a></li>
        <li><a href="../index-test.php">HOME</a></li>
        <li><a href="../invoice-task/invoice.php">INVOICE</a></li>
        <li><a href="../quotation-task/quotation.php">QUOTATION</a></li>
        <li><a href="../PurchaseOrder-task/PurchaseOR.php">P.O</a></li>
        <li><a href="../DeliveryOrder-task/DeliveryOr.php">D.O</a></li>
    </ul>
    <header>
        <img src="kyrol.png">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">HISTORY</p>
    </header>

    <div class="button-container">
    <button id="showQuotationTable">Quotation</button>
    <button id="showPurchaseTable">Purchase</button>
    <button id="showDeliveryTable">Delivery</button>
    <button id="showInvoiceTable">Invoice</button>
    </div>

    <div id="quotationTable">
    <form method="post" id="searchForm">
        <input type="text" class="searchbar" name="search" placeholder="Search For Quotation's ID">
        <input type="submit" class="searchbutton" name="submit" value="Search">
    </form>
    <ul class="search-results" style="background-color:white; margin-top:15px;"></ul>
    <h1 style="padding:15px; margin-left:10px;">Quotation</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>QO NO.</th>
                <th>ATT</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Reference</th>
                <th>Submit By</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($result->num_rows > 0) {
                $count = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $count . "</td>";
                    echo "<td>" . $row["QNo"] . "</td>";
                    echo "<td>" . $row["ATT"] . "</td>";
                    echo "<td>" . $row["TEL"] . "</td>";
                    echo "<td>" . $row["EMAIL"] . "</td>";
                    echo "<td>" . $row["REF"] . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td><a href='viewmore-quotation.php?id=" . $row["id"] . "'><i class='fa fa-eye' style='color:gray;'></i></a></td>";
                    echo "</tr>";
                    $count++;
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
    
    <div id="invoiceTable" class="hidden">
    <form method="post" id="searchForm-invoice" class="searchform1">
        <input type="text" class="searchbar-invoice" id="searchbar1" name="search_invoice" placeholder="Search For Invoice's ID">
        <input type="submit" class="searchbutton" name="submit_invoice" value="Search">
    </form>
    <ul class="search-results-invoice" style="background-color:white; margin-top:15px;"></ul>
    <h1 style="padding:15px; margin-left:10px;">Invoice</h1>
    <table>
    <thead>
            <tr>
                <th>No.</th>
                <th>Invoice No.</th>
                <th>ID</th>
                <th>ATT</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Reference</th>
                <th>SPerson</th>
                <th>Submit By</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($results->num_rows > 0) {
                $counts = 1;
                while($rowz = $results->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $counts . "</td>";
                    echo "<td>" . $rowz["INo"] . "</td>";
                    echo "<td>" . $rowz["id"] . "</td>";
                    echo "<td>" . $rowz["ATT"] . "</td>";
                    echo "<td>" . $rowz["TEL"] . "</td>";
                    echo "<td>" . $rowz["EMAIL"] . "</td>";
                    echo "<td>" . $rowz["REF"] . "</td>";
                    echo "<td>" . $rowz["SaleP"] . "</td>";
                    echo "<td>" . $rowz["username"] . "</td>";
                    echo "<td><a href='viewmore-invoice.php?id=" . $rowz["id"] . "'><i class='fa fa-eye' style='color:gray;'></i></a></td>";
                    echo "</tr>";
                    $counts++;
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
    
    <div id="purchaseTable" class="hidden">
    <form method="post" id="searchForm-purchaseorder" class="searchform1">
        <input type="text" class="searchbar-purchaseorder" id="searchbar1" name="search" placeholder="Search For Purchase Order's ID">
        <input type="submit" class="searchbutton" name="submit" value="Search">
    </form>
    <ul class="search-results-purchaseorder" style="background-color:white; margin-top:15px;"></ul>
    <h1 style="padding:15px; margin-left:10px;">Purchase Order</h1>
    <table>
    <thead>
            <tr>
                <th>No.</th>
                <th>Purchase No.</th>
                <th>Dates</th>
                <th>Company Name</th>
                <th>Street</th>
                <th>City</th>
                <th>State</th>
                <th>Requistioner</th>
                <th>Ship Via</th>
                <th>FOB</th>
                <th>Ship Term</th>
                <th>Ship Date</th>
                <th>Submit By</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($resultsz->num_rows > 0) {
                $countsz = 1;
                while($rowsz = $resultsz->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $countsz . "</td>";
                    echo "<td>" . $rowsz["PO_Number"] . "</td>";
                    echo "<td>" . $rowsz["Dates"] . "</td>";
                    echo "<td>" . $rowsz["compName"] . "</td>";
                    echo "<td>" . $rowsz["compStreet"] . "</td>";
                    echo "<td>" . $rowsz["compCity"] . "</td>";
                    echo "<td>" . $rowsz["compState"] . "</td>";
                    echo "<td>" . $rowsz["Requist"] . "</td>";
                    echo "<td>" . $rowsz["ShipVia"] . "</td>";
                    echo "<td>" . $rowsz["FOB"] . "</td>";
                    echo "<td>" . $rowsz["ShipTerm"] . "</td>";
                    echo "<td>" . $rowsz["ShipDate"] . "</td>";
                    echo "<td>" . $rowsz["username"] . "</td>";
                    echo "<td><a href='viewmore-PO.php?id=" . $rowsz["id"] . "'><i class='fa fa-eye' style='color:gray;'></i></a></td>";
                    echo "</tr>";
                    $countsz++;
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
    
    <div  id="deliveryTable" class="hidden">
    <form method="post" id="searchForm-deliveryorder" class="searchform1">>
        <input type="text" class="searchbar-deliveryorder" id="searchbar1" class="searchbar" name="search" placeholder="Search For Delivery Order">
        <input type="submit" class="searchbutton" name="submit">
    </form>
    <ul class="search-results-deliveryorder" style="background-color:white; margin-top:15px;"></ul>
    <h1 style="padding:15px; margin-left:10px;">Delivery Order</h1>
    <table>
    <thead>
            <tr>
                <th>No.</th>
                <th>Delivery No.</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Term</th>
                <th>Sale Person</th>
                <th>Reference</th>
                <th>Submit By</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($resultszs->num_rows > 0) {
                $countszs = 1;
                while($rowszs = $resultszs->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $countszs . "</td>";
                    echo "<td>" . $rowszs["DOn"] . "</td>";
                    echo "<td>" . $rowszs["att"] . "</td>";
                    echo "<td>" . $rowszs["tel"] . "</td>";
                    echo "<td>" . $rowszs["email"] . "</td>";
                    echo "<td>" . $rowszs["Terms"] . "</td>";
                    echo "<td>" . $rowszs["SaleP"] . "</td>";
                    echo "<td>" . $rowszs["ref"] . "</td>";
                    echo "<td>" . $rowszs["username"] . "</td>";
                    echo "<td><a href='viewmore-DO.php?id=" . $rowszs["id"] . "'><i class='fa fa-eye' style='color:gray;'></i></a></td>";

                    echo "</tr>";
                    $countszs++;
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>

    <br>
    <footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const showInvoiceButton = document.getElementById('showInvoiceTable');
    const showQuotationButton = document.getElementById('showQuotationTable');
    const showPurchaseButton = document.getElementById('showPurchaseTable');
    const showDeliveryButton = document.getElementById('showDeliveryTable');

    const invoiceTable = document.getElementById('invoiceTable');
    const quotationTable = document.getElementById('quotationTable');
    const purchaseTable = document.getElementById('purchaseTable');
    const deliveryTable = document.getElementById('deliveryTable');

    showInvoiceButton.addEventListener('click', function(e) {
        e.preventDefault();
        invoiceTable.classList.remove('hidden');
        quotationTable.classList.add('hidden');
        purchaseTable.classList.add('hidden');
        deliveryTable.classList.add('hidden');
    });

    showQuotationButton.addEventListener('click', function(e) {
        e.preventDefault();
        quotationTable.classList.remove('hidden');
        invoiceTable.classList.add('hidden');
        purchaseTable.classList.add('hidden');
        deliveryTable.classList.add('hidden');
    });

    showPurchaseButton.addEventListener('click', function(e) {
        e.preventDefault();
        purchaseTable.classList.remove('hidden');
        invoiceTable.classList.add('hidden');
        quotationTable.classList.add('hidden');
        deliveryTable.classList.add('hidden');
    });

    showDeliveryButton.addEventListener('click', function(e) {
        e.preventDefault();
        deliveryTable.classList.remove('hidden');
        invoiceTable.classList.add('hidden');
        quotationTable.classList.add('hidden');
        purchaseTable.classList.add('hidden');
    });
});
//Quotation's Search
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const resultsContainer = document.querySelector('.search-results');

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const searchTerm = document.querySelector('.searchbar').value;

        // Make an AJAX request to retrieve data from the server
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'search.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                displayResults(data);
            }
        };

        xhr.send('searchTerm=' + searchTerm);
    });

    function displayResults(data) {
        resultsContainer.innerHTML = '';

        const table = document.createElement('table');
        table.innerHTML = `
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ATT</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Reference</th>
                    <th>Submit By</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;

        for (const result of data) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${result.id}</td>
                <td>${result.ATT}</td>
                <td>${result.TEL}</td>
                <td>${result.EMAIL}</td>
                <td>${result.REF}</td>
                <td>${result.username}</td>
                <td><a href='viewmore-quotation.php?id=${result.id}'><i class='fa fa-eye' style='color:gray;'></i></a></td>
            `;
            table.querySelector('tbody').appendChild(row);
        }

        resultsContainer.appendChild(table);
    }
});

//Invoice's Search
document.addEventListener('DOMContentLoaded', function() {
    const searchFormInvoice = document.getElementById('searchForm-invoice'); // Changed ID to match the Invoice form
    const resultsContainerInvoice = document.querySelector('.search-results-invoice'); // Changed class to match the Invoice results

    searchFormInvoice.addEventListener('submit', function(e) { // Changed to use the Invoice search form
        e.preventDefault();

        const searchTerm = document.querySelector('.searchbar-invoice').value; // Changed to use the Invoice search bar

        // Make an AJAX request to retrieve data from the server
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'search-invoice.php', true); // You might need to change 'search.php' to the actual URL that handles the search
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                displayResults(data);
            }
        };

        xhr.send('searchTerm=' + searchTerm);
    });

    function displayResults(data) {
        resultsContainerInvoice.innerHTML = ''; // Changed to use the Invoice results container

        const table = document.createElement('table');
        table.innerHTML = `
            <thead>
                <tr>
                    <th>Invoice No.</th>
                    <th>ATT</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Reference</th>
                    <th>Sale Person</th>
                    <th>Submit By</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;

        for (const result of data) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${result.INo}</td>
                <td>${result.ATT}</td>
                <td>${result.TEL}</td>
                <td>${result.EMAIL}</td>
                <td>${result.SaleP}</td>
                <td>${result.REF}</td>
                <td>${result.username}</td>
                <td><a href='viewmore-invoice.php?id=${result.id}'><i class='fa fa-eye' style='color:gray;'></i></a></td>
            `;
            table.querySelector('tbody').appendChild(row);
        }

        resultsContainerInvoice.appendChild(table); // Changed to use the Invoice results container
    }
});

//PO
document.addEventListener('DOMContentLoaded', function() {
    const searchFormPurchaseOrder = document.getElementById('searchForm-purchaseorder');
    const resultsContainerPurchaseOrder = document.querySelector('.search-results-purchaseorder');

    searchFormPurchaseOrder.addEventListener('submit', function(e) {
        e.preventDefault();

        const searchTerm = document.querySelector('.searchbar-purchaseorder').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'search-PO.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                displayResults(data);
            }
        };

        xhr.send('searchTerm=' + searchTerm);
    });

    function displayResults(data) {
        resultsContainerPurchaseOrder.innerHTML = '';

        const table = document.createElement('table');
        table.innerHTML = `
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Purchase No.</th>
                    <th>Company Name</th>
                    <th>Dates</th>
                    <th>Submit By</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;

        for (const result of data) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${result.id}</td>
                <td>${result.PO_Number}</td>
                <td>${result.compName}</td>
                <td>${result.Dates}</td>
                <td>${result.username}</td>
                <td><a href='viewmore-PO.php?id=${result.id}'><i class='fa fa-eye' style='color:gray;'></i></a></td>
            `;
            table.querySelector('tbody').appendChild(row);
        }

        resultsContainerPurchaseOrder.appendChild(table);
    }
});

//DO
document.addEventListener('DOMContentLoaded', function() {
    const searchFormDeliveryOrder = document.getElementById('searchForm-deliveryorder'); // Change to match the ID of the form for Delivery Orders
    const resultsContainerDeliveryOrder = document.querySelector('.search-results-deliveryorder'); // Change to match the class of the results container for Delivery Orders

    searchFormDeliveryOrder.addEventListener('submit', function(e) {
        e.preventDefault();

        const searchTerm = document.querySelector('.searchbar-deliveryorder').value; // Change to match the class of the search bar for Delivery Orders

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'search-DO.php', true); // Change to the actual URL that handles the search for Delivery Orders
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                displayResults(data);
            }
        };

        xhr.send('searchTerm=' + searchTerm);
    });

    function displayResults(data) {
        resultsContainerDeliveryOrder.innerHTML = '';

        const table = document.createElement('table');
        table.innerHTML = `
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Delivery No.</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Term</th>
                    <th>Sale Person</th>
                    <th>Reference</th>
                    <th>Submit By</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;

        for (const result of data) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${result.id}</td>
                <td>${result.DOn}</td>
                <td>${result.att}</td>
                <td>${result.tel}</td>
                <td>${result.email}</td>
                <td>${result.Terms}</td>
                <td>${result.SaleP}</td>
                <td>${result.ref}</td>
                <td>${result.username}</td>
                <td><a href='viewmore-DO.php?id=${result.id}'><i class='fa fa-eye' style='color:gray;'></i></a></td>

            `;
            table.querySelector('tbody').appendChild(row);
        }

        resultsContainerDeliveryOrder.appendChild(table);
    }
});
</script>
</html>
