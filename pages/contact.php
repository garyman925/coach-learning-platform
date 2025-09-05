<?php
/**
 * 教練學習平台 - 聯絡我們
 */

require_once '../includes/config.php';
require_once '../includes/header.php';

// 設置頁面特定變數
$pageTitle = '聯絡我們 - ' . SITE_NAME;
$pageDescription = '聯繫教練學習平台，獲取專業的教練培訓和服務諮詢';
$pageKeywords = '聯絡我們,聯繫方式,教練培訓,服務諮詢,地址,電話';
?>

<main class="contact-page">
    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="hero-background">
            <div class="hero-pattern"></div>
            <div class="hero-overlay"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">聯絡我們</h1>
                <p class="hero-subtitle">我們隨時為您提供專業的教練培訓和服務諮詢</p>
                <div class="hero-description">
                    <p>無論您有任何問題或需求，我們都樂意為您提供協助。透過以下方式與我們取得聯繫，我們將盡快回覆您。</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="contact-info">
        <div class="container">
            <div class="contact-info-header">
                <h2 class="section-title">聯繫我們</h2>
                <p class="section-description">有任何問題或需要諮詢？我們很樂意為您提供幫助。請填寫以下表單，我們會盡快回覆您。</p>
            </div>
            <div class="contact-grid">
                <div class="contact-card" data-animate="fadeInUp">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>電話諮詢</h3>
                    <div class="contact-details">
                        <p class="contact-main">+886 2 1234 5678</p>
                        <p class="contact-sub">週一至週五 9:00-18:00</p>
                        <p class="contact-sub">週六 9:00-12:00</p>
                    </div>
                    <a href="tel:+886212345678" class="contact-action">
                        <i class="fas fa-phone"></i>
                        立即撥打
                    </a>
                </div>

                <div class="contact-card" data-animate="fadeInUp" data-delay="200">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>電子郵件</h3>
                    <div class="contact-details">
                        <p class="contact-main">info@coachplatform.com</p>
                        <p class="contact-sub">一般諮詢</p>
                        <p class="contact-main">training@coachplatform.com</p>
                        <p class="contact-sub">課程相關</p>
                    </div>
                    <a href="mailto:info@coachplatform.com" class="contact-action">
                        <i class="fas fa-envelope"></i>
                        發送郵件
                    </a>
                </div>

                <div class="contact-card" data-animate="fadeInUp" data-delay="400">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>實體地址</h3>
                    <div class="contact-details">
                        <p class="contact-main">台北市信義區信義路五段7號</p>
                        <p class="contact-sub">台北101大樓附近</p>
                        <p class="contact-sub">捷運信義安和站步行5分鐘</p>
                    </div>
                    <a href="#map-section" class="contact-action">
                        <i class="fas fa-map"></i>
                        查看地圖
                    </a>
                </div>

                <div class="contact-card" data-animate="fadeInUp" data-delay="600">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>營業時間</h3>
                    <div class="contact-details">
                        <p class="contact-main">週一至週五</p>
                        <p class="contact-sub">9:00 - 18:00</p>
                        <p class="contact-main">週六</p>
                        <p class="contact-sub">9:00 - 12:00</p>
                        <p class="contact-sub">週日休息</p>
                    </div>
                    <div class="contact-action">
                        <i class="fas fa-info-circle"></i>
                        預約諮詢
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="container">
            <div class="form-section-header">
                <h2 class="section-title">發送訊息給我們</h2>
                <p class="section-description">填寫以下表單，我們將在24小時內回覆您</p>
            </div>
            
            <div class="contact-form-container">
                <form id="contactForm" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contactName">姓名 *</label>
                            <input type="text" id="contactName" name="contactName" required>
                        </div>
                        <div class="form-group">
                            <label for="contactEmail">電子郵件 *</label>
                            <input type="email" id="contactEmail" name="contactEmail" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contactPhone">聯絡電話</label>
                            <input type="tel" id="contactPhone" name="contactPhone">
                        </div>
                        <div class="form-group">
                            <label for="contactSubject">諮詢主題 *</label>
                            <select id="contactSubject" name="contactSubject" required>
                                <option value="">請選擇諮詢主題</option>
                                <option value="course-inquiry">課程諮詢</option>
                                <option value="service-inquiry">服務諮詢</option>
                                <option value="alliance-inquiry">聯盟合作</option>
                                <option value="general-inquiry">一般諮詢</option>
                                <option value="feedback">意見回饋</option>
                                <option value="other">其他</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="contactMessage">訊息內容 *</label>
                        <textarea id="contactMessage" name="contactMessage" rows="6" placeholder="請詳細描述您的需求或問題..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="contactAgreement" name="contactAgreement" required>
                            <span class="checkmark"></span>
                            我同意 <a href="/privacy-policy" target="_blank">隱私政策</a> 和 <a href="/terms-of-service" target="_blank">服務條款</a>
                        </label>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-large">
                            <i class="fas fa-paper-plane"></i>
                            發送訊息
                        </button>
                        <button type="reset" class="btn btn-outline btn-large">
                            <i class="fas fa-undo"></i>
                            重新填寫
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section id="map-section" class="map-section">
        <div class="container">
            <div class="map-section-header">
                <h2 class="section-title">我們的位置</h2>
                <p class="section-description">歡迎您親自前來參觀和諮詢</p>
            </div>
            
            <div class="map-container">
                <div class="map-placeholder">
                    <div class="map-content">
                        <i class="fas fa-map-marked-alt"></i>
                        <h3>台北市信義區信義路五段7號</h3>
                        <p>台北101大樓附近，交通便利</p>
                        <div class="map-info">
                            <div class="info-item">
                                <i class="fas fa-subway"></i>
                                <span>捷運信義安和站步行5分鐘</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-bus"></i>
                                <span>公車信義行政中心站</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-car"></i>
                                <span>附近有停車場</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="faq-section-header">
                <h2 class="section-title">常見問題</h2>
                <p class="section-description">快速找到您需要的答案</p>
            </div>
            
            <div class="faq-container">
                <div class="faq-item" data-animate="fadeInUp">
                    <div class="faq-question">
                        <h3>如何報名課程？</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>您可以透過以下方式報名課程：</p>
                        <ul>
                            <li>線上報名：在課程頁面點擊「立即報名」按鈕</li>
                            <li>電話報名：撥打我們的服務專線</li>
                            <li>現場報名：親自到我們的辦公室報名</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item" data-animate="fadeInUp" data-delay="200">
                    <div class="faq-question">
                        <h3>課程費用如何支付？</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>我們提供多種付款方式：</p>
                        <ul>
                            <li>信用卡分期付款</li>
                            <li>銀行轉帳</li>
                            <li>現金付款</li>
                            <li>支票付款</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item" data-animate="fadeInUp" data-delay="400">
                    <div class="faq-question">
                        <h3>可以申請退費嗎？</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>是的，我們提供退費保障：</p>
                        <ul>
                            <li>開課前7天：全額退費</li>
                            <li>開課前3-7天：退費80%</li>
                            <li>開課前3天內：退費50%</li>
                            <li>開課後：恕不退費</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item" data-animate="fadeInUp" data-delay="600">
                    <div class="faq-question">
                        <h3>如何成為教練聯盟成員？</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>成為聯盟成員的步驟：</p>
                        <ul>
                            <li>填寫聯盟申請表</li>
                            <li>提供專業背景和經驗證明</li>
                            <li>通過資格審核</li>
                            <li>簽署聯盟協議</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="contact-cta">
        <div class="container">
            <div class="cta-content">
                <h2>準備好開始您的教練之旅了嗎？</h2>
                <p>立即聯繫我們，獲取專業的諮詢和建議</p>
                <div class="cta-actions">
                    <a href="tel:+886212345678" class="btn btn-primary btn-large">
                        <i class="fas fa-phone"></i>
                        立即撥打
                    </a>
                    <button class="btn btn-outline btn-large" onclick="scrollToForm()">
                        <i class="fas fa-envelope"></i>
                        發送訊息
                    </button>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../includes/footer.php'; ?>
