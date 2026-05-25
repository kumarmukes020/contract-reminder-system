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

$user_email = $_SESSION['email'];

$user_department = $_SESSION['department'];

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

/* CARD */

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

.badge-success{
    background:#16a34a;
}

.badge-failed{
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

Reminder Logs

</h3>

<small class="text-muted">

Department Reminder History

</small>

</div>

<div>

<span class="badge bg-primary fs-6">

<i class="bi bi-calendar-event"></i>

<?php echo date('d M Y'); ?>

</span>

</div>

</div>

<!-- TABLE CARD -->

<div class="table-card">

<div class="alert alert-info">

<b>User:</b>

<?php echo $_SESSION['name']; ?>

|

<b>Department:</b>

<?php echo $user_department; ?>

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
<th>Reminder Type</th>
<th>Status</th>
<th>Sent Date</th>

</tr>

</thead>

<tbody>

<?php

$query = mysqli_query($conn,"

SELECT *
FROM reminder_logs
WHERE email='$user_email'
ORDER BY id DESC

");

while($row=mysqli_fetch_assoc($query))
{

?>

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

<?php echo $row['reminder_type']; ?>

</td>

<td>

<?php

if($row['email_status']=='Sent')
{
    echo "
    <span class='badge badge-success'>
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
strtotime($row['created_at'])
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