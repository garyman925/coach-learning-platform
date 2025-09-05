<?php
/**
 * 教練學習平台 - 家長教練課程
 */

require_once '../../includes/config.php';
require_once '../../includes/header.php';

// 設置頁面特定變數
$pageTitle = '家長教練專業課程 - ' . SITE_NAME;
$pageDescription = '學習家長教練技能，掌握親子溝通、情緒管理和家庭關係建設，成為更好的家長和教練';
$pageKeywords = '家長教練,親子溝通,情緒管理,家庭關係,教養技巧,教練技能';
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
                <div class="course-badge">家長教練</div>
                <h1 class="hero-title">家長教練專業課程</h1>
                <p class="hero-subtitle">掌握親子溝通技巧，建立和諧家庭關係</p>
                <div class="course-meta-hero">
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span>6 週課程</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-heart"></i>
                        <span>情感支持</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-certificate"></i>
                        <span>專業認證</span>
                    </div>
                </div>
                <div class="hero-actions">
                    <button class="btn btn-primary" onclick="showCourseModal('parent-coaching')">
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
                        <p>家長教練專業課程專為希望提升親子關係和教養技巧的家長設計。本課程結合心理學理論和實用技巧，幫助家長建立健康的親子溝通模式，培養孩子的情緒智商和社交能力。</p>
                        
                        <div class="highlight-box">
                            <h3>課程特色</h3>
                            <ul>
                                <li><strong>實用導向：</strong>提供具體可操作的教養技巧和溝通方法</li>
                                <li><strong>情感支持：</strong>建立家長支持社群，分享經驗和挑戰</li>
                                <li><strong>科學基礎：</strong>基於兒童發展心理學和家庭系統理論</li>
                                <li><strong>持續成長：</strong>畢業後可參與進階課程和家長互助小組</li>
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
                                    <h4>親子溝通基礎</h4>
                                    <p>學習有效的親子溝通技巧和傾聽方法</p>
                                    <ul>
                                        <li>積極傾聽技巧</li>
                                        <li>我訊息表達法</li>
                                        <li>非暴力溝通原則</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="curriculum-item">
                                <div class="week-number">第 3-4 週</div>
                                <div class="week-content">
                                    <h4>情緒管理與調節</h4>
                                    <p>掌握情緒管理技巧，幫助孩子建立情緒智商</p>
                                    <ul>
                                        <li>情緒識別與表達</li>
                                        <li>情緒調節策略</li>
                                        <li>壓力管理技巧</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="curriculum-item">
                                <div class="week-number">第 5-6 週</div>
                                <div class="week-content">
                                    <h4>家庭關係建設</h4>
                                    <p>建立健康的家庭系統和親子關係</p>
                                    <ul>
                                        <li>家庭系統理論</li>
                                        <li>界限設定與執行</li>
                                        <li>衝突解決與和解</li>
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
                                    <i class="fas fa-comments"></i>
                                </div>
                                <h4>有效親子溝通</h4>
                                <p>運用專業技巧與孩子建立開放、誠實的溝通</p>
                            </div>
                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <i class="fas fa-brain"></i>
                                </div>
                                <h4>情緒智商培養</h4>
                                <p>幫助孩子認識、理解和管理自己的情緒</p>
                            </div>
                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <h4>和諧家庭關係</h4>
                                <p>建立健康、支持性的家庭環境和關係</p>
                            </div>
                            <div class="outcome-item">
                                <div class="outcome-icon">
                                    <i class="fas fa-seedling"></i>
                                </div>
                                <h4>孩子成長支持</h4>
                                <p>為孩子的全面發展提供適當的指導和支持</p>
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
                            <span>開課時間：每季開班</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <span>課程時長：6 週</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-video"></i>
                            <span>上課方式：線上 + 實體</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-users"></i>
                            <span>班級人數：12-15 人</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span>課程費用：NT$ 32,000</span>
                        </div>
                        <button class="btn btn-primary btn-full" onclick="showCourseModal('parent-coaching')">
                            立即報名
                        </button>
                    </div>

                    <!-- 導師介紹 -->
                    <div class="instructor-card">
                        <h3>課程導師</h3>
                        <div class="instructor-info">
                            <div class="instructor-avatar">
                                <img src="/coach-learning-platform-mainpage/assets/images/instructors/parent-coach.jpg" alt="家長教練導師" loading="lazy">
                            </div>
                            <div class="instructor-details">
                                <h4>林雅芳 老師</h4>
                                <p class="instructor-title">資深家庭教練專家</p>
                                <p class="instructor-bio">擁有 12 年家庭教練經驗，專精於親子關係和家庭系統治療。曾協助數百個家庭改善親子關係。</p>
                            </div>
                        </div>
                    </div>

                    <!-- 學員評價 -->
                    <div class="testimonials-card">
                        <h3>學員評價</h3>
                        <div class="testimonial-item">
                            <div class="testimonial-content">
                                <p>"這門課程改變了我與孩子的相處方式，現在我們的溝通更加順暢了。"</p>
                            </div>
                            <div class="testimonial-author">
                                <strong>王美玲</strong>
                                <span>全職媽媽</span>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <div class="testimonial-content">
                                <p>"學到的情緒管理技巧對我和孩子都很有幫助，家庭氛圍更和諧了。"</p>
                            </div>
                            <div class="testimonial-author">
                                <strong>陳志強</strong>
                                <span>工程師</span>
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
                <h2>準備好成為更好的家長了嗎？</h2>
                <p>立即報名，學習專業的家長教練技能</p>
                <div class="cta-actions">
                    <button class="btn btn-primary btn-large" onclick="showCourseModal('parent-coaching')">
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
