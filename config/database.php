<?php
$host = 'localhost';
$user = 'n1571056_root_rasa';
$password = 'password123@#$'; 
$db = 'n1571056_db_rasa';

$connect = new mysqli($host, $user, $password, $db);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
?>
