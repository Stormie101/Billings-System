<?php
session_start();

//mention database
include 'db.php';


if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
        // 2. Retrieve User Role
        $sql = "SELECT adminrole FROM admin WHERE username = '$username'";
        $result = $conn->query($sql);
    
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $role = $row['adminrole'];
        }
} else {
    header("Location: ../login.php"); // Redirect to login page if not logged in
    exit();
}

if ($role === "Admin" || $role === "SuperAdmin") {
    $sql = "SELECT * FROM client_quotation ORDER BY id DESC";
    $result = $conn->query($sql);

    $sqls = "SELECT * FROM client_invoice ORDER BY id DESC";
    $results = $conn->query($sqls);

    $sqlsz = "SELECT * FROM client_purchaseorder ORDER BY id DESC";
    $resultsz = $conn->query($sqlsz);

    $sqlszs = "SELECT * FROM client_delivery ORDER BY id DESC";
    $resultszs = $conn->query($sqlszs);
} else {
    // For non-Admin users, retrieve only their own data
    $sql = "SELECT * FROM client_quotation WHERE username='$username' ORDER BY id DESC";
    $result = $conn->query($sql);

    $sqls = "SELECT * FROM client_invoice WHERE username='$username' ORDER BY id DESC";
    $results = $conn->query($sqls);

    $sqlsz = "SELECT * FROM client_purchaseorder WHERE username='$username' ORDER BY id DESC";
    $resultsz = $conn->query($sqlsz);

    $sqlszs = "SELECT * FROM client_delivery WHERE username='$username' ORDER BY id DESC";
    $resultszs = $conn->query($sqlszs);
}

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
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
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
        <p style="font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-weight:bold;">HISTORY</p>
    </header>

    <div class="button-container">
    <button id="showQuotationTable">Quotation</button>
    <button id="showPurchaseTable">Purchase</button>
    <button id="showDeliveryTable">Delivery</button>
    <button id="showInvoiceTable">Invoice</button>
    </div>

    <div id="quotationTable">
    <form method="post" id="searchForm">
        <input type="text" class="searchbar" id="searchbar1"  name="search" placeholder="Search For Company's Name">
        <input type="submit" class="searchbutton" name="submit" value="Search">
    </form>
    <ul class="search-results" style="background-color:white; margin-top:15px;"></ul>
    <h1 style="padding:15px; margin-left:10px;">Quotation</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>QO NO.</th>
                <th>Reference</th>
                <th>Company Name</th>
                <th>Attention To</th>
                <th>Submit By</th>
                <th>Date</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($result->num_rows > 0) {
                $count = 1;
                while($row = $result->fetch_assoc()) {
                    $date = $row["DATES"];
                    $year = date("Y", strtotime($date)); // Extract the year from the "Dates" data            
                    echo "<tr>";
                    echo "<td>" . $count . "</td>";
                    echo "<td>KSL/" . $year . "/Q/" . $row["QNo"] . "</td>";
                    echo "<td>" . $row["REF"] . "</td>";
                    echo "<td>" . $row["compName"] . "</td>";
                    echo "<td>" . $row["ATT"] . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["DATES"] . "</td>";
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
        <input type="text" class="searchbar-invoice" id="searchbar1" name="search_invoice" placeholder="Search For Company's Name">
        <input type="submit" class="searchbutton" name="submit_invoice" value="Search">
    </form>
    <ul class="search-results-invoice" style="background-color:white; margin-top:15px;"></ul>
    <h1 style="padding:15px; margin-left:10px;">Invoice</h1>
    <table>
    <thead>
            <tr>
                <th>No.</th>
                <th>Invoice No.</th>
                <th>Reference</th>
                <th>Company Name</th>
                <th>Attention To</th>
                <th>Submit By</th>
                <th>Date</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($results->num_rows > 0) {
                $counts = 1;
                while($rowz = $results->fetch_assoc()) {
                    $date = $rowz["Dates"];
                    $years = date("Y", strtotime($date)); // Extract the year from the "Dates" data     
                    echo "<tr>";
                    echo "<td>" . $counts . "</td>";
                    echo "<td>KSL/" . $year . "/I/" . $rowz["INo"] . "</td>";
                    echo "<td>" . $rowz["REF"] . "</td>";
                    echo "<td>" . $rowz["compName"] . "</td>";
                    echo "<td>" . $rowz["ATT"] . "</td>";
                    echo "<td>" . $rowz["username"] . "</td>";
                    echo "<td>" . $rowz["Dates"] . "</td>";
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
        <input type="text" class="searchbar-purchaseorder" id="searchbar1" name="search" placeholder="Search For Company's Name">
        <input type="submit" class="searchbutton" name="submit" value="Search">
    </form>
    <ul class="search-results-purchaseorder" style="background-color:white; margin-top:15px;"></ul>
    <h1 style="padding:15px; margin-left:10px;">Purchase Order</h1>
    <table>
    <thead>
            <tr>
                <th>No.</th>
                <th>Purchase No.</th>
                <th>Company Name</th>
                <th>Submit By</th>
                <th>Date</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($resultsz->num_rows > 0) {
                $countsz = 1;
                while($rowsz = $resultsz->fetch_assoc()) {
                    $date = $rowsz["Dates"];
                    $year = date("Y", strtotime($date)); // Extract the year from the "Dates" data  
                    echo "<tr>";
                    echo "<td>" . $countsz . "</td>";
                    echo "<td>KSL/" . $year . "/PO/" . $rowsz["PO_Number"] . "</td>";
                    echo "<td>" . $rowsz["compName"] . "</td>";
                    echo "<td>" . $rowsz["username"] . "</td>";
                    echo "<td>" . $rowsz["Dates"] . "</td>";
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
    <form method="post" id="searchForm-deliveryorder" class="searchform1">
        <input type="text" class="searchbar-deliveryorder" id="searchbar1" class="searchbar" name="search" placeholder="Search For Company's Name">
        <input type="submit" class="searchbutton" name="submit">
    </form>
    <ul class="search-results-deliveryorder" style="background-color:white; margin-top:15px;"></ul>
    <h1 style="padding:15px; margin-left:10px;">Delivery Order</h1>
    <table>
    <thead>
            <tr>
                <th>No.</th>
                <th>Delivery No.</th>
                <th>Company Name</th>
                <th>Submit By</th>
                <th>Date</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($resultszs->num_rows > 0) {
                $countszs = 1;
                while($rowszs = $resultszs->fetch_assoc()) {
                    $date = $rowszs["Dates"];
                    $year = date("Y", strtotime($date)); // Extract the year from the "Dates" data  
                    echo "<tr>";
                    echo "<td>" . $countszs . "</td>";
                    echo "<td>KSL/" . $year . "/DO/" . $rowszs["DOn"] . "</td>";
                    echo "<td>" . $rowszs["compName"] . "</td>";
                    echo "<td>" . $rowszs["username"] . "</td>";
                    echo "<td>" . $rowszs["Dates"] . "</td>";
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
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
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
                    <th>QO NO.</th>
                    <th>Reference</th>
                    <th>Company Name</th>
                    <th>Attention To</th>
                    <th>Submit By</th>
                    <th>Date</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;

        for (const result of data) {
            const row = document.createElement('tr');
            const date = new Date(result.DATES);
            const year = date.getFullYear(); // Extract the year
            row.innerHTML = `
                <td>${result.id}</td>
                <td>KSL/${year}/Q/${result.QNo}</td>
                <td>${result.REF}</td>
                <td>${result.compName}</td>
                <td>${result.ATT}</td>
                <td>${result.username}</td>
                <td>${result.DATES}</td>
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
                    <th>Reference</th>
                    <th>Company Name</th>
                    <th>Attention To</th>
                    <th>Submit By</th>
                    <th>Dates</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;

        for (const result of data) {
            const row = document.createElement('tr');
            const date = new Date(result.Dates);
            const year = date.getFullYear(); // Extract the year
            
            row.innerHTML = `
                <td>KSL/${year}/I/${result.INo}</td>
                <td>${result.REF}</td>
                <td>${result.compName}</td>
                <td>${result.ATT}</td>
                <td>${result.username}</td>
                <td>${result.Dates}</td>
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
                    <th>Submit By</th>
                    <th>Dates</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;

        for (const result of data) {
            const row = document.createElement('tr');
            const date = new Date(result.Dates);
            const year = date.getFullYear(); // Extract the year
            row.innerHTML = `
                <td>${result.id}</td>
                <td>KSL/${year}/PO/${result.PO_Number}</td>
                <td>${result.compName}</td>
                <td>${result.username}</td>
                <td>${result.Dates}</td>
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
                    <th>Company Name</th>
                    <th>Submit By</th>
                    <th>Date</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;

        for (const result of data) {
            const row = document.createElement('tr');
            const date = new Date(result.Dates);
            const year = date.getFullYear(); // Extract the year
            row.innerHTML = `
                <td>${result.id}</td>
                <td>KSL/${year}/DO/${result.DOn}</td>
                <td>${result.compName}</td>
                <td>${result.username}</td>
                <td>${result.Dates}</td>
                <td><a href='viewmore-DO.php?id=${result.id}'><i class='fa fa-eye' style='color:gray;'></i></a></td>

            `;
            table.querySelector('tbody').appendChild(row);
        }

        resultsContainerDeliveryOrder.appendChild(table);
    }
});
</script>
</html>
