<?php
// 1. เชื่อมต่อฐานข้อมูล (จากของใหม่)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intrachai_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// 2. ดึงข้อมูลการตั้งค่าเว็บไซต์ (แบนเนอร์ / ติดต่อ)
$sql_settings = "SELECT * FROM web_settings WHERE id = 1";
$result_settings = $conn->query($sql_settings);
$settings = $result_settings->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($settings['banner_title']); ?> | INTRACHAI</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
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
                <li><a href="index.php" class="active">หน้าหลัก</a></li>

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

    <?php 
        // เช็คว่ามีรูปแบนเนอร์ในฐานข้อมูลไหม ถ้าไม่มีใช้สีพื้นฐาน
        $bg_image = !empty($settings['banner_image']) ? $settings['banner_image'] : 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    ?>
    <?php 
        // เช็คว่ามีวิดีโอ หรือ รูปภาพ ในฐานข้อมูลไหม
        $bg_image = !empty($settings['banner_image']) ? $settings['banner_image'] : 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
        $bg_video = !empty($settings['banner_video']) ? $settings['banner_video'] : '';
    ?>
    
    <header class="hero" style="position: relative; overflow: hidden; padding: 180px 0 100px; <?php if(empty($bg_video)) echo "background: url('$bg_image') center/cover;"; ?>">
        
        <?php if(!empty($bg_video)): ?>
        <video autoplay loop muted playsinline style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2;">
            <source src="<?php echo htmlspecialchars($bg_video); ?>" type="video/mp4">
        </video>
        <?php endif; ?>

        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(0, 98, 255, 0.75) 0%, rgba(0, 210, 255, 0.65) 100%); z-index: -1;"></div>

        <div class="container hero-content" style="position: relative; z-index: 1; text-align: center; color: white;">
            <h1 style="font-size: 3.5rem; text-shadow: 0 4px 15px rgba(0,0,0,0.3); margin-bottom: 20px;">
                <?php echo htmlspecialchars($settings['banner_title']); ?>
            </h1>
            <p style="font-size: 1.2rem; margin-bottom: 40px; opacity: 0.9; max-width: 800px; margin-left: auto; margin-right: auto;">
                <?php echo htmlspecialchars($settings['banner_desc']); ?>
            </p>
            <div class="hero-buttons" style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="#courses" class="btn" style="background: white; color: var(--primary-color); padding: 15px 30px; border-radius: 30px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 15px rgba(0,0,0,0.1);"><i class="fas fa-search"></i> ค้นหาหลักสูตร</a>
                <a href="about.php" class="btn btn-outline" style="border: 2px solid white; color: white; padding: 15px 30px; border-radius: 30px; text-decoration: none; font-weight: 600;"><i class="fas fa-university"></i> รู้จักวิทยาลัย</a>
            </div>
        </div>
    </header>

    <section id="news" class="section-padding">
        <div class="container">
            <div class="section-title">
                <h2>ข่าวประชาสัมพันธ์ล่าสุด</h2>
                <p>ติดตามความเคลื่อนไหวและกิจกรรมต่างๆ ของวิทยาลัย</p>
            </div>
            <div class="programs-grid">
                <?php
                $sql_news = "SELECT * FROM news ORDER BY news_date DESC LIMIT 3";
                $result_news = $conn->query($sql_news);
                if ($result_news->num_rows > 0) {
                    while($row = $result_news->fetch_assoc()) {
                ?>
                <div class="program-card">
                    <div class="card-content" style="text-align: left;">
                        <span style="color: var(--primary-color); font-size: 0.9rem;">
                            <i class="far fa-calendar-alt"></i> <?php echo date("d/m/Y", strtotime($row["news_date"])); ?>
                        </span>
                        <h3 style="margin-top: 10px; color: var(--text-dark);"><?php echo htmlspecialchars($row["title"]); ?></h3>
                        <p style="margin-top: 10px; color: var(--text-light);"><?php echo mb_strimwidth(htmlspecialchars($row["description"]), 0, 100, "..."); ?></p>
                        <a href="news_detail.php?id=<?php echo $row['id']; ?>" class="read-more">อ่านเพิ่มเติม <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <?php } } else { echo "<p style='text-align:center; grid-column: 1/-1;'>ยังไม่มีข้อมูลข่าวสารในระบบ</p>"; } ?>
            </div>
        </div>
    </section>

    <section id="programs" class="section-padding" style="background: rgba(255,255,255,0.5);">
        <div class="container">
            <div class="section-title">
                <h2>หลักสูตรที่เปิดสอน</h2>
                <p>เลือกเรียนในสาขาที่ใช่ เพื่ออนาคตที่ชอบ</p>
            </div>
            <div class="programs-grid">
                <?php
                $sql_courses = "SELECT * FROM courses ORDER BY id ASC";
                $result_courses = $conn->query($sql_courses);
                if ($result_courses->num_rows > 0) {
                    while($row_c = $result_courses->fetch_assoc()) {
                ?>
                <div class="program-card">
                    <div class="card-image"><i class="fas <?php echo htmlspecialchars($row_c['icon']); ?> card-icon"></i></div>
                    <div class="card-content">
                        <span class="badge" style="background: rgba(0,98,255,0.1); color: var(--primary-color); padding: 5px 15px; border-radius: 20px; font-size: 0.8rem;">
                            <?php echo htmlspecialchars($row_c['course_level']); ?>
                        </span>
                        <h3 style="margin-top: 15px;"><?php echo htmlspecialchars($row_c['course_desc']); ?></h3>
                    </div>
                </div>
                <?php } } else { echo "<p style='text-align:center; grid-column: 1/-1;'>ยังไม่มีข้อมูลหลักสูตรในระบบ</p>"; } ?>
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