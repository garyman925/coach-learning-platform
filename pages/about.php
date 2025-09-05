<?php
/**
 * 教練學習平台 - 關於我們
 */

require_once '../includes/config.php';
require_once '../includes/header.php';
?>

<main class="about-page">
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="hero-background">
            <div class="hero-overlay"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">關於我們</h1>
                <p class="hero-subtitle">專業的教練培訓平台，致力於培養優秀的教練人才</p>
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">學員畢業</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">專業教練</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">10+</span>
                        <span class="stat-label">年經驗</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Introduction -->
    <section class="company-intro">
        <div class="container">
            <div class="intro-content">
                <div class="intro-text" data-animate="fadeInLeft">
                    <h2 class="section-title">我們的使命</h2>
                    <p class="intro-description">
                        教練學習平台成立於2014年，我們致力於為個人和企業提供最專業的教練培訓服務。
                        透過系統化的課程設計、經驗豐富的師資團隊，以及實用的實戰演練，幫助每一位學員
                        掌握教練技能，成為優秀的教練人才。
                    </p>
                    <p class="intro-description">
                        我們相信，每個人都有潛力成為優秀的教練。透過專業的培訓和持續的實踐，
                        我們可以幫助學員在教練領域取得成功，為社會創造更多價值。
                    </p>
                </div>
                <div class="intro-image" data-animate="fadeInRight">
                    <img src="/coach-learning-platform-mainpage/assets/images/about/mission.svg" alt="我們的使命" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="core-values">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">核心價值觀</h2>
                <p class="section-description">這些價值觀指引著我們的每一個決策和行動</p>
            </div>
            
            <div class="values-grid">
                <div class="value-card" data-animate="fadeInUp">
                    <div class="value-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="value-title">專業卓越</h3>
                    <p class="value-description">
                        我們堅持最高標準的專業品質，確保每一位學員都能獲得最優質的培訓體驗。
                    </p>
                </div>

                <div class="value-card" data-animate="fadeInUp" data-delay="200">
                    <div class="value-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="value-title">持續創新</h3>
                    <p class="value-description">
                        我們不斷探索新的教學方法和技術，確保課程內容與時俱進，滿足學員需求。
                    </p>
                </div>

                <div class="value-card" data-animate="fadeInUp" data-delay="400">
                    <div class="value-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="value-title">以人為本</h3>
                    <p class="value-description">
                        我們重視每一位學員的成長和發展，提供個性化的學習支持和指導。
                    </p>
                </div>

                <div class="value-card" data-animate="fadeInUp" data-delay="600">
                    <div class="value-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="value-title">誠信負責</h3>
                    <p class="value-description">
                        我們承諾對每一位學員負責，提供真實、有效的培訓內容和服務。
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Development History -->
    <section class="development-history">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">發展歷程</h2>
                <p class="section-description">見證我們的成長與進步</p>
            </div>
            
            <div class="timeline">
                <div class="timeline-item" data-animate="fadeInLeft">
                    <div class="timeline-marker">2014</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">平台成立</h3>
                        <p class="timeline-description">
                            教練學習平台正式成立，開始提供專業教練培訓服務。
                        </p>
                    </div>
                </div>

                <div class="timeline-item" data-animate="fadeInRight">
                    <div class="timeline-marker">2016</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">課程擴展</h3>
                        <p class="timeline-description">
                            新增企業教練和團隊教練課程，服務範圍進一步擴大。
                        </p>
                    </div>
                </div>

                <div class="timeline-item" data-animate="fadeInLeft">
                    <div class="timeline-marker">2018</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">國際認證</h3>
                        <p class="timeline-description">
                            獲得國際教練聯合會(ICF)認證，成為官方認可的培訓機構。
                        </p>
                    </div>
                </div>

                <div class="timeline-item" data-animate="fadeInRight">
                    <div class="timeline-marker">2020</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">線上轉型</h3>
                        <p class="timeline-description">
                            推出線上學習平台，為學員提供更靈活的學習方式。
                        </p>
                    </div>
                </div>

                <div class="timeline-item" data-animate="fadeInLeft">
                    <div class="timeline-marker">2024</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">未來展望</h3>
                        <p class="timeline-description">
                            持續創新發展，致力於成為亞洲領先的教練培訓平台。
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Introduction -->
    <section class="team-introduction">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">核心團隊</h2>
                <p class="section-description">認識我們的專業團隊成員</p>
            </div>
            
            <div class="team-grid">
                <div class="team-member" data-animate="fadeInUp">
                    <div class="member-image">
                        <img src="/coach-learning-platform-mainpage/assets/images/team/ceo.svg" alt="執行長 - 張志明" loading="lazy">
                    </div>
                    <div class="member-info">
                        <h3 class="member-name">張志明</h3>
                        <p class="member-title">執行長 / 創始人</p>
                        <p class="member-description">
                            擁有20年企業管理和教練經驗，曾擔任多家知名企業的顧問，
                            專精於領導力發展和組織變革。
                        </p>
                        <div class="member-credentials">
                            <span class="credential">ICF認證教練</span>
                            <span class="credential">MBA</span>
                        </div>
                    </div>
                </div>

                <div class="team-member" data-animate="fadeInUp" data-delay="200">
                    <div class="member-image">
                        <img src="/coach-learning-platform-mainpage/assets/images/team/cto.svg" alt="技術總監 - 李美玲" loading="lazy">
                    </div>
                    <div class="member-info">
                        <h3 class="member-name">李美玲</h3>
                        <p class="member-title">技術總監</p>
                        <p class="member-description">
                            負責平台技術開發和創新，擁有豐富的軟體開發和數位學習平台經驗，
                            致力於為學員提供最佳的線上學習體驗。
                        </p>
                        <div class="member-credentials">
                            <span class="credential">資深工程師</span>
                            <span class="credential">教育科技碩士</span>
                        </div>
                    </div>
                </div>

                <div class="team-member" data-animate="fadeInUp" data-delay="400">
                    <div class="member-image">
                        <img src="/coach-learning-platform-mainpage/assets/images/team/director.svg" alt="課程總監 - 王建國" loading="lazy">
                    </div>
                    <div class="member-info">
                        <h3 class="member-name">王建國</h3>
                        <p class="member-title">課程總監</p>
                        <p class="member-description">
                            負責課程設計和師資管理，擁有15年教練培訓經驗，
                            專精於課程開發和教學方法創新。
                        </p>
                        <div class="member-credentials">
                            <span class="credential">資深教練</span>
                            <span class="credential">教育學博士</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements -->
    <section class="achievements">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">成就與認證</h2>
                <p class="section-description">我們獲得的認可和榮譽</p>
            </div>
            
            <div class="achievements-grid">
                <div class="achievement-item" data-animate="fadeInUp">
                    <div class="achievement-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="achievement-title">ICF認證</h3>
                    <p class="achievement-description">
                        國際教練聯合會官方認可的培訓機構
                    </p>
                </div>

                <div class="achievement-item" data-animate="fadeInUp" data-delay="200">
                    <div class="achievement-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="achievement-title">優秀企業獎</h3>
                    <p class="achievement-description">
                        2023年獲得教育行業優秀企業獎
                    </p>
                </div>

                <div class="achievement-item" data-animate="fadeInUp" data-delay="400">
                    <div class="achievement-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="achievement-title">學員滿意度</h3>
                    <p class="achievement-description">
                        連續5年學員滿意度達95%以上
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="about-cta">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">準備好開始您的教練之旅了嗎？</h2>
                <p class="cta-description">
                    加入我們，成為專業的教練人才，為他人創造價值，實現自我成長。
                </p>
                <div class="cta-actions">
                    <a href="/courses" class="btn btn-primary btn-large">探索課程</a>
                    <a href="/contact" class="btn btn-outline btn-large">聯繫我們</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../includes/footer.php'; ?>
