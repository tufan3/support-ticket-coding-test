<?php
session_start();
include 'db.php';
extract($_REQUEST);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/autoload.php';

$customer_id = $_SESSION['user_id'];
$user_type = $_SESSION['role'];
$query_name = "SELECT name FROM users WHERE id = $customer_id";
$result = $db->query($query_name);

if ($result && $row = $result->fetch_assoc()) {
    $name = $row['name'];
}

$query = $db->prepare("INSERT INTO tickets (customer_id, subject, description, status) VALUES (?, ?, ?, 'open')");
$query->execute([$customer_id, $subject, $description]);

// /email part///
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = "UTF-8";
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username = 'robiultufan61@gmail.com';
$mail->Password = 'faji azvb kvtu qfuu';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = 465;

$mail->From = 'robiultufan61@gmail.com';
$mail->FromName = 'Tickets Notification';
$mail->AddAddress('robiultufan61@gmail.com', $name);
$mail->AddReplyTo('robiultufan61@gmail.com', 'Open Tickets');

$mail->IsHTML(true);
$mail->Subject    = "Open a new tickets";


$mail->Body .= "<br/>Open a new tickets issues for " . $name . ", please check<br/><br/>";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
$mail->send();
// /email part///

if ($user_type == 'admin') {
    echo 'admin';
} else {
    echo 'customer';
}
