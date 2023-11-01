<?php
session_start();

//mention database
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $companyId = $_POST['companyId'];
    $compName = $_POST['compName'];
    $compStreet = $_POST['compStreet'];
    $compCity = $_POST['compCity'];
    $compState = $_POST['compState'];
    $compPcode = $_POST['compPcode'];
    $compTel = $_POST['compTel'];
    $compFax = $_POST['compFax'];

    $sql = "UPDATE companyinfo 
            SET compName = '$compName', 
                compStreet = '$compStreet', 
                compCity = '$compCity', 
                compState = '$compState', 
                compPcode = '$compPcode', 
                compTel = '$compTel',
                compFax = '$compFax' 
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
