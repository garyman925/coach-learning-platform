<?php
/**
 * 教練學習平台 - 首頁
 */



// 包含配置文件
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

// 設置頁面特定變量
$pageTitle = '首頁 - ' . SITE_NAME;
$pageDescription = '專業的教練培訓課程和服務平台，提供個人教練、企業教練、團隊教練等專業服務';
$pageKeywords = '教練培訓,專業教練,企業教練,團隊教練,家長課程,9型人格,教練服務';
$pageCSS = 'assets/css/pages/home.css';
$pageJS = 'assets/js/components/Slider.js';

// 包含頁面頭部
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-slider">
        <div class="hero-slide active" data-slide="1">
            <div class="hero-background">
                <img src="<?php echo BASE_URL; ?>/assets/images/hero/hero-bg-1.png" alt="專業教練培訓" class="hero-image">
                <div class="hero-overlay"></div>
            </div>
            <div class="hero-content">
                <div class="container">
                    <div class="hero-text">
                        <h1 class="hero-title">
                            <span class="hero-title-line">專業教練培訓</span>
                            <span class="hero-title-line">成就卓越人生</span>
                        </h1>
                        <p class="hero-description">
                            透過專業的教練培訓課程，幫助您掌握教練技能，成為優秀的教練人才
                        </p>
                        <div class="hero-actions">
                            <a href="/courses" class="btn btn-primary btn-large">探索課程</a>
                            <a href="/contact" class="btn btn-outline btn-large">咨詢服務</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Actions Section -->
<section class="main-actions-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">開始您的教練之旅</h2>
            <p class="section-description">選擇適合您的路徑，開啟專業教練的職業生涯</p>
        </div>
        
        <div class="action-cards">
                         <div class="action-card" data-animate="fadeInUp">
                 <div class="card-icon">
                     <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                         <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                     </svg>
                 </div>
                 <h3 class="card-title">預訂教練</h3>
                 <p class="card-description">
                     與專業教練一對一交流，獲得個性化的指導和建議，解決您的具體問題
                 </p>
                 <a href="/coach-services" class="btn btn-primary">立即預訂</a>
             </div>
            
                         <div class="action-card" data-animate="fadeInUp" data-delay="200">
                 <div class="card-icon">
                     <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                         <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09v6.91L12 23l-9-5v-7l9-5 9 5v7l-2 1.09V9L12 3z"/>
                     </svg>
                 </div>
                 <h3 class="card-title">成為教練</h3>
                 <p class="card-description">
                     參加專業的教練培訓課程，掌握教練技能，獲得國際認證，開啟教練職業生涯
                 </p>
                 <a href="/courses" class="btn btn-primary">查看課程</a>
             </div>
            
                         <div class="action-card" data-animate="fadeInUp" data-delay="400">
                 <div class="card-icon">
                     <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                         <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                     </svg>
                 </div>
                 <h3 class="card-title">體驗課程</h3>
                 <p class="card-description">
                     免費體驗我們的教練課程，了解教練培訓的內容和方式，找到適合您的學習路徑
                 </p>
                 <a href="/courses" class="btn btn-primary">免費體驗</a>
             </div>
        </div>
    </div>
</section>

