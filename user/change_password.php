<?php

session_start();

include '../config/db.php';

if(!isset($_SESSION['user_id']))
{
    header("Location: ../index.php");
    exit;
}

if(isset($_POST['change']))
{

$current = $_POST['current_password'];

$new = $_POST['new_password'];

$confirm = $_POST['confirm_password'];

$id = $_SESSION['user_id'];

$query = mysqli_query($conn,"
SELECT * FROM users
WHERE id='$id'
");

$user = mysqli_fetch_assoc($query);

if(password_verify($current,$user['password']))
{

    if($new == $confirm)
    {

        $new_password = password_hash(
        $new,
        PASSWORD_DEFAULT
        );

        mysqli_query($conn,"

        UPDATE users

        SET password='$new_password'

        WHERE id='$id'

        ");

        $success = "Password Changed Successfully";

    }
    else
    {
        $error = "New Password & Confirm Password Not Match";
    }

}
else
{
    $error = "Current Password Incorrect";
}

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Change Password</title>

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
}

.main{
margin-left:270px;
padding:20px;
}

.card-box{
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
max-width:600px;
}

</style>

</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="main">

<div class="card-box">

<h3 class="mb-4">

<i class="bi bi-key"></i>

Change Password

</h3>

<?php

if(isset($success))
{
echo "<div class='alert alert-success'>$success</div>";
}

if(isset($error))
{
echo "<div class='alert alert-danger'>$error</div>";
}

?>

<form method="POST">

<div class="mb-3">

<label>Current Password</label>

<input type="password"
name="current_password"
class="form-control"
required>

</div>

<div class="mb-3">

<label>New Password</label>

<input type="password"
name="new_password"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Confirm Password</label>

<input type="password"
name="confirm_password"
class="form-control"
required>

</div>

<button type="submit"
name="change"
class="btn btn-primary">

<i class="bi bi-check-circle"></i>

Update Password

</button>

</form>

</div>

</div>

</body>
</html>