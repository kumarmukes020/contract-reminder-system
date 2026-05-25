<?php

session_start();

include '../config/db.php';

if(isset($_POST['submit']))
{

$project_name = mysqli_real_escape_string(
$conn,
$_POST['project_name']
);

$project_code = mysqli_real_escape_string(
$conn,
$_POST['project_code']
);

$project_location = mysqli_real_escape_string(
$conn,
$_POST['project_location']
);

$status = mysqli_real_escape_string(
$conn,
$_POST['status']
);

/*
|--------------------------------------------------------------------------
| INSERT PROJECT
|--------------------------------------------------------------------------
*/

mysqli_query($conn,"

INSERT INTO projects(

project_name,
project_code,
project_location,
status

)

VALUES(

'$project_name',
'$project_code',
'$project_location',
'$status'

)

");

/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

header("Location: projects.php");

exit;

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Add Project</title>

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

.card-box{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

label{
font-weight:600;
margin-bottom:6px;
}

.form-control,
.form-select{
border-radius:10px;
padding:10px 12px;
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

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h3>

Add Project

</h3>

<small class="text-muted">

Create new project master

</small>

</div>

<a href="projects.php"
class="btn btn-dark">

<i class="bi bi-arrow-left"></i>

Back

</a>

</div>

<div class="card-box">

<form method="POST">

<div class="row">

<!-- PROJECT NAME -->

<div class="col-md-6 mb-3">

<label>

Project Name

</label>

<input type="text"
name="project_name"
class="form-control"
required>

</div>

<!-- PROJECT CODE -->

<div class="col-md-6 mb-3">

<label>

Project Code

</label>

<input type="text"
name="project_code"
class="form-control">

</div>

<!-- LOCATION -->

<div class="col-md-6 mb-3">

<label>

Project Location

</label>

<input type="text"
name="project_location"
class="form-control">

</div>

<!-- STATUS -->

<div class="col-md-6 mb-3">

<label>

Status

</label>

<select name="status"
class="form-select">

<option value="Active">

Active

</option>

<option value="Inactive">

Inactive

</option>

</select>

</div>

<!-- BUTTON -->

<div class="col-md-12">

<button type="submit"
name="submit"
class="btn btn-primary">

<i class="bi bi-save"></i>

Save Project

</button>

<a href="projects.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</div>

</form>

</div>

</div>

</body>
</html>