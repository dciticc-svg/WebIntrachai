<?php
$collegeName = "วิทยาลัยของฉัน";
$collegeFullName = "วิทยาลัยตัวอย่างเทคโนโลยีและอาชีวศึกษา";
$yearFounded = "พ.ศ. 2525";
$founder = "กระทรวงศึกษาธิการ";
$philosophy = "ทักษะดี มีวินัย ใฝ่คุณธรรม นำเทคโนโลยี";
$identity = "ยิ้มไหว้ ทักทาย แต่งกายเรียบร้อย";
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ประวัติวิทยาลัย - <?php echo $collegeName; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Prompt", sans-serif;
    }

    body {
      background: #f4f7fb;
      color: #222;
      line-height: 1.7;
    }

    header {
      background: linear-gradient(135deg, #0d47a1, #1976d2);
      color: #fff;
      padding: 16px 40px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.12);
      position: sticky;
      top: 0;
      z-index: 999;
    }

    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
    }

    .logo {
      font-size: 1.4rem;
      font-weight: 700;
    }

    .menu {
      display: flex;
      gap: 18px;
      flex-wrap: wrap;
    }

    .menu a {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
    }

    .menu a:hover,
    .menu a.active {
      color: #ffeb3b;
    }

    .hero {
      background: linear-gradient(rgba(13,71,161,0.7), rgba(25,118,210,0.75)),
      url('https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1400&q=80') center/cover;
      color: #fff;
      text-align: center;
      padding: 90px 20px;
    }

    .hero h1 {
      font-size: 2.7rem;
      margin-bottom: 10px;
    }

    .hero p {
      font-size: 1.1rem;
      max-width: 850px;
      margin: 0 auto;
    }

    .container {
      max-width: 1150px;
      margin: 0 auto;
      padding: 50px 20px;
    }

    .section-title {
      font-size: 2rem;
      color: #0d47a1;
      margin-bottom: 20px;
      text-align: center;
    }

    .content-box {
      background: #fff;
      border-radius: 18px;
      padding: 30px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.08);
      margin-bottom: 30px;
    }

    .content-box p {
      margin-bottom: 14px;
      text-align: justify;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 20px;
      margin: 30px 0;
    }

    .info-card {
      background: #ffffff;
      border-radius: 18px;
      padding: 22px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      border-top: 5px solid #1976d2;
    }

    .info-card h3 {
      color: #1565c0;
      margin-bottom: 10px;
      font-size: 1.1rem;
    }

    .timeline {
      margin-top: 15px;
      display: grid;
      gap: 18px;
    }

    .timeline-item {
      background: #fff;
      border-left: 6px solid #1976d2;
      border-radius: 12px;
      padding: 18px 20px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    }

    .timeline-item h4 {
      color: #0d47a1;
      margin-bottom: 8px;
    }

    .btn-back {
      display: inline-block;
      margin-top: 10px;
      background: #ffca28;
      color: #222;
      text-decoration: none;
      padding: 12px 24px;
      border-radius: 10px;
      font-weight: 700;
      transition: 0.3s;
    }

    .btn-back:hover {
      background: #ffd95a;
      transform: translateY(-2px);
    }

    footer {
      background: #0d1b2a;
      color: white;
      text-align: center;
      padding: 28px 20px;
      margin-top: 20px;
    }

    footer p {
      margin: 5px 0;
    }

    @media (max-width: 768px) {
      header {
        padding: 14px 20px;
      }

      nav {
        flex-direction: column;
      }

      .hero {
        padding: 70px 20px;
      }

      .hero h1 {
        font-size: 2rem;
      }

      .section-title {
        font-size: 1.6rem;
      }

      .content-box {
        padding: 22px;
      }
    }
  </style>
