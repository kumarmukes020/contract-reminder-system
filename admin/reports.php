<?php
include '../config/db.php';

/*
|--------------------------------------------------------------------------
| TOTAL REPORTS
|--------------------------------------------------------------------------
*/

$total_contracts = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total
FROM contracts
"));

$total_active = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total
FROM contracts
WHERE end_date >= CURDATE()
"));

$total_expiring = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total
FROM contracts
WHERE DATEDIFF(end_date,CURDATE()) <= 30
AND end_date >= CURDATE()
"));

$total_overdue = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total
FROM contracts
WHERE end_date < CURDATE()
"));

/*
|--------------------------------------------------------------------------
| PROJECT WISE REPORT
|--------------------------------------------------------------------------
*/

$project_query = mysqli_query($conn,"

SELECT

project_hq,

COUNT(*) as total_contract,

SUM(
CASE
WHEN end_date < CURDATE()
THEN 1 ELSE 0
END
) as overdue,

SUM(
CASE
WHEN DATEDIFF(end_date,CURDATE()) <= 30
AND end_date >= CURDATE()
THEN 1 ELSE 0
END
) as expiring

FROM contracts

GROUP BY project_hq

ORDER BY total_contract DESC

");

?>

<!DOCTYPE html>
<html>
<head>

<title>Reports Dashboard</title>

<meta name="viewport"
content="width=device-width, initial-scale=1">

<!-- BOOTSTRAP -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<!-- ICONS -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
rel="stylesheet">

<!-- CHART -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
    background:#f1f5f9;
    font-size:14px;
    overflow-x:hidden;
}

/* MAIN */

.main{
    margin-left:270px;
    padding:20px;
}

/* TOPBAR */

.topbar{
    background:white;
    border-radius:15px;
    padding:18px 25px;
    margin-bottom:25px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* REPORT CARDS */

.report-card{
    border:none;
    border-radius:18px;
    overflow:hidden;
    color:white;
    position:relative;
    transition:0.3s;
}

.report-card:hover{
    transform:translateY(-5px);
}

.report-card i{
    position:absolute;
    right:20px;
    top:20px;
    font-size:50px;
    opacity:0.2;
}

/* BOX */

.chart-box,
.table-box{
    background:white;
    border-radius:15px;
    padding:20px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* TABLE */

.table th{
    background:#0f172a;
    color:white;
    vertical-align:middle;
}

.table td{
    vertical-align:middle;
}

/* BUTTON */

.btn{
    border-radius:10px;
}

</style>

</head>

<body>

<!-- SIDEBAR -->

<?php include 'sidebar.php'; ?>

<!-- MAIN -->

<div class="main">

<!-- TOPBAR -->

<div class="topbar d-flex justify-content-between align-items-center">

<div>

<h3 class="mb-0">
Reports Dashboard
</h3>

<small class="text-muted">
Contract analytics and summary reports
</small>

</div>

<div>

<a href="export_excel.php"
class="btn btn-success">

<i class="bi bi-file-earmark-excel"></i>

Excel Export

</a>

<a href="export_pdf.php"
class="btn btn-danger">

<i class="bi bi-file-earmark-pdf"></i>

PDF Export

</a>

</div>

</div>

<!-- SUMMARY CARDS -->

<div class="row g-4 mb-4">

<!-- TOTAL -->

<div class="col-md-3">

<div class="card report-card bg-primary">

<div class="card-body">

<h6>Total Contracts</h6>

<h2>
<?php echo $total_contracts['total']; ?>
</h2>

<i class="bi bi-folder-fill"></i>

</div>

</div>

</div>

<!-- ACTIVE -->

<div class="col-md-3">

<div class="card report-card bg-success">

<div class="card-body">

<h6>Active Contracts</h6>

<h2>
<?php echo $total_active['total']; ?>
</h2>

<i class="bi bi-check-circle-fill"></i>

</div>

</div>

</div>

<!-- EXPIRING -->

<div class="col-md-3">

<div class="card report-card bg-warning">

<div class="card-body">

<h6>Expiring Soon</h6>

<h2>
<?php echo $total_expiring['total']; ?>
</h2>

<i class="bi bi-bell-fill"></i>

</div>

</div>

</div>

<!-- OVERDUE -->

<div class="col-md-3">

<div class="card report-card bg-danger">

<div class="card-body">

<h6>Overdue</h6>

<h2>
<?php echo $total_overdue['total']; ?>
</h2>

<i class="bi bi-exclamation-triangle-fill"></i>

</div>

</div>

</div>

</div>

<!-- CHART + TABLE -->

<div class="row">

<!-- CHART -->

<div class="col-lg-6 mb-4">

<div class="chart-box">

<div class="d-flex justify-content-between align-items-center mb-3">

<h5 class="mb-0">
Project Wise Contracts
</h5>

<span class="badge bg-primary">
Analytics
</span>

</div>

<canvas id="projectChart"></canvas>

</div>

</div>

<!-- TABLE -->

<div class="col-lg-6 mb-4">

<div class="table-box">

<div class="d-flex justify-content-between align-items-center mb-3">

<h5 class="mb-0">
Project Summary
</h5>

<span class="badge bg-dark">

<?php echo $total_contracts['total']; ?>

Projects

</span>

</div>

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>Project</th>
<th>Total</th>
<th>Expiring</th>
<th>Overdue</th>

</tr>

</thead>

<tbody>

<?php

$chart_labels = [];
$chart_values = [];

while($project = mysqli_fetch_assoc($project_query))
{

$chart_labels[] = $project['project_hq'];

$chart_values[] = $project['total_contract'];

?>

<tr>

<td>

<?php echo $project['project_hq']; ?>

</td>

<td>

<span class="badge bg-primary">

<?php echo $project['total_contract']; ?>

</span>

</td>

<td>

<span class="badge bg-warning text-dark">

<?php echo $project['expiring']; ?>

</span>

</td>

<td>

<span class="badge bg-danger">

<?php echo $project['overdue']; ?>

</span>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

<!-- CHART JS -->

<script>

const ctx = document.getElementById('projectChart');

new Chart(ctx, {

type: 'bar',

data: {

labels: <?php echo json_encode($chart_labels); ?>,

datasets: [{

label: 'Contracts',

data: <?php echo json_encode($chart_values); ?>,

backgroundColor: [

'#2563eb',
'#16a34a',
'#dc2626',
'#f59e0b',
'#9333ea',
'#0891b2',
'#0ea5e9',
'#14b8a6'

],

borderRadius: 10

}]

},

options: {

responsive: true,

plugins: {

legend: {

display: false

}

},

scales: {

y: {

beginAtZero: true

}

}

}

});

</script>

</body>
</html>