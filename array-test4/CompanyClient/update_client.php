<?php
session_start();

//mention database
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientId = $_POST['clientId'];
    $att = $_POST['att'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];

    $sql = "UPDATE client 
            SET att = '$att', 
                tel = '$tel', 
                email = '$email' 
            WHERE id = $clientId";

    if ($conn->query($sql) === TRUE) {
        echo "Client information updated successfully.";

        // Redirect back to the edit page
        header("Location: CNC.php?id=$clientId");
        exit();
    } else {
        echo "Error updating client information: " . $conn->error;
    }
}

$conn->close();
?>
