<?php
session_start();

// 1. เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intrachai_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) { die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error); }

$page = isset($_GET['page']) ? $_GET['page'] : 'news';
$login_error = "";

// 2. ระบบ Login / Logout
if (isset($_POST['btn_login'])) {
    if ($_POST['username'] === 'admin' && $_POST['password'] === '1234') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php"); exit;
    } else { $login_error = "ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง!"; }
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy(); header("Location: admin.php"); exit;
}

// 3. ระบบบันทึก/ลบ ข้อมูล
if (isset($_SESSION['admin_logged_in'])) {

    // --- [1. ข่าวสาร (อัปเกรดระบบอัลบั้ม)] ---
    if (isset($_POST['btn_add_news'])) {
        $title = $conn->real_escape_string($_POST['title']);
        $news_date = $conn->real_escape_string($_POST['news_date']);
        $description = $conn->real_escape_string($_POST['description']);
        
        // บันทึกหัวข้อข่าวลงตาราง news ก่อน เพื่อให้ได้ ID มา
        $conn->query("INSERT INTO news (title, news_date, description) VALUES ('$title', '$news_date', '$description')");
        $news_id = $conn->insert_id; // ดึง ID ของข่าวที่เพิ่งเพิ่มล่าสุดมาใช้

        // จัดการอัปโหลดรูปภาพหลายรูป (ถ้ามีการเลือกรูป)
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }

        if (!empty($_FILES['news_images']['name'][0])) {
            $total_files = count($_FILES['news_images']['name']);
            for ($i = 0; $i < $total_files; $i++) {
                if ($_FILES['news_images']['error'][$i] == 0) {
                    $ext = pathinfo($_FILES['news_images']['name'][$i], PATHINFO_EXTENSION);
                    // ตั้งชื่อไฟล์ให้ไม่ซ้ำกัน (เช่น news_5_167890_0.jpg)
                    $new_filename = "news_" . $news_id . "_" . time() . "_" . $i . "." . $ext;
                    $target_file = $target_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['news_images']['tmp_name'][$i], $target_file)) {
                        // บันทึกเส้นทางรูปลงตาราง news_images
                        $conn->query("INSERT INTO news_images (news_id, image_path) VALUES ($news_id, '$target_file')");
                    }
                }
            }
        }
        header("Location: admin.php?page=news&status=success"); exit;
    }

    if (isset($_GET['delete_news_id'])) {
        $del_id = (int)$_GET['delete_news_id'];
        
        // ลบไฟล์รูปภาพจริงๆ ออกจากโฟลเดอร์ uploads ก่อน
        $img_res = $conn->query("SELECT image_path FROM news_images WHERE news_id = $del_id");
        while($img_row = $img_res->fetch_assoc()) {
            if(file_exists($img_row['image_path'])) { unlink($img_row['image_path']); }
        }
        
        // ลบข้อมูลข่าว (ตาราง news_images จะโดนลบตามอัตโนมัติด้วยคำสั่ง ON DELETE CASCADE)
        $conn->query("DELETE FROM news WHERE id = $del_id");
        header("Location: admin.php?page=news&status=deleted"); exit;
    }

    // --- [2. หลักสูตร] ---
    if (isset($_POST['btn_add_course'])) {
        $course_level = $conn->real_escape_string($_POST['course_level']);
        $course_desc = $conn->real_escape_string($_POST['course_desc']);
        $icon = $conn->real_escape_string($_POST['icon']);
        $conn->query("INSERT INTO courses (course_level, course_desc, icon) VALUES ('$course_level', '$course_desc', '$icon')");
        header("Location: admin.php?page=courses&status=success"); exit;
    }
    if (isset($_GET['delete_course_id'])) {
        $conn->query("DELETE FROM courses WHERE id = " . (int)$_GET['delete_course_id']);
        header("Location: admin.php?page=courses&status=deleted"); exit;
    }

    // --- [3. ตั้งค่าเว็บไซต์ (แบนเนอร์, วิดีโอ & ติดต่อ)] ---
    if (isset($_POST['btn_save_settings'])) {
        $banner_title = $conn->real_escape_string($_POST['banner_title']);
        $banner_desc = $conn->real_escape_string($_POST['banner_desc']);
        $address = $conn->real_escape_string($_POST['address']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $email = $conn->real_escape_string($_POST['email']);

        $image_update_sql = "";
        $video_update_sql = "";
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }

        if (isset($_POST['delete_image'])) { $image_update_sql = ", banner_image=''"; }
        elseif (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] == 0) {
            $ext = pathinfo($_FILES["banner_image"]["name"], PATHINFO_EXTENSION);
            $target_file = $target_dir . "banner_" . time() . "." . $ext;
            if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_file)) { $image_update_sql = ", banner_image='$target_file'"; }
        }

        if (isset($_POST['delete_video'])) { $video_update_sql = ", banner_video=''"; }
        elseif (isset($_FILES['banner_video']) && $_FILES['banner_video']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES["banner_video"]["name"], PATHINFO_EXTENSION));
            if ($ext == 'mp4') {
                $target_file = $target_dir . "banner_vid_" . time() . ".mp4";
                if (move_uploaded_file($_FILES["banner_video"]["tmp_name"], $target_file)) { $video_update_sql = ", banner_video='$target_file'"; }
            }
        }

        $sql = "UPDATE web_settings SET banner_title='$banner_title', banner_desc='$banner_desc', address='$address', phone='$phone', email='$email' $image_update_sql $video_update_sql WHERE id=1";
        $conn->query($sql);
        header("Location: admin.php?page=settings&status=success"); exit;
    }

    // --- [4. ข้อมูลวิทยาลัย (About Us)] ---
    if (isset($_POST['btn_save_about'])) {
        $vision = $conn->real_escape_string($_POST['vision']);
        $mission = $conn->real_escape_string($_POST['mission']);
        $history = $conn->real_escape_string($_POST['history']);
        $conn->query("UPDATE web_settings SET vision='$vision', mission='$mission', history='$history' WHERE id=1");
        header("Location: admin.php?page=about&status=success"); exit;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบหลังบ้าน | Intrachai Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .sidebar a { display: block; color: white; padding: 15px; text-decoration: none; margin-bottom: 5px; border-radius: 5px; transition: 0.3s;}
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.2); }
        .btn-delete { color: white; background: #e74c3c; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 14px;}
        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container { flex-direction: column !important; }
            .sidebar { width: 100% !important; display: flex; flex-wrap: wrap; gap: 10px; padding: 15px !important; }
            .sidebar h3 { width: 100%; text-align: center; }
            .sidebar a { flex: 1; text-align: center; min-width: 120px; font-size: 14px; margin-bottom: 0; }
            .main-content { padding: 15px !important; width: 100%; box-sizing: border-box;}
            .topbar { flex-direction: column; gap: 15px; text-align: center; }
            .admin-table { display: block; overflow-x: auto; white-space: nowrap; }
        }
    </style>
