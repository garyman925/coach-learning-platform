<?php
/**
 * 教練學習平台 - 專業教練課程
 */

require_once '../../includes/config.php';
require_once '../../includes/header.php';

// 設置頁面特定變數
$pageTitle = '專業教練基礎課程 - ' . SITE_NAME;
$pageDescription = '系統學習教練核心技能，掌握專業教練的基礎理論和實踐方法，獲得ICF認證';
$pageKeywords = '專業教練,教練培訓,ICF認證,教練技能,教練理論,教練實踐';
?>

<main class="course-detail-page">
    <!-- Hero Section -->
    <section class="course-hero">
        <div class="hero-background">
            <div class="hero-overlay"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <div class="course-badge">ICF認證課程</div>
                <h1 class="hero-title">專業教練基礎課程</h1>
                <p class="hero-subtitle">
                    系統學習教練核心技能，掌握專業教練的基礎理論和實踐方法
                </p>
                <div class="course-meta-hero">
                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <span>12週課程</span>
                    </div>
                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <span>初級到中級</span>
                    </div>
                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <span>4.9/5 評分</span>
                    </div>
                </div>
                <div class="hero-actions">
                    <button class="btn btn-primary btn-large" onclick="showCourseModal('professional-coaching')">立即報名</button>
                    <a href="#course-content" class="btn btn-outline btn-large">了解詳情</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Content -->
    <section id="course-content" class="course-content">
        <div class="container">
            <div class="content-grid">
                <!-- 主要內容 -->
                <div class="main-content">
                    <!-- 課程介紹 -->
                    <div class="content-section">
                        <h2 class="section-title">課程介紹</h2>
                        <p class="section-text">
                            專業教練基礎課程是我們的核心課程之一，專為想要成為專業教練的學員設計。
                            課程涵蓋教練的核心理論、技能和實踐方法，幫助學員建立堅實的教練基礎。
                        </p>
                        <p class="section-text">
                            通過系統化的學習和大量的實戰演練，學員將掌握教練的核心技能，
                            包括積極聆聽、有力提問、目標設定、行動規劃等，為未來的教練生涯奠定基礎。
                        </p>
                    </div>

                    <!-- 課程大綱 -->
                    <div class="content-section">
                        <h2 class="section-title">課程大綱</h2>
                        <div class="curriculum-list">
                            <div class="curriculum-item">
                                <div class="curriculum-header">
                                    <h3>第一週：教練基礎理論</h3>
                                    <span class="week-badge">第1週</span>
                                </div>
                                <ul class="curriculum-topics">
                                    <li>什麼是教練？教練與諮詢、培訓的區別</li>
                                    <li>教練的核心原則和價值觀</li>
                                    <li>教練關係的建立和維護</li>
                                </ul>
                            </div>

                            <div class="curriculum-item">
                                <div class="curriculum-header">
                                    <h3>第二週：積極聆聽技能</h3>
                                    <span class="week-badge">第2週</span>
                                </div>
                                <ul class="curriculum-topics">
                                    <li>聆聽的三個層次</li>
                                    <li>非語言溝通的理解</li>
                                    <li>聆聽中的常見障礙和克服方法</li>
                                </ul>
                            </div>

                            <div class="curriculum-item">
                                <div class="curriculum-header">
                                    <h3>第三週：有力提問技巧</h3>
                                    <span class="week-badge">第3週</span>
                                </div>
                                <ul class="curriculum-topics">
                                    <li>開放式問題的設計</li>
                                    <li>深度探索問題的運用</li>
                                    <li>問題的時機和節奏控制</li>
                                </ul>
                            </div>

                            <div class="curriculum-item">
                                <div class="curriculum-header">
                                    <h3>第四週：目標設定與規劃</h3>
                                    <span class="week-badge">第4週</span>
                                </div>
                                <ul class="curriculum-topics">
                                    <li>SMART目標設定原則</li>
                                    <li>行動計劃的制定</li>
                                    <li>進度追蹤和調整方法</li>
                                </ul>
                            </div>

                            <div class="curriculum-item">
                                <div class="curriculum-header">
                                    <h3>第五週：教練會話結構</h3>
                                    <span class="week-badge">第5週</span>
                                </div>
                                <ul class="curriculum-topics">
                                    <li>GROW模型的運用</li>
                                    <li>會話的開場和結尾技巧</li>
                                    <li>會話中的時間管理</li>
                                </ul>
                            </div>

                            <div class="curriculum-item">
                                <div class="curriculum-header">
                                    <h3>第六週：實戰演練與反饋</h3>
                                    <span class="week-badge">第6週</span>
                                </div>
                                <ul class="curriculum-topics">
                                    <li>角色扮演練習</li>
                                    <li>同儕反饋和導師指導</li>
                                    <li>自我反思和改進方法</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 學習成果 -->
                    <div class="content-section">
                        <h2 class="section-title">學習成果</h2>
                        <div class="outcomes-grid">
                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <h3>掌握核心教練技能</h3>
                                <p>學會積極聆聽、有力提問、目標設定等核心教練技能</p>
                            </div>

                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <h3>建立教練思維模式</h3>
                                <p>培養教練的思維方式和價值觀，建立專業的教練身份認同</p>
                            </div>

                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <h3>獲得實戰經驗</h3>
                                <p>通過大量實戰演練，積累實際的教練經驗和信心</p>
                            </div>

                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <h3>準備ICF認證</h3>
                                <p>為申請國際教練聯合會(ICF)認證做好準備</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 側邊欄 -->
                <div class="sidebar">
                    <!-- 課程資訊卡片 -->
                    <div class="course-info-card">
                        <h3>課程資訊</h3>
                        <div class="info-item">
                            <span class="info-label">課程時長</span>
                            <span class="info-value">12週</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">上課時間</span>
                            <span class="info-value">每週二、四 19:00-21:00</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">課程形式</span>
                            <span class="info-value">線上 + 線下混合</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">班級人數</span>
                            <span class="info-value">15-20人</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">課程費用</span>
                            <span class="info-value">NT$ 45,000</span>
                        </div>
                        <button class="btn btn-primary btn-full" onclick="showCourseModal('professional-coaching')">
                            立即報名
                        </button>
                    </div>

                    <!-- 導師介紹 -->
                    <div class="instructor-card">
                        <h3>課程導師</h3>
                        <div class="instructor-info">
                            <img src="/coach-learning-platform-mainpage/assets/images/team/ceo.svg" alt="張美玲 資深教練" class="instructor-avatar">
                            <div class="instructor-details">
                                <h4>張美玲</h4>
                                <p class="instructor-title">資深教練</p>
                                <p class="instructor-bio">
                                    擁有15年教練經驗，ICF認證專業教練(PCC)，
                                    專精於個人發展和領導力教練。
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- 學員評價 -->
                    <div class="testimonials-card">
                        <h3>學員評價</h3>
                        <div class="testimonial-item">
                            <div class="testimonial-rating">
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                            </div>
                            <p class="testimonial-text">
                                "這門課程讓我對教練有了全新的認識，導師的指導非常專業，
                                實戰演練讓我收穫滿滿。"
                            </p>
                            <p class="testimonial-author">- 李小明，企業主管</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="course-cta">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">準備好開始您的教練之旅了嗎？</h2>
                <p class="cta-description">
                    加入專業教練基礎課程，掌握核心技能，成為優秀的教練人才
                </p>
                <div class="cta-actions">
                    <button class="btn btn-primary btn-large" onclick="showCourseModal('professional-coaching')">立即報名</button>
                    <a href="/contact" class="btn btn-outline btn-large">聯繫我們</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../../includes/footer.php'; ?>
