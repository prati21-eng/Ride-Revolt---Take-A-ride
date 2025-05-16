<?php
// reports.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bikerental"; // your DB name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Fetch user list for dropdown
$userOptions = [];
$res = $conn->query("SELECT id, FullName FROM tblusers");
while ($row = $res->fetch_assoc()) {
    $userOptions[$row['id']] = $row['FullName'];
}

// Filters
$userId = isset($_GET['user_id']) ? $_GET['user_id'] : '';
$fromDate = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$toDate = isset($_GET['to_date']) ? $_GET['to_date'] : '';

$whereClause = "1=1";
if ($userId) $whereClause .= " AND bk.userEmail = (SELECT EmailId FROM tblusers WHERE id = $userId)";
if ($fromDate && $toDate) $whereClause .= " AND DATE(bk.PostingDate) BETWEEN '$fromDate' AND '$toDate'";

// Helper function to run and return chart data
function fetchData($conn, $sql, $mapFunc) {
    $res = $conn->query($sql);
    $data = [];
    while ($row = $res->fetch_assoc()) $data[] = $mapFunc($row);
    return $data;
}

// PIE Chart (Brand bookings this month)
$currMonth = date('m');
$currYear = date('Y');
$pieData = fetchData($conn, "
    SELECT b.BrandName, COUNT(*) AS TotalBookings
    FROM tblbooking bk
    JOIN tblvehicles v ON bk.VehicleId = v.id
    JOIN tblbrands b ON v.VehiclesBrand = b.id
    WHERE MONTH(bk.PostingDate) = $currMonth AND YEAR(bk.PostingDate) = $currYear AND $whereClause
    GROUP BY b.BrandName
", fn($r) => [$r['BrandName'], (int)$r['TotalBookings']]);

// Bar Chart (Total bookings by brand)
$barData = fetchData($conn, "
    SELECT b.BrandName, COUNT(*) AS TotalBookings
    FROM tblbooking bk
    JOIN tblvehicles v ON bk.VehicleId = v.id
    JOIN tblbrands b ON v.VehiclesBrand = b.id
    WHERE $whereClause
    GROUP BY b.BrandName
", fn($r) => [$r['BrandName'], (int)$r['TotalBookings']]);

// Line Chart (Daily bookings this month)
$lineData = fetchData($conn, "
    SELECT DATE(bk.PostingDate) as DateOnly, COUNT(*) AS DailyBookings
    FROM tblbooking bk
    WHERE MONTH(bk.PostingDate) = $currMonth AND YEAR(bk.PostingDate) = $currYear AND $whereClause
    GROUP BY DATE(bk.PostingDate)
", fn($r) => [$r['DateOnly'], (int)$r['DailyBookings']]);

// Stacked Bar (Bookings per brand last 6 months)
$stackedData = [];
$brandList = [];
$monthMap = [];
$res = $conn->query("
    SELECT b.BrandName, DATE_FORMAT(bk.PostingDate, '%Y-%m') as Month, COUNT(*) AS Bookings
    FROM tblbooking bk
    JOIN tblvehicles v ON bk.VehicleId = v.id
    JOIN tblbrands b ON v.VehiclesBrand = b.id
    WHERE bk.PostingDate >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND $whereClause
    GROUP BY b.BrandName, Month
");
while ($row = $res->fetch_assoc()) {
    $monthMap[$row['Month']][$row['BrandName']] = (int)$row['Bookings'];
    if (!in_array($row['BrandName'], $brandList)) $brandList[] = $row['BrandName'];
}
$stackedChartHeader = array_merge(['Month'], $brandList);
foreach ($monthMap as $month => $data) {
    $row = [$month];
    foreach ($brandList as $brand) {
        $row[] = isset($data[$brand]) ? $data[$brand] : 0;
    }
    $stackedData[] = $row;
}

// Area Chart (Monthly trend)
$areaData = fetchData($conn, "
    SELECT DATE_FORMAT(PostingDate, '%Y-%m') as Month, COUNT(*) as Total
    FROM tblbooking bk
    WHERE $whereClause
    GROUP BY Month
    ORDER BY Month ASC
", fn($r) => [$r['Month'], (int)$r['Total']]);

// Combo Chart (Brand bookings vs avg)
$comboData = [];
$res = $conn->query("
    SELECT b.BrandName, COUNT(*) AS TotalBookings
    FROM tblbooking bk
    JOIN tblvehicles v ON bk.VehicleId = v.id
    JOIN tblbrands b ON v.VehiclesBrand = b.id
    WHERE $whereClause
    GROUP BY b.BrandName
");
$total = 0; $count = 0;
while ($r = $res->fetch_assoc()) {
    $comboData[] = [$r['BrandName'], (int)$r['TotalBookings']];
    $total += $r['TotalBookings'];
    $count++;
}
$avg = $count ? round($total / $count) : 0;

// Top customers
$topUsers = fetchData($conn, "
    SELECT u.FullName, COUNT(*) as Bookings
    FROM tblbooking bk
    JOIN tblusers u ON bk.userEmail = u.EmailId
    WHERE $whereClause
    GROUP BY u.FullName
    ORDER BY Bookings DESC
    LIMIT 5
", fn($r) => $r);

// Top locations
$topCities = fetchData($conn, "
    SELECT u.City, COUNT(*) as Count
    FROM tblbooking bk
    JOIN tblusers u ON bk.userEmail = u.EmailId
    WHERE $whereClause
    GROUP BY u.City
    ORDER BY Count DESC
    LIMIT 5
", fn($r) => $r);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ride Revolt Reports Dashboard</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }
        body {
            background:rgb(187, 189, 192);
            padding: 30px;
            margin: 0;
            color: #333;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5em;
            color: #2c3e50;
        }
        h2 {
            margin-top: 60px;
            margin-bottom: 20px;
            color: #34495e;
        }

        .filter-box {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(125, 63, 63, 0.05);
            margin-bottom: 40px;
        }

        .filter-box label {
            margin-right: 10px;
            font-weight: 500;
        }

        .filter-box select,
        .filter-box input[type="date"],
        .filter-box input[type="submit"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-right: 15px;
            font-size: 14px;
        }

        .filter-box input[type="submit"] {
            background-color:rgb(14, 100, 158);
            color: #fff;
            border: none;
            transition: background 0.6s ease;
            cursor: pointer;
        }

        .filter-box input[type="submit"]:hover {
            background-color:rgb(25, 49, 66);
        }

        .chart-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            transition: transform 0.3s ease;
        }

        .chart-container:hover {
            transform: translateY(-9px);
            
        }

        .analytics-card {
            display: inline-block;
            vertical-align: top;
            background: #ffffff;
            border-left: 5px solid #3498db;
            padding: 20px 30px;
            margin: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            min-width: 250px;
        }

        .analytics-card strong {
            color: #2c3e50;
            font-size: 1.1em;
        }

        @media (max-width: 768px) {
            .analytics-card {
                display: block;
                width: 100%;
                margin: 15px 0;
            }
        }
    </style>
    <script>
        google.charts.load('current', {'packages':['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawCharts);
        function drawCharts() {
            drawChart('pieChart', 'Most Booked Brands (This Month)', ['Brand', 'Bookings'], <?php echo json_encode($pieData); ?>, 'PieChart');
            drawChart('barChart', 'Total Bookings by Brand', ['Brand', 'Bookings'], <?php echo json_encode($barData); ?>, 'BarChart');
            drawChart('lineChart', 'Daily Bookings (Current Month)', ['Date', 'Bookings'], <?php echo json_encode($lineData); ?>, 'LineChart');
            drawChart('areaChart', 'Monthly Booking Trend', ['Month', 'Bookings'], <?php echo json_encode($areaData); ?>, 'AreaChart');
            drawStacked();
            drawCombo();
        }
        function drawChart(container, title, header, dataArray, type) {
            var data = google.visualization.arrayToDataTable([header, ...dataArray]);
            var chart;
            var options = { title: title, legend: { position: 'bottom' } };
            if (type === 'PieChart') options.pieHole = 0.4;
            if (type === 'BarChart') options.chartArea = {width: '60%'};
            chart = new google.visualization[type](document.getElementById(container));
            chart.draw(data, options);
        }
        function drawStacked() {
            var data = google.visualization.arrayToDataTable([<?php echo json_encode($stackedChartHeader); ?>, <?php foreach($stackedData as $row) echo json_encode($row) . ","; ?>]);
            var options = { title: 'Monthly Brand-wise Bookings (Stacked)', isStacked: true };
            new google.visualization.BarChart(document.getElementById('stackedBarChart')).draw(data, options);
        }
        function drawCombo() {
            var data = google.visualization.arrayToDataTable([
                ['Brand', 'Bookings', 'Average'],
                <?php foreach($comboData as $d) echo "['$d[0]', $d[1], $avg],"; ?>
            ]);
            var options = {
                title : 'Brand Bookings vs Average',
                vAxis: {title: 'Bookings'}, hAxis: {title: 'Brand'},
                seriesType: 'bars', series: {1: {type: 'line'}}
            };
            new google.visualization.ComboChart(document.getElementById('comboChart')).draw(data, options);
        }
    </script>
</head>
<body>

<h1>📊 Ride Revolt Reports Dashboard</h1>

<!-- Filters -->
<div class="filter-box">
    <form method="GET">
        <label>User:</label>
        <select name="user_id">
            <option value="">All Users</option>
            <?php foreach($userOptions as $id => $name): ?>
                <option value="<?= $id ?>" <?= ($userId == $id) ? 'selected' : '' ?>><?= $name ?></option>
            <?php endforeach; ?>
        </select>
        <label>From:</label>
        <input type="date" name="from_date" value="<?= $fromDate ?>">
        <label>To:</label>
        <input type="date" name="to_date" value="<?= $toDate ?>">
        <input type="submit" value="Filter">
    </form>
</div>

<!-- Charts -->
<div class="chart-container" id="pieChart" style="height: 400px;"></div>
<div class="chart-container" id="barChart" style="height: 400px;"></div>
<div class="chart-container" id="lineChart" style="height: 400px;"></div>
<div class="chart-container" id="stackedBarChart" style="height: 400px;"></div>
<div class="chart-container" id="areaChart" style="height: 400px;"></div>
<div class="chart-container" id="comboChart" style="height: 400px;"></div>

<!-- Analytics Cards -->
<h2>📈 User Analytics</h2>
<div class="analytics-card">
    <strong>Top Customers:</strong><br>
    <?php foreach ($topUsers as $u) echo $u['FullName'] . " ({$u['Bookings']} bookings)<br>"; ?>
</div>

<div class="analytics-card">
    <strong>Top Cities:</strong><br>
    <?php foreach ($topCities as $c) echo $c['City'] . " ({$c['Count']} bookings)<br>"; ?>
</div>

</body>
</html>
