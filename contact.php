<?php
include 'db.php';
$settings = getSettings($conn);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ติดต่อเรา | วิทยาลัยอินทราชัย</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="about-header" style="padding: 150px 0 80px; background: var(--gradient-blue); color: white; text-align: center;">
        <div class="container">
            <h1>ติดต่อเรา</h1>
            <p>สอบถามข้อมูลเพิ่มเติมหรือแจ้งปัญหาการใช้งาน</p>
        </div>
    </div>
    <div class="container" style="margin-top: 40px; margin-bottom: 80px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
            <div class="program-card" style="text-align: left;">
                <h3>ข้อมูลการติดต่อ</h3>
                <p style="margin: 20px 0;"><i class="fas fa-map-marker-alt" style="color: var(--primary-color);"></i> <?php echo $settings['address']; ?></p>
                <p style="margin: 20px 0;"><i class="fas fa-phone" style="color: var(--primary-color);"></i> <?php echo $settings['phone']; ?></p>
                <p style="margin: 20px 0;"><i class="fas fa-envelope" style="color: var(--primary-color);"></i> <?php echo $settings['email']; ?></p>
            </div>
            <div class="program-card">
                <h3>ส่งข้อความถึงเรา</h3>
                <form action="#" style="margin-top: 20px;">
                    <input type="text" placeholder="ชื่อของคุณ" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 8px; border: 1px solid #ddd;">
                    <input type="email" placeholder="อีเมลของคุณ" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 8px; border: 1px solid #ddd;">
                    <textarea placeholder="ข้อความ" rows="4" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 8px; border: 1px solid #ddd;"></textarea>
                    <button type="button" class="btn btn-primary" style="width: 100%;">ส่งข้อความ</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>