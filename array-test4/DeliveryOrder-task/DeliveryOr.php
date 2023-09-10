<?php
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
} else {
    header("Location: ../login.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Process</title>
    <link rel="stylesheet" href="DeliveryOr.css">
    <link rel="icon" href="kyrol.png" sizes="40x40">
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
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">DELIVERY ORDER</p>
    </header>
    <div class="content">
    <div id="innercontent">
    <form action="DeliveryOr2.php" method="post">
        <div class="clientdetail">
            <h5>CLIENT'S DETAIL</h5>
                <table>
                    <tr>
                        <td><p>ATT:</p></td>
                        <td><p><input type="text" name="att" id="att" required></p></td>
                    </tr>
                    <tr>
                        <td><p>TEL:</p></td>
                        <td><p><input type="tel" name="tel" required></p></td>
                    </tr>
                    <tr>
                        <td><p>EMAIL:</p></td>
                        <td><p><input type="text" name="email" required></p></td>
                    </tr>
                    <tr>
                        <td><p>REF:</p></td>
                        <td><p><input type="text" name="reference" required></p></td>
                    </tr>
                </table>
        </div>
        <div class="clientdetail">
                <h5>DELIVERY ORDER'S DETAIL</h5>
                <table>
                    <tr>
                        <!-- NEW -->
                        <td><p>D.O No:</p></td>
                        <td><p><input type="number" name="DOn" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Date:</p></td>
                        <td><p><input type="date" name="Dates" required></p></td> 
                    </tr>
                    <tr>
                        <td><p>Terms:</p></td>
                        <td><p><input type="text" name="Terms" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Sales Per:</p></td>
                        <td><p><input type="text" name="SaleP" required></p></td>
                    </tr>
                    <tr>
                        <td><p>Inv No:</p></td>
                        <td><p><input type="number" name="INo" required></p></td>
                        <!-- NEW -->
                    </tr>
                    <tr>
                        <td><p>Pages:</p></td>
                        <td><p><input type="number" name="Pages" required></p></td>
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
