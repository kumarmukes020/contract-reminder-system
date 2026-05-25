<?php

session_start();

include '../config/db.php';

$id = $_GET['id'];

$query = mysqli_query($conn,"
SELECT *
FROM projects
WHERE id='$id'
");

$row = mysqli_fetch_assoc($query);

if(isset($_POST['update']))
{

$project_name = $_POST['project_name'];

$project_code = $_POST['project_code'];

$project_location = $_POST['project_location'];

$project_head = $_POST['project_head'];

$project_email = $_POST['project_email'];

$status = $_POST['status'];

mysqli_query($conn,"

UPDATE projects

SET

project_name='$project_name',
project_code='$project_code',
project_location='$project_location',
project_head='$project_head',
project_email='$project_email',
status='$status'

WHERE id='$id'

");

header("Location: projects.php");

exit;

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Project</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{
background:#f1f5f9;
}

.main{
margin-left:270px;
padding:20px;
}

.card-box{
background:white;
padding:25px;
border-radius:15px;
}

</style>

</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="main">

<div class="card-box">

<h3 class="mb-4">

Edit Project

</h3>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label>Project Name</label>

<input type="text"
name="project_name"
class="form-control"
value="<?php echo $row['project_name']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Project Code</label>

<input type="text"
name="project_code"
class="form-control"
value="<?php echo $row['project_code']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Project Location</label>

<input type="text"
name="project_location"
class="form-control"
value="<?php echo $row['project_location']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Project Head</label>

<input type="text"
name="project_head"
class="form-control"
value="<?php echo $row['project_head']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Project Email</label>

<input type="email"
name="project_email"
class="form-control"
value="<?php echo $row['project_email']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Status</label>

<select name="status"
class="form-select">

<option value="Active"
<?php if($row['status']=='Active') echo 'selected'; ?>>

Active

</option>

<option value="Inactive"
<?php if($row['status']=='Inactive') echo 'selected'; ?>>

Inactive

</option>

</select>

</div>

<div class="col-md-12">

<button type="submit"
name="update"
class="btn btn-primary">

Update Project

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