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

// 3. รับค่า ID ของข่าวที่ส่งมาจากหน้าแรก
$news_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// ดึงข้อมูลข่าวเฉพาะ ID นั้นๆ
$sql_news = "SELECT * FROM news WHERE id = $news_id";
$result_news = $conn->query($sql_news);

// ถ้าไม่มีข่าวนี้ในระบบ ให้เด้งกลับไปหน้าแรก
if ($result_news->num_rows == 0) {
    header("Location: index.php");
    exit;
}
$news_data = $result_news->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($news_data['title']); ?> | INTRACHAI</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .news-header {
            padding: 160px 0 80px;
            background: linear-gradient(135deg, rgba(0, 98, 255, 0.9) 0%, rgba(0, 210, 255, 0.9) 100%), url('https://images.unsplash.com/photo-1512820790803-83ca734da794?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
            color: white;
            text-align: center;
        }
        .news-content-card {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-top: -50px;
            position: relative;
            z-index: 10;
        }
        .news-meta {
            color: var(--primary-color);
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        .news-meta span {
            background: rgba(0, 98, 255, 0.1);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        .news-body {
            line-height: 1.8;
            color: #4a5568;
            font-size: 1.1rem;
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
                    <a href="#">ข้อมูลเกี่ยวกับหน่วยงาน <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="about.php">ประวัติวิทยาลัย</a></li>
                        <li><a href="#">อัตลักษณ์ เอกลักษณ์</a></li>
                        <li><a href="#">ปรัชญา วิสัยทัศน์</a></li>
                        <li><a href="#">ทำเนียบผู้บริหาร</a></li>
                        <li><a href="#">หมายเลขโทรศัพท์ภายในวิทยาลัย</a></li>
                        <li><a href="#">ติดต่อวิทยาลัย</a></li>
                    </ul>
                </li>
                
                <li><a href="admin.php">ระบบจัดการ</a></li>
            </ul>
        </div>
    </nav>

    <header class="news-header">
        <div class="container">
            <h1 style="font-size: 2.5rem; text-shadow: 0 4px 10px rgba(0,0,0,0.2); max-width: 900px; margin: 0 auto;">
                <?php echo htmlspecialchars($news_data['title']); ?>
            </h1>
        </div>
    </header>

    <section class="section-padding" style="background: #f0f7ff; padding-top: 0;">
        <div class="container" style="max-width: 1000px;">
            <div class="news-content-card">
                
                <div class="news-meta">
                    <span><i class="far fa-calendar-alt"></i> วันที่ประกาศ: <?php echo date("d/m/Y", strtotime($news_data["news_date"])); ?></span>
                    <span><i class="fas fa-user-circle"></i> ฝ่ายประชาสัมพันธ์</span>
                </div>

                <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">

                <div class="news-body">
                    <?php echo nl2br(htmlspecialchars($news_data['description'])); ?>
                </div>

                <div style="margin-top: 50px; text-align: center;">
                    <a href="index.php" class="btn btn-outline" style="color: var(--primary-color); border-color: var(--primary-color);">
                        <i class="fas fa-arrow-left"></i> กลับไปหน้าหลัก
                    </a>
                </div>

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