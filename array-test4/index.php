<?php
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
} else {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Billing System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="index.css">
  <link rel="icon" href="kyrol.png" sizes="40x40">
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      
    }

    h1{
      color: white;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 500px;
      display: none;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }

    .centered {
  display: flex;
}

.centered-dashboard {
  display: flex;
  justify-content: center;
  align-items: center;
  
}


.dashboard {
    display: grid;
    place-items: center;
    height: 80vh; /* Set the height of the dashboard container as needed */
    justify-content: center;
  align-items: center;
  }
  
  .button-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Two columns */
    gap: 10px; /* Adjust the gap between buttons as needed */
  }
  
  .dashboard-button {
    padding: 40px 10px;
    font-size: 16px;
    background-color: rgb(231, 229, 229); /* White background */
    color: black; /* Blue text color */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 0 0 2px grey; /* Add a subtle shadow and a 2px blue border to create a 3D look */
    transition: transform 0.2s ease-in-out;
    font-size: 20px;
    text-align: center;
  }
  .button-container a:hover{
    color: darkcyan;
  }
  .dashboard-button:hover {
    transform: translateY(-2px);
  }

  .footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px 0;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
}

  </style>

  
</head>
<body>


<div class="header">
  <img src="kyrol.png" width="450px" height="150px">
    <h1>KYROL SECURITY LABS</h1>
    <p>BILLING SYSTEM 0.2</p>
  </div>

<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      
    </div>
    <div class="col-sm-8 text-left" style="margin: 0px 300px 0px 300px;"> 

      <h2>Welcome, <?php echo $username; ?></h2> <a href="logout.php" id="log-out">Log-out</a>
      <hr>
    <br><br><br>
    
      <div class="button-container">
        <!-- Add an anchor tag around each button with the link you want to redirect to -->
        <a href="invoice-task/invoice.php" class="dashboard-button" style="text-decoration: none;"> INVOICE
        </a>

        <a href="quotation-task/quotation.php" class="dashboard-button" style="text-decoration: none;" > QUOTATION
        </a>

        <a href="PurchaseOrder-task/PurchaseOR.php" class="dashboard-button" style="text-decoration: none;" > PURCHASE ORDER
        </a>

        <a href="DeliveryOrder-task/DeliveryOr.php" class="dashboard-button" style="text-decoration: none;" > DELIVERY ORDER
        </a>

        <a href="CNC.php" class="dashboard-button" style="text-decoration: none;" > COMPANY / CLIENT
        </a>
      </div>
    </div>
    </div>
    <br><br>

    <footer class="footer">
        <div class="footer-content">
            <p>Copyright ©️ 2023 KYROL Security Labs Sdn Bhd</p>
        </div>
    </footer>

</body>
</html>


