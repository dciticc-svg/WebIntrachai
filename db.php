<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intrachai_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ฟังก์ชันสำหรับดึงข้อมูลการตั้งค่าเว็บมาใช้ได้ทุกหน้า
function getSettings($conn) {
    return $conn->query("SELECT * FROM web_settings WHERE id = 1")->fetch_assoc();
}
?>