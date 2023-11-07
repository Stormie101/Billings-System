<?php
// Establish a connection to the MySQL database
$servername = "localhost";  // Assuming the database is hosted locally
$username = "root";      // Your MySQL username
$password = "";      // Your MySQL password
$dbname = "kyrol";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get username and password from the form
$username = $_POST['username'];
$adminpassword = $_POST['adminPassword'];

// Apply MD5 to the plain password
$hashedPassword = md5($adminpassword);

// SQL query to check if the username and hashed password match
$sql = "SELECT * FROM admin WHERE username='$username' AND adminPassword='$hashedPassword' AND (adminrole='Admin' OR adminrole='User' OR adminrole='SuperAdmin')";


// SQL query to check if the username and password match
// $sql = "SELECT * FROM admin WHERE username='$username' AND adminPassword='$adminpassword'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if ($row['adminrole'] == 'Admin' || $row['adminrole'] == 'User' || $row['adminrole'] == 'SuperAdmin') {
        // Login successful
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['adminrole'] = $row['adminrole']; // Set admin role in session
        header("Location: index-test.php"); // Redirect to the dashboard page after successful login
    } else {
        // Role is not "Admin" or "User"
        echo "Role are not yet set! contact admin.";
    }
} else {
    // Login failed
    
    header("Location: role-error.html");
}

$conn->close();
?>
