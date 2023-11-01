<?php
//mention database
include 'db.php';

// Get the att value from the POST request
$att = $_POST['att'];

// Fetch tel and email based on att
$sql = "SELECT tel, email FROM client WHERE att = '$att'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $details = array(
        'tel' => $row['tel'],
        'email' => $row['email']
    );
    echo json_encode($details);
} else {
    echo json_encode(array('tel' => '', 'email' => ''));
}

$conn->close();
?>
