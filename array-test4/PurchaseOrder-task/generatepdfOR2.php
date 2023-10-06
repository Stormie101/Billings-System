<?php

require '../vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // // Database connection parameters
        // $dbHost = "localhost";
        // $dbUser = "root";
        // $dbPass = "";
        // $dbName = "kyrol";
    
        // // Establish a database connection
        //  $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    
        // if ($conn->connect_error) {
        //     die("Database connection failed: " . $conn->connect_error);
        // }
    


    $html = "<html><body>";

    //input
    $nom = $_POST["nom"];
    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $quantity = $_POST["quantity"];
    $price = $_POST["unit_price"];
    $PODate = $_POST["PODate"];
    $gst = $_POST["gst_amount"];
    $totals = $_POST["item_total"];

    //client details
    $POno = $_POST["POno"];
    $Dates = $_POST["dates"];
    
    //Shipping information
    $Req = $_POST["req"];
    $ShipV = $_POST["shipv"];
    $Fob = $_POST["fob"];
    $Sterm = $_POST["sterm"];
    $Sdate = $_POST["sdate"];
    

    //vendor address
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
  //    for ($i = 0; $i < count($nom); $i++) {
  //      $num = $nom[$i];
  //      $titles = $title[$i];
  //      $INos = $INo;
  //      $description = $desc[$i];
  //      $quantitys = $quantity[$i];
  //      $prices = $price[$i];
  //      $gsts = $gst[$i];
  //      $totalss = $totals[$i];
  //      $references = $reference;
  
  //      // Insert data into the database
  //      $sql = "INSERT INTO item_invoice (Invoice_No, num, item_name, descript, REF, quantity, Unit_Price, gstPer, TotalPer) VALUES ('$INos', '$num', '$titles', '$description', '$reference', '$quantitys', '$prices', '$gsts', '$totalss')";
      
  //      if ($conn->query($sql) !== true) {
  //           echo "Error: " . $sql . "<br>" . $conn->error;
  //      }
  //   }

  //    $sql2 = "INSERT INTO invoice (Inv_no, Total_Amount, Total_discount, Net, total_gst, Gross, REF) VALUES ('$INo','$Tamount','$Tdiscount','$Tnet','$Tgst','$Tgross', '$reference')";
    
  //    if ($conn->query($sql2) !== true) {
  //      echo "Error: " . $sql2 . "<br>" . $conn->error;
  // }
  //      // Close the database connection
  //    $conn->close();

    
    $html = '
    <!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">

    <div class="containerd">
      <p>PURCHASE ORDER</p>
      <label1>Date:</label1> '. $Dates .'<br>
      <label1>P/O No:</label1> '. $POno .'<br>
    </div>   
  
</head>
<body>
  
  <img src="kyrol.png" width="50px" height="50px">
  <br><br><br><br><br><br>
  <div class="container">
    <p style="font-size: 13px; text-align: left; font-weight: bold;">KYROL SECURITY LABS SDN BHD</p>
    <p style="font-size: 13px; text-align: left;">C-09-01 I-Tech Tower Jalan Impact, Cyber 6</p>
    <p style="font-size: 13px; text-align: left;"> 63000 Cyberjaya, Selangor Darul Ehsan, Malaysia</p>
    <p style="font-size: 13px; text-align: left;">Tel: +60385855033 Fax: +60386855032</p>
    <p style="font-size: 13px;text-align: left;">(GST Reg No: GST-000303255552)</p>
  </div>
  <br><br><br>
  <div class="info">
<br><br><br><br>
    <p>SHIP TO</p>
  <br>  
    <label>KYROL SECURITY LABS SDN BHD </label><br>
    <label>C-09-01 I-Tech Tower Jalan Impact, Cyber 6</label> <br>
    <label>Jalan Impact, Cyber 6</label> <br>
    <label>63000 Cyberjaya, Selangor Darul Ehsan, Malaysia</label> <br>
    <label>Tel: +60385855033 Fax: +60386855032</label> <br>
  </div>
 
<div class="address">
  <p1>VENDOR</p1> <br><br><br>
  
    <p class="compname">'. $compName .'</p>
    <p class="street">'. $compStreet .'</p>
    <p class="city-state-zip">'. $compState .'</p>
    <p class="country">'. $compState .'</p>
    
  </div>
  
<br>
    <p style="font-size: 13px;"><b>T: 603-6286 8222 </b> &nbsp; &nbsp; &nbsp; <b>F: 603-6142 1850</b></p>
   
<br>
<table class="center">
  <tr>
    <th>REQUISTIONER</th>
    <th>SHIP VIA</th>
    <th>F.O.B</th>
    <th>SHIPPING TERMS</th>
    <th>DELIVERY DATE</th>
  </tr>
  <tr>
    <td>'. $Req .'</td>
    <td>'. $ShipV .'</td>
    <td>'. $Fob .'</td>
    <td>'. $Sterm .'</td>
    <td>'. $Sdate .'</td>
  </tr>

</table>

