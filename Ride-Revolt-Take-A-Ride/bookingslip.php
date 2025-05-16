<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['login'])) {
    header('location:index.php');
    exit();
}

$useremail = $_SESSION['login'];

// Fetch latest booking
$sql = "SELECT b.id, b.VehicleId, b.FromDate, b.ToDate, b.message, b.Status, b.PostingDate,
               v.VehiclesTitle, v.PricePerDay, v.ModelYear, v.SeatingCapacity, v.FuelType, v.Vimage1 as VehicleImage,
               u.FullName, u.ContactNo, u.Address
        FROM tblbooking b
        JOIN tblvehicles v ON v.id = b.VehicleId
        JOIN tblusers u ON u.EmailId = b.userEmail
        WHERE b.userEmail = :useremail
        ORDER BY b.id DESC
        LIMIT 1";

$query = $dbh->prepare($sql);
$query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

if (!$result) {
    echo "<h3 style='text-align:center; margin-top:50px;'>No booking found!</h3>";
    exit();
}

$fromDate = new DateTime($result->FromDate);
$toDate = new DateTime($result->ToDate);
$days = $fromDate->diff($toDate)->days + 1;
$total = $days * $result->PricePerDay;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ride Revolt – Booking Slip</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background: #f2f2f2;
            font-family: 'Segoe UI', sans-serif;
        }
        .invoice-box {
            background: white;
            max-width: 900px;
            margin: 40px auto;
            padding: 40px;
            border: 1px solid #eee;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }
        .header-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .header-title h2 {
            margin: 0;
            color: #2c3e50;
        }
        .header-title p {
            font-size: 14px;
            color: #777;
        }
        .section-title {
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
        }
        .info-table td {
            padding: 5px 10px;
        }
        .info-table tr td:first-child {
            font-weight: 600;
            color: #444;
            width: 180px;
        }
        .vehicle-image {
            width: 50%;
            max-height: 110px;
            /* object-fit: cover; */
            border-radius: 8px;
            margin-top: 10px;
        }
        .badge-status {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 0.9rem;
        }
        .pending { background: #f39c12; color: white; }
        .confirmed { background: #27ae60; color: white; }
        .cancelled { background: #e74c3c; color: white; }
        .summary {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
        }
        .buttons {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .btn {
            border-radius: 25px;
            padding: 10px 25px;
        }
        .footer-note {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="header-title">
        <h2>🛵 Ride Revolt – Take A Ride</h2>
        <p>Booking Slip / Invoice</p>
    </div>

    <table class="table info-table">
        <tr><td>Booking ID:</td><td>#<?php echo htmlentities($result->id); ?></td></tr>
        <tr><td>Booking Date:</td><td><?php echo htmlentities($result->PostingDate); ?></td></tr>
    </table>

    <div class="section-title">👤 Customer Details</div>
    <table class="table info-table">
        <tr><td>Full Name:</td><td><?php echo htmlentities($result->FullName); ?></td></tr>
        <tr><td>Email:</td><td><?php echo htmlentities($useremail); ?></td></tr>
        <tr><td>Contact:</td><td><?php echo htmlentities($result->ContactNo); ?></td></tr>
        <tr><td>Address:</td><td><?php echo htmlentities($result->Address); ?></td></tr>
    </table>

    <div class="section-title">🚗 Vehicle Details</div>
    <table class="table info-table">
        <tr><td>Title:</td><td><?php echo htmlentities($result->VehiclesTitle); ?></td></tr>
        <tr><td>Model Year:</td><td><?php echo htmlentities($result->ModelYear); ?></td></tr>
        <tr><td>Fuel Type:</td><td><?php echo htmlentities($result->FuelType); ?></td></tr>
        <tr><td>Seating Capacity:</td><td><?php echo htmlentities($result->SeatingCapacity); ?></td></tr>
        <tr><td>Price/Day:</td><td>₹<?php echo htmlentities($result->PricePerDay); ?></td></tr>
    </table>
    <img src="admin/img/vehicleimages/<?php echo htmlentities($result->VehicleImage); ?>" class="vehicle-image" alt="Vehicle Image">

    <div class="section-title">📅 Booking Duration</div>
    <table class="table info-table">
        <tr><td>From:</td><td><?php echo htmlentities($result->FromDate); ?></td></tr>
        <tr><td>To:</td><td><?php echo htmlentities($result->ToDate); ?></td></tr>
        <tr><td>Total Days:</td><td><?php echo $days; ?></td></tr>
        <tr><td>Status:</td><td>
            <?php
                if ($result->Status == 0) echo "<span class='badge-status pending'>Pending</span>";
                elseif ($result->Status == 1) echo "<span class='badge-status confirmed'>Confirmed</span>";
                else echo "<span class='badge-status cancelled'>Cancelled</span>";
            ?>
        </td></tr>
        <tr><td>Message:</td><td><?php echo htmlentities($result->message); ?></td></tr>
    </table>

    <div class="summary">
        <h5><strong>💰 Total Amount: ₹<?php echo number_format($total); ?></strong></h5>
        <small>(<?php echo $days; ?> Days × ₹<?php echo $result->PricePerDay; ?>)</small>
    </div>

    <div class="buttons">
        <a href="index.php" class="btn btn-secondary">🏠 Back to Home</a>
        <button onclick="window.print();" class="btn btn-primary">🖨️ Print Slip</button>
    </div>

    <div class="footer-note">
        Thank you for choosing Ride Revolt – Take A Ride! <br>
        Safe travels and see you again soon.
    </div>
</div>

</body>
</html>
