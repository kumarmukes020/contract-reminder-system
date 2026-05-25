<!-- SIDEBAR -->

<div class="sidebar">

<!-- LOGO -->

<div class="logo-area">

<h3>

<i class="bi bi-building"></i>

NML SYSTEM

</h3>

</div>

<!-- USER -->

<div class="user-box">

<div class="user-icon">

<i class="bi bi-person-circle"></i>

</div>

<div>

<h6 class="mb-0">
Admin User
</h6>

<small>
Super Admin
</small>

</div>

</div>

<!-- MENU -->

<ul class="menu">

<!-- DASHBOARD -->

<li>

<a href="dashboard.php">

<i class="bi bi-speedometer2"></i>

<span>
Dashboard
</span>

</a>

</li>


<!-- CONTRACTS -->

<li>

<a href="contracts.php">

<i class="bi bi-file-earmark-text"></i>

<span>
Contracts
</span>

</a>

</li>

<li>

<a href="projects.php"
class="<?php if(basename($_SERVER['PHP_SELF'])=='projects.php') echo 'active'; ?>">

<i class="bi bi-building"></i>

<span>
Projects
</span>

</a>

</li>
<!-- ADD CONTRACT -->

<li>

<a href="add_contract.php">

<i class="bi bi-plus-circle"></i>

<span>
Add Contract
</span>

</a>

</li>



<!-- REPORTS -->

<li>

<a href="reports.php">

<i class="bi bi-bar-chart-line"></i>

<span>
Reports
</span>

</a>

</li>

<!-- REMINDER LOGS -->

<li>

<a href="reminder_logs.php">

<i class="bi bi-envelope-check"></i>

<span>
Reminder Logs
</span>

</a>

</li>

<!-- RUN REMINDER -->

<li>

<a href="../cron/send_reminder.php"
target="_blank">

<i class="bi bi-bell"></i>

<span>
Run Reminder
</span>

</a>

</li>

<!-- USERS -->

<li>

<a href="users.php">

<i class="bi bi-people"></i>

<span>
Users
</span>

</a>

</li>



<!-- LOGOUT -->

<li class="mt-3">

<a href="../logout.php"
class="logout-btn">

<i class="bi bi-box-arrow-right"></i>

<span>
Logout
</span>

</a>

</li>

</ul>

</div>
<style>

body{
    background:#f1f5f9;
    font-size:14px;
    overflow-x:hidden;
}

/* SIDEBAR */

.sidebar{
    width:270px;
    min-height:100vh;
    background:#0f172a;
    position:fixed;
    left:0;
    top:0;
    overflow-y:auto;
    box-shadow:4px 0 10px rgba(0,0,0,0.1);
}

/* LOGO */

.logo-area{
    padding:20px;
    border-bottom:1px solid #334155;
    text-align:center;
}

.logo-area h3{
    color:white;
    font-weight:700;
    margin:0;
    font-size:22px;
}

/* USER BOX */

.user-box{
    display:flex;
    align-items:center;
    gap:12px;
    padding:20px;
    border-bottom:1px solid #334155;
    color:white;
}

.user-icon i{
    font-size:45px;
}

/* MENU */

.menu{
    list-style:none;
    padding:0;
    margin:0;
}

.menu li{
    width:100%;
}

.menu li a{
    display:flex;
    align-items:center;
    gap:15px;
    padding:15px 22px;
    text-decoration:none;
    color:#cbd5e1;
    transition:0.3s;
    font-size:15px;
    border-left:4px solid transparent;
}

.menu li a:hover{
    background:#1e293b;
    color:white;
    border-left:4px solid #3b82f6;
    padding-left:28px;
}

.menu li a i{
    font-size:18px;
    min-width:20px;
}

/* LOGOUT */

.logout-btn{
    background:#991b1b;
}

.logout-btn:hover{
    background:#dc2626 !important;
    border-left:4px solid white !important;
}

/* MAIN */

.main{
    margin-left:270px;
    padding:20px;
}

</style>