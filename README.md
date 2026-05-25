Your project is a Contract / Alert Mail Reminder System built using PHP + MySQL with email notification support.

Project Overview

The system helps users manage contracts, subscriptions, agreements, or any records with an End Date and automatically sends reminder emails before expiry.

Main Purpose
Store contract/details data
Track expiry/end dates
Send automatic email alerts before expiry
Avoid missing renewals or deadlines
Technologies Used
Frontend: HTML, CSS, Bootstrap
Backend: PHP
Database: MySQL
Mail Service: PHPMailer (without Composer)
Server: XAMPP / Apache
Main Features
1. User Login System
User registration
Login/logout
Session management
2. Excel-Like Data Entry Form

Users can enter:

Contract Name
Company Name
Start Date
End Date
Email Address
Status
Notes

Similar to an Excel sheet UI.

3. Dashboard

Shows:

Total contracts
Upcoming expiry alerts
Expired contracts
Recent reminders
4. Automatic Reminder Emails

System checks:

End Date - 30 days

If today matches reminder date:

Email automatically sent
User gets notification before expiry

Example:

End Date → 30 June 2026
Reminder sent on → 31 May 2026
5. Duplicate Reminder Prevention

The system stores reminder status in database.

Example column:

reminder_sent ENUM('Yes','No')

After email sent:

UPDATE contracts 
SET reminder_sent='Yes'

This prevents sending multiple emails.

Database Example
Table: contracts
id	contract_name	email	start_date	end_date	reminder_sent
1	AMC Renewal	abc@gmail.com	2025-01-01	2026-06-30	No
Email Sending Flow
Cron Job / Scheduled Task

A PHP file runs daily:

php reminder.php

It:

Checks contracts nearing expiry
Sends email
Updates reminder status
Example Email

Subject:

Contract Expiry Reminder

Body:

Your contract "AMC Renewal" will expire on 30 June 2026.
Please renew before expiry.
Extra Features You Can Add
Advanced Features
Excel import/export
PDF report download
SMS/WhatsApp alerts
Admin panel
Multi-user roles
Search & filter
Calendar view
Notification bell
File upload for contracts
Real-World Use Cases

This project can be used by:

Companies
HR departments
Legal teams
IT AMC management
Subscription tracking
License renewal management
Resume Project Description

You can write this in your resume:

Developed a Contract Reminder & Alert Mail System using PHP, MySQL, and PHPMailer that automatically tracks contract expiry dates and sends email notifications before expiration. Implemented dashboard analytics, authentication, and automated reminder scheduling.

GitHub Project Structure
contract-reminder-system/
│
├── admin/
├── user/
├── includes/
├── uploads/
├── reminder.php
├── login.php
├── register.php
├── dashboard.php
├── db.php
└── README.md

This is a good real-time PHP project for:

internships
portfolio
GitHub
resume projects
interview demonstrations
readme for this project
Contract Reminder & Alert Mail System

A web-based Contract Reminder System developed using PHP and MySQL that automatically sends email alerts before contract expiry dates. The system helps organizations manage contracts, subscriptions, renewals, and agreements efficiently.

Features
User Registration & Login
Dashboard with contract statistics
Add/Edit/Delete contract records
Automatic email reminders before expiry
Excel-like data entry form
Search and filter contracts
Prevent duplicate reminder emails
PHPMailer integration (without Composer)
Responsive Bootstrap UI
Technologies Used
PHP
MySQL
HTML5 / CSS3
Bootstrap
JavaScript
PHPMailer
XAMPP
Project Structure
contract-reminder-system/
│
├── admin/
├── user/
├── includes/
├── uploads/
├── assets/
│
├── db.php
├── login.php
├── register.php
├── dashboard.php
├── reminder.php
├── logout.php
│
└── README.md
Database Setup
Step 1: Create Database

Create a database named:

contract_reminder_system
Step 2: Create Table
CREATE TABLE contracts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contract_name VARCHAR(255),
    company_name VARCHAR(255),
    email VARCHAR(255),
    start_date DATE,
    end_date DATE,
    reminder_sent ENUM('Yes','No') DEFAULT 'No',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
Installation Steps
1. Clone Project
git clone https://github.com/yourusername/contract-reminder-system.git

Or download ZIP and extract into:

C:\xampp\htdocs\
2. Start XAMPP

Start:

Apache
MySQL
3. Configure Database

Update database credentials in:

db.php

Example:

<?php
$conn = mysqli_connect("localhost","root","","contract_reminder_system");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}
?>
PHPMailer Setup

Download PHPMailer from:

PHPMailer GitHub Repository

Extract the folder and place it inside project directory.

Example:

PHPMailer/
Gmail SMTP Configuration

Inside reminder.php

$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'your_email@gmail.com';
$mail->Password   = 'your_app_password';
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;
Reminder Logic

The system automatically checks contracts nearing expiry.

Example:

End Date → 30 June 2026
Reminder sent → 30 days before expiry

Query Example:

SELECT * FROM contracts
WHERE DATEDIFF(end_date, CURDATE()) = 30
AND reminder_sent='No'

After email sent:

UPDATE contracts
SET reminder_sent='Yes'
WHERE id='$id'
Run Reminder Script
Manual Run

Open browser:

http://localhost/contract-reminder-system/reminder.php
Automatic Daily Run (Recommended)

Use Windows Task Scheduler or Cron Job.

Windows Task Scheduler Command
php C:\xampp\htdocs\contract-reminder-system\reminder.php
Dashboard Features
Total Contracts
Upcoming Expiry Alerts
Expired Contracts
Recent Reminders
Search & Filter
Future Enhancements
Excel Import/Export
PDF Reports
WhatsApp Notifications
SMS Alerts
Role-Based Access
File Upload Support
Multi-user Management
Notification Bell
Screenshots

Add screenshots here:

screenshots/dashboard.png
screenshots/login.png
screenshots/contracts.png
Use Cases

Useful for:

Contract Management
AMC Renewals
HR Agreements
Subscription Tracking
License Expiry Alerts
Legal Document Monitoring
Resume Description

Developed a Contract Reminder & Alert Mail System using PHP, MySQL, and PHPMailer that automatically tracks contract expiry dates and sends email notifications before expiration.

Author

Mukesh Kumar
PHP Developer

License

This project is open-source and free to use for learning purposes.