<!-- Coach Introduction Section -->
<section class="coach-introduction-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">認識我們的專業教練團隊</h2>
            <p class="section-description">經驗豐富的教練專家，為您提供專業的指導和支持</p>
        </div>
        
        <div class="coach-carousel-container">
            <div class="coach-carousel-wrapper">
                <div class="coach-carousel-track">
                    <!-- Coach 1 -->
                    <div class="coach-card" data-animate="fadeInUp">
                        <div class="coach-image">
                            <img src="<?php echo BASE_URL; ?>/assets/images/coaches/coach-1.png" alt="專業教練 - 張教練" loading="lazy">
                            <div class="coach-overlay">
                                <div class="coach-social">
                                    <a href="#" class="social-link" aria-label="LinkedIn">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.047-1.032-3.047-1.032 0-1.26 1.317-1.26 3.031v5.585H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="coach-info">
                            <h3 class="coach-name">張教練</h3>
                            <p class="coach-title">資深專業教練</p>
                            <p class="coach-specialty">領導力發展、團隊建設</p>
                            <p class="coach-description">
                                擁有15年企業教練經驗，專精於領導力發展和團隊效能提升。
                            </p>
                            <div class="coach-credentials">
                                <span class="credential">ICF認證</span>
                                <span class="credential">MBA</span>
                            </div>
                            <div class="coach-actions">
                                <a href="/coaches/zhang" class="btn btn-outline btn-sm">查看詳情</a>
                                <a href="/booking?coach=zhang" class="btn btn-primary btn-sm">預約諮詢</a>
                            </div>
                        </div>
                    </div>

                    <!-- Coach 2 -->
                    <div class="coach-card" data-animate="fadeInUp" data-delay="200">
                        <div class="coach-image">
                            <img src="<?php echo BASE_URL; ?>/assets/images/coaches/coach-2.png" alt="專業教練 - 李教練" loading="lazy">
                            <div class="coach-overlay">
                                <div class="coach-social">
                                    <a href="#" class="social-link" aria-label="LinkedIn">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.047-1.032-3.047-1.032 0-1.26 1.317-1.26 3.031v5.585H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="coach-info">
                            <h3 class="coach-name">李教練</h3>
                            <p class="coach-title">9型人格專家</p>
                            <p class="coach-specialty">9型人格分析、親子關係</p>
                            <p class="coach-description">
                                專注於9型人格理論研究和應用，幫助個人和家庭建立更好的關係。
                            </p>
                            <div class="coach-credentials">
                                <span class="credential">9型認證</span>
                                <span class="credential">心理碩士</span>
                            </div>
                            <div class="coach-actions">
                                <a href="/coaches/li" class="btn btn-outline btn-sm">查看詳情</a>
                                <a href="/booking?coach=li" class="btn btn-primary btn-sm">預約諮詢</a>
                            </div>
                        </div>
                    </div>

                    <!-- Coach 3 -->
                    <div class="coach-card" data-animate="fadeInUp" data-delay="400">
                        <div class="coach-image">
                            <img src="<?php echo BASE_URL; ?>/assets/images/coaches/coach-3.png" alt="專業教練 - 王教練" loading="lazy">
                            <div class="coach-overlay">
                                <div class="coach-social">
                                    <a href="#" class="social-link" aria-label="LinkedIn">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.047-1.032-3.047-1.032 0-1.26 1.317-1.26 3.031v5.585H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="coach-info">
                            <h3 class="coach-name">王教練</h3>
                            <p class="coach-title">企業教練顧問</p>
                            <p class="coach-specialty">企業轉型、組織發展</p>
                            <p class="coach-description">
                                專注於企業組織發展和變革管理，協助企業建立高效能團隊。
                            </p>
                            <div class="coach-credentials">
                                <span class="credential">企業認證</span>
                                <span class="credential">管理博士</span>
                            </div>
                            <div class="coach-actions">
                                <a href="/coaches/wang" class="btn btn-outline btn-sm">查看詳情</a>
                                <a href="/booking?coach=wang" class="btn btn-primary btn-sm">預約諮詢</a>
                            </div>
                        </div>
                    </div>

                    <!-- Coach 4 (新增) -->
                    <div class="coach-card" data-animate="fadeInUp" data-delay="600">
                        <div class="coach-image">
                            <img src="<?php echo BASE_URL; ?>/assets/images/coaches/coach-4.png" alt="專業教練 - 陳教練" loading="lazy">
                            <div class="coach-overlay">
                                <div class="coach-social">
                                    <a href="#" class="social-link" aria-label="LinkedIn">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.047-1.032-3.047-1.032 0-1.26 1.317-1.26 3.031v5.585H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="coach-info">
                            <h3 class="coach-name">陳教練</h3>
                            <p class="coach-title">親子教練專家</p>
                            <p class="coach-specialty">親子溝通、情緒管理</p>
                            <p class="coach-description">
                                專注於親子關係改善，幫助家長建立更好的溝通模式。
                            </p>
                            <div class="coach-credentials">
                                <span class="credential">親子認證</span>
                                <span class="credential">教育碩士</span>
                            </div>
                            <div class="coach-actions">
                                <a href="/coaches/chen" class="btn btn-outline btn-sm">查看詳情</a>
                                <a href="/booking?coach=chen" class="btn btn-primary btn-sm">預約諮詢</a>
                            </div>
                        </div>
                    </div>

                    <!-- Coach 5 (新增) -->
                    <div class="coach-card" data-animate="fadeInUp" data-delay="800">
                        <div class="coach-image">
                            <img src="<?php echo BASE_URL; ?>/assets/images/coaches/coach-1.png" alt="專業教練 - 林教練" loading="lazy">
                            <div class="coach-overlay">
                                <div class="coach-social">
                                    <a href="#" class="social-link" aria-label="LinkedIn">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.047-1.032-3.047-1.032 0-1.26 1.317-1.26 3.031v5.585H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="coach-info">
                            <h3 class="coach-name">林教練</h3>
                            <p class="coach-title">團隊教練顧問</p>
                            <p class="coach-specialty">團隊建設、衝突解決</p>
                            <p class="coach-description">
                                專精於團隊效能提升，協助企業建立高績效團隊文化。
                            </p>
                            <div class="coach-credentials">
                                <span class="credential">團隊認證</span>
                                <span class="credential">組織心理學</span>
                            </div>
                            <div class="coach-actions">
                                <a href="/coaches/lin" class="btn btn-outline btn-sm">查看詳情</a>
                                <a href="/booking?coach=lin" class="btn btn-primary btn-sm">預約諮詢</a>
                            </div>
                        </div>
                    </div>

                    <!-- Coach 6 (新增) -->
                    <div class="coach-card" data-animate="fadeInUp" data-delay="1000">
                        <div class="coach-image">
                            <img src="<?php echo BASE_URL; ?>/assets/images/coaches/coach-2.png" alt="專業教練 - 黃教練" loading="lazy">
                            <div class="coach-overlay">
                                <div class="coach-social">
                                    <a href="#" class="social-link" aria-label="LinkedIn">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.047-1.032-3.047-1.032 0-1.26 1.317-1.26 3.031v5.585H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="coach-info">
                            <h3 class="coach-name">黃教練</h3>
                            <p class="coach-title">職涯發展教練</p>
                            <p class="coach-specialty">職涯規劃、技能提升</p>
                            <p class="coach-description">
                                幫助個人找到職業方向，提升職場競爭力和個人價值。
                            </p>
                            <div class="coach-credentials">
                                <span class="credential">職涯認證</span>
                                <span class="credential">人力資源</span>
                            </div>
                            <div class="coach-actions">
                                <a href="/coaches/huang" class="btn btn-outline btn-sm">查看詳情</a>
                                <a href="/booking?coach=huang" class="btn btn-primary btn-sm">預約諮詢</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 輪播控制按鈕 -->
            <div class="coach-carousel-controls">
                <button class="coach-carousel-btn coach-carousel-prev" aria-label="上一頁">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                </button>
                <div class="coach-carousel-indicators">
                    <button class="coach-carousel-indicator active" data-slide="0" aria-label="第1頁"></button>
                    <button class="coach-carousel-indicator" data-slide="1" aria-label="第2頁"></button>
                </div>
                <button class="coach-carousel-btn coach-carousel-next" aria-label="下一頁">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="coach-section-footer">
            <p class="coach-footer-text">想要了解更多教練資訊？</p>
            <a href="/coaches" class="btn btn-outline btn-large">查看所有教練</a>
        </div>
    </div>
