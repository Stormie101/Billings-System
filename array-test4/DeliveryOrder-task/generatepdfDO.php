<?php

require '../vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//mention database
include 'db.php';
    


    $html = "<html><body>";
    // $unitArray = $_POST["unit"];
    // $priceArray = $_POST["price"];
    // Establish a database connection

    //Quotation
    $nom = $_POST["nom"];
    $desc = $_POST["desc"];
    $quantity = isset($_POST["quantity"]) && !empty($_POST["quantity"]) ? $_POST["quantity"] : "0";
    $price = isset($_POST["unit_price"]) && !empty($_POST["unit_price"]) ? $_POST["unit_price"] : "0";
    $gst = isset($_POST["gst_amount"]) && !empty($_POST["gst_amount"]) ? $_POST["gst_amount"] : "0";
    $totals = $_POST["item_total"];

    //client details
    $att = $_POST["att"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];
    $reference = $_POST["reference"];
    $set = $_POST["set"];

    
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
    $compPcode = $_POST["compPcode"];

    //calculation section
    $Tamount = $_POST["total_amount"];
    $Tdiscount = $_POST["total_discount"];
    $Tnet = $_POST["net_amount"];
    $Tgst = $_POST["Tgst"];
    $Tgross = $_POST["gross_amount"];
    
    //remove slashes
    $newatt = stripslashes($att);
    $newemail = stripslashes($email);

    $newcompName = stripslashes($compName);
    $newcompStreet = stripslashes($compStreet);
    $newcompCity = stripslashes($compCity);
    $newcompState = stripslashes($compState);

    $year = date("Y", strtotime($Date));
    
    $checkQuery = "SELECT DO_No FROM item_delivery WHERE DO_No = '$DOn'";
    $result = $conn->query($checkQuery);
    
    if ($result->num_rows > 0) {
      // QNo already exists, handle accordingly (show an error message or take any other action)
      $conn->close();
  } else {
     // Loop through quotation items and insert into database
     for ($i = 0; $i < count($nom); $i++) {
      $num = $nom[$i];
      $DOns = $DOn;
      $description = htmlspecialchars($desc[$i], ENT_QUOTES);
      $quantitys = $quantity[$i];
      $prices = $price[$i];
      $gsts = $gst[$i];
      $totalss = $totals[$i];

      // Insert data into the database
      $sql = "INSERT INTO item_delivery(DO_No, num, descript, quantity, Unit_Price, gstPer, TotalPer, W_do) VALUES ('$DOn','$num','$description','$quantitys','$prices','$gsts','$totalss', '$set')";
    
      if ($conn->query($sql) !== true) {
           echo "Error: " . $sql . "<br>" . $conn->error;
      }
   }

    $sql2 = "INSERT INTO delivery_order (DO_No, Total_Amount, Total_discount, Net, total_gst, Gross, W_do) VALUES ('$DOn','$Tamount','$Tdiscount','$Tnet','$Tgst','$Tgross', '$set')";
  
    if ($conn->query($sql2) !== true) {
      echo "Error: " . $sql2 . "<br>" . $conn->error;
 }
  // Close the database connection
    $conn->close();
  }

    $html = '
    <!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">


    <div class="info">
      <br><br><br><br><br><br><br><br>
      <p style="background-color:#203864; padding:3px 25px 3px 25px; border-bottom-left-radius: 5px; font-weight:normal;">DELIVERY ORDER</p>
      <table style="border-color:white; margin-top:20px; margin-right:15px;">
      <tr>
        <td style="padding-right:20px; text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">DO NO</td>
        <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">'. $set .'</td>
      </tr>
      <tr>
        <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">DATE</td>
        <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; color:black;">'. $Date .'</td>
      </tr>
      <tr>
        <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">TERMS</td>
        <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; color:black;"> '. $Term .'</td>
      </tr>
      <tr>
        <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">SALES PER</td>
        <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; color:black;">'. $SaleP .'</td>
      </tr>
      <tr>
        <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">INV NO</td>
        <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; color:black;"> '. $INos .'</td>
      </tr>
      <tr>
        <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">PAGE </td>
        <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; color:black;"> '. $Pages .'
      </td>
      </tr>
    </table>
        </div>
    </div>
    
</head>
<body>
  
  <div class="container">
    <img src="kyrol.png" alt="Image" style="width:150px; height:40px;">
    <p style="font-size: 13px; line-height:2px; margin-top:40px; font-size:11px; color:black;">KYROL SECURITY LABS SDN BHD</p>
    <p style="font-size: 13px; line-height:15px; font-size:11px; color:black;">C-09-01 I-Tech Tower Jalan Impact, Cyber 6</p>
    <p style="font-size: 13px; line-height:15px; font-size:11px; color:black;"> 63000 Cyberjaya, Selangor Darul Ehsan, Malaysia</p>
    <p style="font-size: 13px; line-height:15px; font-size:11px; color:black;">Tel: +60385855033 Fax: +60386855032</p>
    <p style="font-size: 13px; line-height:15px; font-size:11px; color:black;">(GST Reg No: GST-000303255552)</p>
  </div>

<div class="address">
    <p class="compname" style="text-transform: uppercase;">'. $compName .'</p>
    <p class="street" style="color:black;">'. $compStreet .',</p>
    <p class="city-state-zip" style="color:black;">'. $compPcode .' '. $compCity .',</p>
    <p class="country" style="color:black;">'. $compState .'</p>
    
  </div>
  
