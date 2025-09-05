<?php
/**
 * 教練學習平台 - 九型人格課程
 */

require_once '../../includes/config.php';
require_once '../../includes/header.php';

// 設置頁面特定變數
$pageTitle = '九型人格深度課程 - ' . SITE_NAME;
$pageDescription = '深入學習九型人格理論，掌握人格類型分析，提升自我認知和人際關係，成為專業的人格教練';
$pageKeywords = '九型人格,人格類型,自我認知,人際關係,人格教練,教練技能';
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
                <div class="course-badge">九型人格</div>
                <h1 class="hero-title">九型人格深度課程</h1>
                <p class="hero-subtitle">探索人格奧秘，提升自我認知與人際關係</p>
                <div class="course-meta-hero">
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span>10 週課程</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-user-friends"></i>
                        <span>深度探索</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-certificate"></i>
                        <span>國際認證</span>
                    </div>
                </div>
                <div class="hero-actions">
                    <button class="btn btn-primary" onclick="showCourseModal('enneagram')">
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
                        <p>九型人格深度課程是一門系統性的人格探索課程，基於古老的九型人格智慧，結合現代心理學理論。本課程幫助學員深入了解自己的人格類型，提升自我認知，改善人際關係，並掌握將九型人格應用於教練實踐的技能。</p>
                        
                        <div class="highlight-box">
                            <h3>課程特色</h3>
                            <ul>
                                <li><strong>深度探索：</strong>系統學習九型人格理論，深入理解每種類型的特質</li>
                                <li><strong>實用應用：</strong>學習將九型人格應用於教練、管理和人際關係中</li>
                                <li><strong>個人成長：</strong>通過自我認知提升個人成長和人際溝通能力</li>
                                <li><strong>專業認證：</strong>完成課程後可獲得國際九型人格協會認證</li>
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
                                    <h4>九型人格基礎理論</h4>
                                    <p>了解九型人格的歷史淵源和基本概念</p>
                                    <ul>
                                        <li>九型人格的起源與發展</li>
                                        <li>九種人格類型概述</li>
                                        <li>核心恐懼與慾望</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="curriculum-item">
                                <div class="week-number">第 3-4 週</div>
                                <div class="week-content">
                                    <h4>九種人格類型深度解析</h4>
                                    <p>深入學習每種人格類型的特質和行為模式</p>
                                    <ul>
                                        <li>完美主義者（1號）</li>
                                        <li>助人者（2號）</li>
                                        <li>成就者（3號）</li>
                                        <li>浪漫主義者（4號）</li>
                                        <li>觀察者（5號）</li>
                                        <li>忠誠者（6號）</li>
                                        <li>冒險家（7號）</li>
                                        <li>挑戰者（8號）</li>
                                        <li>調停者（9號）</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="curriculum-item">
                                <div class="week-number">第 5-6 週</div>
                                <div class="week-content">
                                    <h4>翅膀理論與副型</h4>
                                    <p>學習翅膀理論和副型對人格的影響</p>
                                    <ul>
                                        <li>翅膀理論與應用</li>
                                        <li>三種副型：自保、社交、一對一</li>
                                        <li>人格發展路徑</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="curriculum-item">
                                <div class="week-number">第 7-8 週</div>
                                <div class="week-content">
                                    <h4>九型人格在教練中的應用</h4>
                                    <p>學習如何將九型人格應用於教練實踐</p>
                                    <ul>
                                        <li>教練對話中的類型識別</li>
                                        <li>針對不同類型的教練策略</li>
                                        <li>團隊教練中的應用</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="curriculum-item">
                                <div class="week-number">第 9-10 週</div>
                                <div class="week-content">
                                    <h4>實戰演練與認證</h4>
                                    <p>通過實戰演練鞏固所學，準備認證考試</p>
                                    <ul>
                                        <li>九型人格評估實戰</li>
                                        <li>教練案例演練</li>
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
                                    <i class="fas fa-eye"></i>
                                </div>
                                <h4>深度自我認知</h4>
                                <p>清楚了解自己的人格類型、優勢和成長方向</p>
                            </div>
                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h4>改善人際關係</h4>
                                <p>理解他人的人格類型，建立更和諧的人際關係</p>
                            </div>
                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <h4>專業教練技能</h4>
                                <p>運用九型人格理論提升教練效果和專業能力</p>
                            </div>
                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <h4>個人成長突破</h4>
                                <p>識別個人盲點，實現自我突破和成長</p>
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
                            <span>開課時間：每半年開班</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <span>課程時長：10 週</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-video"></i>
                            <span>上課方式：線上 + 實體</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-users"></i>
                            <span>班級人數：10-15 人</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span>課程費用：NT$ 58,000</span>
                        </div>
                        <button class="btn btn-primary btn-full" onclick="showCourseModal('enneagram')">
                            立即報名
                        </button>
                    </div>

                    <!-- 導師介紹 -->
                    <div class="instructor-card">
                        <h3>課程導師</h3>
                        <div class="instructor-info">
                            <div class="instructor-avatar">
                                <img src="/coach-learning-platform-mainpage/assets/images/instructors/enneagram-coach.jpg" alt="九型人格導師" loading="lazy">
                            </div>
                            <div class="instructor-details">
                                <h4>吳志明 博士</h4>
                                <p class="instructor-title">資深九型人格專家</p>
                                <p class="instructor-bio">擁有 20 年九型人格研究和教學經驗，國際九型人格協會認證導師。曾協助數千名學員探索自我。</p>
                            </div>
                        </div>
                    </div>

                    <!-- 學員評價 -->
                    <div class="testimonials-card">
                        <h3>學員評價</h3>
                        <div class="testimonial-item">
                            <div class="testimonial-content">
                                <p>"這門課程讓我對自己有了全新的認識，也幫助我更好地理解身邊的人。"</p>
                            </div>
                            <div class="testimonial-author">
                                <strong>林雅婷</strong>
                                <span>心理諮商師</span>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <div class="testimonial-content">
                                <p>"九型人格理論在我的教練工作中發揮了巨大作用，客戶反饋非常好。"</p>
                            </div>
                            <div class="testimonial-author">
                                <strong>張偉傑</strong>
                                <span>企業教練</span>
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
                <h2>準備好探索人格奧秘了嗎？</h2>
                <p>立即報名，開啟您的九型人格深度學習之旅</p>
                <div class="cta-actions">
                    <button class="btn btn-primary btn-large" onclick="showCourseModal('enneagram')">
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
