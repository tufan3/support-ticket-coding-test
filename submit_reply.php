<?php
session_start();
include 'db.php';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $message = $_POST['message'];

    $insert_query = $db->prepare("INSERT INTO replies (ticket_id, message, user_id) VALUES (?, ?, $user_id)");
    $insert_query->execute([$ticket_id, $message]);

    echo 1;
}
