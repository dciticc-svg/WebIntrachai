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

// 2. ดึงข้อมูลเกี่ยวกับวิทยาลัยจากตาราง web_settings
$sql_settings = "SELECT * FROM web_settings WHERE id = 1";
$result_settings = $conn->query($sql_settings);
$settings = $result_settings->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เกี่ยวกับวิทยาลัย | INTRACHAI COLLEGE</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* สไตล์เฉพาะสำหรับหน้า About */
        .about-header {
            padding: 160px 0 80px;
            background: linear-gradient(135deg, rgba(0, 98, 255, 0.9) 0%, rgba(0, 210, 255, 0.9) 100%), url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
            color: white;
            text-align: center;
        }
        .content-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-top: -50px;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255,255,255,0.5);
        }
        .vision-box {
            background: rgba(0, 98, 255, 0.05);
            padding: 30px;
            border-left: 5px solid var(--primary-color);
            margin: 20px 0;
            border-radius: 0 15px 15px 0;
        }
        .history-text {
            line-height: 2;
            color: var(--text-light);
            text-indent: 50px;
            text-align: justify;
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
                    <a href="#" class="active">ข้อมูลเกี่ยวกับหน่วยงาน <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="about.php">ประวัติวิทยาลัย</a></li>
                        <li><a href="#">อัตลักษณ์ เอกลักษณ์</a></li>
                        <li><a href="#">ปรัชญา วิสัยทัศน์</a></li>
                        <li><a href="#">ทำเนียบผู้บริหาร</a></li>
                        <li><a href="#">หมายเลขโทรศัพท์ภายในวิทยาลัย</a></li>
                        <li><a href="#">ติดต่อวิทยาลัย</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#">ข้อมูลพื้นฐานวิทยาลัย <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">ข้อมูลบุคลากร</a></li>
                        <li><a href="#">แผนผังบุคลากร</a></li>
                        <li><a href="#">ข้อมูลนักเรียน นักศึกษา</a></li>
                        <li><a href="#">หลักสูตรที่เปิดสอน</a></li>
                        <li><a href="#">ข้อมูลด้านงบประมาณ</a></li>
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

                <li class="dropdown">
                    <a href="#">ฝ่ายวิชาการ <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">งานพัฒนาหลักสูตรการเรียนการสอน</a></li>
                        <li><a href="#">งานวัดผลและประเมินผล</a></li>
                        <li><a href="#">งานวิทยบริการและห้องสมุด</a></li>
                        <li><a href="#">งานอาชีวศึกษาระบบทวิภาคี</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#">ฝ่ายบริหารทรัพยากร <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">งานบริหารงานทั่วไป</a></li>
                        <li><a href="#">งานบุคลากร</a></li>
                        <li><a href="#">งานการเงิน</a></li>
                        <li><a href="#">งานประชาสัมพันธ์</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#">ฝ่ายแผนงานฯ <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">งานวางแผนและงบประมาณ</a></li>
                        <li><a href="#">งานความร่วมมือ</a></li>
                        <li><a href="#">งานประกันคุณภาพสถานศึกษา</a></li>
                        <li><a href="#">งานศูนย์ข้อมูลสารสนเทศ</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#">ฝ่ายพัฒนากิจการฯ <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu scrollable-menu">
                        <li><a href="#">งานกิจกรรมนักเรียน นักศึกษา</a></li>
                        <li><a href="#">งานปกครอง</a></li>
                        <li><a href="#">งานครูที่ปรึกษา</a></li>
                        <li><a href="#">งานแนะแนวอาชีพ</a></li>
                        <li><a href="#">TO BE NUMBER ONE</a></li>
                        <li><a href="#">นักศึกษาวิชาทหาร</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <header class="about-header">
        <div class="container">
            <h1 style="font-size: 3rem; margin-bottom: 10px; text-shadow: 0 4px 10px rgba(0,0,0,0.2);">ข้อมูลเกี่ยวกับหน่วยงาน</h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">ประวัติความเป็นมา วิสัยทัศน์ และพันธกิจของเรา</p>
        </div>
    </header>

    <section class="section-padding" style="background: #f0f7ff; padding-top: 0;">
        <div class="container">
            <div class="content-card">
                
                <div class="about-section">
                    <h2 style="color: var(--primary-color); margin-bottom: 25px;">
                        <i class="fas fa-history"></i> ประวัติความเป็นมา
                    </h2>
                    <div class="history-text">
                        <?php echo nl2br(htmlspecialchars($settings['history'])); ?>
                    </div>
                </div>

                <hr style="margin: 40px 0; border: none; border-top: 1px solid rgba(0,0,0,0.05);">

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                    <div class="vision-box">
                        <h3 style="color: var(--primary-color); margin-bottom: 15px;">
                            <i class="fas fa-eye"></i> วิสัยทัศน์ (Vision)
                        </h3>
                        <p style="color: var(--text-light); line-height: 1.8;">
                            <?php echo nl2br(htmlspecialchars($settings['vision'])); ?>
                        </p>
                    </div>
                    
                    <div class="vision-box" style="border-left-color: var(--secondary-color); background: rgba(0, 210, 255, 0.05);">
                        <h3 style="color: var(--secondary-color); margin-bottom: 15px;">
                            <i class="fas fa-bullseye"></i> พันธกิจ (Mission)
                        </h3>
                        <p style="color: var(--text-light); line-height: 1.8;">
                            <?php echo nl2br(htmlspecialchars($settings['mission'])); ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer class="footer" id="contact">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-info">
                    <h3>วิทยาลัยอินทราชัย</h3>
                    <p>สถาบันการศึกษาอาชีวศึกษาชั้นนำ มุ่งเน้นการผลิตบุคลากรที่มีคุณภาพสู่ตลาดแรงงานสากล</p>
                </div>
                <div class="footer-links">
                    <h3>ลิงก์ด่วน</h3>
                    <ul>
                        <li><a href="index.php">หน้าหลัก</a></li>
                        <li><a href="about.php">เกี่ยวกับวิทยาลัย</a></li>
                        <li><a href="admin.php">ระบบจัดการ (Admin)</a></li>
                    </ul>
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