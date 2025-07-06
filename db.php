<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // leave empty unless you set a password
$db   = 'taskmate';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
