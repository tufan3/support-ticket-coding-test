<?php
$host = 'localhost';  
$username = 'root';   
$password = '';       
$dbname = 'support_ticket_system';  

$db = new mysqli($host, $username, $password, $dbname);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// $db->set_charset("utf8");
?>
