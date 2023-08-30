<?php

require '../vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
         // Database connection parameters
         $dbHost = "localhost";
         $dbUser = "root";
         $dbPass = "";
         $dbName = "kyrol";
    
         // Establish a database connection
         $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    
         if ($conn->connect_error) {
             die("Database connection failed: " . $conn->connect_error);
         }
    


    $html = "<html><body>";
    // $unitArray = $_POST["unit"];
    // $priceArray = $_POST["price"];
    // Establish a database connection

    //Quotation
    $nom = $_POST["nom"];
    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $quantity = $_POST["quantity"];
    $price = $_POST["unit_price"];
    $gst = $_POST["gst_amount"];
    $totals = $_POST["item_total"];

    //client details
    $att = $_POST["att"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];
    $reference = $_POST["reference"];
    
    $DOn = $_POST["DOn"];
    $Date = $_POST["Date"];
    $Term = $_POST["Term"];
    $SaleP = $_POST["SaleP"];
    $INos = $_POST["INo"];
    $Pages = $_POST["Page"];

    $compName = $_POST["compName"];
    $compStreet = $_POST["compStreet"];
    $compCity = $_POST["compCity"];
    $compState = $_POST["compState"];

    //calculation section
    $Tamount = $_POST["total_amount"];
    $Tdiscount = $_POST["total_discount"];
    $Tnet = $_POST["net_amount"];
    $Tgst = $_POST["Tgst"];
    $Tgross = $_POST["gross_amount"];
    
     // Loop through quotation items and insert into database
      for ($i = 0; $i < count($nom); $i++) {
        $num = $nom[$i];
        $titles = $title[$i];
        $DOns = $DOn;
        $description = $desc[$i];
        $quantitys = $quantity[$i];
        $prices = $price[$i];
        $gsts = $gst[$i];
        $totalss = $totals[$i];
        $references = $reference;
  
        // Insert data into the database
        $sql = "INSERT INTO item_delivery(DO_No, num, item_name, descript, REF, quantity, Unit_Price, gstPer, TotalPer) VALUES ('$DOn','$num','$titles','$description','$references','$quantitys','$prices','$gsts','$totalss')";
      
        if ($conn->query($sql) !== true) {
             echo "Error: " . $sql . "<br>" . $conn->error;
        }
     }

      $sql2 = "INSERT INTO delivery_order (DO_No, Total_Amount, Total_discount, Net, total_gst, Gross, REF) VALUES ('$DOn','$Tamount','$Tdiscount','$Tnet','$Tgst','$Tgross', '$reference')";
    
      if ($conn->query($sql2) !== true) {
        echo "Error: " . $sql2 . "<br>" . $conn->error;
   }
    // Close the database connection
      $conn->close();

    
    $html = '
    <!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">


    <div class="info">
      <br><br><br><br><br><br><br><br>
      <p>DELIVERY ORDER</p>
      <h style="font-size: 13px;"><b>DO NO:</b> KSL/2023/D0/10158'. $DOn.'</p><br>
          <label>Date:</label> '. $Date .'<br>
          <label>Terms:</label> '. $Term .'<br>
          <label>Sales Per:</label> '. $SaleP .'<br>
          <label>Inv No:</label> '. $INos .'<br>
          <label>Page:</label> '. $Pages .'
        </div>
    </div>
    
</head>
<body>
  
  <div class="container">
    <img src="kyrol.png" alt="Image">
    <p style="font-size: 13px;">KYROL SECURITY LABS SDN BHD</p>
    <p style="font-size: 13px;">C-09-01 I-Tech Tower Jalan Impact, Cyber 6</p>
    <p style="font-size: 13px;"> 63000 Cyberjaya, Selangor Darul Ehsan, Malaysia</p>
    <p style="font-size: 13px;">Tel: +60385855033 Fax: +60386855032</p>
    <p style="font-size: 13px;">(GST Reg No: GST-000303255552)</p>
  </div>

<div class="address">
    <p class="compname">'. $compName .'</p>
    <p class="street">'. $compStreet .'</p>
    <p class="city-state-zip">'. $compCity .'</p>
    <p class="country">'. $compState .'</p>
    
  </div>
  
<br>
    <p style="font-size: 13px;"><b>ATT:</b> '. $att .'</p>
    <p style="font-size: 13px;"><b>TEL:</b> '. $tel .'</p>
    <p style="font-size: 13px;"><b>EMAIL:</b> '. $email .'</p>
     <p style="font-size: 13px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<b>REF:</b><b> '. $reference .' </b></p><br>
