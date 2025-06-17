<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'hospital_devices';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>
