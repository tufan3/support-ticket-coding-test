<?php
session_start();
include 'db.php';
extract($_REQUEST);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/autoload.php';

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['role'];
$query_name = "SELECT * FROM users WHERE id = $customer_id";
$result = $db->query($query_name);

if ($result && $row = $result->fetch_assoc()) {
    $name = $row['name'];
    $user_email = $row['email'];
}


$closed_id = $_POST['closed_id'];
$status = 'closed';

$update_query = $db->prepare("UPDATE tickets SET status = ? WHERE id = ?");

$update_query->execute([$status, $closed_id]);

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
$mail->FromName = 'Tickets Closed Notification';
$mail->AddAddress($user_email, $name);
$mail->AddReplyTo('robiultufan61@gmail.com', 'Open Tickets');

$mail->IsHTML(true);
$mail->Subject    = "tickets closed";


$mail->Body .= "<br />Hello " . $name . ", <br/>The ticket has been closed.<br/>";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
$mail->send();

if ($update_query) {
    echo 'Ticket status updated to closed successfully';
} else {
    echo 'Error updating ticket status';
}