<br>
    <table style="text-align: center;">
        <thead>
           <tr>
                <th>NO</th>
                <th>Title</th>
                <th>DESCRIPTION</th>
                <th>DELIVERY DATE</th>
                <th>QTY</th>
                <th>U.PRICE</th>
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
        $html .= "<td>". $PODate[$i] ."</td>";
        $html .= "<td>". $quantity[$i] ."</td>";
        $html .= "<td>". $price[$i] ."</td>";
        $html .= "<td>". $totals[$i] ."</td>";
        $html .= "</tr>"; 
    }


    $html .= '
    <tr style="border-top: 1px solid black;">
    <td colspan="5" style="border:none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;">SUBTOTAL:</td>
    <td  style="background-color: lightgray; border-color: black; border:1px solid black;">'. $Tamount .'</td>
  </tr>
  <tr>
    <td colspan="5" style="border: none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;">TAX RATE (GST):</td>
    <td  style="background-color: lightgray; border-color: black; border:1px solid black;"> 6% </td>
  </tr>
  <tr>
    <td colspan="5" style="border: none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;">TAX:</td>
    <td  style="background-color: lightgray; border-color: black; border:1px solid black;">{{ net }}</td>
  </tr>
  <tr>
    <td colspan="5" style="border: none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;">OTHER:</td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;">{{ disc }}</td>
  </tr>
  <tr >
    <td colspan="5" style="border: none; "></td>
    <td style="border: none; "><b>TOTAL (RM)</b></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;">'. $Tgross .'</td>
  </tr>
</tbody>
</table>