<br>
    <table style="text-align: center; font-size: 13px;">
        <thead>
           <tr>
                <th>NO</th>
                <th>NAME</th>
                <th>DESCRIPTION</th>
                <th>QTY</th>
                <th>U.PRICE</th>
                <th>GST</th>
                <th>TOTAL</th>
           </tr> 
        </thead>
        <tbody>
    ';

    for ($i = 0; $i < count($nom); $i++){
        $html .= "<tr>";
        $html .= "<td>". $nom[$i] ."</td>";
        $html .= "<td>". $title[$i] ."</td>";
        $html .= "<td>". nl2br($desc[$i]) ."</td>";
        $html .= "<td>". $quantity[$i] ."</td>";
        $html .= "<td>". $price[$i] ."</td>";
        $html .= "<td>". $gst[$i] ."</td>";
        $html .= "<td>". $totals[$i] ."</td>";
        $html .= "</tr>"; 
    }


    $html .= '
    <tr style="border-top: 1px solid black;">
    <td colspan="5" style="border:none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 13px;">Total:</td>
    <td  style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 13px;">'. $Tamount .'</td>
  </tr>
  <tr>
    <td colspan="5" style="border: none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;font-size: 13px;">Discount:</td>
    <td  style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 13px;">'. $Tdiscount .'</td>
  </tr>
  <tr>
    <td colspan="5" style="border: none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 13px;">Net:</td>
    <td  style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 13px;">'. $Tnet .'</td>
  </tr>
  <tr>
    <td colspan="5" style="border: none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 13px;">Add GST 6%:</td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 13px;">'. $Tgst .'</td>
  </tr>
  
  <tr >
    <td colspan="5" style="border: none; "></td>
    <td style="border: none; font-size: 12px;"><b>GROSS (RM)</b></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 13px;">'. $Tgross .'</td>
  </tr>
  
</tr>
</tbody>
</table>
<p style="font-size: 13px;"><b>Note: Good Sold are not returnable. E.&0.E</b></p>

<br>

<div class="containers">
<br>
<br>
<table style="width: 200px; height: 200px; font-size: 13px;">
<tr>
<td>Date Received</td>
<td style="color: white;">21/12/2022</td>
</tr>
<tr>
<td>Time Received</td>
<td style="color: white;">5:00PM</td>
</tr>
</table>
<br>
</div>

<div class="signbox">

<p1>Received in good order by.</p1>
<br>
<br>
<br>
<br>
<br>
<br>
<p1>..........................................</p1><br>
<p1>Company stamp signature</p1>
</div>

<footer>

</footer>
   
    </body>

    </html>
    <style>
    /* General styles for invoice PDF */
body {
  font-family: Arial, sans-serif;
  font-size: 10pt;
  line-height: 1.5;
  color: #333;
  margin: 0;
  padding: 0;
}

h1, h2, h3 {
  font-weight: bold;
  margin: 60px 0;
}

p {
  margin: 5px 0;
  font-size: 19px;
}

p1 { margin: 5px 0;
font-size: 13px;}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  font-size: 10px;
}

th, td {
  padding: 5px;
  border: 1px solid black;
  text-align: center;
  
  
}

th {
  background-color: #f5f5f5;
  font-weight: bold;
  text-align: center;
  
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
  margin-bottom: 20px;
  width: 15%;
  height: auto;
  margin-top: 60px;
  flex: 1;
  object-position: top;
}






.address {
  font-size: 12px;
  line-height: 1;
  margin-bottom: 20px;
  text-align: left;
}

.address p {
  margin: 0;
  display: block;
  margin-bottom: 3px;
  font-size: 12px;
  text-align: left;
}

.address .compname {
  font-weight: bold;
  font-size: 12px;
  text-align: left;
  margin-top: 5px;
}

.address .street {
  margin-top: 5px;
  font-size: 12px;
  text-align: left;
}

.address .city-state-zip {
  margin-top: 5px;
  font-size: 12px;
  text-align: left;
}

.address .country {
  margin-top: 5px;
  font-size: 12px;
  text-align: left;
  
}




.info {
  margin-bottom: 20px;
  float: right;
  text-align:justify ;
  font-size: 10px;
}
.info label {
  font-weight: bold;
}

.info p{
  background-color: black;
  color: white;
  text-align: center;
  font-weight: bold;
    
}




.container {
  width: 700px;
}

img {
  float: left;
  margin-right: 20px;
  width: 100px;
}

.container img {
float: left;
margin-right: 40px; /* add some space between the image and the text */
height: 50px;
  width: 150px;
}

.container p {
  text-align: center;
}



.containers{
  float: left;
  margin-left: 60px;
  font-size: 11px;
  font-weight: bold;
  margin-right: 160px;
  
}

.signbox{
  float: left;
  font-size: 11px;
  font-weight: bold;
 
}
    </style>';

    
    //to gave permission for dompdf to load picture from directory
    $dompdf = new Dompdf([
      "chroot" => __DIR__
    ]);
    
    //to load template within this file for pdf generating
    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("quotations.pdf", array("Attachment" => false));
}
