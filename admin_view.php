<?php
session_start();
include 'db.php';

// 1. กำหนดตัวแปรกลางที่ต้องใช้ใน View เสมอ
$page = isset($_GET['page']) ? $_GET['page'] : 'news';
$login_error = "";

// 2. ตรวจสอบการ Login
if (isset($_POST['btn_login'])) {
    if ($_POST['username'] === 'admin' && $_POST['password'] === '1234') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php"); // Refresh เพื่อล้าง POST data
        exit;
    } else {
        $login_error = "ชื่อผู้ใช้งานหรือรหัสผ่านผิด!";
    }
}

// 3. เช็คว่า Login หรือยัง
if (!isset($_SESSION['admin_logged_in'])) {
    // --- ถ้ายังไม่ Login ให้แสดงหน้า Login (ก๊อปโค้ดหน้า Login มาวางตรงนี้) ---
    echo "<h2>กรุณาเข้าสู่ระบบ</h2>";
    echo "<form method='POST'><input name='username'><input type='password' name='password'><button name='btn_login'>Login</button></form>";
    if($login_error) echo $login_error;
} else {
    // --- ถ้า Login แล้ว ถึงค่อยเรียกใช้หน้าเมนูหลังบ้าน ---
    include 'admin_view.php';
}
?>