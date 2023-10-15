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
    $companyId = $_POST['companyId'];
    $compName = $_POST['compName'];
    $compStreet = $_POST['compStreet'];
    $compCity = $_POST['compCity'];
    $compState = $_POST['compState'];
    $compPcode = $_POST['compPcode'];

    $sql = "UPDATE companyinfo 
            SET compName = '$compName', 
                compStreet = '$compStreet', 
                compCity = '$compCity', 
                compState = '$compState', 
                compPcode = '$compPcode' 
            WHERE id = $companyId";

    if ($conn->query($sql) === TRUE) {
        echo "Company information updated successfully.";

        // Redirect back to the edit page
        header("Location: CNC.php?id=$companyId");
        exit();
    } else {
        echo "Error updating company information: " . $conn->error;
    }
}

$conn->close();
?>
