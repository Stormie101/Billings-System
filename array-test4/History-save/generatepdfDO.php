<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['DOn'])){
        $DOn = $_POST['DOn'];

        //mention database
        include 'db.php';
        
        // Use prepared statement to prevent SQL injection
        $sqlClient = $conn->prepare("SELECT att, tel, email, ref, DOn, Dates, Terms, SaleP, INo, Pages, compName, compStreet, compCity, compState, compPcode, username, W_DOn FROM client_delivery WHERE DOn = ?");
        $sqlClient->bind_param("s", $DOn);
        $sqlClient->execute();
        $resultClient = $sqlClient->get_result();

        if ($resultClient->num_rows > 0) {
            // Output data to the PDF
            $html = "<html><body>";

            while ($rowClient = $resultClient->fetch_assoc()) {
                $att = $rowClient["att"];
                $tel = $rowClient["tel"];
                $email = $rowClient["email"];
                $ref = $rowClient["ref"];

                $DOn = $rowClient["DOn"];
                $Dates = $rowClient["Dates"];
                $Terms = $rowClient["Terms"];
                $SaleP = $rowClient["SaleP"];
                $INo = $rowClient["INo"];
                $Pages = $rowClient["Pages"];

                $compName = $rowClient["compName"];
                $compStreet = $rowClient["compStreet"];
                $compCity = $rowClient["compCity"];
                $compState = $rowClient["compState"];
                $compPcode = $rowClient["compPcode"];
                $sets = $rowClient["W_DOn"];


                $html .= '<head>
                <link rel="stylesheet" type="text/css" href="style.css">
                <meta charset="UTF-8">
                <div class="info">
                  <br><br><br><br><br><br><br><br>
                  <p style="background-color:#203864; padding:3px 25px 3px 25px; border-bottom-left-radius: 5px; font-weight:normal;">DELIVERY ORDER</p>
                  <table style="border-color:white; margin-top:20px; margin-right:15px;">
                  <tr>
                    <td style="padding-right:20px; text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">DO NO</td>
                    <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">'. $sets .'</td>
                  </tr>
                  <tr>
                    <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">DATE</td>
                    <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; color:black;"> '. $Dates .'</td>
                  </tr>
                  <tr>
                    <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">TERMS</td>
                    <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; color:black;"> '. $Terms .'</td>
                  </tr>
                  <tr>
                    <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">SALES PER</td>
                    <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; color:black;"> '. $SaleP .'</td>
                  </tr>
                  <tr>
                    <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; font-weight:bold; color:black;">INV NO</td>
                    <td style="text-align:left; border: 1px solid white; line-height:7px; font-size:12px; color:black;"> '. $INo .'</td>
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
                            <th style="border-left:none; border-right:none; background-color:white; font-weight:normal; color:black; width:55px;">NO</th>
                            <th style="border-left:none; border-right:none; background-color:white; font-weight:normal; color:black; text-align:center;">DESCRIPTION</th>
                            <th style="border-left:none; border-right:none; background-color:white; font-weight:normal; color:black;">QTY</th>
                            <th style="border-left:none; border-right:none; background-color:white; font-weight:normal; color:black;">U.PRICE</th>
                            <th style="border-left:none; border-right:none; background-color:white; font-weight:normal; color:black;">GST</th>
                            <th style="border-left:none; border-right:none; background-color:white; font-weight:normal; color:black;">TOTAL</th>
                       </tr> 
                    </thead>
                    <tbody>';
            }

                        // Fetch data from the item_quotation table
                        $sqlItem = $conn->prepare("SELECT DO_No, num, descript, REF, quantity, Unit_Price, gstPer, TotalPer, W_do FROM item_delivery WHERE DO_No = ?");
                        $sqlItem->bind_param("s", $DOn);
                        $sqlItem->execute();
                        $resultItem = $sqlItem->get_result();
            
                        $itemNumber = 1; // Initialize item number
            
                        if ($resultItem->num_rows > 0) {
                            while ($rowItem = $resultItem->fetch_assoc()) {
                                $desc = $rowItem["descript"];
                                $quantity = $rowItem["quantity"];
                                $price = $rowItem["Unit_Price"];
                                $gst = $rowItem["gstPer"];
                                $totals = $rowItem["TotalPer"];
                        
                                $html .= "<tr>";
                                $html .= "<td style='border-left:none; border-right:none; background-color:white; color:black; border-bottom:none; border-top:none;'>$itemNumber</td>";
                                $html .= "<td style='border-left:none; border-right:none; background-color:white; color:black; border-bottom:none; border-top:none; text-align:left;'>". nl2br($desc) ."</td>";
                                $html .= "<td style='border-left:none; border-right:none; background-color:white; color:black; border-bottom:none; border-top:none; text-align:center;'>". $quantity ."</td>";
                                $html .= "<<td style='border-left:none; border-right:none; background-color:white; color:black; border-bottom:none; border-top:none;'></td>";
                                $html .= "<td style='border-left:none; border-right:none; background-color:#B8B8B8; color:black; border-bottom:none; border-top:none;'></td>";
                                $html .= "<td style='border-left:none; border-right:none; background-color:#B8B8B8; color:black; border-bottom:none; border-top:none;'></td>";
                                $html .= "</tr>"; 
                        
                                $itemNumber++; // Increment item number for the next iteration
                            }
                        } else {
                            $html .= "<p>No items found for QNo: " . $DOn . "</p>";
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
                  <tr>
                    <td colspan="4" style="border: none; "></td>
                    <td style="border: none; font-size: 12px; padding:0px; color:black;"><b>GROSS (RM)</b></td>
                    <td style="background-color: lightgray; border-color: black; border:1px solid black; font-size: 13px; padding:0px; color:black;"> - </td>
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
                    </style>
                    ';

            $html .= "</body></html>";
            
            $conn->close();

            // Load HTML into Dompdf
            $dompdf = new Dompdf(["chroot" => __DIR__]);
            $dompdf->loadHtml($html);

            // Set paper size and render PDF
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Output PDF
            $dompdf->stream("Delivery_Order.pdf", array("Attachment" => false));
        } else {
            echo "No data found in the table with Delivery Order: " . $DOn;
        }
    } else {
        echo "Delivery Number not set.";
    }
} else {
    echo "Invalid request.";
}
?>
