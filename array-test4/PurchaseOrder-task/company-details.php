<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kyrol";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the att value from the POST request
$compName = $_POST['compName'];

// Fetch tel and email based on att
$sql = "SELECT compStreet, compCity, compPcode, compState, compTel, compFax FROM companyinfo WHERE compName = '$compName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $details = array(
        'compStreet' => $row['compStreet'],
        'compPcode' => $row['compPcode'],
        'compCity' => $row['compCity'],
        'compState' => $row['compState'],
        'compTel' => $row['compTel'],
        'compFax' => $row['compFax']
    );
    echo json_encode($details);
} else {
    echo json_encode(array('compStreet' => '', 'compPcode' => '','compCity' =>'', 'compState' => '', 'compTel' =>'', 'compFax' =>''));
}

$conn->close();
?>
