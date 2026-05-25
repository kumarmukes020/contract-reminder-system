<?php

include '../config/db.php';

/*
|--------------------------------------------------------------------------
| DELETE USER
|--------------------------------------------------------------------------
*/

if(isset($_GET['delete']))
{

$id = $_GET['delete'];

mysqli_query($conn,"
DELETE FROM users
WHERE id='$id'
");

header("Location: users.php");

exit;

}

?>

<!DOCTYPE html>
<html>
<head>

<title>User Management</title>

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
    padding:18px 25px;
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

/* TABLE */

.table th{
    background:#0f172a;
    color:white;
    vertical-align:middle;
}

.table td{
    vertical-align:middle;
}

/* BADGES */

.badge-admin{
    background:#dc2626;
}

.badge-user{
    background:#16a34a;
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

User Management

</h3>

<small class="text-muted">

Manage system users and department access

</small>

</div>

<a href="add_user.php"
class="btn btn-primary">

<i class="bi bi-plus-circle"></i>

Add User

</a>

</div>

<!-- TABLE -->

<div class="table-card">

<div class="table-responsive">

<table id="usersTable"
class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Department</th>
<th>Role</th>
<th>Created</th>
<th width="120">Action</th>

</tr>

</thead>

<tbody>

<?php

$query = mysqli_query($conn,"
SELECT *
FROM users
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

<?php echo $row['name']; ?>

</td>

<td>

<?php echo $row['email']; ?>

</td>

<td>

<?php echo $row['department']; ?>

</td>

<td>

<?php

if($row['role']=='admin')
{
    echo "
    <span class='badge badge-admin'>
    Admin
    </span>
    ";
}
else
{
    echo "
    <span class='badge badge-user'>
    User
    </span>
    ";
}

?>

</td>

<td>

<?php

echo date(
'd-m-Y',
strtotime($row['created_at'])
);

?>

</td>

<td>

<a href="edit_user.php?id=<?php echo $row['id']; ?>"
class="btn btn-warning btn-sm">

<i class="bi bi-pencil"></i>

</a>

<a href="users.php?delete=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete User?')">

<i class="bi bi-trash"></i>

</a>

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

$('#usersTable').DataTable({

pageLength: 25,
responsive: true,
order: [[0, "desc"]]

});

});

</script>

</body>
</html>