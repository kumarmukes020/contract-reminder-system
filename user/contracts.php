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

?>

<!DOCTYPE html>
<html>
<head>

<title>My Contracts</title>

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
    padding:20px 25px;
    margin-bottom:25px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* TABLE CARD */

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

My Contracts

</h3>

<small class="text-muted">

Department :
<?php echo $_SESSION['department']; ?>

</small>

</div>

<div>

<span class="badge bg-primary fs-6">

<i class="bi bi-calendar-event"></i>

<?php echo date('d M Y'); ?>

</span>

</div>

</div>

<!-- TABLE -->

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-3">

<div>

<h5 class="mb-0">

Contract Records

</h5>

<small class="text-muted">

Department-wise contract list

</small>

</div>

</div>

<div class="table-responsive">

<table id="contractsTable"
class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th>SN</th>
<th>PO No</th>
<th>Project HQ</th>
<th>Activity</th>
<th>Department</th>
<th>Start Date</th>
<th>End Date</th>
<th>Remaining Days</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$query = mysqli_query($conn,"

SELECT *
FROM contracts
WHERE eic_name_dept='$user_department'
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

<td style="min-width:250px;">

<?php echo $row['activity_contract']; ?>

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
    <span class='badge bg-danger'>
    Expired
    </span>
    ";
}
else
{
    echo "
    <span class='badge bg-primary'>
    ".$days." Days
    </span>
    ";
}

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