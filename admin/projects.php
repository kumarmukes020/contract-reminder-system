<?php

session_start();

include '../config/db.php';

if(!isset($_SESSION['user_id']))
{
    header("Location: ../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Projects Management</title>

<meta name="viewport"
content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
rel="stylesheet">

<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"
rel="stylesheet">

<style>

body{
background:#f1f5f9;
font-size:14px;
}

.main{
margin-left:270px;
padding:20px;
}

.card-box{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.table th{
background:#0f172a;
color:white;
}

</style>

</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="main">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h3>Projects Management</h3>

<small class="text-muted">
Manage project master data
</small>

</div>

<a href="add_project.php"
class="btn btn-primary">

<i class="bi bi-plus-circle"></i>

Add Project

</a>

</div>

<div class="card-box">

<table id="projectTable"
class="table table-bordered table-hover">

<thead>

<tr>

<th>ID</th>
<th>Project</th>
<th>Code</th>
<th>Location</th>
<th>Status</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php

$query = mysqli_query($conn,"
SELECT *
FROM projects
ORDER BY id DESC
");

while($row=mysqli_fetch_assoc($query))
{

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['project_name']; ?></td>

<td><?php echo $row['project_code']; ?></td>

<td><?php echo $row['project_location']; ?></td>

<td>

<?php

if($row['status']=='Active')
{
echo "<span class='badge bg-success'>Active</span>";
}
else
{
echo "<span class='badge bg-danger'>Inactive</span>";
}

?>

</td>

<td>

<a href="edit_project.php?id=<?php echo $row['id']; ?>"
class="btn btn-warning btn-sm">

<i class="bi bi-pencil"></i>

</a>

<a href="delete_project.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete Project?')">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>
<?php } ?>

</tbody>

</table>

</div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>

$(document).ready(function(){

$('#projectTable').DataTable();

});

</script>

</body>
</html>