<br>
<table style="border-color:white; width:250px;">
  <tr>
    <td style="text-align:left; border: 1px solid white; line-height:20px; font-size:12px; font-weight:bold; color:black;">ATT</td>
    <td style="text-align:left; border: 1px solid white; line-height:20px; font-size:12px; color:black; text-transform: uppercase;">: '. $att .'</td>
  </tr>
  <tr>
    <td style="text-align:left; border: 1px solid white; line-height:20px; font-size:12px; font-weight:bold; color:black;">TEL</td>
    <td style="text-align:left; border: 1px solid white; line-height:20px; font-size:12px; color:black;">:  '. $tel .'</td>
  </tr>
  <tr>
    <td style="text-align:left; border: 1px solid white; line-height:20px; font-size:12px; font-weight:bold; color:black;">EMAIL</td>
    <td style="text-align:left; border: 1px solid white; line-height:20px; font-size:12px; color:black;"> : '. $email .'</td>
  </tr>
</table>
<br>
    <table style="text-align: center; font-size: 13px;">
        <thead>
           <tr>
                <th style="border-left:none; border-right:none; background-color:white; font-weight:normal; color:black;">NO</th>
                <th style="border-left:none; border-right:none; background-color:white; font-weight:normal; color:black;">DESCRIPTION</th>
                <th style="border-left:none; border-right:none; background-color:white; font-weight:normal; color:black;">QTY</th>
                <th style="border-left:none; border-right:none; background-color:white; font-weight:normal; color:black;">U.PRICE</th>
                <th style="border-left:none; border-right:none; background-color:white; font-weight:normal; color:black;">GST</th>
                <th style="border-left:none; border-right:none; background-color:white; font-weight:normal; color:black;">TOTAL</th>
           </tr> 
        </thead>
        <tbody>
    ';

    for ($i = 0; $i < count($nom); $i++){
        $html .= "<tr>";
        $html .= "<td style='border-left:none; border-right:none; background-color:white; color:black; border-bottom:none; border-top:none;'>". $nom[$i] ."</td>";
        $html .= "<td style='border-left:none; border-right:none; background-color:white; color:black; border-bottom:none; border-top:none; text-align:left;'>". nl2br($desc[$i]) ."</td>";
        $html .= "<td style='border-left:none; border-right:none; background-color:white; color:black; border-bottom:none; border-top:none;'>". $quantity[$i] ."</td>";
        $html .= "<td style='border-left:none; border-right:none; background-color:#B8B8B8; color:black; border-bottom:none; border-top:none;'></td>";
        $html .= "<td style='border-left:none; border-right:none; background-color:#B8B8B8; color:black; border-bottom:none; border-top:none;'></td>";
        $html .= "<td style='border-left:none; border-right:none; background-color:#B8B8B8; color:black; border-bottom:none; border-top:none;'></td>";
        $html .= "</tr>"; 
    }


    $html .= '
    <tr style="border-top: 1px solid black;">
    <td colspan="2" style="border:none; font-size:11px; font-color:black; color:black; padding:0px; text-align:left; font-weight:bold;">Note: Good Sold are not returnable.</td>
    <td colspan="1" style="border:none; padding:0px; font-size:11px; color:black; font-weight:bold;">E.&0.E</td>

    <td colspan="1" style="border:none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 11px; text-align:left; padding:0px; padding-left:5px; color:black;">TOTAL</td>
    <td  style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 11px; padding:0px; color:black;"> - </td>
  </tr>
  <tr>
    <td colspan="4" style="border: none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;font-size: 11px; text-align:left; padding:0px; padding-left:5px; color:black;">DISCOUNT</td>
    <td  style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 11px; padding:0px; color:black;"> - </td>
  </tr>
  <tr>
    <td colspan="4" style="border: none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 11px; text-align:left; padding:0px; padding-left:5px; color:black;">NET</td>
    <td  style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 11px; padding:0px; color:black;"> - </td>
  </tr>
  <tr>
    <td colspan="4" style="border: none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 11px; text-align:left; padding:0px; padding-left:5px; color:black;">ADD GST 6%</td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 11px; padding:0px; color:black;"> - </td>
  </tr>
  
  <tr >
    <td colspan="4" style="border: none; "></td>
    <td style="border: none; font-size: 12px; padding:0px; color:black;"><b>GROSS (RM)</b></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 13px; padding:0px; color:black;"> - </td>
  </tr>
  
</tr>
</tbody>
</table>
<br>

<div class="containers">
<br>
<br>
<table style="border-collapse: collapse; width: 250px;">
<tr>
  <td style="border: 1px solid black; padding: 5px; text-align: left; font-weight:bold; color:black; font-size:11px;">Data Receive</td>
  <td style="padding-right: 70px; padding-bottom: 40px;"></td>
</tr>
<tr>
  <td style="    border: 1px solid black; padding: 5px; text-align: left; font-weight:bold; color:black; font-size:11px;">Time Receive</td>
  <td style="padding-right: 70px; padding-bottom: 40px;"></td>
</tr>
</table>
<br>
</div>

<div class="signbox" style="margin-left:50px;">

<p1>Received in good order by.</p1>
<br>
<br>
<br>
<br>
<br>
<br>
<p1>..........................................</p1><br>
<p style="font-size:13px; font-weight:normal;">Company\' stamp signature</p>
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
    $dompdf->stream("Delivery Order.pdf", array("Attachment" => false));
}
