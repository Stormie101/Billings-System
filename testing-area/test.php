<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['QNo'])){
        $QNo = $_POST['QNo'];

        $dbHost = "localhost";
        $dbUser = "root";
        $dbPass = "";
        $dbName = "kyrol";

        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }
        
        // Use prepared statement to prevent SQL injection
        $sqlClient = $conn->prepare("SELECT att, tel FROM client_quotation WHERE QNo = ?");
        $sqlClient->bind_param("s", $QNo);
        $sqlClient->execute();
        $resultClient = $sqlClient->get_result();

        if ($resultClient->num_rows > 0) {
            // Output data to the PDF
            $html = "<html><body>";

            while ($rowClient = $resultClient->fetch_assoc()) {
                $testingData = $rowClient["att"];
                $testingDatas = $rowClient["tel"];
                $html .= "<p>Client Testing Data: " . $testingData . "</p>";
                $html .= "<p>Client Testing Data: " . $testingDatas . "</p>";
            }

            // Fetch data from the item_quotation table
            $sqlItem = $conn->prepare("SELECT ref, descript FROM item_quotation WHERE Quotation_No = ?");
            $sqlItem->bind_param("s", $QNo);
            $sqlItem->execute();
            $resultItem = $sqlItem->get_result();

            if ($resultItem->num_rows > 0) {
                while ($rowItem = $resultItem->fetch_assoc()) {
                    $itemName = $rowItem["ref"];
                    $itemPrice = $rowItem["descript"];
                    $html .= "<p>Item Name: " . $itemName . ", Item Price: " . $itemPrice . "</p>";
                }
            } else {
                $html .= "<p>No items found for QNo: " . $QNo . "</p>";
            }

            $html .= "</body></html>";
            
            $conn->close();

            // Load HTML into Dompdf
            $dompdf = new Dompdf(["chroot" => __DIR__]);
            $dompdf->loadHtml($html);

            // Set paper size and render PDF
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Output PDF
            $dompdf->stream("quotations.pdf", array("Attachment" => false));
        } else {
            echo "No data found in the 'client_quotation' table with QNo: " . $QNo;
        }
    } else {
        echo "QNo not set.";
    }
} else {
    echo "Invalid request.";
}
?>
