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

$sql = "SELECT * FROM companyinfo";
$result = $conn->query($sql);

$sqls = "SELECT * FROM client";
$results = $conn->query($sqls);

// Handle delete request
if(isset($_GET['delete_company'])){
    $companyId = $_GET['delete_company'];

    $sqlDelete = "DELETE FROM companyinfo WHERE id = $companyId";
    if ($conn->query($sqlDelete) === TRUE) {
        header("Location: $_SERVER[PHP_SELF]");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

if(isset($_GET['delete_client'])){
    $clientId = $_GET['delete_client'];

    $sqlDelete = "DELETE FROM client WHERE id = $clientId";
    if ($conn->query($sqlDelete) === TRUE) {
        header("Location: $_SERVER[PHP_SELF]");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company / Client</title>
    <link rel="stylesheet" href="CNC.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
    <ul style="font-family: 'Poppins';">
        <li><a href="../index-test.php"><img src="../kyrol.png" alt=""></a></li>
        <li><a href="../index-test.php">HOME</a></li>
        <li><a href="../invoice-task/invoice.php">INVOICE</a></li>
        <li><a href="../quotation-task/quotation.php">QUOTATION</a></li>
        <li><a href="../purchaseorder-task/purchaseOR.php">P.O</a></li>
        <li><a href="../deliveryorder-task/deliveryOR.php">D.O</a></li>
    </ul>
    <header>
        <img src="kyrol.png">
        <p style=" font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-weight:bold;">COMPANY / CLIENT</p>
    </header>
    <div class="secheader" style="font-family: 'Poppins';">
    <a href="#" onclick="showTable('addAccountTable')">COMPANY</a>
    <a href="#" onclick="showTable('manageRoleTable')">CLIENT</a>
   </div> 

   <div id="addAccountTable" class="table-container">
    <h1 style="padding:15px; margin-left:10px;">Company</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Company Name</th>
                <th>Street</th>
                <th>City</th>
                <th>State</th>
                <th>Postcode</th>
                <th>Tel</th>
                <th>Fax</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($result->num_rows > 0) {
                $count = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $count . "</td>";
                    echo "<td>" . $row["compName"] . "</td>";
                    echo "<td>" . $row["compStreet"] . "</td>";
                    echo "<td>" . $row["compCity"] . "</td>";
                    echo "<td>" . $row["compState"] . "</td>";
                    echo "<td>" . $row["compPcode"] . "</td>";
                    echo "<td>" . $row["compTel"] . "</td>";
                    echo "<td>" . $row["compFax"] . "</td>";
                    echo "<td><a href='edit_company.php?id=" . $row["id"] . "'><i class='fas fa-edit' style='color:darkcyan;'></i>                    </a></td>";
                    echo "<td><a class='delete-link' href='". $_SERVER['PHP_SELF'] ."?delete_company=". $row['id'] ."'><i class='fas fa-trash' style='color:red;'></i>                    </td>";
                    echo "</tr>";
                    $count++;
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    

    <div id="buttonholder">
        <a href="add_company.php">Add Company</a>
    </div>
    </div>
    
    <div id="manageRoleTable" class="table-container">
    <h1 style="padding:15px; margin-left:10px;">Client</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Tel</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($results->num_rows > 0) {
                $counts = 1;
                while($rowz = $results->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $counts . "</td>";
                    echo "<td>" . $rowz["att"] . "</td>";
                    echo "<td>" . $rowz["tel"] . "</td>";
                    echo "<td>" . $rowz["email"] . "</td>";
                    echo "<td><a href='edit_client.php?id=" . $rowz["id"] . "'><i class='fas fa-edit' style='color:darkcyan;'></i></a></td>";
                    echo "<td><a class='delete-link' href='". $_SERVER['PHP_SELF'] ."?delete_client=". $rowz['id'] ."'><i class='fas fa-trash' style='color:red;'></i></a></td>";
                    echo "</tr>";
                    $counts++;
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div id="buttonholder">
        <a href="add_client.php">Add Client</a>
    </div>
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
    const deleteLinks = document.querySelectorAll('.delete-link');

    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const confirmed = confirm('Are you sure you want to delete?');

            if(confirmed) {
                window.location.href = this.href;
            }
        });
    });
});

function showTable(tableId) {
        var tables = document.querySelectorAll('.table-container');
        tables.forEach(function(table) {
            table.style.display = 'none';
        });

        var selectedTable = document.getElementById(tableId);
        selectedTable.style.display = 'block';

        return false; // Prevent the default link behavior
    }

    window.onload = function() {
        showTable('manageRoleTable'); // Show the "Add Account" table by default
    };
</script>
</html>
