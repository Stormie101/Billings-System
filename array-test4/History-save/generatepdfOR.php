<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['PO_Number'])){
        $PO_Number = $_POST['PO_Number'];

        //mention database
        include 'db.php';
        
        // Use prepared statement to prevent SQL injection
        $sqlClient = $conn->prepare("SELECT PO_Number, Dates, compName, compStreet, compCity, compPcode, compState, compTel, compFax, Requist, ShipVia, FOB, ShipTerm, ShipDate, username, W_PO FROM client_purchaseorder WHERE PO_Number = ?");
        $sqlClient->bind_param("s", $PO_Number);
        $sqlClient->execute();
        $resultClient = $sqlClient->get_result();

        if ($resultClient->num_rows > 0) {
            // Output data to the PDF
            $html = "    <!DOCTYPE html><html><head>";

            while ($rowClient = $resultClient->fetch_assoc()) {
                $Dates = $rowClient["Dates"];
                $W_PO = $rowClient["W_PO"];

                $testingDatas = $rowClient["compStreet"];
                $compName = $rowClient["compName"];
                $compStreet = $rowClient["compStreet"];
                $compCity = $rowClient["compCity"];
                $compPcode = $rowClient["compPcode"];
                $compTel = $rowClient["compTel"];
                $compFax = $rowClient["compFax"];

                $Requist = $rowClient["Requist"];
                $ShipVia = $rowClient["ShipVia"];
                $FOB = $rowClient["FOB"];
                $ShipTerm = $rowClient["ShipTerm"];
                $ShipDate = $rowClient["ShipDate"];
                $username = $rowClient["username"];

                $html .= '
                <link rel="stylesheet" type="text/css" href="style.css">
                <meta charset="UTF-8">
            
                <div class="containerd">
                  <p4 style="font-size:25px;">PURCHASE ORDER</p4><br>
                  <table style="border-top: none; width:160px; margin-left:80px;">
                  <tr style="border:none; padding:0px;">
                    <th style="border:none; background-color:white; ">DATE:</th>
                    <th style=" padding:3px;border:none; text-align:center; background-color:#E4E8F3;">'. $Dates .'</th>
                  </tr>
                  <tr>
                    <th style="border:none; background-color:white;">P.O. #</th>
                    <th style="padding:3px; background-color:white; text-align:center;">'. $W_PO .'</th>
                  </tr>
                </table>
                </div>   
              
            </head>
            <body>
            <br>
            <p style="font-size: 15px; text-align: left; font-weight: bold;">KYROL Security Labs Sdn Bhd</p>
            <img src="kyrol.png" style="width:190px;">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div style="margin-bottom:120px;">
            <p style="line-height:17px; font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;">C-09-01 I-Tech Tower Jalan Impact, Cyber 6 <br>
            63000 Cyberjaya, Selangor Darul Ehsan, Malaysia<br>
            Tel: +60385855033 Fax: +60386855032<br>
            (GST Reg No: GST-000303255552)</p>
            <br>
        <div class="vendor-container">
            <h3 id="vendor">VENDOR</h3>
            <p style="line-height:17px;">'. $compName .'<br>
            '. $compStreet .'<br>
            '. $compPcode .' '. $compCity .'<br>
            '. $compStreet .'<br>
            T: '. $compTel .' F: '. $compFax .'
            </p>
        </div>
      
        <div class="vendor-container">
            <h3 id="vendor">SHIP TO</h3>
            <p style="line-height:17px;">Kyrol Security Labs
            C-09-01 iTech Tower<br>
            Jalan Impact, Cyber 6, <br>
            63000 Cyberjaya<br>
            Selangor Darul Ehsan<br>
            T:603-8685 5033 F: 603-8685 5032</p>
        </div>
        <br>
        </div>
          <table class="center">
          
            <tr>
              <th style="text-align:center; background-color:#3B4E87;">REQUISTIONER</th>
              <th style="text-align:center; background-color:#3B4E87;">SHIP VIA</th>
              <th style="text-align:center; background-color:#3B4E87;">F.O.B.</th>
              <th style="text-align:center; background-color:#3B4E87;">SHIPPING TERMS</th>
              <th style="text-align:center; background-color:#3B4E87;">DELIVERY DATE</th>
            </tr>
            <tr>
              <td style="text-align:center;">'. $Requist .'</td>
              <td style="text-align:center;">'. $ShipVia .'</td>
              <td style="text-align:center;">'. $FOB .'</td>
              <td style="text-align:center;">'. $ShipTerm .'</td>
              <td style="text-align:center;">'. $ShipDate .'</td>
            </tr>
          
          </table>
          
          <br>
              <table style="text-align: center;">
                  <thead>
                     <tr>
                          <th style="text-align:center; background-color:#3B4E87;">ITEM #</th>
                          <th style="text-align:center; background-color:#3B4E87;">DESCRIPTION</th>
                          <th style="text-align:center; background-color:#3B4E87;">DELIVERY DATE</th>
                          <th style="text-align:center; background-color:#3B4E87;">QTY</th>
                          <th style="text-align:center; background-color:#3B4E87;">U.PRICE</th>
                          <th style="text-align:center; background-color:#3B4E87;">TOTAL</th>
                     </tr> 
                  </thead>
                  <tbody>  
            ';
            }

            // Fetch data from the item_quotation table
            $sqlItem = $conn->prepare("SELECT P_No, num, descript, DDate, Qty, UPrice, Tgst, Total, W_PO FROM item_purchase WHERE P_No = ?");
            $sqlItem->bind_param("s", $PO_Number);
            $sqlItem->execute();
            $resultItem = $sqlItem->get_result();

            $itemNumber = 1; // Initialize item number

            if ($resultItem->num_rows > 0) {
                while ($rowItem = $resultItem->fetch_assoc()) {
                    $PODate = $rowItem["DDate"];
                    $descript = $rowItem["descript"];
                    $quantity = $rowItem["Qty"];
                    $price = $rowItem["UPrice"];
                    $totals = $rowItem["Total"];

                    $html .= "<tr>";
                    $html .= "<td style='text-align:center;'>$itemNumber</td>";
                    $html .= "<td style='text-align:left;'>". nl2br($descript) ."</td>";
                    $html .= "<td style='text-align:center;'>". $PODate ."</td>";
                    $html .= "<td style='text-align:center;'>". $quantity ."</td>";
                    $html .= "<td style='text-align:right;'>". $price ."</td>";
                    $html .= "<td style='text-align:right;'>". $totals ."</td>";
                    $html .= "</tr>";

                    $itemNumber++;
                }
            } else {
                $html .= "<p>No items found for QNo: " . $PO_Number . "</p>";
            }
            
            $sqlClients = $conn->prepare("SELECT PO_NO, Total_amount, Total_discount, net, others, total_gst, Gross FROM purchase_order WHERE PO_NO = ?");
            $sqlClients->bind_param("s", $PO_Number);
            $sqlClients->execute();
            $resultClients = $sqlClients->get_result();
            
            while ($rowClients = $resultClients->fetch_assoc()) {
              $Tamount = $rowClients["Total_amount"];
              $Tothers = $rowClients["others"];
              $Tgst = $rowClients["total_gst"];
              $Tgross = $rowClients["Gross"];
            $html .= '
            <tr>
            <td colspan="3" style="border-left:none; border-right:none; border-bottom:none;"></td>
      
              <td colspan="1" style="border:none;"></td>
              <td style="border-left:none; border-bottom:none; border-right:none;">SUBTOTAL:</td>
              <td style="border:none; border-left:gone; background-color:#E4E8F3; text-align:right;">
                  <div style="float:left;"><p style="text-align:left; margin-top:5px">RM</p></div>
                  <div style="float:right;"><p style="text-align:right; margin-top:5px">'. $Tamount .'</p></div>
              </td>
            </tr>
                  <tr>
                  <td colspan="3" style="text-align:left; background-color:#C0C0C0; font-weight:bold; border:none; border-top:none;">Other Comments or Special Instructions</td>
                    <td colspan="1" style="border: none;"></td>
                    <td style="background-color: lightgray; border-color: black; border:1px solid black; border:none; background-color:white;">TAX RATE (GST):</td>
                    <td  style="background-color: lightgray; border-color: black; border:1px solid black; text-align:right; border:none; background-color:white;"></td>
                  </tr>
                  <tr>
                  <td colspan="3" rowspan="3"></td>
                    <td colspan="1" style="border: none;"></td>
                    <td style="background-color: lightgray; border-color: black; border:1px solid black; border:none; background-color:white; ">TAX:</td>
                    <td style="background-color: lightgray; border-color: black; border:1px solid black; text-align:right; border:none; border-top:1px solid black; background-color:#E4E8F3;">
                      <div style="float:left;"><p style="text-align:left; margin-top:5px">RM</p></div>
                      <div style="float:right;"><p style="text-align:right; margin-top:5px">'. $Tgst .'</p></div>
                    </td>
                  </tr>
                  <tr > 
                  <td colspan="1" style="border: none;"></td>
                  <td style="background-color: lightgray; border:none; background-color:white;"><div class="dboule1">OTHER:</div></td>
                  <td style="background-color: lightgray; border-color: black; border: 1px solid black; text-align:right; padding-top: 2px; border:none; background-color:white;">
                  <div style="float:left;"><p style="text-align:left; margin-top:5px">RM</p></div>
                  <div style="float:right;"><p style="text-align:right; margin-top:5px">'. $Tothers .'</p></div>
                </td>
              </tr>
              <tr>
                  <td colspan="1" style="border: none; "></td>
                  <td style="border: none;"><div class="dboule2"><b>TOTAL</b></div></td>
                  <td style="background-color: lightgray; border-color: black; border: 1px solid black; text-align:right; padding-bottom: 2px; border:none; background-color:#E4E8F3;"><b>RM'. $Tgross .'</b></td>
              </tr>
              </tbody>
          </table>
      
      <br>
          <div class="half-line" style="height:2px;"></div>
          <p2>Authorized by   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ELLE     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label1>Date:</label1> '. $Dates .'<br> </p2>
      
      <br>
          <p style="font-size: 13px; text-align: center;">If you have any question about this purchase order, please contact us</p>
          
      
          <footer>
      
          </footer>
          <style>
body {
  font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
  font-size: 10px;
  line-height: 1.5;
  color: #333;
  margin: 0;
  padding: 0;
}

.header {
  padding: 50px;
  text-align: center;
  background-color: #474e5d;
  color: white;
}

h1, h2, h3 {
  font-weight: bold;
  margin: 60px 0;
}

  
  p {
    margin: 0px 0;
    font-size: 13px;
    text-align: left;
  }

  p4 {
  margin: 0px 0;
    font-size: 20px;
    text-align: left;
    color: #8e9dcd;
    font-weight: bold;
  }
  
  table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 10px;
    border-top: 1px solid black;
    font-size: 10px;
   
   
    
    
  }
  th, td {
    text-align: left;
    font-size: 13px;
    border-bottom: 1px solid black;
    border: 1px solid black;
    
    
    
    
  }
  th {
    background-color: #f2f2f2;
    border-bottom: 1px solid black;
    font-size: 10px;
  }

  table.center th {
    background-color: #2a355b; /* Set the background color of th elements */
    color: white; /* Set the text color of th elements */
    font-weight: bold; /* Optionally set font-weight for bold text */
  }

  table thead th {
    background-color: #2a355b; /* Set the background color of th elements */
    color: white; /* Set the text color of th elements */
    font-weight: bold; /* Optionally set font-weight for bold text */
  }
 


  
  /* Header and footer styles */
  header, footer {
    position: fixed;
    left: 0;
    right: 0;
    color: #777;
    font-size: 8pt;
  }
  
  header {
    top: 0;
    height: 50px;
    border-bottom: 1px solid #ccc;
  }
  
  footer {
    bottom: 0;
    height: 30px;
    border-top: 1px solid #ccc;
    text-align: center;
  }
  
  /* Invoice-specific styles */
  .invoice-info {
    margin-top: 30px;
    margin-bottom: 50px;
  }
  
  .invoice-info p {
    margin: 0;
  }
  
  .invoice-details {
    margin-top: 30px;
  }
  
  .invoice-details th {
    text-align: center;
  }
  
  .invoice-total {
    margin-top: 50px;
    margin-bottom: 30px;
  }
  
  .invoice-total th {
    text-align: right;
  }
  
  .invoice-total td {
    text-align: center;
  }
  
  .invoice-notes {
    margin-top: 50px;
    margin-bottom: 30px;
  }
  
  .invoice-notes p {
    margin: 0;
  }
  
  
  
  img {
    display: block;
    margin-bottom: 5px;
    width: 50%;
    height: auto;
    margin-top: 30px;
    flex: 1;
    object-position: top;
  }
  
  .container img {
    float: left;
   
    height: 50px;
    width: 150px;
  }
  
  
  
  
  .address {
    font-size: 13px;
    line-height: 1;
    margin-bottom: 20px;
    text-align: left;
  }
  
  .address p {
    margin: 0;
    display: block;
    margin-bottom: 3px;
    font-size: 13px;
    text-align: left;
  }
  
  .address .compname {
    font-weight: bold;
    font-size: 13px;
    text-align: left;
    margin-top: 5px;
  }
  
  .address .street {
    margin-top: 5px;
    font-size: 13px;
    text-align: left;
  }
  
  .address .city-state-zip {
    margin-top: 5px;
    font-size: 13px;
    text-align: left;
  }
  
  .address .country {
    margin-top: 5px;
    font-size: 13px;
    text-align: left;
  }
  
  
.containerd{
  float: right;
  font-size: 13px;
  text-align: right;
  
}

.containerd p{
  font-size: 20px;
  text-align: right;
  font-weight: bold;
  

}



  .info {
    margin-bottom: 20px;
    float: right;
    text-align:justify ;
    font-size: 10px;
    
  }
  .info label {
    
    font-size: 13px;
  }

.container {
  display: flex; /* Use flexbox to align the divs side by side */
}

.info p {
  flex: 1; 
  padding: 6px; /* Add padding for spacing */
  background-color: #2a355b;
  color: white;
  text-align: center;
  font-weight: bold;

}

.address p1 {
  flex: 1; 
  padding: 9px 100px; /* Add padding for spacing */
  background-color: #2a355b;
  color: white;
  text-align: right;
  font-weight: bold;

}


  .container {
    text-align: left;
    float: left;
    width: 700px;
    height: 100px;
    
  }
  
  img {
    float: left;
    margin-right: 20px;
    width: 150px;
    height: 50px;
  }

.container p {
    text-align: center;
}

.containers{
    float: left;
    margin-right: 40px;
    font-size: 11px;
    font-weight: bold;
}

.signbox{
    float: right;
    font-size: 11px;
    font-weight: bold;
}

.half-line {
  width: 80%; /* Set the width of the line to 50% */
  height: 1px; /* Set the height of the line */
  background-color: black; /* Set the color of the line */
  
  float: right;
}

p2 {
  margin-left: 20%;
  margin-right: 50%;
  font-size: 13px;
}

.boxs {
  width: 300px; /* Adjust the width as needed */
  height: 90px; /* Adjust the height as needed */
  background-color: #f2f2f2; /* Adjust the background color as needed */
  border: 1px solid #000; /* Adjust the border properties as needed */
  padding: 10px; /* Adjust the padding as needed */
  box-sizing: border-box; 
}

p3 {
  font-size: 13px;
  font-weight: bold;
}

label1 {
  font-weight: bold;
  margin-left: 1em;
}

.spaced-table tr{

  margin-bottom:10%;
}

#vendor{
  background-color:#3B4E87;
  margin: 0;
  width: 250px;
  text-align: left;
  color: white;
  font-weight: normal;
}

div p{
  line-height: 10px;
  font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande", "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
}

.vendor-container {
  width: 50%;
  float: left;
  width: max-content;
  height: max-content;
}

.vendor-container:nth-child(2) {
  float: right;
  width: max-content;
  height: max-content;
}

#Dborder{
  border-bottom:1px solid black;
}

#Dborder:before{
  content:"";
  display: block;
  position: absolute;
  left: 0;
  bottom: 5px;
  width: 100%;
  height: 5px;
  background-color: green;
}

.dboule1 {
  border-bottom: 2px solid black;
}

.dboule2 {
  border-top: 2px solid black;
}
</style>
            </body></html>';
}
            $conn->close();

            // Load HTML into Dompdf
            $dompdf = new Dompdf(["chroot" => __DIR__]);
            $dompdf->loadHtml($html);

            // Set paper size and render PDF
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Output PDF
            $dompdf->stream("Purchase_Order.pdf", array("Attachment" => false));
        } else {
            echo "No data found in the table with Purchase Number: " . $PO_Number;
        }
    } else {
        echo "Purchase Order Number not set.";
    }
} else {
    echo "Invalid request.";
}
?>
