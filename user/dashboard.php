<?php

session_start();

include '../config/db.php';

/*
|--------------------------------------------------------------------------
| LOGIN CHECK
|--------------------------------------------------------------------------
*/

if(
!isset($_SESSION['user_id'])
||
$_SESSION['role'] != 'admin'
)
{
    header("Location: ../index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| AUTO LOGOUT AFTER 30 MINUTES
|--------------------------------------------------------------------------
*/

$inactive = 1800;

if(isset($_SESSION['timeout']))
{
    $session_life = time() - $_SESSION['timeout'];

    if($session_life > $inactive)
    {
        session_unset();

        session_destroy();

        header("Location: ../index.php?timeout=1");

        exit;
    }
}

$_SESSION['timeout'] = time();

/*
|--------------------------------------------------------------------------
| USER INFO
|--------------------------------------------------------------------------
*/

$user_department = mysqli_real_escape_string(
$conn,
$_SESSION['department']
);

/*
|--------------------------------------------------------------------------
| TOTAL CONTRACTS
|--------------------------------------------------------------------------
*/

$total_contracts_query = mysqli_query($conn,"

SELECT COUNT(*) as total
FROM contracts
WHERE eic_department='$user_department'

");

if(!$total_contracts_query)
{
    die(mysqli_error($conn));
}

$total_contracts = mysqli_fetch_assoc(
$total_contracts_query
);

/*
|--------------------------------------------------------------------------
| ACTIVE CONTRACTS
|--------------------------------------------------------------------------
*/

$active_contracts_query = mysqli_query($conn,"

SELECT COUNT(*) as total
FROM contracts
WHERE eic_department='$user_department'
AND end_date >= CURDATE()

");

if(!$active_contracts_query)
{
    die(mysqli_error($conn));
}

$active_contracts = mysqli_fetch_assoc(
$active_contracts_query
);

/*
|--------------------------------------------------------------------------
| EXPIRING CONTRACTS
|--------------------------------------------------------------------------
*/

$expiring_contracts_query = mysqli_query($conn,"

SELECT COUNT(*) as total
FROM contracts
WHERE eic_department='$user_department'
AND DATEDIFF(end_date,CURDATE()) <= 30
AND end_date >= CURDATE()

");

if(!$expiring_contracts_query)
{
    die(mysqli_error($conn));
}

$expiring_contracts = mysqli_fetch_assoc(
$expiring_contracts_query
);

/*
|--------------------------------------------------------------------------
| EXPIRED CONTRACTS
|--------------------------------------------------------------------------
*/

$expired_contracts_query = mysqli_query($conn,"

SELECT COUNT(*) as total
FROM contracts
WHERE eic_department='$user_department'
AND end_date < CURDATE()

");

if(!$expired_contracts_query)
{
    die(mysqli_error($conn));
}

$expired_contracts = mysqli_fetch_assoc(
$expired_contracts_query
);

/*
|--------------------------------------------------------------------------
| RECENT CONTRACTS
|--------------------------------------------------------------------------
*/

$contracts = mysqli_query($conn,"

SELECT *
FROM contracts
WHERE eic_department='$user_department'
ORDER BY end_date ASC
LIMIT 10

");

if(!$contracts)
{
    die(mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html>
<head>

<title>User Dashboard</title>

<meta name="viewport"
content="width=device-width, initial-scale=1">

<!-- BOOTSTRAP -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<!-- BOOTSTRAP ICON -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
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
border-radius:18px;
padding:20px 25px;
margin-bottom:25px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

/* DASHBOARD CARD */

.dashboard-card{
border:none;
border-radius:20px;
overflow:hidden;
color:white;
position:relative;
transition:0.3s;
box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

.dashboard-card:hover{
transform:translateY(-5px);
}

.dashboard-card i{
position:absolute;
right:20px;
top:20px;
font-size:55px;
opacity:0.2;
}

/* TABLE CARD */

.table-card{
background:white;
border-radius:18px;
padding:20px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
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

.badge-expiring{
background:#facc15;
color:black;
}

.badge-expired{
background:#dc2626;
}

.badge-active{
background:#16a34a;
}

/* TITLE */

.welcome-title{
font-weight:700;
color:#0f172a;
}

.department-text{
color:#64748b;
}

/* RESPONSIVE */

@media(max-width:768px)
{
.main{
margin-left:0;
padding:15px;
}
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

<h3 class="welcome-title mb-1">

Welcome,
<?php echo $_SESSION['name']; ?>

</h3>

<div class="department-text">

Department :
<?php echo $_SESSION['department']; ?>

</div>

</div>

<div>

<span class="badge bg-primary fs-6">

<i class="bi bi-calendar-event"></i>

<?php echo date('d M Y'); ?>

</span>

</div>

</div>

<!-- DASHBOARD CARDS -->

<div class="row g-4 mb-4">

<!-- TOTAL -->

<div class="col-md-3">

<div class="card dashboard-card bg-primary">

<div class="card-body">

<h6>Total Contracts</h6>

<h2>

<?php echo $total_contracts['total']; ?>

</h2>

<i class="bi bi-file-earmark-text"></i>

</div>

</div>

</div>

<!-- ACTIVE -->

<div class="col-md-3">

<div class="card dashboard-card bg-success">

<div class="card-body">

<h6>Active Contracts</h6>

<h2>

<?php echo $active_contracts['total']; ?>

</h2>

<i class="bi bi-check-circle-fill"></i>

</div>

</div>

</div>

<!-- EXPIRING -->

<div class="col-md-3">

<div class="card dashboard-card bg-warning">

<div class="card-body">

<h6>Expiring Soon</h6>

<h2>

<?php echo $expiring_contracts['total']; ?>

</h2>

<i class="bi bi-bell-fill"></i>

</div>

</div>

</div>

<!-- EXPIRED -->

<div class="col-md-3">

<div class="card dashboard-card bg-danger">

<div class="card-body">

<h6>Expired Contracts</h6>

<h2>

<?php echo $expired_contracts['total']; ?>

</h2>

<i class="bi bi-exclamation-triangle-fill"></i>

</div>

</div>

</div>

</div>

<!-- CONTRACT TABLE -->

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-3">

<div>

<h5 class="mb-0">

Recent Contracts

</h5>

<small class="text-muted">

Department Contract Records

</small>

</div>

</div>

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th>PO No</th>
<th>Project</th>
<th>Activity</th>
<th>Start Date</th>
<th>End Date</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

while($row=mysqli_fetch_assoc($contracts))
{

$today = strtotime(date('Y-m-d'));

$end = strtotime($row['end_date']);

$days = floor(($end - $today)/86400);

?>

<tr>

<td>

<?php echo $row['po_no']; ?>

</td>

<td>

<?php echo $row['project_hq']; ?>

</td>

<td>

<?php echo $row['activity_contract']; ?>

</td>

<td>

<?php echo date('d-m-Y',strtotime($row['start_date'])); ?>

</td>

<td>

<?php echo date('d-m-Y',strtotime($row['end_date'])); ?>

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

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>