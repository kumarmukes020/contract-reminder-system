<?php

session_start();

include '../config/db.php';

/*
|--------------------------------------------------------------------------
| LOGIN CHECK
|--------------------------------------------------------------------------
*/

if(!isset($_SESSION['user_id']))
{
    header("Location: ../index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| USER INFO
|--------------------------------------------------------------------------
*/

$user_department = $_SESSION['department'];

/*
|--------------------------------------------------------------------------
| FILTER
|--------------------------------------------------------------------------
*/

$from_date = isset($_GET['from_date'])
? $_GET['from_date']
: '';

$to_date = isset($_GET['to_date'])
? $_GET['to_date']
: '';

$where = "WHERE eic_name_dept='$user_department'";

if(!empty($from_date) && !empty($to_date))
{
    $where .= "
    AND end_date
    BETWEEN '$from_date'
    AND '$to_date'
    ";
}

/*
|--------------------------------------------------------------------------
| TOTAL COUNTS
|--------------------------------------------------------------------------
*/

$total = mysqli_fetch_assoc(mysqli_query($conn,"

SELECT COUNT(*) as total
FROM contracts
$where

"));

$active = mysqli_fetch_assoc(mysqli_query($conn,"

SELECT COUNT(*) as total
FROM contracts
$where
AND end_date >= CURDATE()

"));

$expiring = mysqli_fetch_assoc(mysqli_query($conn,"

SELECT COUNT(*) as total
FROM contracts
$where
AND DATEDIFF(end_date,CURDATE()) <= 30
AND end_date >= CURDATE()

"));

$expired = mysqli_fetch_assoc(mysqli_query($conn,"

SELECT COUNT(*) as total
FROM contracts
$where
AND end_date < CURDATE()

"));

?>

<!DOCTYPE html>
<html>
<head>

<title>User Reports</title>

<meta name="viewport"
content="width=device-width, initial-scale=1">

<!-- BOOTSTRAP -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<!-- ICON -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
rel="stylesheet">

<!-- DATATABLE -->

<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"
rel="stylesheet">

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
    padding:20px 25px;
    margin-bottom:25px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* CARD */

.report-card{
    border:none;
    border-radius:18px;
    color:white;
    transition:0.3s;
}

.report-card:hover{
    transform:translateY(-5px);
}

/* TABLE */

.table-card{
    background:white;
    border-radius:15px;
    padding:20px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.table th{
    background:#0f172a;
    color:white;
}

/* STATUS */

.badge-active{
    background:#16a34a;
}

.badge-expiring{
    background:#facc15;
    color:black;
}

.badge-expired{
    background:#dc2626;
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

Department Contract Reports

</small>

</div>

<div>

<span class="badge bg-primary fs-6">

<?php echo date('d M Y'); ?>

</span>

</div>

</div>

<!-- FILTER -->

<div class="table-card mb-4">

<form method="GET">

<div class="row align-items-end">

<div class="col-md-4">

<label class="form-label">

From Date

</label>

<input type="date"
name="from_date"
value="<?php echo $from_date; ?>"
class="form-control">

</div>

<div class="col-md-4">

<label class="form-label">

To Date

</label>

<input type="date"
name="to_date"
value="<?php echo $to_date; ?>"
class="form-control">

</div>

<div class="col-md-4">

<button type="submit"
class="btn btn-primary">

<i class="bi bi-search"></i>

Filter

</button>

<a href="reports.php"
class="btn btn-secondary">

Reset

</a>

</div>

</div>

</form>

</div>

<!-- REPORT CARDS -->

<div class="row g-4 mb-4">

<!-- TOTAL -->

<div class="col-md-3">

<div class="card report-card bg-primary">

<div class="card-body">

<h6>Total Contracts</h6>

<h2>

<?php echo $total['total']; ?>

</h2>

</div>

</div>

</div>

<!-- ACTIVE -->

<div class="col-md-3">

<div class="card report-card bg-success">

<div class="card-body">

<h6>Active</h6>

<h2>

<?php echo $active['total']; ?>

</h2>

</div>

</div>

</div>

<!-- EXPIRING -->

<div class="col-md-3">

<div class="card report-card bg-warning">

<div class="card-body">

<h6>Expiring</h6>

<h2>

<?php echo $expiring['total']; ?>

</h2>

</div>

</div>

</div>

<!-- EXPIRED -->

<div class="col-md-3">

<div class="card report-card bg-danger">

<div class="card-body">

<h6>Expired</h6>

<h2>

<?php echo $expired['total']; ?>

</h2>

</div>

</div>

</div>

</div>

<!-- TABLE -->

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-3">

<div>

<h5 class="mb-0">

Contract Report

</h5>

<small class="text-muted">

Department-wise contract report

</small>

</div>

</div>

<div class="table-responsive">

<table id="reportTable"
class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th>SN</th>
<th>PO No</th>
<th>Project</th>
<th>Department</th>
<th>Start Date</th>
<th>End Date</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$query = mysqli_query($conn,"

SELECT *
FROM contracts
$where
ORDER BY end_date ASC

");

while($row=mysqli_fetch_assoc($query))
{

$today = strtotime(date('Y-m-d'));

$end = strtotime($row['end_date']);

$days = floor(($end - $today)/86400);

?>

<tr>

<td>

<?php echo $row['sn']; ?>

</td>

<td>

<?php echo $row['po_no']; ?>

</td>

<td>

<?php echo $row['project_hq']; ?>

</td>

<td>

<?php echo $row['eic_name_dept']; ?>

</td>

<td>

<?php

echo date(
'd-m-Y',
strtotime($row['start_date'])
);

?>

</td>

<td>

<?php

echo date(
'd-m-Y',
strtotime($row['end_date'])
);

?>

</td>

<td>

<?php

if($days < 0)
{
    echo "
    <span class='badge badge-expired'>
    Expired
    </span>
    ";
}
elseif($days <= 30)
{
    echo "
    <span class='badge badge-expiring'>
    Expiring
    </span>
    ";
}
else
{
    echo "
    <span class='badge badge-active'>
    Active
    </span>
    ";
}

?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<!-- JS -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>

$(document).ready(function(){

$('#reportTable').DataTable({

pageLength: 25,
responsive: true,
order: [[5, "asc"]]

});

});

</script>

</body>
</html>