</head>
<body>

<?php if (!isset($_SESSION['admin_logged_in'])) { ?>
    <div class="login-container" style="display:flex; justify-content:center; align-items:center; height:100vh; background:#0F204B;">
        <div class="login-box" style="background:white; padding:40px; border-radius:8px; width:350px; text-align:center;">
            <h2 style="color:#0F204B; margin-bottom:20px;"><i class="fas fa-shield-alt"></i> ระบบจัดการข้อมูล</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;">
                <input type="password" name="password" placeholder="Password" required style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;">
                <button type="submit" name="btn_login" style="width:100%; padding:10px; background:#D4AF37; color:white; border:none; border-radius:4px; cursor:pointer; font-size:16px;">เข้าสู่ระบบ</button>
            </form>
            <?php if($login_error) echo "<p style='color:red; margin-top:10px;'>$login_error</p>"; ?>
            <a href="index.php" style="display:block; margin-top:20px; color:#555; text-decoration:none;">กลับหน้าเว็บ</a>
        </div>
    </div>
<?php } else { ?>
    <div class="dashboard-container" style="display: flex; min-height: 100vh;">
        
        <div class="sidebar" style="width: 260px; background: #2c3e50; padding: 20px; color: white;">
            <h3 style="padding: 0 15px; margin-bottom: 20px;">INTRACHAI CMS</h3>
            <a href="admin.php?page=news" class="<?php echo ($page == 'news') ? 'active' : ''; ?>"><i class="fas fa-newspaper"></i> จัดการข่าวสาร</a>
            <a href="admin.php?page=courses" class="<?php echo ($page == 'courses') ? 'active' : ''; ?>"><i class="fas fa-book"></i> จัดการหลักสูตร</a>
            <a href="admin.php?page=about" class="<?php echo ($page == 'about') ? 'active' : ''; ?>"><i class="fas fa-info-circle"></i> ข้อมูลวิทยาลัย</a>
            <a href="admin.php?page=settings" class="<?php echo ($page == 'settings') ? 'active' : ''; ?>"><i class="fas fa-cog"></i> ตั้งค่าเว็บไซต์</a>
            <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 0;">
            <a href="admin.php?action=logout" style="text-align: center; background: #e74c3c;"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
        </div>
        
        <div class="main-content" style="flex: 1; padding: 30px; background: #f4f6f9;">
            <div class="topbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #ddd; padding-bottom: 10px;">
                <h2 style="color: #2c3e50;">จัดการข้อมูล</h2>
                <a href="index.php" target="_blank" style="background: #3498db; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none;"><i class="fas fa-external-link-alt"></i> ดูหน้าเว็บจริง</a>
            </div>

            <?php if(isset($_GET['status'])) {
                if($_GET['status'] == 'success') echo "<div style='background:#d4edda; color:#155724; padding:15px; border-radius:5px; margin-bottom:20px;'><i class='fas fa-check-circle'></i> บันทึกข้อมูลเรียบร้อยแล้ว!</div>";
                if($_GET['status'] == 'deleted') echo "<div style='background:#f8d7da; color:#721c24; padding:15px; border-radius:5px; margin-bottom:20px;'><i class='fas fa-trash'></i> ลบข้อมูลเรียบร้อยแล้ว!</div>";
            } ?>

            <?php if ($page == 'news') { ?>
                <div class="admin-card" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <h3 style="margin-bottom: 20px; color:#34495e;"><i class="fas fa-plus-circle"></i> เพิ่มข่าวสารและภาพกิจกรรม</h3>
                    <form method="POST" action="admin.php?page=news" enctype="multipart/form-data">
                        <div class="form-group" style="margin-bottom: 15px;"><label style="display:block; margin-bottom:5px;">หัวข้อข่าว</label><input type="text" name="title" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;"></div>
                        <div class="form-group" style="margin-bottom: 15px;"><label style="display:block; margin-bottom:5px;">วันที่ประกาศ</label><input type="date" name="news_date" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;"></div>
                        <div class="form-group" style="margin-bottom: 15px;"><label style="display:block; margin-bottom:5px;">รายละเอียดข่าว</label><textarea name="description" rows="4" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;"></textarea></div>
                        
                        <div class="form-group" style="margin-bottom: 20px; background:#f0f7ff; padding:15px; border-radius:5px; border:1px dashed #3498db;">
                            <label style="display:block; margin-bottom:5px; font-weight:bold; color:#0062ff;">📸 อัปโหลดรูปภาพ (เลือกได้หลายรูปพร้อมกัน)</label>
                            <p style="font-size:12px; color:#666; margin-bottom:10px;">* คุณสามารถลากเมาส์คลุม หรือกด Ctrl ค้างไว้ เพื่อเลือกรูปหลายรูปได้เลย รูปแรกจะเป็นหน้าปกข่าวครับ</p>
                            <input type="file" name="news_images[]" accept="image/jpeg, image/png, image/jpg" multiple>
                        </div>

                        <button type="submit" name="btn_add_news" class="btn-save" style="background:#2ecc71; color:white; padding:12px 25px; font-size:16px; border:none; border-radius:4px; cursor:pointer;"><i class="fas fa-save"></i> บันทึกข้อมูลและอัปโหลดรูป</button>
                    </form>
                </div>

                <div class="admin-card" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <h3 style="margin-bottom: 20px; color:#34495e;"><i class="fas fa-list"></i> รายการข่าวสาร</h3>
                    <table class="admin-table" style="width:100%; border-collapse: collapse;">
                        <tr style="background:#f4f6f9;">
                            <th style="padding:10px; border-bottom:1px solid #ddd; text-align:left;">วันที่</th>
                            <th style="padding:10px; border-bottom:1px solid #ddd; text-align:left;">หัวข้อข่าว</th>
                            <th style="padding:10px; border-bottom:1px solid #ddd; text-align:center;">จำนวนรูป</th>
                            <th style="padding:10px; border-bottom:1px solid #ddd; text-align:center;">จัดการ</th>
                        </tr>
                        <?php
                        $result = $conn->query("SELECT * FROM news ORDER BY news_date DESC");
                        while($row = $result->fetch_assoc()) {
                            // นับว่าข่าวนี้มีกี่รูป
                            $img_count_res = $conn->query("SELECT COUNT(id) as total FROM news_images WHERE news_id = " . $row['id']);
                            $img_count = $img_count_res->fetch_assoc()['total'];

                            echo "<tr>";
                            echo "<td style='padding:10px; border-bottom:1px solid #eee;'>" . date("d/m/Y", strtotime($row["news_date"])) . "</td>";
                            echo "<td style='padding:10px; border-bottom:1px solid #eee;'>" . htmlspecialchars($row["title"]) . "</td>";
                            echo "<td style='padding:10px; border-bottom:1px solid #eee; text-align:center;'><span style='background:#3498db; color:white; padding:3px 10px; border-radius:20px; font-size:12px;'>$img_count รูป</span></td>";
                            echo "<td style='padding:10px; border-bottom:1px solid #eee; text-align:center;'><a href='admin.php?page=news&delete_news_id=" . $row["id"] . "' class='btn-delete' onclick=\"return confirm('ยืนยันการลบข่าวและรูปทั้งหมด?');\"><i class='fas fa-trash'></i> ลบ</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>

            <?php } elseif ($page == 'courses') { ?>
                <div class="admin-card" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <h3 style="margin-bottom: 20px; color:#34495e;"><i class="fas fa-plus-circle"></i> เพิ่มหลักสูตร</h3>
                    <form method="POST" action="admin.php?page=courses">
                        <div class="form-group" style="margin-bottom: 15px;"><label style="display:block; margin-bottom:5px;">ระดับชั้น (เช่น ปวช./ปวส.)</label><input type="text" name="course_level" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;"></div>
                        <div class="form-group" style="margin-bottom: 15px;"><label style="display:block; margin-bottom:5px;">ชื่อสาขา</label><input type="text" name="course_desc" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;"></div>
                        <div class="form-group" style="margin-bottom: 15px;"><label style="display:block; margin-bottom:5px;">ไอคอน (เช่น fa-laptop)</label><input type="text" name="icon" value="fa-book" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;"></div>
                        <button type="submit" name="btn_add_course" class="btn-save" style="background:#2ecc71; color:white; padding:10px 20px; border:none; border-radius:4px; cursor:pointer;"><i class="fas fa-save"></i> บันทึกหลักสูตร</button>
                    </form>
                </div>
                <div class="admin-card" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <h3 style="margin-bottom: 20px; color:#34495e;"><i class="fas fa-list"></i> รายการหลักสูตร</h3>
                    <table class="admin-table" style="width:100%; border-collapse: collapse;">
                        <tr style="background:#f4f6f9;">
                            <th style="padding:10px; border-bottom:1px solid #ddd; text-align:left;">ระดับชั้น</th>
                            <th style="padding:10px; border-bottom:1px solid #ddd; text-align:left;">สาขา</th>
                            <th style="padding:10px; border-bottom:1px solid #ddd; text-align:center;">จัดการ</th>
                        </tr>
                        <?php
                        $result = $conn->query("SELECT * FROM courses ORDER BY course_level ASC, id ASC");
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td style='padding:10px; border-bottom:1px solid #eee;'><strong>" . htmlspecialchars($row["course_level"]) . "</strong></td>";
                            echo "<td style='padding:10px; border-bottom:1px solid #eee;'>" . htmlspecialchars($row["course_desc"]) . "</td>";
                            echo "<td style='padding:10px; border-bottom:1px solid #eee; text-align:center;'><a href='admin.php?page=courses&delete_course_id=" . $row["id"] . "' class='btn-delete' onclick=\"return confirm('ลบหลักสูตรนี้?');\"><i class='fas fa-trash'></i> ลบ</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
                
            <?php } elseif ($page == 'about') { ?>
                <?php 
                $res = $conn->query("SELECT vision, mission, history FROM web_settings WHERE id = 1");
                $about_data = $res->fetch_assoc();
                ?>
                <div class="admin-card" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <h3 style="margin-bottom: 20px; color:#34495e;"><i class="fas fa-edit"></i> แก้ไขข้อมูลวิทยาลัย</h3>
                    <form method="POST" action="admin.php?page=about">
                        <div class="form-group" style="margin-bottom: 15px;"><label style="display:block; margin-bottom:5px;">วิสัยทัศน์</label><textarea name="vision" rows="3" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;"><?php echo htmlspecialchars($about_data['vision']); ?></textarea></div>
                        <div class="form-group" style="margin-bottom: 15px;"><label style="display:block; margin-bottom:5px;">พันธกิจ</label><textarea name="mission" rows="4" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;"><?php echo htmlspecialchars($about_data['mission']); ?></textarea></div>
                        <div class="form-group" style="margin-bottom: 15px;"><label style="display:block; margin-bottom:5px;">ประวัติ</label><textarea name="history" rows="6" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;"><?php echo htmlspecialchars($about_data['history']); ?></textarea></div>
                        <button type="submit" name="btn_save_about" class="btn-save" style="background:#3498db; color:white; padding:10px 20px; border:none; border-radius:4px; cursor:pointer;"><i class="fas fa-save"></i> บันทึกข้อมูล</button>
                    </form>
                </div>
                
            <?php } elseif ($page == 'settings') { ?>
                <?php 
                $res = $conn->query("SELECT * FROM web_settings WHERE id = 1");
                $settings = $res->fetch_assoc();
                ?>
                <div class="admin-card" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <h3 style="margin-bottom: 20px; color:#34495e;"><i class="fas fa-desktop"></i> แก้ไขข้อมูลเว็บไซต์</h3>
                    <form method="POST" action="admin.php?page=settings" enctype="multipart/form-data">
                        <h4 style="margin-top:20px; color:#e67e22; border-bottom:1px solid #eee; padding-bottom:10px;">ส่วนที่ 1: แบนเนอร์หน้าแรก</h4>
                        <div class="form-group" style="margin-bottom: 15px; margin-top:15px;"><label style="display:block; margin-bottom:5px;">หัวข้อแบนเนอร์</label><input type="text" name="banner_title" value="<?php echo htmlspecialchars($settings['banner_title']); ?>" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;"></div>
                        <div class="form-group" style="margin-bottom: 15px;"><label style="display:block; margin-bottom:5px;">รายละเอียดแบนเนอร์</label><textarea name="banner_desc" rows="3" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;"><?php echo htmlspecialchars($settings['banner_desc']); ?></textarea></div>
                        
                        <div class="form-group" style="margin-bottom: 15px; background:#f9f9f9; padding:15px; border-radius:5px;">
                            <label style="display:block; margin-bottom:5px; font-weight:bold;">🖼️ อัปโหลดรูปภาพพื้นหลังแบนเนอร์</label>
                            <input type="file" name="banner_image" accept="image/jpeg, image/png, image/jpg">
                            <?php if(!empty($settings['banner_image'])) { ?>
                                <div style="margin-top:15px; padding-top:15px; border-top:1px solid #ddd;">
                                    <span style="font-size:14px; color:#7f8c8d;">รูปภาพปัจจุบัน:</span><br>
                                    <img src="<?php echo $settings['banner_image']; ?>" style="max-height: 80px; border-radius:5px; margin-top:5px; margin-bottom:10px; border: 1px solid #ccc; display:block;">
                                    <label style="color:#e74c3c; font-weight:bold; cursor:pointer;"><input type="checkbox" name="delete_image" value="1"> 🗑️ ลบรูปภาพนี้ออก</label>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group" style="margin-bottom: 15px; background:#f0f7ff; padding:15px; border-radius:5px; border:1px dashed #3498db;">
                            <label style="display:block; margin-bottom:5px; font-weight:bold; color:#0062ff;">🎥 อัปโหลดวิดีโอพื้นหลังแบนเนอร์ (.mp4 เท่านั้น)</label>
                            <input type="file" name="banner_video" accept="video/mp4">
                            <?php if(!empty($settings['banner_video'])) { ?>
                                <div style="margin-top:15px; padding-top:15px; border-top:1px solid #b3d4fc;">
                                    <span style="font-size:14px; color:#7f8c8d;">วิดีโอปัจจุบัน:</span><br>
                                    <video src="<?php echo $settings['banner_video']; ?>" style="max-height: 120px; border-radius:5px; margin-top:5px; margin-bottom:10px; border: 1px solid #ccc; display:block;" controls muted></video>
                                    <label style="color:#e74c3c; font-weight:bold; cursor:pointer;"><input type="checkbox" name="delete_video" value="1"> 🗑️ ลบวิดีโอนี้ออก</label>
                                </div>
                            <?php } ?>
                        </div>

                        <h4 style="margin-top:30px; color:#e67e22; border-bottom:1px solid #eee; padding-bottom:10px;">ส่วนที่ 2: ข้อมูลติดต่อ</h4>
                        <div class="form-group" style="margin-bottom: 15px; margin-top:15px;"><label style="display:block; margin-bottom:5px;">ที่อยู่วิทยาลัย</label><textarea name="address" rows="2" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;"><?php echo htmlspecialchars($settings['address']); ?></textarea></div>
                        <div style="display:flex; gap:20px; flex-wrap:wrap;">
                            <div class="form-group" style="margin-bottom: 15px; flex:1; min-width:200px;"><label style="display:block; margin-bottom:5px;">เบอร์โทร</label><input type="text" name="phone" value="<?php echo htmlspecialchars($settings['phone']); ?>" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;"></div>
                            <div class="form-group" style="margin-bottom: 15px; flex:1; min-width:200px;"><label style="display:block; margin-bottom:5px;">อีเมล</label><input type="email" name="email" value="<?php echo htmlspecialchars($settings['email']); ?>" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;"></div>
                        </div>

                        <button type="submit" name="btn_save_settings" class="btn-save" style="background:#e67e22; color:white; padding:12px 25px; border:none; border-radius:4px; cursor:pointer; margin-top: 20px; font-size:16px;"><i class="fas fa-save"></i> บันทึกการตั้งค่าทั้งหมด</button>
                    </form>
                </div>
            <?php } ?>
            
        </div>
    </div>
<?php } ?>

</body>
</html>