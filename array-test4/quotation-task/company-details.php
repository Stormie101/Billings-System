<?php
//mention database
include 'db.php';

// Get the att value from the POST request
$compName = $_POST['compName'];

// Fetch tel and email based on att
$sql = "SELECT compStreet, compCity, compState, compPcode FROM companyinfo WHERE compName = '$compName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $details = array(
        'compStreet' => $row['compStreet'],
        'compCity' => $row['compCity'],
        'compState' => $row['compState'],
        'compPcode' => $row['compPcode']
    );
    echo json_encode($details);
} else {
    echo json_encode(array('compStreet' => '', 'compCity' => '', 'compState' => '', 'compPcode' => ''));
}

$conn->close();
?>
