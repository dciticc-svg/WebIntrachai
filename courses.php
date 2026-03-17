<?php
// 1. เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intrachai_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// 2. ดึงข้อมูลการตั้งค่าเว็บไซต์ (สำหรับแบนเนอร์ / ติดต่อ / Footer)
$sql_settings = "SELECT * FROM web_settings WHERE id = 1";
$result_settings = $conn->query($sql_settings);
$settings = $result_settings->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หลักสูตรที่เปิดสอน | INTRACHAI</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .page-header {
            padding: 160px 0 80px;
            background: linear-gradient(135deg, rgba(0, 98, 255, 0.9) 0%, rgba(0, 210, 255, 0.9) 100%), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
            color: white;
            text-align: center;
        }
        .courses-container {
            margin-top: -50px;
            position: relative;
            z-index: 10;
        }
        .course-badge {
            background: rgba(0, 98, 255, 0.1);
            color: var(--primary-color);
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container nav-container">
            <a href="index.php" class="logo" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
    <img src="images/logo.png" alt="โลโก้วิทยาลัย" style="width: 45px; height: auto;">
    <span style="font-size: 1.3rem; font-weight: 700; color: var(--text-dark);">
        วิทยาลัยพณิชยการ<span style="color: var(--primary-color);">อินทราชัย</span>
    </span>
</a>
            
            <ul class="nav-links">
                <li><a href="index.php">หน้าหลัก</a></li>

                <li class="dropdown">
                    <a href="#">ข้อมูลเกี่ยวกับหน่วยงาน <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="about.php">ประวัติวิทยาลัย</a></li>
                        <li><a href="#">อัตลักษณ์ เอกลักษณ์</a></li>
                        <li><a href="#">ปรัชญา วิสัยทัศน์</a></li>
                        <li><a href="#">ทำเนียบผู้บริหาร</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#">ข้อมูลพื้นฐานวิทยาลัย <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">ข้อมูลบุคลากร</a></li>
                        <li><a href="courses.php" class="active">หลักสูตรที่เปิดสอน</a></li>
                        <li><a href="#">ข้อมูลอาคารสถานที่</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#">สาขาวิชาที่เปิดสอน <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">สาขาวิชาสามัญสัมพันธ์</a></li>
                        <li><a href="#">สาขาวิชาการบัญชี</a></li>
                        <li><a href="#">สาขาวิชาการตลาด</a></li>
                        <li><a href="#">สาขาวิชาเทคโนโลยีธุรกิจดิจิทัล</a></li>
                        <li><a href="#">สาขาวิชาโลจิสติกส์และซัพพลายเชน</a></li>
                    </ul>
                </li>
                
                <li><a href="admin.php">ระบบจัดการ</a></li>
            </ul>
        </div>
    </nav>

    <header class="page-header">
        <div class="container">
            <h1 style="font-size: 3rem; text-shadow: 0 4px 10px rgba(0,0,0,0.2);">หลักสูตรที่เปิดสอน</h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">สาขาวิชาที่เปิดสอนในระดับ ปวช. และ ปวส.</p>
        </div>
    </header>

    <section class="section-padding" style="background: #f0f7ff; padding-top: 0;">
        <div class="container courses-container">
            <div class="programs-grid">
                <?php
                // ดึงข้อมูลหลักสูตรทั้งหมด
                $sql_courses = "SELECT * FROM courses ORDER BY course_level ASC, id ASC";
                $result_courses = $conn->query($sql_courses);
                
                if ($result_courses->num_rows > 0) {
                    while($row = $result_courses->fetch_assoc()) {
                ?>
                <div class="program-card" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
                    <div class="card-image" style="margin-bottom: 20px;">
                        <i class="fas <?php echo htmlspecialchars($row['icon']); ?>" style="font-size: 60px; color: var(--primary-color);"></i>
                    </div>
                    <div class="card-content">
                        <span class="course-badge"><?php echo htmlspecialchars($row['course_level']); ?></span>
                        <h3 style="font-size: 1.3rem; color: #1a202c;"><?php echo htmlspecialchars($row['course_desc']); ?></h3>
                    </div>
                </div>
                <?php 
                    } 
                } else { 
                    echo "<div style='grid-column: 1/-1; background: white; padding: 50px; text-align: center; border-radius: 20px;'>
                            <i class='fas fa-box-open' style='font-size: 50px; color: #cbd5e1; margin-bottom: 20px;'></i>
                            <h3 style='color: #64748b;'>ยังไม่มีข้อมูลหลักสูตร</h3>
                          </div>"; 
                } 
                ?>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-info">
                    <h3>วิทยาลัยอินทราชัย</h3>
                    <p>สถาบันการศึกษาอาชีวศึกษาชั้นนำ มุ่งเน้นการผลิตบุคลากรที่มีคุณภาพสู่ตลาดแรงงานสากล</p>
                </div>
                <div class="footer-contact">
                    <h3>ติดต่อเรา</h3>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($settings['address']); ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($settings['phone']); ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($settings['email']); ?></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date("Y"); ?> INTRACHAI COLLEGE. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>