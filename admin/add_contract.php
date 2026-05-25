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
| AUTO GENERATE SN
|--------------------------------------------------------------------------
*/

$sn_query = mysqli_query($conn,"
SELECT MAX(sn) as max_sn
FROM contracts
");

$sn_data = mysqli_fetch_assoc($sn_query);

$next_sn = $sn_data['max_sn'] + 1;

if(empty($next_sn))
{
    $next_sn = 1;
}

/*
|--------------------------------------------------------------------------
| INSERT CONTRACT
|--------------------------------------------------------------------------
*/

if(isset($_POST['submit']))
{

    $sn = mysqli_real_escape_string(
    $conn,
    $_POST['sn']
    );

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

    /*
    |--------------------------------------------------------------------------
    | EIC DETAILS
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | OTHER DETAILS
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | INSERT QUERY
    |--------------------------------------------------------------------------
    */

    $insert = mysqli_query($conn,"

    INSERT INTO contracts(

    sn,
    project_hq,
    activity_contract,
    mode_of_tendering,
    po_no,
    eic_name,
    eic_department,
    eic_email,
    award_value,
    start_date,
    contract_period_months,
    end_date,
    po_extension_taken,
    extended_end_date,
    new_pr_initiated,
    new_pr_no,
    remark,
    email,
    status,
    reminder_30_sent,
    reminder_15_sent,
    reminder_7_sent

    )

    VALUES(

    '$sn',
    '$project_hq',
    '$activity_contract',
    '$mode_of_tendering',
    '$po_no',
    '$eic_name',
    '$eic_department',
    '$eic_email',
    '$award_value',
    '$start_date',
    '$contract_period_months',
    '$end_date',
    '$po_extension_taken',
    ".($extended_end_date ? "'$extended_end_date'" : "NULL").",
    '$new_pr_initiated',
    '$new_pr_no',
    '$remark',
    '$email',
    'Active',
    0,
    0,
    0

    )

    ");

    if($insert)
    {
        header("Location: contracts.php?success=1");
        exit;
    }
    else
    {
        $error = "Failed To Save Contract";
    }

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Add Contract</title>

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

Add New Contract

</h3>

<small class="text-muted">

Create new contract entry

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

<!-- SN -->

<div class="col-md-2 mb-3">

<label>SN</label>

<input type="text"
class="form-control"
value="<?php echo $next_sn; ?>"
readonly>

<input type="hidden"
name="sn"
value="<?php echo $next_sn; ?>">

</div>

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

<option value="<?php echo $project['project_name']; ?>">

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

<option value="">
Select
</option>

<option value="OT">
OT
</option>

<option value="LT">
LT
</option>

<option value="ST">
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
placeholder="Enter 10 Digit PO Number"
maxlength="10"
minlength="10"
pattern="[0-9]{10}"
title="PO Number must be exactly 10 digits"
required>

</div>

<!-- ACTIVITY -->

<div class="col-md-12 mb-3">

<label>Activity / Contract</label>

<textarea name="activity_contract"
class="form-control"
rows="4"
required></textarea>

</div>

<!-- EIC NAME -->

<div class="col-md-4 mb-3">

<label>EIC Name</label>

<input type="text"
name="eic_name"
class="form-control"
placeholder="Enter EIC Name"
required>

</div>

<!-- EIC DEPARTMENT -->

<div class="col-md-4 mb-3">

<label>EIC Department</label>

<input type="text"
name="eic_department"
class="form-control"
placeholder="Enter Department Name"
required>

</div>

<!-- EIC EMAIL -->

<div class="col-md-4 mb-3">

<label>EIC Email</label>

<input type="email"
name="eic_email"
class="form-control"
placeholder="example@company.com"
pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
title="Enter valid email address"
required>

</div>

<!-- REMINDER EMAIL -->

<div class="col-md-4 mb-3">

<label>Reminder Email</label>

<input type="email"
name="email"
class="form-control"
placeholder="example@company.com"
pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
title="Enter valid email address"
required>

</div>

<!-- VALUE -->

<div class="col-md-3 mb-3">

<label>Award Value</label>

<input type="text"
name="award_value"
class="form-control">

</div>

<!-- START DATE -->

<div class="col-md-3 mb-3">

<label>Start Date</label>

<input type="date"
name="start_date"
class="form-control"
required>

</div>

<!-- PERIOD -->

<div class="col-md-3 mb-3">

<label>Contract Period (Months)</label>

<input type="number"
name="contract_period_months"
class="form-control">

</div>

<!-- END DATE -->

<div class="col-md-3 mb-3">

<label>End Date</label>

<input type="date"
name="end_date"
class="form-control"
required>

</div>

<!-- EXTENSION -->

<div class="col-md-3 mb-3">

<label>PO Extension Taken</label>

<select name="po_extension_taken"
id="po_extension_taken"
class="form-select">

<option value="N">
No
</option>

<option value="Y">
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
disabled>

</div>

<!-- NEW PR -->

<div class="col-md-3 mb-3">

<label>New PR Initiated</label>

<select name="new_pr_initiated"
id="new_pr_initiated"
class="form-select">

<option value="N">
No
</option>

<option value="Y">
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
disabled>

</div>

<!-- REMARK -->

<div class="col-md-12 mb-4">

<label>Remark</label>

<textarea name="remark"
class="form-control"
rows="4"></textarea>

</div>

<!-- BUTTON -->

<div class="col-md-12">

<button type="submit"
name="submit"
class="btn btn-primary">

<i class="bi bi-save"></i>

Save Contract

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

/*
|--------------------------------------------------------------------------
| EXTENDED DATE ENABLE
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| NEW PR ENABLE
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| PO VALIDATION
|--------------------------------------------------------------------------
*/

document.querySelector("form")
.addEventListener("submit", function(e){

let po = document.querySelector("[name='po_no']").value;

if(!/^\d{10}$/.test(po))
{
alert("PO Number must be exactly 10 digits");
e.preventDefault();
}

});

</script>

</body>
</html>