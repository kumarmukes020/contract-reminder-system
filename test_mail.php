<?php

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();
$mail->isSMTP();

$mail->Host = 'smtprelay.ntpc.co.in';

$mail->SMTPAuth = false;

$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

$mail->Port = 25;

$mail->CharSet = 'UTF-8';

$mail->SMTPDebug = 2;

$mail->Debugoutput = 'html';

$mail->SMTPOptions = [

'ssl' => [

'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true

]

];

$mail->setFrom(
'cmhqranchi@ntpc.co.in',
'NML Reminder System'
);