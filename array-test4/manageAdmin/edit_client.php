<?php
session_start();

// Check if the user is logged in; you can reuse your existing authentication logic here

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

// Check if 'id' parameter exists in the URL
if (isset($_GET['id'])) {
    $clientId = $_GET['id'];

    // Fetch company details based on the 'id'
    $sql = "SELECT * FROM admin WHERE id = $clientId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $clientData = $result->fetch_assoc();
    } else {
        echo "Company not found.";
        // Handle the case when the company is not found
        exit();
    }
} else {
    echo "Invalid request.";
    // Handle the case when 'id' is not provided in the URL
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company</title>
    <link rel="stylesheet" href="edit.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
    <div class="secheader">
    <a href="../index-test.php">HOME</a>
    <a href="manages.php">MANAGE</a>
   </div> 
    <header>
        <img src="kyrol.png" alt="">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">Edit Role</p>
    </header>
    <!-- Create an edit form with fields pre-filled with $companyData -->
    <form action="update_user.php" method="POST">
        <input type="hidden" name="clientId" value="<?php echo $clientId; ?>">

        <label for="compName">Username:</label>
        <input type="text" name="username" value="<?php echo $clientData['username']; ?>" readonly><br>

        <label for="compStreet">Role:</label>
        <select id="adminrole" name="adminrole" required>
                            <option value="Unauthorized">Unauthorized</option>
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
        </select>
        <!-- <input type="text" name="adminrole" value="<?php echo $clientData['adminrole']; ?>"><br> -->

        <input type="submit" value="Update" id="update-button" onclick='return confirmEdit()'>
        
    </form>
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
    function confirmEdit() {
    return confirm("Are you sure you wanted to make changes?");
}
</script>
</html>

<style>
    body {
    font-family: Arial, sans-serif;
    text-align: center;
}
</style>