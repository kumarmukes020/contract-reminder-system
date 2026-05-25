<?php

session_start();

include '../config/db.php';

/*
|--------------------------------------------------------------------------
| LOGIN CHECK
|--------------------------------------------------------------------------
*/

if(
!isset($_SESSION['user_id'])
||
(
$_SESSION['role'] != 'admin'
&&
$_SESSION['role'] != 'super_admin'
)
)
{
    header("Location: ../index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| ADD USER
|--------------------------------------------------------------------------
*/

if(isset($_POST['submit']))
{

$name = mysqli_real_escape_string(
$conn,
$_POST['name']
);

$email = mysqli_real_escape_string(
$conn,
$_POST['email']
);

$department = mysqli_real_escape_string(
$conn,
$_POST['department']
);

$role = mysqli_real_escape_string(
$conn,
$_POST['role']
);

$password = md5($_POST['password']);

/*
|--------------------------------------------------------------------------
| CHECK EMAIL
|--------------------------------------------------------------------------
*/

$check = mysqli_query($conn,"
SELECT *
FROM users
WHERE email='$email'
");

if(mysqli_num_rows($check)>0)
{
    $error = "Email already exists!";
}
else
{

    /*
    |--------------------------------------------------------------------------
    | INSERT USER
    |--------------------------------------------------------------------------
    */

    $insert = mysqli_query($conn,"

    INSERT INTO users(

    name,
    email,
    department,
    role,
    password,
    created_at

    )

    VALUES(

    '$name',
    '$email',
    '$department',
    '$role',
    '$password',
    NOW()

    )

    ");

    if($insert)
    {
        $success = "User Added Successfully";
    }
    else
    {
        $error = "Failed to add user!";
    }

}

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Add User</title>

<meta name="viewport"
content="width=device-width, initial-scale=1">

<!-- BOOTSTRAP -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<!-- ICON -->

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
padding:25px;
}

/* TOPBAR */

.topbar{
background:white;
padding:20px 25px;
border-radius:18px;
margin-bottom:25px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

/* FORM CARD */

.form-card{
background:white;
border-radius:20px;
padding:35px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

/* FORM LABEL */

.form-label{
font-weight:600;
color:#334155;
margin-bottom:8px;
}

/* INPUT */

.form-control,
.form-select{
height:50px;
border-radius:12px;
border:1px solid #cbd5e1;
}

.form-control:focus,
.form-select:focus{
box-shadow:none;
border-color:#2563eb;
}

/* BUTTON */

.btn-save{
background:#2563eb;
border:none;
height:50px;
padding:0 25px;
border-radius:12px;
font-weight:600;
transition:0.3s;
}

.btn-save:hover{
background:#1d4ed8;
transform:translateY(-2px);
}

/* BACK BUTTON */

.btn-back{
height:45px;
border-radius:12px;
padding:0 20px;
display:flex;
align-items:center;
gap:8px;
}

/* ALERT */

.alert{
border-radius:12px;
}

/* PAGE TITLE */

.page-title{
font-weight:700;
color:#0f172a;
}

.page-subtitle{
color:#64748b;
font-size:14px;
}

/* ICON BOX */

.icon-box{
width:65px;
height:65px;
background:#dbeafe;
border-radius:18px;
display:flex;
justify-content:center;
align-items:center;
margin-bottom:20px;
}

.icon-box i{
font-size:32px;
color:#2563eb;
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

<h3 class="page-title mb-1">

Add New User

</h3>

<div class="page-subtitle">

Create admin, super admin or department user

</div>

</div>

<a href="users.php"
class="btn btn-dark btn-back">

<i class="bi bi-arrow-left"></i>

Back

</a>

</div>

<!-- FORM CARD -->

<div class="form-card">

<div class="icon-box">

<i class="bi bi-person-plus-fill"></i>

</div>

<!-- SUCCESS -->

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

?>

<!-- ERROR -->

<?php

if(isset($error))
{
echo "

<div class='alert alert-danger'>

<i class='bi bi-exclamation-triangle-fill'></i>

".$error."

</div>

";
}

?>

<!-- FORM -->

<form method="POST">

<div class="row">

<!-- FULL NAME -->

<div class="col-md-6 mb-4">

<label class="form-label">

Full Name

</label>

<input type="text"
name="name"
class="form-control"
placeholder="Enter Full Name"
required>

</div>

<!-- EMAIL -->

<div class="col-md-6 mb-4">

<label class="form-label">

Email Address

</label>

<input type="email"
name="email"
class="form-control"
placeholder="Enter Email Address"
required>

</div>

<!-- DEPARTMENT -->

<div class="col-md-6 mb-4">

<label class="form-label">

Department

</label>

<input type="text"
name="department"
class="form-control"
placeholder="Enter Department"
required>

</div>

<!-- ROLE -->

<div class="col-md-6 mb-4">

<label class="form-label">

User Role

</label>

<select name="role"
class="form-select"
required>

<option value="">
Select Role
</option>

<option value="super_admin">
Super Admin
</option>

<option value="admin">
Admin
</option>

<option value="user">
User
</option>

</select>

</div>

<!-- PASSWORD -->

<div class="col-md-6 mb-4">

<label class="form-label">

Password

</label>

<input type="password"
name="password"
class="form-control"
placeholder="Enter Password"
required>

</div>

</div>

<!-- BUTTON -->

<button type="submit"
name="submit"
class="btn btn-save text-white">

<i class="bi bi-check-circle-fill"></i>

Save User

</button>

</form>

</div>

</div>

</body>
</html>