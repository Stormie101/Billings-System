<?php

require '../vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //mention database
  include 'db.php';

    $html = "<html><body>";

    //input
    $nom = $_POST["nom"];
    $desc = $_POST["desc"];
    $quantity = $_POST["quantity"];
    $price = $_POST["unit_price"];
    $PODate = isset($_POST["PODate"]) && !empty($_POST["PODate"]) ? $_POST["PODate"] : "None";
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
    $compPcode = $_POST["compPcode"];
    $compState = $_POST["compState"];
    $compTel = $_POST["compTel"];
    $compFax = $_POST["compFax"];
    $set = $_POST["set"];

    //calculation section
    $Tamount = $_POST["total_amount"];
    $Tdiscount = $_POST["total_discount"];
    $Tnet = $_POST["net_amount"];
    $Tothers = $_POST["other_amount"];
    $Tgst = $_POST["Tgst"];
    $Tgross = $_POST["gross_amount"];
    
    //remove slashes

    $newReq = stripslashes($Req);
    $newShipV = stripslashes($ShipV);
    $newFob = stripslashes($Fob);
    $newSterm = stripslashes($Sterm);
    $newSdate = stripslashes($Sdate);
    $newcompName = stripslashes($compName);
    $newcompStreet = stripslashes($compStreet);
    $newcompCity = stripslashes($compCity);
    $newcompState = stripslashes($compState);

    if (empty($PODate)) {
      $PODate = "None";
  }

  $checkQuery = "SELECT P_No FROM item_Purchase WHERE P_No = '$POno'";
  $result = $conn->query($checkQuery);

  if ($result->num_rows > 0) {
    // QNo already exists, handle accordingly (show an error message or take any other action)
    $conn->close();
} else {
        // Loop through quotation items and insert into database
        for ($i = 0; $i < count($nom); $i++) {
          $num = $nom[$i];
          $POnos = $POno;
          $description = htmlspecialchars($desc[$i], ENT_QUOTES);
          $PODates = $PODate[$i];
          $quantitys = $quantity[$i];
          $prices = $price[$i];
          $gsts = $gst[$i];
          $totalss = $totals[$i];
     
          // Insert data into the database
          $sql = "INSERT INTO item_Purchase(P_No, num, descript, DDate, Qty, UPrice, Tgst, Total, W_PO) VALUES ('$POnos', '$num', '$description', '$PODates', '$quantitys', '$prices', '$gsts', '$totalss', '$set')";
         
          if ($conn->query($sql) !== true) {
               echo "Error: " . $sql . "<br>" . $conn->error;
          }
       }
       
       $sql2 = "INSERT INTO purchase_order (PO_NO, Total_amount, Total_discount, net, others, total_gst, Gross) VALUES ('$POno','$Tamount','$Tdiscount','$Tnet', '$Tothers','$Tgst','$Tgross')";
    
       if ($conn->query($sql2) !== true) {
         echo "Error: " . $sql2 . "<br>" . $conn->error;
    }

       $conn->close();
}

    $html = '
    <!DOCTYPE html>
    <html>
    <head>
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
            <th style="padding:3px; background-color:white; text-align:center;">'. $set .'</th>
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
      <p style="line-height:17px;">'. $newcompName .'<br>
      '. $newcompStreet .'<br>
      '. $compPcode .' '. $newcompCity .'<br>
      '. $newcompState .'<br>
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
        <td style="text-align:center;">'. $newReq .'</td>
        <td style="text-align:center;">'. $newShipV .'</td>
        <td style="text-align:center;">'. $newFob .'</td>
        <td style="text-align:center;">'. $newSterm .'</td>
        <td style="text-align:center;">'. $newSdate .'</td>
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

    for ($i = 0; $i < count($nom); $i++){
        $html .= "<tr>";
        $html .= "<td style='text-align:center;'>". $nom[$i] ."</td>";
        $html .= "<td style='padding-left:5px;'>". nl2br($desc[$i]) ."</td>";
        $html .= "<td style='text-align:center;'>". $PODate[$i] ."</td>";
        $html .= "<td style='text-align:center;'>". $quantity[$i] ."</td>";
        $html .= "<td style='text-align:right; padding-right:5px;'>". $price[$i] ."</td>";
        $html .= "<td style='text-align:right; background-color:#E4E8F3;'>". $totals[$i] ."</td>";
        $html .= "</tr>"; 
    }


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
    $dompdf->stream("PurchaseOrder.pdf", array("Attachment" => false));

}
?>