<p3>Other Comments or Special Instructions</p3>
<div class="boxs"></div>
<br>
<div class="half-line"></div>
<p2>Authorized by   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ELLE     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label1>Date:</label1>'. $Sdate .'<br> </p2>

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
  
  table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 10px;
    border-top: 1px solid black;
    font-size: 13px;
    
  }
  th, td {
    text-align: left;
    padding: 8px;
    font-size: 13px;
    border-bottom: 1px solid black;
    
    
    
  }
  th {
    background-color: #f2f2f2;
    border-bottom: 1px solid black;
    font-size: 13px;
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

.info p{
    background-color: black;
    color: white;
    text-align: center;
    font-weight: bold;
    padding: 4px 20px;
      
}


p1 {
  background-color: black;
    color: white;
    text-align: left;
    font-weight: bold;
    padding: 6px 100px;
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
  margin: 10px 0; /* Add margin to adjust spacing */
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
  box-sizing: border-box; /* Include padding and border in the box"s total width and height */
}

p3 {
  font-size: 13px;
  font-weight: bold;
}

</style>
    </body>
    </html>';
    
    //to gave permission for dompdf to load picture from directory
    $dompdf = new Dompdf([
      "chroot" => __DIR__
    ]);
    
    //to load template within this file for pdf generating
    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("quotations.pdf", array("Attachment" => false));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // // Database connection parameters
        // $dbHost = "localhost";
        // $dbUser = "root";
        // $dbPass = "";
        // $dbName = "kyrol";
    
        // // Establish a database connection
        //  $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    
        // if ($conn->connect_error) {
        //     die("Database connection failed: " . $conn->connect_error);
        // }
    


    $html = "<html><body>";

    //input
    $nom = $_POST["nom"];
    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $quantity = $_POST["quantity"];
    $price = $_POST["unit_price"];
    $PODate = $_POST["PODate"];
    $gst = $_POST["gst_amount"];
    $totals = $_POST["item_total"];

    //client details
    $POno = $_POST["POno"];
    $Dates = $_POST["dates"];
    
    //Shipping information
    $Req = $_POST["req"];
    $ShipV = $_POST["shipv"];
    $Fob = $_POST["fob"];
    $Sterm = $_POST["sterm"];
    $Sdate = $_POST["sdate"];
    

    //vendor address
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
  //    for ($i = 0; $i < count($nom); $i++) {
  //      $num = $nom[$i];
  //      $titles = $title[$i];
  //      $INos = $INo;
  //      $description = $desc[$i];
  //      $quantitys = $quantity[$i];
  //      $prices = $price[$i];
  //      $gsts = $gst[$i];
  //      $totalss = $totals[$i];
  //      $references = $reference;
  
  //      // Insert data into the database
  //      $sql = "INSERT INTO item_invoice (Invoice_No, num, item_name, descript, REF, quantity, Unit_Price, gstPer, TotalPer) VALUES ('$INos', '$num', '$titles', '$description', '$reference', '$quantitys', '$prices', '$gsts', '$totalss')";
      
  //      if ($conn->query($sql) !== true) {
  //           echo "Error: " . $sql . "<br>" . $conn->error;
  //      }
  //   }

  //    $sql2 = "INSERT INTO invoice (Inv_no, Total_Amount, Total_discount, Net, total_gst, Gross, REF) VALUES ('$INo','$Tamount','$Tdiscount','$Tnet','$Tgst','$Tgross', '$reference')";
    
  //    if ($conn->query($sql2) !== true) {
  //      echo "Error: " . $sql2 . "<br>" . $conn->error;
  // }
  //      // Close the database connection
  //    $conn->close();

    
    $html = '
    <!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">

    <div class="containerd">
      <p>PURCHASE ORDER</p>
      <label1>Date:</label1> '. $Dates .'<br>
      <label1>P/O No:</label1> '. $POno .'<br>
    </div>   
  
</head>
<body>
  
  <img src="kyrol.png" width="50px" height="50px">
  <br><br><br><br><br><br>
  <div class="container">
    <p style="font-size: 13px; text-align: left; font-weight: bold;">KYROL SECURITY LABS SDN BHD</p>
    <p style="font-size: 13px; text-align: left;">C-09-01 I-Tech Tower Jalan Impact, Cyber 6</p>
    <p style="font-size: 13px; text-align: left;"> 63000 Cyberjaya, Selangor Darul Ehsan, Malaysia</p>
    <p style="font-size: 13px; text-align: left;">Tel: +60385855033 Fax: +60386855032</p>
    <p style="font-size: 13px;text-align: left;">(GST Reg No: GST-000303255552)</p>
  </div>

  <div class="info">
<br><br><br><br><br><br>
    <p>SHIP TO</p>
    
    <label>KYROL SECURITY LABS SDN BHD </label><br>
    <label>C-09-01 I-Tech Tower Jalan Impact, Cyber 6</label> <br>
    <label>Jalan Impact, Cyber 6</label> <br>
    <label>63000 Cyberjaya, Selangor Darul Ehsan, Malaysia</label> <br>
    <label>Tel: +60385855033 Fax: +60386855032</label> <br>
  </div>
 
<div class="address">
  <p1>VENDOR</p1> 
  <br>
    <p class="compname">'. $compName .'</p>
    <p class="street">'. $compStreet .'</p>
    <p class="city-state-zip">'. $compState .'</p>
    <p class="country">'. $compState .'</p>
    
  </div>
  
<br>
    <p style="font-size: 13px;"><b>T: 603-6286 8222 </b> &nbsp; &nbsp; &nbsp; <b>F: 603-6142 1850</b></p>
   
<br>
<table class="center">
  <tr>
    <th>REQUISTIONER</th>
    <th>SHIP VIA</th>
    <th>F.O.B</th>
    <th>SHIPPING TERMS</th>
    <th>DELIVERY DATE</th>
  </tr>
  <tr>
    <td>'. $Req .'</td>
    <td>'. $ShipV .'</td>
    <td>'. $Fob .'</td>
    <td>'. $Sterm .'</td>
    <td>'. $Sdate .'</td>
  </tr>

</table>

<br>
    <table style="text-align: center;">
        <thead>
           <tr>
                <th>NO</th>
                <th>Title</th>
                <th>DESCRIPTION</th>
                <th>DELIVERY DATE</th>
                <th>QTY</th>
                <th>U.PRICE</th>
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
        $html .= "<td>". $PODate[$i] ."</td>";
        $html .= "<td>". $quantity[$i] ."</td>";
        $html .= "<td>". $price[$i] ."</td>";
        $html .= "<td>". $totals[$i] ."</td>";
        $html .= "</tr>"; 
    }


    $html .= '
    <tr style="border-top: 1px solid black;">
    <td colspan="5" style="border:none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;">SUBTOTAL:</td>
    <td  style="background-color: lightgray; border-color: black; border:1px solid black;">'. $Tamount .'</td>
  </tr>
  <tr>
    <td colspan="5" style="border: none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;">TAX RATE (SST):</td>
    <td  style="background-color: lightgray; border-color: black; border:1px solid black;">6%</td>
  </tr>
  <tr>
    <td colspan="5" style="border: none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;">TAX:</td>
    <td  style="background-color: lightgray; border-color: black; border:1px solid black;">{{ net }}</td>
  </tr>
  <tr>
    <td colspan="5" style="border: none;"></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;">OTHER:</td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;">{{ disc }}</td>
  </tr>
  <tr >
    <td colspan="5" style="border: none; "></td>
    <td style="border: none; "><b>TOTAL (RM)</b></td>
    <td style="background-color: lightgray; border-color: black; border:1px solid black;">'. $Tgross .'</td>
  </tr>
</tbody>
</table>

<p3>Other Comments or Special Instructions</p3>
<div class="boxs"></div>
<br>
<div class="half-line"></div>
<p2>Authorized by   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ELLE     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label1>Date:</label1>'. $Sdate .'<br> </p2>

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
  
  table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 10px;
    border-top: 1px solid black;
    font-size: 13px;
    
  }
  th, td {
    text-align: left;
    padding: 8px;
    font-size: 13px;
    border-bottom: 1px solid black;
    
    
    
  }
  th {
    background-color: #f2f2f2;
    border-bottom: 1px solid black;
    font-size: 13px;
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

.info p{
    background-color: black;
    color: white;
    text-align: center;
    font-weight: bold;
    padding: 4px 20px;
      
}


p1 {
  background-color: black;
    color: white;
    text-align: left;
    font-weight: bold;
    padding: 6px 100px;
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
  margin: 10px 0; /* Add margin to adjust spacing */
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
  box-sizing: border-box; /* Include padding and border in the box"s total width and height */
}

p3 {
  font-size: 13px;
  font-weight: bold;
}

</style>
    </body>
    </html>';
    
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
}
?>
