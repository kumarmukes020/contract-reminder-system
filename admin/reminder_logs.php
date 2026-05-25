<?php
include '../config/db.php';

/*
|--------------------------------------------------------------------------
| FETCH LOGS
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn,"
SELECT *
FROM reminder_logs
ORDER BY sent_date DESC
");

if(!$query)
{
    die("Query Failed : ".mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Reminder Logs</title>

<meta name="viewport"
content="width=device-width, initial-scale=1">

<!-- BOOTSTRAP -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<!-- BOOTSTRAP ICON -->

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

/* BADGES */

.badge-sent{
    background:#16a34a;
}

.badge-failed{
    background:#dc2626;
}

.badge-reminder{
    background:#facc15;
    color:black;
}

/* SUMMARY */

.summary-card{
    border:none;
    border-radius:18px;
    color:white;
    overflow:hidden;
    position:relative;
}

.summary-card i{
    position:absolute;
    right:20px;
    top:20px;
    font-size:45px;
    opacity:0.2;
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
Reminder Logs
</h3>

<small class="text-muted">
Reminder mail history and status
</small>

</div>

<a href="../cron/send_reminder.php"
target="_blank"
class="btn btn-primary">

<i class="bi bi-bell"></i>

Run Reminder

</a>

</div>

<!-- SUMMARY -->

<div class="row g-4 mb-4">

<?php

$total_logs = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM reminder_logs
"));

$total_sent = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM reminder_logs
WHERE email_status='Sent'
"));

$total_failed = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM reminder_logs
WHERE email_status='Failed'
"));

?>

<!-- TOTAL -->

<div class="col-md-4">

<div class="card summary-card bg-primary">

<div class="card-body">

<h6>Total Logs</h6>

<h2>
<?php echo $total_logs['total']; ?>
</h2>

<i class="bi bi-envelope-paper"></i>

</div>

</div>

</div>

<!-- SENT -->

<div class="col-md-4">

<div class="card summary-card bg-success">

<div class="card-body">

<h6>Mail Sent</h6>

<h2>
<?php echo $total_sent['total']; ?>
</h2>

<i class="bi bi-check-circle-fill"></i>

</div>

</div>

</div>

<!-- FAILED -->

<div class="col-md-4">

<div class="card summary-card bg-danger">

<div class="card-body">

<h6>Failed</h6>

<h2>
<?php echo $total_failed['total']; ?>
</h2>

<i class="bi bi-x-circle-fill"></i>

</div>

</div>

</div>

</div>

<!-- TABLE -->

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-3">

<div>

<h5 class="mb-0">
Reminder Mail Logs
</h5>

<small class="text-muted">
All reminder activity records
</small>

</div>

</div>

<div class="table-responsive">

<table id="logsTable"
class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th>ID</th>
<th>PO No</th>
<th>Project</th>
<th>Email</th>
<th>Reminder</th>
<th>Status</th>
<th>Sent Date</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($query)) { ?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>

<td>

<?php echo $row['po_no']; ?>

</td>

<td>

<?php echo $row['project_hq']; ?>

</td>

<td>

<?php echo $row['email']; ?>

</td>

<td>

<span class="badge badge-reminder">

<?php echo $row['reminder_type']; ?>

</span>

</td>

<td>

<?php

if($row['email_status']=="Sent")
{
    echo "
    <span class='badge badge-sent'>
    Sent
    </span>
    ";
}
else
{
    echo "
    <span class='badge badge-failed'>
    Failed
    </span>
    ";
}

?>

</td>

<td>

<?php

echo date(
'd-m-Y h:i A',
strtotime($row['sent_date'])
);

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

$('#logsTable').DataTable({

pageLength: 25,
responsive: true,
order: [[0, "desc"]]

});

});

</script>

</body>
</html>