</head>
<body>

  <header>
    <nav>
      <div class="logo"><?php echo $collegeName; ?></div>
      <div class="menu">
        <a href="index.html">หน้าแรก</a>
        <a href="history.php" class="active">ประวัติวิทยาลัย</a>
        <a href="#">สาขาวิชา</a>
        <a href="#">ข่าวประชาสัมพันธ์</a>
        <a href="#">ติดต่อ</a>
      </div>
    </nav>
  </header>

  <section class="hero">
    <h1>ประวัติวิทยาลัย</h1>
    <p><?php echo $collegeFullName; ?> เป็นสถานศึกษาที่มุ่งพัฒนาผู้เรียนด้านวิชาชีพ เทคโนโลยี และคุณธรรม เพื่อเตรียมความพร้อมสู่โลกการทำงานและการศึกษาต่ออย่างมีคุณภาพ</p>
  </section>

  <div class="container">
    <h2 class="section-title">ข้อมูลทั่วไป</h2>

    <div class="info-grid">
      <div class="info-card">
        <h3>ชื่อสถานศึกษา</h3>
        <p><?php echo $collegeFullName; ?></p>
      </div>

      <div class="info-card">
        <h3>ก่อตั้งเมื่อ</h3>
        <p><?php echo $yearFounded; ?></p>
      </div>

      <div class="info-card">
        <h3>หน่วยงานต้นสังกัด</h3>
        <p><?php echo $founder; ?></p>
      </div>

      <div class="info-card">
        <h3>ปรัชญา</h3>
        <p><?php echo $philosophy; ?></p>
      </div>

      <div class="info-card">
        <h3>อัตลักษณ์</h3>
        <p><?php echo $identity; ?></p>
      </div>
    </div>

    <div class="content-box">
      <h2 class="section-title">ความเป็นมา</h2>
      <p>
        <?php echo $collegeFullName; ?> จัดตั้งขึ้นเมื่อ <?php echo $yearFounded; ?> โดยมีวัตถุประสงค์เพื่อจัดการศึกษาด้านอาชีวศึกษาให้แก่เยาวชนในพื้นที่และชุมชนใกล้เคียง
        มุ่งเน้นการผลิตและพัฒนากำลังคนสายวิชาชีพให้มีความรู้ ความสามารถ และทักษะที่สอดคล้องกับความต้องการของตลาดแรงงาน
        รวมทั้งส่งเสริมคุณธรรม จริยธรรม และระเบียบวินัยควบคู่ไปกับการเรียนรู้ทางวิชาชีพ
      </p>
      <p>
        ตลอดระยะเวลาที่ผ่านมา วิทยาลัยได้พัฒนาหลักสูตร อาคารสถานที่ ห้องปฏิบัติการ และเทคโนโลยีทางการศึกษาอย่างต่อเนื่อง
        เพื่อยกระดับคุณภาพการเรียนการสอนให้ทันสมัย และเปิดโอกาสให้นักเรียน นักศึกษา ได้ฝึกปฏิบัติจริงในสาขาวิชาต่าง ๆ
        ทั้งด้านอุตสาหกรรม พาณิชยกรรม เทคโนโลยีสารสนเทศ และสาขาวิชาชีพอื่น ๆ ที่ตอบสนองต่อการเปลี่ยนแปลงของสังคมยุคดิจิทัล
      </p>
      <p>
        ปัจจุบันวิทยาลัยมุ่งสู่การเป็นสถานศึกษาคุณภาพที่ผลิตผู้เรียนให้เป็น “คนดี คนเก่ง และมีความสุข”
        พร้อมทั้งสร้างเครือข่ายความร่วมมือกับสถานประกอบการ หน่วยงานภาครัฐ และเอกชน
        เพื่อเสริมสร้างประสบการณ์วิชาชีพและเพิ่มโอกาสในการมีงานทำให้กับผู้สำเร็จการศึกษา
      </p>
    </div>

    <div class="content-box">
      <h2 class="section-title">พัฒนาการของวิทยาลัย</h2>
      <div class="timeline">
        <div class="timeline-item">
          <h4>พ.ศ. 2525 - เริ่มก่อตั้งวิทยาลัย</h4>
          <p>เริ่มจัดการเรียนการสอนในสาขาวิชาพื้นฐานด้านอาชีวศึกษา เพื่อรองรับความต้องการของชุมชนและตลาดแรงงานในพื้นที่</p>
        </div>

        <div class="timeline-item">
          <h4>พ.ศ. 2535 - ขยายสาขาวิชาและอาคารเรียน</h4>
          <p>มีการเพิ่มสาขาวิชาใหม่ พร้อมทั้งพัฒนาอาคารเรียนและห้องปฏิบัติการให้มีความพร้อมมากยิ่งขึ้น</p>
        </div>

        <div class="timeline-item">
          <h4>พ.ศ. 2550 - พัฒนาด้านเทคโนโลยีการศึกษา</h4>
          <p>นำเทคโนโลยีสารสนเทศเข้ามาใช้ในการเรียนการสอน และส่งเสริมการเรียนรู้เชิงปฏิบัติการให้ทันต่อยุคสมัย</p>
        </div>

        <div class="timeline-item">
          <h4>พ.ศ. 2560 - สร้างความร่วมมือกับสถานประกอบการ</h4>
          <p>พัฒนาระบบทวิภาคีและการฝึกประสบการณ์วิชาชีพ เพื่อเตรียมความพร้อมให้ผู้เรียนก่อนเข้าสู่โลกการทำงานจริง</p>
        </div>

        <div class="timeline-item">
          <h4>ปัจจุบัน - มุ่งสู่วิทยาลัยอาชีวศึกษายุคดิจิทัล</h4>
          <p>พัฒนาผู้เรียนให้มีสมรรถนะทางวิชาชีพ ใช้เทคโนโลยีอย่างสร้างสรรค์ และเป็นกำลังสำคัญของประเทศในอนาคต</p>
        </div>
      </div>

      <a href="index.html" class="btn-back">กลับสู่หน้าแรก</a>
    </div>
  </div>

  <footer>
    <p><strong><?php echo $collegeFullName; ?></strong></p>
    <p>123 ถนนตัวอย่าง ตำบลตัวอย่าง อำเภอตัวอย่าง จังหวัดตัวอย่าง</p>
    <p>โทร: 0xx-xxx-xxxx | อีเมล: college@example.com</p>
    <p>© 2026 All Rights Reserved</p>
  </footer>

</body>
</html>