</section>

<!-- Latest News & Activities Section -->
<section class="news-activities-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">最新消息與活動</h2>
            <p class="section-description">了解我們的最新課程、活動和行業動態</p>
        </div>
        
        <div class="news-grid">
            <!-- News Item 1 -->
            <article class="news-card" data-animate="fadeInUp">
                <div class="news-image">
                    <img src="assets/images/news/news-1.svg" alt="專業教練認證課程開課" loading="lazy">
                    <div class="news-category">課程資訊</div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date">2024年1月15日</span>
                        <span class="news-author">教練平台</span>
                    </div>
                    <h3 class="news-title">2024年專業教練認證課程正式開課</h3>
                    <p class="news-excerpt">
                        我們很高興地宣布，2024年專業教練認證課程正式開課！本課程將為學員提供全面的教練技能培訓...
                    </p>
                    <div class="news-actions">
                        <a href="/news/coach-certification-2024" class="btn btn-outline btn-sm">閱讀更多</a>
                        <a href="/courses/professional-coaching" class="btn btn-primary btn-sm">立即報名</a>
                    </div>
                </div>
            </article>

            <!-- News Item 2 -->
            <article class="news-card" data-animate="fadeInUp" data-delay="200">
                <div class="news-image">
                    <img src="assets/images/news/news-2.svg" alt="企業教練工作坊" loading="lazy">
                    <div class="news-category">活動預告</div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date">2024年1月20日</span>
                        <span class="news-author">教練平台</span>
                    </div>
                    <h3 class="news-title">企業教練工作坊：提升團隊效能</h3>
                    <p class="news-excerpt">
                        針對企業管理者和HR專業人士的專題工作坊，學習如何運用教練技巧提升團隊效能和員工滿意度...
                    </p>
                    <div class="news-actions">
                        <a href="/news/enterprise-coaching-workshop" class="btn btn-outline btn-sm">閱讀更多</a>
                        <a href="/events/enterprise-workshop" class="btn btn-primary btn-sm">報名參加</a>
                    </div>
                </div>
            </article>

            <!-- News Item 3 -->
            <article class="news-card" data-animate="fadeInUp" data-delay="400">
                <div class="news-image">
                    <img src="assets/images/news/news-3.svg" alt="9型人格親子課程" loading="lazy">
                    <div class="news-category">課程更新</div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date">2024年1月25日</span>
                        <span class="news-author">教練平台</span>
                    </div>
                    <h3 class="news-title">9型人格親子課程全新升級</h3>
                    <p class="news-excerpt">
                        基於家長反饋，我們對9型人格親子課程進行了全面升級，新增更多實用工具和案例分析...
                    </p>
                    <div class="news-actions">
                        <a href="/news/enneagram-parenting-upgrade" class="btn btn-outline btn-sm">閱讀更多</a>
                        <a href="/courses/parenting-enneagram" class="btn btn-primary btn-sm">了解詳情</a>
                    </div>
                </div>
            </article>
        </div>

        <div class="news-section-footer">
            <p class="news-footer-text">想要獲取更多最新資訊？</p>
            <a href="/news" class="btn btn-outline btn-large">查看所有新聞</a>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="contact-form-section">
    <div class="container">
        <div class="contact-content">
            <div class="contact-info" data-animate="fadeInLeft">
                <h2 class="contact-title">聯繫我們</h2>
                <p class="contact-description">
                    有任何問題或需要諮詢？我們很樂意為您提供幫助。請填寫以下表單，我們會盡快回覆您。
                </p>
                
                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        </div>
                        <div class="contact-text">
                            <h4>地址</h4>
                            <p>台北市信義區信義路五段7號</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                        </div>
                        <div class="contact-text">
                            <h4>電話</h4>
                            <p>+886 2 2345 6789</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        <div class="contact-text">
                            <h4>電子郵件</h4>
                            <p>info@coachplatform.com</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="contact-form-container" data-animate="fadeInRight">
                <form id="homepage-contact-form" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact-name">姓名 *</label>
                            <input type="text" id="contact-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-email">電子郵件 *</label>
                            <input type="email" id="contact-email" name="email" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-phone">電話號碼</label>
                        <input type="tel" id="contact-phone" name="phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-subject">諮詢主題 *</label>
                        <select id="contact-subject" name="subject" required>
                            <option value="">請選擇諮詢主題</option>
                            <option value="course-inquiry">課程諮詢</option>
                            <option value="coaching-service">教練服務</option>
                            <option value="partnership">合作夥伴</option>
                            <option value="general">一般諮詢</option>
                            <option value="other">其他</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-message">訊息內容 *</label>
                        <textarea id="contact-message" name="message" rows="5" required placeholder="請詳細描述您的需求或問題..."></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-large">發送訊息</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<?php
// 包含頁面頁腳
include 'includes/footer.php';
?>
