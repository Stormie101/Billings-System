<?php
session_start();

//mention database
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientId = $_POST['clientId'];
    $username = $_POST['username'];
    $adminrole = $_POST['adminrole'];

    $sql = "UPDATE admin 
            SET username = '$username', 
                adminrole = '$adminrole' 
            WHERE id = $clientId";

    if ($conn->query($sql) === TRUE) {
        echo "Company information updated successfully.";

        // Redirect back to the edit page
        header("Location: manages.php?id=$clientId");
        exit();
    } else {
        echo "Error updating company information: " . $conn->error;
    }
}

$conn->close();
?>
