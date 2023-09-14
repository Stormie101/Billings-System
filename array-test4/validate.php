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

// SQL query to check if the username and password match
$sql = "SELECT * FROM admin WHERE username='$username' AND adminPassword='$adminpassword'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // Login successful
    session_start();
    $_SESSION['username'] = $username;
    header("Location: index-test.php"); // Redirect to the dashboard page after successful login
} else {
    // Login failed
    echo "Invalid username or password. Please try again.";
}

$conn->close();
?>
