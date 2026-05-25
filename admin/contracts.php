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
| TOTAL COUNTS
|--------------------------------------------------------------------------
*/

$total = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM contracts
"));

$expiring = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM contracts
WHERE DATEDIFF(end_date,CURDATE()) <= 30
AND end_date >= CURDATE()
AND status!='Closed'
"));

$overdue = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM contracts
WHERE end_date < CURDATE()
AND status!='Closed'
"));

$active = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM contracts
WHERE status='Active'
"));

?>

<!DOCTYPE html>
<html>
<head>

<title>Contracts Management</title>

<meta name="viewport"
content="width=device-width, initial-scale=1">

<!-- BOOTSTRAP -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<!-- ICONS -->

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
padding:18px 25px;
margin-bottom:25px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* SUMMARY CARDS */

.card-box{
border:none;
border-radius:18px;
overflow:hidden;
color:white;
position:relative;
transition:0.3s;
}

.card-box:hover{
transform:translateY(-5px);
}

.card-box i{
position:absolute;
right:20px;
top:20px;
font-size:45px;
opacity:0.2;
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
vertical-align:middle;
}

.table td{
vertical-align:middle;
}

/* STATUS */

.badge-expire{
background:#facc15;
color:black;
}

.badge-overdue{
background:#dc2626;
}

.badge-active{
background:#16a34a;
}

.badge-closed{
background:#6b7280;
}

/* BUTTON */

.btn-action{
width:35px;
height:35px;
border-radius:8px;
display:inline-flex;
align-items:center;
justify-content:center;
}

.activity-box{
min-width:300px;
max-width:400px;
white-space:normal;
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

Contracts Management

</h3>

<small class="text-muted">

Manage all contracts and reminders

</small>

</div>

<a href="add_contract.php"
class="btn btn-primary">

<i class="bi bi-plus-circle"></i>

Add New Contract

</a>

</div>

<!-- SUMMARY -->

<div class="row g-4 mb-4">

<!-- TOTAL -->

<div class="col-md-3">

<div class="card card-box bg-primary">

<div class="card-body">

<h6>Total Contracts</h6>

<h2>

<?php echo $total['total']; ?>

</h2>

<i class="bi bi-folder-fill"></i>

</div>

</div>

</div>

<!-- EXPIRING -->

<div class="col-md-3">

<div class="card card-box bg-warning">

<div class="card-body">

<h6>Expiring Soon</h6>

<h2>

<?php echo $expiring['total']; ?>

</h2>

<i class="bi bi-bell-fill"></i>

</div>

</div>

</div>

<!-- OVERDUE -->

<div class="col-md-3">

<div class="card card-box bg-danger">

<div class="card-body">

<h6>Overdue</h6>

<h2>

<?php echo $overdue['total']; ?>

</h2>

<i class="bi bi-exclamation-triangle-fill"></i>

</div>

</div>

</div>

<!-- ACTIVE -->

<div class="col-md-3">

<div class="card card-box bg-success">

<div class="card-body">

<h6>Active Contracts</h6>

<h2>

<?php echo $active['total']; ?>

</h2>

<i class="bi bi-check-circle-fill"></i>

</div>

</div>

</div>

</div>

<!-- TABLE -->

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-3">

<div>

<h5 class="mb-0">

All Contracts

</h5>

<small class="text-muted">

Contract records list

</small>

</div>

</div>

<div class="table-responsive">

<table id="contractsTable"
class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th>SN</th>
<th>Project HQ</th>
<th>PO No</th>
<th>Activity</th>
<th>EIC Details</th>
<th>Start Date</th>
<th>End Date</th>
<th>Status</th>
<th>Email</th>
<th width="120">Action</th>

</tr>

</thead>

<tbody>

<?php

$query = mysqli_query($conn,"
SELECT *
FROM contracts
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

<?php echo $row['project_hq']; ?>

</td>

<td>

<?php echo $row['po_no']; ?>

</td>

<td class="activity-box">

<?php echo $row['activity_contract']; ?>

</td>

<td>

<b>

<?php echo isset($row['eic_name']) ? $row['eic_name'] : ''; ?>

</b>

<br>

<small class="text-muted">

<?php echo isset($row['eic_department']) ? $row['eic_department'] : ''; ?>

</small>

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

if($row['status']=='Closed')
{
echo "
<span class='badge badge-closed'>
Closed
</span>
";
}
elseif($days < 0)
{
echo "
<span class='badge badge-overdue'>
Overdue
</span>
";
}
elseif($days <= 30)
{
echo "
<span class='badge badge-expire'>
Expiring Soon
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

<td>

<?php echo $row['email']; ?>

</td>

<td>

<a href="edit_contract.php?id=<?php echo $row['id']; ?>"
class="btn btn-warning btn-sm btn-action">

<i class="bi bi-pencil"></i>

</a>

<a href="delete_contract.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm btn-action"
onclick="return confirm('Delete Contract?')">

<i class="bi bi-trash"></i>

</a>

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

$('#contractsTable').DataTable({

pageLength: 25,
responsive: true,
order: [[6, "asc"]]

});

});

</script>

</body>
</html>