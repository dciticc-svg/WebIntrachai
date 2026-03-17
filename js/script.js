// --- สคริปต์สำหรับหน้าแรก (Frontend) ---
document.addEventListener('DOMContentLoaded', () => {
    loadFrontendNews();
});

// ฟังก์ชันดึงข่าวจาก LocalStorage มาวาดเป็นการ์ดหน้าเว็บ
function loadFrontendNews() {
    const newsContainer = document.getElementById('frontend-news-container');
    
    // ป้องกัน Error ถ้าหน้าไหนไม่มี container นี้ (เช่น หน้าอื่นที่ไม่ได้โชว์ข่าว)
    if (!newsContainer) return;

    // ดึงฐานข้อมูลข่าว
    let newsList = JSON.parse(localStorage.getItem('intrachai_news')) || [];

    newsContainer.innerHTML = ''; // ล้างกล่องให้สะอาด

    // ถ้าไม่มีข่าวเลย ให้โชว์กล่องบอกว่ากำลังอัปเดต
    if (newsList.length === 0) {
        newsContainer.innerHTML = `
            <div class="no-news">
                <i class="fas fa-bullhorn" style="font-size: 40px; color: #ccc; margin-bottom: 10px;"></i>
                <h3>กำลังอัปเดตข้อมูลข่าวสาร</h3>
                <p>โปรดติดตามประกาศจากทางวิทยาลัยในเร็วๆ นี้</p>
            </div>
        `;
        return;
    }

    // วนลูปสร้างการ์ดข่าว (โชว์แค่ 3 ข่าวล่าสุดเพื่อความสวยงาม)
    const recentNews = newsList.slice(0, 3);

    recentNews.forEach(news => {
        const card = document.createElement('div');
        card.className = 'news-card';
        
        const formattedDate = new Date(news.date).toLocaleDateString('th-TH', { year: 'numeric', month: 'short', day: 'numeric' });

        card.innerHTML = `
            <span class="news-date"><i class="far fa-calendar-alt"></i> ${formattedDate}</span>
            <h3 class="news-title">${news.title}</h3>
            <p class="news-desc">${news.desc}</p>
        `;
        newsContainer.appendChild(card);
    });
}