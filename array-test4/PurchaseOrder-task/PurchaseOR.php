<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Process</title>
    <link rel="stylesheet" href="PurchaseOR.css">
</head>
<body>
    <ul>
        <li><a href="../index.html"><img src="../kyrol.png" alt=""></a></li>
        <li><a href="../index.html">HOME</a></li>
        <li><a href="news.asp">INVOICE</a></li>
        <li><a href="../quotation-task/quotation.php">QUOTATION</a></li>
        <li><a href="about.asp">P.O</a></li>
        <li><a href="about.asp">D.O</a></li>
    </ul>
    <header>
        <img src="../kyrol.png" alt="">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">PURCHASE ORDER</p>
    </header>
    <div class="content">
    <div id="innercontent">
    <form action="PurchaseOR2.php" method="post">
        <div class="clientdetail">
            <h5>CLIENT'S DETAIL</h5>
                <table>
                    <tr>
                        <td><p>PO NO:</p></td>
                        <td><p><input type="number" name="PO-NO" id="att" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Date</p></td>
                        <td><p><input type="date" name="Dates" required></p></td>
                    </tr>
                </table>
        </div>
        <div class="clientdetail">
                <h5>VENDOR ADDRESS</h5>
                <table>
                    <tr>
                        <td><p>Company:</p></td>
                        <td><p><input type="text" name="compName" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Street:</p></td>
                        <td><p><input type="text" name="compStreet" required></p></td>
                    </tr>
                    <tr>
                        <td><p>City:</p></td>
                        <td><p><input type="text" name="compCity" required></p></td>
                    </tr>
                    <tr>
                        <td><p>State:</p></td>
                        <td><p><input type="text" name="compState" required></p></td>
                    </tr>
                </table>
            </div>
        <div class="clientdetail">
                <h5>SHIPPING INFORMATION</h5>
                <table>
                    <tr>
                        <td><p>Requistioner:</p></td>
                        <td><p><input type="text" name="Req" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Ship VIA:</p></td>
                        <td><p><input type="text" name="ShipV" required></p></td> 
                    </tr>
                    <tr>
                        <td><p>F.O.B:</p></td>
                        <td><p><input type="text" name="Fob" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Shipping Terms:</p></td>
                        <td><p><input type="text" name="Sterm" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Shipping Date:</p></td>
                        <td><p><input type="date" name="Sdate" required></p></td>
                    </tr>
                </table>
            </div>
        
        <label>Enter the number of quotations (10 max):</label>
        <input type="number" name="numQuotations" min="1" max="10" style="width:500px;" required>
        <button type="submit">Proceed</button>
    </form>
    </div>
    </div>
    <footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>
</body>
</html>
