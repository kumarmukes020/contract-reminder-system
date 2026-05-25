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
| GET ID
|--------------------------------------------------------------------------
*/

$id = $_GET['id'];

/*
|--------------------------------------------------------------------------
| FETCH CONTRACT
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn,"

SELECT *
FROM contracts
WHERE id='$id'

");

$row = mysqli_fetch_assoc($query);

/*
|--------------------------------------------------------------------------
| UPDATE CONTRACT
|--------------------------------------------------------------------------
*/

if(isset($_POST['update']))
{

$project_hq = mysqli_real_escape_string(
$conn,
$_POST['project_hq']
);

$activity_contract = mysqli_real_escape_string(
$conn,
$_POST['activity_contract']
);

$mode_of_tendering = mysqli_real_escape_string(
$conn,
$_POST['mode_of_tendering']
);

$po_no = mysqli_real_escape_string(
$conn,
$_POST['po_no']
);

$eic_name = mysqli_real_escape_string(
$conn,
$_POST['eic_name']
);

$eic_department = mysqli_real_escape_string(
$conn,
$_POST['eic_department']
);

$eic_email = mysqli_real_escape_string(
$conn,
$_POST['eic_email']
);

$award_value = mysqli_real_escape_string(
$conn,
$_POST['award_value']
);

$start_date = $_POST['start_date'];

$contract_period_months = $_POST['contract_period_months'];

$end_date = $_POST['end_date'];

$po_extension_taken = mysqli_real_escape_string(
$conn,
$_POST['po_extension_taken']
);

$extended_end_date = !empty($_POST['extended_end_date'])
? $_POST['extended_end_date']
: NULL;

$new_pr_initiated = mysqli_real_escape_string(
$conn,
$_POST['new_pr_initiated']
);

$new_pr_no = mysqli_real_escape_string(
$conn,
$_POST['new_pr_no']
);

$remark = mysqli_real_escape_string(
$conn,
$_POST['remark']
);

$email = mysqli_real_escape_string(
$conn,
$_POST['email']
);

$status = mysqli_real_escape_string(
$conn,
$_POST['status']
);

/*
|--------------------------------------------------------------------------
| UPDATE QUERY
|--------------------------------------------------------------------------
*/

$update = mysqli_query($conn,"

UPDATE contracts

SET

project_hq='$project_hq',
activity_contract='$activity_contract',
mode_of_tendering='$mode_of_tendering',
po_no='$po_no',
eic_name='$eic_name',
eic_department='$eic_department',
eic_email='$eic_email',
award_value='$award_value',
start_date='$start_date',
contract_period_months='$contract_period_months',
end_date='$end_date',
po_extension_taken='$po_extension_taken',
extended_end_date=".($extended_end_date ? "'$extended_end_date'" : "NULL").",
new_pr_initiated='$new_pr_initiated',
new_pr_no='$new_pr_no',
remark='$remark',
email='$email',
status='$status'

WHERE id='$id'

");

if($update)
{
    header("Location: contracts.php?updated=1");
    exit;
}
else
{
    $error = "Failed To Update Contract";
}

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Contract</title>

<meta name="viewport"
content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
rel="stylesheet">

<style>

body{
background:#f1f5f9;
font-size:14px;
overflow-x:hidden;
}

.main{
margin-left:270px;
padding:20px;
}

.topbar{
background:white;
border-radius:15px;
padding:18px 25px;
margin-bottom:25px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.form-card{
background:white;
border-radius:15px;
padding:25px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.form-control,
.form-select{
border-radius:10px;
padding:10px 12px;
}

label{
font-weight:600;
margin-bottom:6px;
color:#334155;
}

.btn{
border-radius:10px;
padding:10px 20px;
}

</style>

</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="main">

<div class="topbar d-flex justify-content-between align-items-center">

<div>

<h3 class="mb-0">

Edit Contract

</h3>

<small class="text-muted">

Update contract details

</small>

</div>

<a href="contracts.php"
class="btn btn-dark">

<i class="bi bi-arrow-left"></i>

Back

</a>

</div>

<?php if(isset($error)) { ?>

<div class="alert alert-danger">

<?php echo $error; ?>

</div>

<?php } ?>

<div class="form-card">

<form method="POST">

<div class="row">

<!-- PROJECT -->

<div class="col-md-4 mb-3">

<label>Project Name</label>

<select name="project_hq"
class="form-select"
required>

<option value="">
Select Project
</option>

<?php

$project_query = mysqli_query($conn,"

SELECT *
FROM projects
WHERE status='Active'
ORDER BY project_name ASC

");

while($project=mysqli_fetch_assoc($project_query))
{

?>

<option value="<?php echo $project['project_name']; ?>"

<?php
if($row['project_hq']==$project['project_name'])
{
echo "selected";
}
?>

>

<?php echo $project['project_name']; ?>

</option>

<?php } ?>

</select>

</div>

<!-- TENDER -->

<div class="col-md-3 mb-3">

<label>Mode of Tendering</label>

<select name="mode_of_tendering"
class="form-select"
required>

<option value="OT"
<?php if($row['mode_of_tendering']=='OT') echo 'selected'; ?>>
OT
</option>

<option value="LT"
<?php if($row['mode_of_tendering']=='LT') echo 'selected'; ?>>
LT
</option>

<option value="ST"
<?php if($row['mode_of_tendering']=='ST') echo 'selected'; ?>>
ST
</option>

</select>

</div>

<!-- PO -->

<div class="col-md-3 mb-3">

<label>PO No</label>

<input type="text"
name="po_no"
class="form-control"
maxlength="10"
minlength="10"
pattern="[0-9]{10}"
value="<?php echo $row['po_no']; ?>"
required>

</div>

<!-- STATUS -->

<div class="col-md-2 mb-3">

<label>Status</label>

<select name="status"
class="form-select">

<option value="Active"
<?php if($row['status']=='Active') echo 'selected'; ?>>

Active

</option>

<option value="Closed"
<?php if($row['status']=='Closed') echo 'selected'; ?>>

Closed

</option>

</select>

</div>

<!-- ACTIVITY -->

<div class="col-md-12 mb-3">

<label>Activity / Contract</label>

<textarea name="activity_contract"
class="form-control"
rows="4"
required><?php echo $row['activity_contract']; ?></textarea>

</div>

<!-- EIC NAME -->

<div class="col-md-4 mb-3">

<label>EIC Name</label>

<input type="text"
name="eic_name"
class="form-control"
value="<?php echo $row['eic_name']; ?>"
required>

</div>

<!-- EIC DEPARTMENT -->

<div class="col-md-4 mb-3">

<label>EIC Department</label>

<input type="text"
name="eic_department"
class="form-control"
value="<?php echo $row['eic_department']; ?>"
required>

</div>

<!-- EIC EMAIL -->

<div class="col-md-4 mb-3">

<label>EIC Email</label>

<input type="email"
name="eic_email"
class="form-control"
value="<?php echo $row['eic_email']; ?>"
required>

</div>

<!-- REMINDER EMAIL -->

<div class="col-md-4 mb-3">

<label>Reminder Email</label>

<input type="email"
name="email"
class="form-control"
value="<?php echo $row['email']; ?>"
required>

</div>

<!-- VALUE -->

<div class="col-md-3 mb-3">

<label>Award Value</label>

<input type="text"
name="award_value"
class="form-control"
value="<?php echo $row['award_value']; ?>">

</div>

<!-- START DATE -->

<div class="col-md-3 mb-3">

<label>Start Date</label>

<input type="date"
name="start_date"
class="form-control"
value="<?php echo $row['start_date']; ?>"
required>

</div>

<!-- PERIOD -->

<div class="col-md-3 mb-3">

<label>Contract Period (Months)</label>

<input type="number"
name="contract_period_months"
class="form-control"
value="<?php echo $row['contract_period_months']; ?>">

</div>

<!-- END DATE -->

<div class="col-md-3 mb-3">

<label>End Date</label>

<input type="date"
name="end_date"
class="form-control"
value="<?php echo $row['end_date']; ?>"
required>

</div>

<!-- EXTENSION -->

<div class="col-md-3 mb-3">

<label>PO Extension Taken</label>

<select name="po_extension_taken"
id="po_extension_taken"
class="form-select">

<option value="N"
<?php if($row['po_extension_taken']=='N') echo 'selected'; ?>>
No
</option>

<option value="Y"
<?php if($row['po_extension_taken']=='Y') echo 'selected'; ?>>
Yes
</option>

</select>

</div>

<!-- EXTENDED DATE -->

<div class="col-md-3 mb-3">

<label>Extended End Date</label>

<input type="date"
name="extended_end_date"
id="extended_end_date"
class="form-control"
value="<?php echo $row['extended_end_date']; ?>">

</div>

<!-- NEW PR -->

<div class="col-md-3 mb-3">

<label>New PR Initiated</label>

<select name="new_pr_initiated"
id="new_pr_initiated"
class="form-select">

<option value="N"
<?php if($row['new_pr_initiated']=='N') echo 'selected'; ?>>
No
</option>

<option value="Y"
<?php if($row['new_pr_initiated']=='Y') echo 'selected'; ?>>
Yes
</option>

</select>

</div>

<!-- NEW PR NO -->

<div class="col-md-3 mb-3">

<label>New PR No</label>

<input type="text"
name="new_pr_no"
id="new_pr_no"
class="form-control"
value="<?php echo $row['new_pr_no']; ?>">

</div>

<!-- REMARK -->

<div class="col-md-12 mb-4">

<label>Remark</label>

<textarea name="remark"
class="form-control"
rows="4"><?php echo $row['remark']; ?></textarea>

</div>

<!-- BUTTON -->

<div class="col-md-12">

<button type="submit"
name="update"
class="btn btn-primary">

<i class="bi bi-save"></i>

Update Contract

</button>

<a href="contracts.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</div>

</form>

</div>

</div>

<script>

document
.getElementById('po_extension_taken')
.addEventListener('change', function(){

let extendedDate =
document.getElementById('extended_end_date');

if(this.value == 'Y')
{
extendedDate.disabled = false;
}
else
{
extendedDate.disabled = true;
extendedDate.value = '';
}

});

document
.getElementById('new_pr_initiated')
.addEventListener('change', function(){

let prNo =
document.getElementById('new_pr_no');

if(this.value == 'Y')
{
prNo.disabled = false;
}
else
{
prNo.disabled = true;
prNo.value = '';
}

});

</script>

</body>
</html>