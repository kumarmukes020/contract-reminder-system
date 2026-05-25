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

$password = md5($_POST['password']);

$query = mysqli_query($conn,"

SELECT *
FROM users
WHERE email='$email'
AND password='$password'

");

if(mysqli_num_rows($query)>0)
{

$user = mysqli_fetch_assoc($query);

$_SESSION['user_id'] = $user['id'];

$_SESSION['name'] = $user['name'];

$_SESSION['role'] = $user['role'];

$_SESSION['department'] = $user['department'];

$_SESSION['timeout'] = time();

/*
|--------------------------------------------------------------------------
| ROLE BASED REDIRECT
|--------------------------------------------------------------------------
*/

if($user['role']=='super_admin')
{
    header("Location: admin/dashboard.php");
}
elseif($user['role']=='admin')
{
    header("Location: user/dashboard.php");
}
elseif($user['role']=='user')
{
    header("Location: dashboard.php");
}
else
{
    session_destroy();

    header("Location: index.php");
}

exit;

}
else
{
$error = "Invalid Email or Password!";
}

}

?>

<!DOCTYPE html>
<html>
<head>

<title>NML Contract Reminder System</title>

<meta name="viewport"
content="width=device-width, initial-scale=1">

<!-- BOOTSTRAP -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<!-- ICON -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:Arial, Helvetica, sans-serif;
height:100vh;
overflow:hidden;
background:linear-gradient(
135deg,
#0f172a,
#1d4ed8,
#2563eb
);
position:relative;
}

/* ANIMATED BACKGROUND */

.bg-circle{
position:absolute;
border-radius:50%;
background:rgba(255,255,255,0.08);
animation:float 6s infinite ease-in-out;
}

.circle1{
width:300px;
height:300px;
top:-100px;
left:-80px;
}

.circle2{
width:250px;
height:250px;
bottom:-80px;
right:-50px;
animation-delay:2s;
}

.circle3{
width:150px;
height:150px;
top:45%;
left:10%;
animation-delay:4s;
}

@keyframes float{

0%{
transform:translateY(0px);
}

50%{
transform:translateY(-20px);
}

100%{
transform:translateY(0px);
}

}

/* LOGIN BOX */

.login-box{
background:rgba(255,255,255,0.12);
border:1px solid rgba(255,255,255,0.2);
backdrop-filter:blur(15px);
border-radius:25px;
padding:40px;
box-shadow:0 8px 30px rgba(0,0,0,0.3);
color:white;
}

/* LOGO */

.logo{
width:100px;
height:100px;
background:white;
border-radius:50%;
display:flex;
justify-content:center;
align-items:center;
margin:auto;
margin-bottom:20px;
box-shadow:0 5px 20px rgba(0,0,0,0.2);
}

.logo i{
font-size:50px;
color:#2563eb;
}

/* TITLE */

.title{
font-size:32px;
font-weight:700;
text-align:center;
margin-bottom:5px;
}

.subtitle{
text-align:center;
font-size:14px;
opacity:0.85;
margin-bottom:30px;
}

/* INPUT */

.form-control{
height:55px;
border:none;
border-radius:15px;
padding-left:45px;
background:rgba(255,255,255,0.15);
color:white;
font-size:15px;
}

.form-control::placeholder{
color:#e2e8f0;
}

.form-control:focus{
background:rgba(255,255,255,0.2);
color:white;
box-shadow:none;
}

/* INPUT ICON */

.input-group-text{
position:absolute;
height:55px;
background:transparent;
border:none;
z-index:10;
color:white;
}

/* BUTTON */

.btn-login{
height:55px;
border:none;
border-radius:15px;
background:white;
color:#1d4ed8;
font-size:16px;
font-weight:700;
transition:0.3s;
}

.btn-login:hover{
background:#dbeafe;
transform:translateY(-2px);
}

/* FOOTER */

.footer-text{
text-align:center;
margin-top:20px;
font-size:13px;
opacity:0.8;
}

/* ALERT */

.alert{
border-radius:12px;
}

/* MOBILE */

@media(max-width:768px)
{

.login-box{
padding:30px 20px;
}

.title{
font-size:26px;
}

}

</style>

</head>

<body>

<!-- BACKGROUND -->

<div class="bg-circle circle1"></div>

<div class="bg-circle circle2"></div>

<div class="bg-circle circle3"></div>

<!-- LOGIN AREA -->

<div class="container">

<div class="row justify-content-center align-items-center vh-100">

<div class="col-md-5 col-lg-4">

<div class="login-box">

<!-- LOGO -->

<div class="logo">

<i class="bi bi-shield-lock-fill"></i>

</div>

<!-- TITLE -->

<div class="title">

NML SYSTEM

</div>

<div class="subtitle">

Contract Reminder Management Portal

</div>

<!-- ERROR -->

<?php if(isset($error)) { ?>

<div class="alert alert-danger">

<i class="bi bi-exclamation-triangle-fill"></i>

<?php echo $error; ?>

</div>

<?php } ?>

<!-- LOGIN FORM -->

<form method="POST">

<!-- EMAIL -->

<div class="mb-3 position-relative">

<span class="input-group-text">

<i class="bi bi-envelope-fill"></i>

</span>

<input type="email"
name="email"
class="form-control"
placeholder="Enter Email Address"
required>

</div>

<!-- PASSWORD -->

<div class="mb-4 position-relative">

<span class="input-group-text">

<i class="bi bi-lock-fill"></i>

</span>

<input type="password"
name="password"
class="form-control"
placeholder="Enter Password"
required>

</div>

<!-- BUTTON -->

<div class="d-grid">

<button type="submit"
name="login"
class="btn btn-login">

<i class="bi bi-box-arrow-in-right"></i>

Login Securely

</button>

</div>

</form>

<!-- FOOTER -->

<div class="footer-text">

© <?php echo date('Y'); ?>

NML Contract Reminder System

</div>

</div>

</div>

</div>

</div>

</body>
</html>