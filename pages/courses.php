<?php
/**
 * 教練學習平台 - 培訓課程
 */

require_once '../includes/config.php';
require_once '../includes/header.php';

// 設置頁面特定變數
$pageTitle = '培訓課程 - ' . SITE_NAME;
$pageDescription = '專業的教練培訓課程，包含專業教練、團隊教練、家長課程和9型人格課程';
$pageKeywords = '教練培訓,專業教練,團隊教練,家長課程,9型人格,教練課程';
?>

<main class="courses-page">
    <!-- Hero Section -->
    <section class="courses-hero">
        <div class="hero-background">
            <div class="hero-overlay"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">培訓課程</h1>
                <p class="hero-subtitle">專業的教練培訓課程，助您成為優秀的教練人才</p>
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">20+</span>
                        <span class="stat-label">專業課程</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">學員畢業</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">95%</span>
                        <span class="stat-label">滿意度</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Categories -->
    <section class="course-categories">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">課程分類</h2>
                <p class="section-description">選擇適合您的教練培訓課程</p>
            </div>
            
            <div class="categories-grid">
                <div class="category-card" data-animate="fadeInUp">
                    <div class="category-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="category-title">專業教練課程</h3>
                    <p class="category-description">
                        系統化的專業教練培訓，培養核心教練技能和專業素養
                    </p>
                    <div class="category-features">
                        <span class="feature">ICF認證</span>
                        <span class="feature">實戰演練</span>
                        <span class="feature">導師指導</span>
                    </div>
                    <a href="/courses/professional-coaching" class="btn btn-primary">了解詳情</a>
                </div>

                <div class="category-card" data-animate="fadeInUp" data-delay="200">
                    <div class="category-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A1.5 1.5 0 0 0 18.54 8H17c-.8 0-1.54.37-2.01 1l-1.99 2.5V20h6z"/>
                        </svg>
                    </div>
                    <h3 class="category-title">團隊教練課程</h3>
                    <p class="category-description">
                        專注於團隊建設和領導力發展的教練培訓課程
                    </p>
                    <div class="category-features">
                        <span class="feature">團隊動力</span>
                        <span class="feature">領導力</span>
                        <span class="feature">衝突解決</span>
                    </div>
                    <a href="/courses/team-coaching" class="btn btn-primary">了解詳情</a>
                </div>

                <div class="category-card" data-animate="fadeInUp" data-delay="400">
                    <div class="category-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="category-title">家長課程</h3>
                    <p class="category-description">
                        幫助家長建立良好的親子關係，提升家庭教育效果
                    </p>
                    <div class="category-features">
                        <span class="feature">親子溝通</span>
                        <span class="feature">情緒管理</span>
                        <span class="feature">行為引導</span>
                    </div>
                    <a href="/courses/parent-coaching" class="btn btn-primary">了解詳情</a>
                </div>

                <div class="category-card" data-animate="fadeInUp" data-delay="600">
                    <div class="category-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="category-title">9型人格課程</h3>
                    <p class="category-description">
                        深入學習九型人格理論，提升自我認知和人際關係
                    </p>
                    <div class="category-features">
                        <span class="feature">人格分析</span>
                        <span class="feature">自我成長</span>
                        <span class="feature">人際關係</span>
                    </div>
                    <a href="/courses/enneagram" class="btn btn-primary">了解詳情</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Courses -->
    <section class="featured-courses">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">熱門課程</h2>
                <p class="section-description">學員最喜愛的課程推薦</p>
            </div>
            
            <div class="courses-grid">
                <div class="course-card featured" data-animate="fadeInUp">
                    <div class="course-image">
                        <img src="/coach-learning-platform-mainpage/assets/images/courses/professional-coaching.jpg" alt="專業教練基礎課程" loading="lazy">
                        <div class="course-badge">熱門</div>
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">專業教練基礎課程</h3>
                        <p class="course-description">
                            系統學習教練核心技能，掌握專業教練的基礎理論和實踐方法
                        </p>
                        <div class="course-meta">
                            <span class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                12週
                            </span>
                            <span class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                初級
                            </span>
                            <span class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                4.9/5
                            </span>
                        </div>
                        <div class="course-actions">
                            <a href="/courses/professional-coaching" class="btn btn-primary">查看詳情</a>
                            <button class="btn btn-outline" onclick="showCourseModal('professional-coaching')">立即報名</button>
                        </div>
                    </div>
                </div>

                <div class="course-card" data-animate="fadeInUp" data-delay="200">
                    <div class="course-image">
                        <img src="/coach-learning-platform-mainpage/assets/images/courses/team-coaching.jpg" alt="團隊教練實戰課程" loading="lazy">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">團隊教練實戰課程</h3>
                        <p class="course-description">
                            學習如何有效指導團隊，提升團隊凝聚力和執行力
                        </p>
                        <div class="course-meta">
                            <span class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                8週
                            </span>
                            <span class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                中級
                            </span>
                            <span class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                4.8/5
                            </span>
                        </div>
                        <div class="course-actions">
                            <a href="/courses/team-coaching" class="btn btn-primary">查看詳情</a>
                            <button class="btn btn-outline" onclick="showCourseModal('team-coaching')">立即報名</button>
                        </div>
                    </div>
                </div>

                <div class="course-card" data-animate="fadeInUp" data-delay="400">
                    <div class="course-image">
                        <img src="/coach-learning-platform-mainpage/assets/images/courses/parent-coaching.jpg" alt="家長教練課程" loading="lazy">
                    </div>
                    <div class="course-content">
                        <h3 class="course-title">家長教練課程</h3>
                        <p class="course-description">
                            學習如何成為孩子的教練，建立健康的親子關係
                        </p>
                        <div class="course-meta">
                            <span class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                6週
                            </span>
                            <span class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                初級
                            </span>
                            <span class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                4.7/5
                            </span>
                        </div>
                        <div class="course-actions">
                            <a href="/courses/parent-coaching" class="btn btn-primary">查看詳情</a>
                            <button class="btn btn-outline" onclick="showCourseModal('parent-coaching')">立即報名</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Benefits -->
    <section class="course-benefits">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">為什麼選擇我們的課程？</h2>
                <p class="section-description">專業的師資團隊，系統化的課程設計</p>
            </div>
            
            <div class="benefits-grid">
                <div class="benefit-item" data-animate="fadeInUp">
                    <div class="benefit-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="benefit-title">專業認證</h3>
                    <p class="benefit-description">
                        課程獲得國際教練聯合會(ICF)認可，畢業後可申請專業認證
                    </p>
                </div>

                <div class="benefit-item" data-animate="fadeInUp" data-delay="200">
                    <div class="benefit-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="benefit-title">實戰演練</h3>
                    <p class="benefit-description">
                        理論與實踐並重，大量實戰演練幫助學員掌握教練技能
                    </p>
                </div>

                <div class="benefit-item" data-animate="fadeInUp" data-delay="400">
                    <div class="benefit-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="benefit-title">導師指導</h3>
                    <p class="benefit-description">
                        經驗豐富的導師一對一指導，確保學習效果和個人成長
                    </p>
                </div>

                <div class="benefit-item" data-animate="fadeInUp" data-delay="600">
                    <div class="benefit-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="benefit-title">持續支持</h3>
                    <p class="benefit-description">
                        畢業後提供持續的專業發展支持和校友網絡
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="courses-cta">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">準備好開始您的教練之旅了嗎？</h2>
                <p class="cta-description">
                    選擇適合的課程，開始您的專業教練培訓之路
                </p>
                <div class="cta-actions">
                    <button class="btn btn-primary btn-large" onclick="showCourseModal('consultation')">免費諮詢</button>
                    <a href="/contact" class="btn btn-outline btn-large">聯繫我們</a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Course Registration Modal -->
<div id="courseModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">課程報名</h3>
            <button class="modal-close" onclick="closeCourseModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="courseForm" class="course-form">
                <div class="form-group">
                    <label for="courseName">課程名稱</label>
                    <input type="text" id="courseName" name="courseName" readonly>
                </div>
                <div class="form-group">
                    <label for="applicantName">姓名 *</label>
                    <input type="text" id="applicantName" name="applicantName" required>
                </div>
                <div class="form-group">
                    <label for="applicantEmail">電子郵件 *</label>
                    <input type="email" id="applicantEmail" name="applicantEmail" required>
                </div>
                <div class="form-group">
                    <label for="applicantPhone">聯絡電話 *</label>
                    <input type="tel" id="applicantPhone" name="applicantPhone" required>
                </div>
                <div class="form-group">
                    <label for="applicantMessage">備註訊息</label>
                    <textarea id="applicantMessage" name="applicantMessage" rows="4"></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">提交報名</button>
                    <button type="button" class="btn btn-outline" onclick="closeCourseModal()">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
