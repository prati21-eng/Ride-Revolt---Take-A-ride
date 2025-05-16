<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_GET['eid'])) {
        $eid = intval($_GET['eid']);
        $sql = "SELECT tblusers.FullName, tblusers.EmailId, tblvehicles.VehiclesTitle, tblvehicles.Vimage1, tblbrands.BrandName, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.Status, tblbooking.PostingDate FROM tblbooking 
                JOIN tblvehicles ON tblvehicles.id = tblbooking.VehicleId 
                JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                JOIN tblusers ON tblusers.EmailId = tblbooking.userEmail 
                WHERE tblbooking.id = :eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':eid', $eid, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Booking Slip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
        }
        .vehicle-details {
            margin-bottom: 20px;
        }
        .vehicle-details img {
            width: 150px;
            height: 100px;
            border: 1px solid #ddd;
        }
        .vehicle-details div {
            display: inline-block;
            margin-left: 20px;
        }
        .status {
            padding: 10px;
            font-size: 16px;
            margin-top: 10px;
            text-align: center;
        }
        .confirmed {
            background-color: green;
            color: white;
        }
        .cancelled {
            background-color: red;
            color: white;
        }
        .not-confirmed {
            background-color: orange;
            color: white;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
        }
        .footer button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Booking Slip</h2>

    <div class="vehicle-details">
        <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="Vehicle Image">
        <div>
            <h3><?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->VehiclesTitle); ?></h3>
            <p><b>From Date:</b> <?php echo htmlentities($result->FromDate); ?></p>
            <p><b>To Date:</b> <?php echo htmlentities($result->ToDate); ?></p>
            <p><b>Message:</b> <?php echo htmlentities($result->message); ?></p>
            <p><b>Posting Date:</b> <?php echo htmlentities($result->PostingDate); ?></p>
        </div>
    </div>

    <div class="status">
        <?php if ($result->Status == 1) { ?>
            <span class="confirmed">Confirmed</span>
        <?php } elseif ($result->Status == 2) { ?>
            <span class="cancelled">Cancelled</span>
        <?php } else { ?>
            <span class="not-confirmed">Not Confirmed yet</span>
        <?php } ?>
    </div>

    <div class="footer">
        <button onclick="window.print();">Print Slip</button>
    </div>
</div>

</body>
</html>
