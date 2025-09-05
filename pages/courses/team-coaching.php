<?php
/**
 * 教練學習平台 - 團隊教練課程
 */

require_once '../../includes/config.php';
require_once '../../includes/header.php';

// 設置頁面特定變數
$pageTitle = '團隊教練進階課程 - ' . SITE_NAME;
$pageDescription = '學習團隊教練技能，掌握團隊動力學、衝突管理和團隊建設技巧，提升團隊效能';
$pageKeywords = '團隊教練,團隊動力學,衝突管理,團隊建設,團隊效能,教練技能';
?>

<main class="course-detail-page">
    <!-- Hero Section -->
    <section class="course-hero">
        <div class="hero-background">
            <div class="hero-pattern"></div>
            <div class="hero-overlay"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <div class="course-badge">團隊教練</div>
                <h1 class="hero-title">團隊教練進階課程</h1>
                <p class="hero-subtitle">掌握團隊動力學，建立高效能團隊</p>
                <div class="course-meta-hero">
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span>8 週課程</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-users"></i>
                        <span>小組學習</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-certificate"></i>
                        <span>國際認證</span>
                    </div>
                </div>
                <div class="hero-actions">
                    <button class="btn btn-primary" onclick="showCourseModal('team-coaching')">
                        <i class="fas fa-edit"></i>
                        立即報名
                    </button>
                    <a href="#course-content" class="btn btn-outline">
                        <i class="fas fa-info-circle"></i>
                        了解更多
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Content -->
    <section id="course-content" class="course-content">
        <div class="container">
            <div class="content-grid">
                <div class="main-content">
                    <!-- 課程介紹 -->
                    <div class="content-section">
                        <h2>課程介紹</h2>
                        <p>團隊教練進階課程專為有志於成為專業團隊教練的學員設計。本課程深入探討團隊動力學、衝突管理、團隊建設等核心議題，幫助學員掌握實用的團隊教練技能。</p>
                        
                        <div class="highlight-box">
                            <h3>課程特色</h3>
                            <ul>
                                <li><strong>實戰導向：</strong>結合理論與實踐，通過真實案例學習</li>
                                <li><strong>小組互動：</strong>與同儕一起練習，建立教練社群</li>
                                <li><strong>國際認證：</strong>完成課程後可獲得國際教練聯盟認證</li>
                                <li><strong>持續支持：</strong>畢業後仍可參與校友活動和進修課程</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 課程大綱 -->
                    <div class="content-section">
                        <h2>課程大綱</h2>
                        <div class="curriculum-list">
                            <div class="curriculum-item">
                                <div class="week-number">第 1-2 週</div>
                                <div class="week-content">
                                    <h4>團隊動力學基礎</h4>
                                    <p>了解團隊發展階段、角色定位和溝通模式</p>
                                    <ul>
                                        <li>團隊發展的五大階段</li>
                                        <li>團隊角色理論與應用</li>
                                        <li>有效溝通技巧</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="curriculum-item">
                                <div class="week-number">第 3-4 週</div>
                                <div class="week-content">
                                    <h4>衝突管理與解決</h4>
                                    <p>學習識別衝突根源，掌握調解技巧</p>
                                    <ul>
                                        <li>衝突類型分析</li>
                                        <li>調解技巧與工具</li>
                                        <li>建立共識的方法</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="curriculum-item">
                                <div class="week-number">第 5-6 週</div>
                                <div class="week-content">
                                    <h4>團隊建設與激勵</h4>
                                    <p>掌握團隊建設策略和激勵技巧</p>
                                    <ul>
                                        <li>團隊建設活動設計</li>
                                        <li>激勵理論與應用</li>
                                        <li>團隊文化塑造</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="curriculum-item">
                                <div class="week-number">第 7-8 週</div>
                                <div class="week-content">
                                    <h4>實戰演練與認證</h4>
                                    <p>通過實戰演練鞏固所學，準備認證考試</p>
                                    <ul>
                                        <li>團隊教練實戰演練</li>
                                        <li>案例研究與分析</li>
                                        <li>認證考試準備</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 學習成果 -->
                    <div class="content-section">
                        <h2>學習成果</h2>
                        <p>完成本課程後，您將能夠：</p>
                        <div class="outcomes-grid">
                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <h4>理解團隊動力</h4>
                                <p>深入理解團隊運作機制和動力學原理</p>
                            </div>
                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <h4>管理團隊衝突</h4>
                                <p>有效識別和解決團隊中的各種衝突</p>
                            </div>
                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <h4>建設高效團隊</h4>
                                <p>運用專業技巧建立和發展高效能團隊</p>
                            </div>
                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h4>提升團隊效能</h4>
                                <p>通過教練干預提升團隊整體表現</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sidebar">
                    <!-- 課程資訊卡片 -->
                    <div class="course-info-card">
                        <h3>課程資訊</h3>
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>開課時間：每月開班</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <span>課程時長：8 週</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-video"></i>
                            <span>上課方式：線上 + 實體</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-users"></i>
                            <span>班級人數：15-20 人</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span>課程費用：NT$ 45,000</span>
                        </div>
                        <button class="btn btn-primary btn-full" onclick="showCourseModal('team-coaching')">
                            立即報名
                        </button>
                    </div>

                    <!-- 導師介紹 -->
                    <div class="instructor-card">
                        <h3>課程導師</h3>
                        <div class="instructor-info">
                            <div class="instructor-avatar">
                                <img src="/coach-learning-platform-mainpage/assets/images/instructors/team-coach.jpg" alt="團隊教練導師" loading="lazy">
                            </div>
                            <div class="instructor-details">
                                <h4>陳美玲 博士</h4>
                                <p class="instructor-title">資深團隊教練專家</p>
                                <p class="instructor-bio">擁有 15 年團隊教練經驗，專精於組織發展和團隊效能提升。曾協助多家企業建立高效能團隊文化。</p>
                            </div>
                        </div>
                    </div>

                    <!-- 學員評價 -->
                    <div class="testimonials-card">
                        <h3>學員評價</h3>
                        <div class="testimonial-item">
                            <div class="testimonial-content">
                                <p>"這門課程讓我對團隊教練有了全新的認識，實戰演練部分特別有幫助。"</p>
                            </div>
                            <div class="testimonial-author">
                                <strong>張志明</strong>
                                <span>人力資源經理</span>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <div class="testimonial-content">
                                <p>"導師的經驗豐富，課程內容實用，對我的工作幫助很大。"</p>
                            </div>
                            <div class="testimonial-author">
                                <strong>李雅婷</strong>
                                <span>專案主管</span>
                            </div>
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
                <h2>準備好成為專業團隊教練了嗎？</h2>
                <p>立即報名，開啟您的團隊教練專業之路</p>
                <div class="cta-actions">
                    <button class="btn btn-primary btn-large" onclick="showCourseModal('team-coaching')">
                        <i class="fas fa-edit"></i>
                        立即報名
                    </button>
                    <a href="/coach-learning-platform-mainpage/courses" class="btn btn-outline btn-large">
                        <i class="fas fa-arrow-left"></i>
                        返回課程列表
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../../includes/footer.php'; ?>
