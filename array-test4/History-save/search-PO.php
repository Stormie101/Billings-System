<?php
$servername = "localhost";
$usernames = "root";
$password = "";
$dbname = "kyrol";

$conn = new mysqli($servername, $usernames, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
        // 2. Retrieve User Role
        $sql = "SELECT adminrole FROM admin WHERE username = '$username'";
        $result = $conn->query($sql);
    
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $role = $row['adminrole'];
        }
} else {
    header("Location: ../login.php"); // Redirect to login page if not logged in
    exit();
}

$searchTerm = $_POST['searchTerm'];

if($role == 'Admin') {
    // If the user is an admin, search everything
    $sql = "SELECT * FROM client_purchaseorder WHERE compName LIKE '%$searchTerm%' ORDER BY id DESC";
} else {
    // If the user is not an admin, only search their own records
    $sql = "SELECT * FROM client_purchaseorder WHERE compName LIKE '%$searchTerm%' AND username='$username' ORDER BY id DESC";
}
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}

$conn->close();
?>
