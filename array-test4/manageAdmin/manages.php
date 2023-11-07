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
    
    if($userRole !== 'Admin' && $userRole !== 'SuperAdmin'){
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
<div class="secheader">
    <a href="#" onclick="showTable('addAccountTable')">ADD ACCOUNT</a>
    <a href="../index-test.php">HOME</a>
    <a href="#" onclick="showTable('manageRoleTable')">MANAGE ROLE</a>
   </div> 
    <header>
        <img src="kyrol.png" alt="">
        <p style=" font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-weight:bold; letter-spacing:2px;">Billing System 0.7</p>
    </header>
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
                    <td><label class="containersz">
                    <input type="checkbox" id="showPassword" onclick="togglePassword()">
                    <svg class="eye" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                    <svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg>
                    </label></td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                </tr>
                <tr>
                    <td><input type="password" name="confirm_password" id="confirm_password"></td>
                    <td><label class="containersz">
                    <input type="checkbox" id="showPasswords" onclick="togglePasswords()">
                    <svg class="eye" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                    <svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg>
                    </label></td>
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
                if ($row["adminrole"] !== 'SuperAdmin') {
                    echo "<tr>";
                    echo "<td>" . $count . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["adminrole"] . "<br></td>";
                    echo "<td>
                            <a href='edit_client.php?id=" . $row["id"] . "'><i class='fas fa-edit' style='color: darkcyan;'></i></a>
                          </td>";
                    echo "<td>
                    <a class='delete-link' href='". $_SERVER['PHP_SELF'] ."?delete_user=". $row['id'] ."' onclick='return confirmDelete()'><i class='fas fa-trash' style='color: red;'></i></a>
                    </td>";
                    echo "</tr>";
                    $count++;
                }
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
function confirmDelete() {
    return confirm("Are you sure you want to delete this user?");
}
function validateForm() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    // Password format regular expression (minimum 8 characters, at least one uppercase letter, and one symbol)
    var passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

    if (!password.match(passwordRegex)) {
        alert("Password must be at least 8 characters long and contain at least one uppercase letter and one symbol.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match. Please try again.");
        return false;
    }

    return true;
}
function togglePassword() {
    var passwordInput = document.getElementById("password");
    var showPasswordCheckbox = document.getElementById("showPassword");

    if (showPasswordCheckbox.checked) {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}
function togglePasswords() {
    var passwordInputs = document.getElementById("confirm_password");
    var showPasswordCheckboxs = document.getElementById("showPasswords");

    if (showPasswordCheckboxs.checked) {
        passwordInputs.type = "text";
    } else {
        passwordInputs.type = "password";
    }
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
