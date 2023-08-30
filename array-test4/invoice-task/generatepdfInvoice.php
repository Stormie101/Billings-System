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
    
    $INo = $_POST["INo"];
    $Date = $_POST["Date"];
    $Term = $_POST["Term"];
    $SaleP = $_POST["SaleP"];
    $Pno = $_POST["Pno"];
    $Ldate = $_POST["Ldate"];
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
       $INos = $INo;
       $description = $desc[$i];
       $quantitys = $quantity[$i];
       $prices = $price[$i];
       $gsts = $gst[$i];
       $totalss = $totals[$i];
       $references = $reference;
  
       // Insert data into the database
       $sql = "INSERT INTO item_invoice (Invoice_No, num, item_name, descript, REF, quantity, Unit_Price, gstPer, TotalPer) VALUES ('$INos', '$num', '$titles', '$description', '$reference', '$quantitys', '$prices', '$gsts', '$totalss')";
      
       if ($conn->query($sql) !== true) {
            echo "Error: " . $sql . "<br>" . $conn->error;
       }
    }

     $sql2 = "INSERT INTO invoice (Inv_no, Total_Amount, Total_discount, Net, total_gst, Gross, REF) VALUES ('$INo','$Tamount','$Tdiscount','$Tnet','$Tgst','$Tgross', '$reference')";
    
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
      <p>INVOICE</p>
      <h style="font-size: 13px;"><b>INV NO:</b> '. $INo .'</p><br>
      
      <label >Date:</label> '. $Date .'<br>
      <label>Terms:</label> '. $Term .'<br>
      <label>Sales Per:</label> '. $SaleP .'<br>
      <label>P/O No:</label> '. $Pno .'<br>
      <label>L/O Date:</label> '. $Ldate .'<br>
      <label>Page:</label> '. $Pages .'
    </div>
</head>
<body>
  
  <div class="container">
    <img src="kyrol.png" alt="Image" style="height:60px; width:160px"> <br><br>
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
                <th>Name</th>
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
    <td  style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 13px;">'.$Tnet .'</td>
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
  
</tbody>
</table>
<p style="font-size: 13px;"><b>General Terms and Conditions</b></p>
<p style="font-size: 13px;">Payment Terms:</p>
<p style="font-size: 13px;">Cheque/EFT to MAYBANK 568603061668 KYROL Security Labs Sdn Bhd </p>
<br >
<br>
<br> 
<div class="containers" style="margin-left:0px; margin-right:230px;">
<p1>All cheque should be crossed & made payable to 
<br>"KYROL Security Labs Sdn Bhd"</p1>
<br><br>
<p1>..................................................</p1><br>
<p1>Company stamp signature</p1>
</div>

<div class="signbox">
<p1>For KYROL Security Labs Sdn Bhd</p1>
<br><br><br><br>
<p1>..................................................</p1><br>
<p1>Company stamp signature</p1>
</div>

<footer>

