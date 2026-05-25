<?php

session_start();

include 'config/db.php';

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

if(isset($_POST['login']))
{

$email = mysqli_real_escape_string(
$conn,
$_POST['email']
);

$password = $_POST['password'];

/*
|--------------------------------------------------------------------------
| CHECK USER
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn,"

SELECT *
FROM users
WHERE email='$email'

");

if(mysqli_num_rows($query)>0)
{

    $row = mysqli_fetch_assoc($query);

    /*
    |--------------------------------------------------------------------------
    | VERIFY PASSWORD
    |--------------------------------------------------------------------------
    */

    if(password_verify($password,$row['password']))
    {

        /*
        |--------------------------------------------------------------------------
        | SESSION
        |--------------------------------------------------------------------------
        */

        $_SESSION['user_id'] = $row['id'];

        $_SESSION['name'] = $row['name'];

        $_SESSION['email'] = $row['email'];

        $_SESSION['role'] = $row['role'];

        $_SESSION['department'] = $row['department'];

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        if($row['role']=='admin')
        {
            header("Location: admin/dashboard.php");
        }
        else
        {
            header("Location: user/dashboard.php");
        }

        exit;

    }
    else
    {
        $error = "Invalid Password!";
    }

}
else
{
    $error = "Email Not Found!";
}

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Contract Reminder System</title>

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
    background:linear-gradient(
    135deg,
    #0f172a,
    #1e293b
    );
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Arial;
}

/* LOGIN CARD */

.login-card{
    width:100%;
    max-width:420px;
    background:white;
    border-radius:20px;
    padding:40px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

/* LOGO */

.logo{
    text-align:center;
    margin-bottom:30px;
}

.logo i{
    font-size:60px;
    color:#2563eb;
}

.logo h2{
    margin-top:10px;
    font-weight:700;
    color:#0f172a;
}

/* FORM */

.form-control{
    height:50px;
    border-radius:12px;
}

.btn-login{
    height:50px;
    border-radius:12px;
    font-weight:600;
    font-size:16px;
}

.footer-text{
    text-align:center;
    margin-top:20px;
    color:#64748b;
    font-size:13px;
}

</style>

</head>

<body>

<!-- LOGIN CARD -->

<div class="login-card">

<!-- LOGO -->

<div class="logo">

<i class="bi bi-shield-lock-fill"></i>

<h2>

Contract Reminder System

</h2>

<p class="text-muted">

NML / NTPC Mail Reminder Portal

</p>

</div>

<!-- ERROR -->

<?php

if(isset($error))
{
    echo "

    <div class='alert alert-danger'>

    <i class='bi bi-exclamation-circle'></i>

    ".$error."

    </div>

    ";
}

?>

<!-- LOGIN FORM -->

<form method="POST">

<!-- EMAIL -->

<div class="mb-3">

<label class="form-label">

Email Address

</label>

<div class="input-group">

<span class="input-group-text">

<i class="bi bi-envelope"></i>

</span>

<input type="email"
name="email"
class="form-control"
placeholder="Enter Email"
required>

</div>

</div>

<!-- PASSWORD -->

<div class="mb-3">

<label class="form-label">

Password

</label>

<div class="input-group">

<span class="input-group-text">

<i class="bi bi-lock"></i>

</span>

<input type="password"
name="password"
class="form-control"
placeholder="Enter Password"
required>

</div>

</div>

<!-- BUTTON -->

<!-- BUTTONS -->

<div class="d-grid gap-3">

<!-- USER LOGIN -->

<button type="submit"
name="login"
class="btn btn-primary btn-login">

<i class="bi bi-box-arrow-in-right"></i>

User Login

</button>

<!-- SUPER ADMIN -->

<a href="login.php"
class="btn btn-dark btn-login">

<i class="bi bi-shield-lock-fill"></i>

Super Admin Login

</a>

</div>

</form>

<!-- FOOTER -->

<div class="footer-text">

© <?php echo date('Y'); ?>

NML Contract Reminder System

</div>

</div>

</body>
</html>