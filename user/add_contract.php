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
| AUTO SN GENERATION
|--------------------------------------------------------------------------
*/

$sn_query = mysqli_query($conn,"
SELECT MAX(id) as max_id
FROM contracts
");

$sn_data = mysqli_fetch_assoc($sn_query);

$next_sn = $sn_data['max_id'] + 1;

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

$po_no = mysqli_real_escape_string(
$conn,
$_POST['po_no']
);

$activity_contract = mysqli_real_escape_string(
$conn,
$_POST['activity_contract']
);

$eic_name_dept = mysqli_real_escape_string(
$conn,
$_POST['eic_name_dept']
);

$start_date = mysqli_real_escape_string(
$conn,
$_POST['start_date']
);

$end_date = mysqli_real_escape_string(
$conn,
$_POST['end_date']
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
po_no,
activity_contract,
eic_name_dept,
start_date,
end_date,
email,
reminder_30_sent,
reminder_15_sent,
reminder_7_sent

)

VALUES(

'$sn',
'$project_hq',
'$po_no',
'$activity_contract',
'$eic_name_dept',
'$start_date',
'$end_date',
'$email',
0,
0,
0

)

");

if($insert)
{
    $success = "Contract Added Successfully";
}
else
{
    $error = "Failed to Add Contract";
}

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Add Contract</title>

<meta name="viewport"
content="width=device-width, initial-scale=1">

<!-- BOOTSTRAP -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<!-- ICONS -->

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
    border-radius:15px;
    padding:20px 25px;
    margin-bottom:25px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* FORM CARD */

.form-card{
    background:white;
    border-radius:15px;
    padding:30px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.form-label{
    font-weight:600;
}

textarea{
    resize:none;
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

Add Contract

</h3>

<small class="text-muted">

Create new contract reminder record

</small>

</div>

<a href="contracts.php"
class="btn btn-dark">

<i class="bi bi-arrow-left"></i>

Back

</a>

</div>

<!-- FORM -->

<div class="form-card">

<?php

if(isset($success))
{
    echo "

    <div class='alert alert-success'>

    <i class='bi bi-check-circle-fill'></i>

    ".$success."

    </div>

    ";
}

if(isset($error))
{
    echo "

    <div class='alert alert-danger'>

    <i class='bi bi-x-circle-fill'></i>

    ".$error."

    </div>

    ";
}

?>

<form method="POST">

<div class="row">

<!-- SN -->

<div class="col-md-3 mb-3">

<label class="form-label">

SN

</label>

<input type="text"
name="sn"
class="form-control"
value="<?php echo $next_sn; ?>"
readonly>

</div>

<!-- PROJECT HQ -->

<div class="col-md-9 mb-3">

<label class="form-label">

Project Name

</label>

<input type="text"
name="project_hq"
class="form-control"
required>

</div>

<!-- PO NO -->

<div class="col-md-6 mb-3">

<label class="form-label">

PO No

</label>

<input type="text"
name="po_no"
class="form-control"
required>

</div>

<!-- DEPARTMENT -->

<div class="col-md-6 mb-3">

<label class="form-label">

Department

</label>

<input type="text"
name="eic_name_dept"
class="form-control"
value="<?php echo $_SESSION['department']; ?>"
readonly>

</div>

<!-- START DATE -->

<div class="col-md-6 mb-3">

<label class="form-label">

Start Date

</label>

<input type="date"
name="start_date"
class="form-control"
required>

</div>

<!-- END DATE -->

<div class="col-md-6 mb-3">

<label class="form-label">

End Date

</label>

<input type="date"
name="end_date"
class="form-control"
required>

</div>

<!-- EMAIL -->

<div class="col-md-6 mb-3">

<label class="form-label">

Reminder Email

</label>

<input type="email"
name="email"
class="form-control"
required>

</div>

<!-- ACTIVITY -->

<div class="col-md-12 mb-3">

<label class="form-label">

Activity / Contract Details

</label>

<textarea
name="activity_contract"
class="form-control"
rows="5"
required></textarea>

</div>

</div>

<!-- BUTTON -->

<button type="submit"
name="submit"
class="btn btn-primary">

<i class="bi bi-check-circle"></i>

Save Contract

</button>

</form>

</div>

</div>

</body>
</html>