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

$sql = "SELECT id, username, adminrole FROM admin";
$result = $conn->query($sql);

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $sqlRole = "SELECT adminrole FROM admin WHERE username = '$username'";
    $resultRole = $conn->query($sqlRole);
    $row = $resultRole->fetch_assoc();
    $userRole = $row['adminrole'];
    
    if($userRole !== 'Admin'){
        header("Location: access_denied.php"); // Redirect to login page if not an Admin
        exit();
    }
} else {
    header("Location: access_denied.php"); // Redirect to login page if not logged in
    exit();
}

// Handle delete request
if(isset($_GET['delete_user'])){
    $userId = $_GET['delete_user'];

    $sqlDelete = "DELETE FROM admin WHERE id = $userId";
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
    <title>Billing System</title>
    <link rel="stylesheet" href="manage.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
    <header>
        <img src="kyrol.png" alt="">
        <p style=" font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-weight:bold; letter-spacing:2px;">Billing System 0.5</p>
    </header>
   <div class="secheader">
    <a href="#" onclick="showTable('addAccountTable')">ADD ACCOUNT</a>
    <a href="../index-test.php">HOME</a>
    <a href="#" onclick="showTable('manageRoleTable')">MANAGE ROLE</a>
   </div> 

<div id="addAccountTable" class="table-container">
    <form method="post" action="register.php" onsubmit="return validateForm()">
        <div class="containeradd">
            <h2 style="text-align: center; font-size: 20px; color: black; padding: 0px 120px 0px 120px;">REGISTER</h2>
            <table id="tablereg">
                <tr>
                    <td>Username</td>
                </tr>
                <tr>
                    <td><input type="text" name="username" id="username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                </tr>
                <tr>
                    <td><input type="password" name="password" id="password"></td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                </tr>
                <tr>
                    <td><input type="password" name="confirm_password" id="confirm_password"></td>
                </tr>
                <tr>
                    <td><input type="submit" value="CREATE ACCOUNT" id="sButton" style="font-size:15px;"></td>
                </tr>
            </table>
        </div>
    </form>
</div>

<div id="manageRoleTable" class="table-container">
    <div class="containerrole">
        <h2 style="margin-bottom:10px;">MANAGE ROLE</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Edit Role</th>
                    <th>Delete User</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($result->num_rows > 0) {
                    $count = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["adminrole"] . "<br></td>";
                        echo "<td>
                                <a href='edit_client.php?id=" . $row["id"] . "'><i class='fas fa-edit' style='color: darkcyan;'></i></a>
                              </td>";
                        echo "<td>
                                <a class='delete-link' href='". $_SERVER['PHP_SELF'] ."?delete_user=". $row['id'] ."'><i class='fas fa-trash' style='color: red;'></i></a>
                                </td>";
                        echo "</tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No records found</td></tr>";
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
</div>

    <footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>
</body>
<script>
    function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    if (password !== confirmPassword) {
        alert("Passwords do not match. Please try again.");
        return false;
    }

    return true;
    }
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
