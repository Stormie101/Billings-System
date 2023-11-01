<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kyrol";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];

    // Add validation for username and password (e.g., length requirements)

        $hashedPassword = md5($newPassword);

        $sql = "INSERT INTO admin(username, adminPassword) VALUES ('$newUsername', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            header("Location: manages.php"); // Redirect to the previous page
            exit(); // Make sure to exit after redirect
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        if ($conn->query($sql) === TRUE) {
            echo "New admin user created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

}

$conn->close();
?>