</footer>
    <style>
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    
    /*
     * -- BASE STYLES --
     * Most of these are inherited from Base, but I want to change a few.
     */
    body {
        line-height: 1.7em;
        color: #7f8c8d;
        font-size: 13px;
    }
    
    
    
    
    .pure-img-responsive {
        max-width: 100%;
        height: auto;
    }
    
    /*
     * -- LAYOUT STYLES --
     * These are some useful classes which I will need
     */
    .l-box {
        padding: 1em;
    }
    
    .l-box-lrg {
        padding: 2em;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }
    
    .is-center {
        text-align: center;
    }
    
    
    
    /*
     * -- PURE FORM STYLES --
     * Style the form inputs and labels
     */
    .pure-form label {
        margin: 1em 0 0;
        font-weight: bold;
        font-size: 100%;
    }
    
    .pure-form input[type] {
        border: 2px solid #ddd;
        box-shadow: none;
        font-size: 100%;
        width: 100%;
        margin-bottom: 1em;
    }
    
    /*
     * -- PURE BUTTON STYLES --
     * I want my pure-button elements to look a little different
     */
    .pure-button {
        background-color: #1f8dd6;
        color: white;
        padding: 0.5em 2em;
        border-radius: 5px;
    }
    
    a.pure-button-primary {
        background: white;
        color: #1f8dd6;
        border-radius: 5px;
        font-size: 120%;
    }
    
    
    /*
     * -- MENU STYLES --
     * I want to customize how my .pure-menu looks at the top of the page
     */
    
    .home-menu {
        padding: 0.5em;
        text-align: center;
        box-shadow: 0 1px 1px rgba(0,0,0, 0.10);
    }
    .home-menu {
        background: #2d3e50;
    }
    .pure-menu.pure-menu-fixed {
        /* Fixed menus normally have a border at the bottom. */
        border-bottom: none;
        /* I need a higher z-index here because of the scroll-over effect. */
        z-index: 4;
    }
    
    .home-menu .pure-menu-heading {
        color: white;
        font-weight: 400;
        font-size: 120%;
    }
    
    .home-menu .pure-menu-selected a {
        color: white;
    }
    
    .home-menu a {
        color: #6FBEF3;
    }
    .home-menu li a:hover,
    .home-menu li a:focus {
        background: none;
        border: none;
        color: #AECFE5;
    }
    
    
    /*
     * -- SPLASH STYLES --
     * This is the blue top section that appears on the page.
     */
    
    .splash-container {
        background: #1f8dd6;
        z-index: 1;
        overflow: hidden;
        /* The following styles are required for the "scroll-over" effect */
        width: 100%;
        height: 88%;
        top: 0;
        left: 0;
        position: fixed !important;
    }
    
    .splash {
        /* absolute center .splash within .splash-container */
        width: 80%;
        height: 50%;
        margin: auto;
        position: absolute;
        top: 100px; left: 0; bottom: 0; right: 0;
        text-align: center;
        text-transform: uppercase;
    }
    
    /* This is the main heading that appears on the blue section */
    .splash-head {
        font-size: 20px;
        font-weight: bold;
        color: white;
        border: 3px solid white;
        padding: 1em 1.6em;
        font-weight: 100;
        border-radius: 5px;
        line-height: 1em;
    }
    
    /* This is the subheading that appears on the blue section */
    .splash-subhead {
        color: white;
        letter-spacing: 0.05em;
        opacity: 0.8;
    }
    
    /*
     * -- CONTENT STYLES --
     * This represents the content area (everything below the blue section)
     */
    .content-wrapper {
        /* These styles are required for the "scroll-over" effect */
        position: absolute;
        top: 87%;
        width: 100%;
        min-height: 12%;
        z-index: 2;
        background: white;
    
    }
    
    /* We want to give the content area some more padding */
    .content {
        padding: 1em 1em 3em;
    }
    
    /* This is the class used for the main content headers (<h2>) */
    .content-head {
        font-weight: 400;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin: 2em 0 1em;
    }
    
    /* This is a modifier class used when the content-head is inside a ribbon */
    .content-head-ribbon {
        color: white;
    }
    
    /* This is the class used for the content sub-headers (<h3>) */
    .content-subhead {
        color: #1f8dd6;
    }
        .content-subhead i {
            margin-right: 7px;
        }
    
    /* This is the class used for the dark-background areas. */
    .ribbon {
        background: #2d3e50;
        color: #aaa;
    }
    
    /* This is the class used for the footer */
    .footer {
        background: #111;
        position: fixed;
        bottom: 0;
        width: 120%;
        color: white;
    }
    
        .header {
            padding: 50px;
            text-align: center;
            background-color: #474e5d;
            color: white;
          }
          
    h1{
        color: white;
    }
    
    /* styles.css */
    .dashboard {
        display: grid;
        place-items: center;
        height: 80vh; /* Set the height of the dashboard container as needed */
      }
      
      .button-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* Two columns */
        gap: 10px; /* Adjust the gap between buttons as needed */
        
      }
      
      .dashboard-button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #fff; /* White background */
        color: #007bff; /* Blue text color */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 0 0 2px #007bff; /* Add a subtle shadow and a 2px blue border to create a 3D look */
        transition: transform 0.2s ease-in-out;
        font-size: 20px;
        text-align: center;
      }
    
      .dashboard-button:hover {
        transform: translateY(-2px);}
      
      
      
    
    /*
     * -- TABLET (AND UP) MEDIA QUERIES --
     * On tablets and other medium-sized devices, we want to customize some
     * of the mobile styles.
     */
    @media (min-width: 48em) {
    
        /* We increase the body font size */
        body {
            font-size: 16px;
        }
    
        /* We can align the menu header to the left, but float the
        menu items to the right. */
        .home-menu {
            text-align: left;
        }
            .home-menu ul {
                float: right;
            }
    
        /* We increase the height of the splash-container */
    /*    .splash-container {
            height: 500px;
        }*/
    
        /* We decrease the width of the .splash, since we have more width
        to work with */
        .splash {
            width: 50%;
            height: 50%;
        }
    
        .splash-head {
            font-size: 250%;
        }
    
    
        /* We remove the border-separator assigned to .l-box-lrg */
        .l-box-lrg {
            border: none;
        }
    
        
    
    }
    
    /*
     * -- DESKTOP (AND UP) MEDIA QUERIES --
     * On desktops and other large devices, we want to over-ride some
     * of the mobile and tablet styles.
     */
    @media (min-width: 78em) {
        /* We increase the header font size even more */
        .splash-head {
            font-size: 300%;
        }
    
        
       
    }
    
    body {
        font-size: 10px;
        line-height: 1.5;
        color: #333;
        margin: 0;
        padding: 0;
      }
      
      h1, h2, h3 {
        font-weight: bold;
        margin: 60px 0;
      }
      
      p1 {
        margin: 5px 0;
        font-size: 13px;
      }
    
      
    
      label { font-size: 13px;}
      
      table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 10px;
        border-top: 1px solid black;
        
      }
      th, td {
        text-align: left;
        padding: 8px;
        
        
        
      }
      th {
        background-color: #f2f2f2;
        border-bottom: 1px solid black;
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
        width: 20%;
        height: auto;
        margin-top: 60px;
        flex: 1;
        object-position: top;
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
      
      
    
    
      .info {
        margin-bottom: 20px;
        float: right;
        text-align:justify ;
        font-size: 12px;
      }
      .info label {
        font-weight: bold;
        font-size: 14px;
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
        margin-right: 80px;
        font-size: 12px;
        font-weight: bold;
        margin-left: 100px;
    }
    
    .signbox{
        float: left;
        font-size: 11px;
        font-weight: bold;
    }
    
    p{
      font-size: 20px;
      margin: 5px 0;
    }
    
    b{
      font-size: 14px;
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
?>