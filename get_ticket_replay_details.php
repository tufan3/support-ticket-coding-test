<?php
session_start();
include 'db.php';

$ticket_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$ticket_id) {
    echo json_encode(['error' => 'Invalid ticket ID']);
    exit();
}

$query = "SELECT * FROM tickets WHERE id = $ticket_id";
$result = $db->query($query);

if ($result && $result->num_rows > 0) {
    $ticket = $result->fetch_assoc();
    $customer_id = $ticket['customer_id'];
} else {
    echo json_encode(['error' => 'Ticket not found']);
    exit();
}

$replies_query = "
    SELECT replies.*, users.name AS user_name, users.role AS user_role 
    FROM replies 
    JOIN users ON replies.user_id = users.id 
    WHERE replies.ticket_id = $ticket_id";

$replies_result = $db->query($replies_query);

if ($replies_result && $replies_result->num_rows > 0) {
    $replies = $replies_result->fetch_all(MYSQLI_ASSOC);
} else {
    $replies = [];
}

header('Content-Type: application/json');

echo json_encode([
    'ticket' => $ticket,
    'replies' => $replies
]);
