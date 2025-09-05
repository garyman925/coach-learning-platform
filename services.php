<?php
define('SECURE_ACCESS', true);
require_once 'includes/config.php';
require_once 'includes/header.php';
?>

<main class="services-page">
    <!-- Hero Section -->
    <section class="services-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title" data-animate="fadeInUp">專業教練服務</h1>
                <p class="hero-description" data-animate="fadeInUp" data-delay="200">
                    為個人和企業提供全方位的專業教練服務，幫助您實現目標、提升效能、創造價值
                </p>
                <div class="hero-actions" data-animate="fadeInUp" data-delay="400">
                    <a href="#services-overview" class="btn btn-primary">了解服務</a>
                    <a href="#contact-form" class="btn btn-outline">免費諮詢</a>
                </div>
            </div>
            <div class="hero-visual" data-animate="fadeInRight" data-delay="300">
                <div class="hero-image">
                    <svg width="400" height="300" viewBox="0 0 400 300" fill="none">
                        <defs>
                            <linearGradient id="heroGradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:var(--color-primary);stop-opacity:1" />
                                <stop offset="100%" style="stop-color:var(--color-secondary);stop-opacity:1" />
                            </linearGradient>
                            <linearGradient id="heroGradient2" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:var(--color-accent);stop-opacity:1" />
                                <stop offset="100%" style="stop-color:var(--color-primary);stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <rect x="50" y="50" width="300" height="200" rx="20" fill="url(#heroGradient1)" opacity="0.8"/>
                        <circle cx="200" cy="150" r="80" fill="url(#heroGradient2)" opacity="0.6"/>
                        <path d="M180 130 L200 150 L220 130 M180 170 L200 150 L220 170" stroke="white" stroke-width="3" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section id="services-overview" class="services-overview">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">服務概覽</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    我們提供兩大核心服務類別，滿足不同需求的客戶
                </p>
            </div>
            
            <div class="services-grid">
                <div class="service-category" data-animate="fadeInUp" data-delay="300">
                    <div class="service-icon">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="35" fill="var(--color-primary)" opacity="0.1"/>
                            <circle cx="40" cy="40" r="25" fill="var(--color-primary)"/>
                            <path d="M30 40 L36 46 L50 32" stroke="white" stroke-width="3" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="service-title">個人教練服務</h3>
                    <p class="service-description">
                        專注於個人成長、職涯發展、生活平衡等領域，提供一對一的專業指導
                    </p>
                    <ul class="service-features">
                        <li>職涯規劃與發展</li>
                        <li>領導力提升</li>
                        <li>工作生活平衡</li>
                        <li>個人效能優化</li>
                    </ul>
                    <a href="<?php echo BASE_URL; ?>/services/personal" class="btn btn-primary">了解更多</a>
                </div>
                
                <div class="service-category" data-animate="fadeInUp" data-delay="400">
                    <div class="service-icon">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <rect x="20" y="20" width="40" height="40" rx="8" fill="var(--color-secondary)" opacity="0.1"/>
                            <rect x="25" y="25" width="30" height="30" rx="6" fill="var(--color-secondary)"/>
                            <path d="M35 35 L45 35 M35 40 L45 40 M35 45 L45 45" stroke="white" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="service-title">企業教練服務</h3>
                    <p class="service-description">
                        為企業組織提供團隊建設、文化塑造、效能提升等專業服務
                    </p>
                    <ul class="service-features">
                        <li>團隊效能提升</li>
                        <li>組織文化建設</li>
                        <li>變革管理</li>
                        <li>領導團隊發展</li>
                    </ul>
                    <a href="<?php echo BASE_URL; ?>/services/enterprise" class="btn btn-primary">了解更多</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Process -->
    <section class="service-process">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">服務流程</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    專業的服務流程，確保每次合作都能達到最佳效果
                </p>
            </div>
            
            <div class="process-steps">
                <div class="process-step" data-animate="fadeInUp" data-delay="300">
                    <div class="step-number">01</div>
                    <div class="step-content">
                        <h3 class="step-title">需求評估</h3>
                        <p class="step-description">
                            深入了解您的需求和目標，制定個性化的服務方案
                        </p>
                    </div>
                </div>
                
                <div class="process-step" data-animate="fadeInUp" data-delay="400">
                    <div class="step-number">02</div>
                    <div class="step-content">
                        <h3 class="step-title">方案制定</h3>
                        <p class="step-description">
                            根據評估結果，設計專屬的教練計劃和執行策略
                        </p>
                    </div>
                </div>
                
                <div class="process-step" data-animate="fadeInUp" data-delay="500">
                    <div class="step-number">03</div>
                    <div class="step-content">
                        <h3 class="step-title">執行實施</h3>
                        <p class="step-description">
                            專業教練全程指導，確保計劃有效執行和目標達成
                        </p>
                    </div>
                </div>
                
                <div class="process-step" data-animate="fadeInUp" data-delay="600">
                    <div class="step-number">04</div>
                    <div class="step-content">
                        <h3 class="step-title">效果評估</h3>
                        <p class="step-description">
                            定期評估進展，調整策略，確保服務效果最大化
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-choose-us">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">為什麼選擇我們</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    專業的團隊、豐富的經驗、個性化的服務，是您最值得信賴的選擇
                </p>
            </div>
            
            <div class="advantages-grid">
                <div class="advantage-item" data-animate="fadeInUp" data-delay="300">
                    <div class="advantage-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <path d="M30 5 L35 20 L50 20 L37.5 30 L42.5 45 L30 35 L17.5 45 L22.5 30 L10 20 L25 20 Z" fill="var(--color-accent)"/>
                        </svg>
                    </div>
                    <h3 class="advantage-title">專業認證</h3>
                    <p class="advantage-description">
                        所有教練都持有國際認證資格，具備豐富的實戰經驗
                    </p>
                </div>
                
                <div class="advantage-item" data-animate="fadeInUp" data-delay="400">
                    <div class="advantage-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <circle cx="30" cy="30" r="25" fill="var(--color-primary)" opacity="0.1"/>
                            <path d="M20 30 L27 37 L40 23" stroke="var(--color-primary)" stroke-width="3" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="advantage-title">個性化服務</h3>
                    <p class="advantage-description">
                        根據每位客戶的具體需求，量身定制專屬的服務方案
                    </p>
                </div>
                
                <div class="advantage-item" data-animate="fadeInUp" data-delay="500">
                    <div class="advantage-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <rect x="15" y="15" width="30" height="30" rx="6" fill="var(--color-secondary)" opacity="0.1"/>
                            <path d="M25 25 L35 25 M25 30 L35 30 M25 35 L35 35" stroke="var(--color-secondary)" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="advantage-title">持續支持</h3>
                    <p class="advantage-description">
                        提供長期的跟進服務，確保客戶能夠持續進步和成長
                    </p>
                </div>
                
                <div class="advantage-item" data-animate="fadeInUp" data-delay="600">
                    <div class="advantage-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <circle cx="30" cy="30" r="25" fill="var(--color-accent)" opacity="0.1"/>
                            <path d="M20 20 L40 40 M40 20 L20 40" stroke="var(--color-accent)" stroke-width="3" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="advantage-title">靈活安排</h3>
                    <p class="advantage-description">
                        提供靈活的時間安排，適應客戶的日程和需求
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section id="contact-form" class="contact-form-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">免費諮詢</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    填寫以下表單，我們將為您提供專業的諮詢服務
                </p>
            </div>
            
            <div class="contact-form-container">
                <form class="contact-form" id="service-contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="form-label">姓名 *</label>
                            <input type="text" id="name" name="name" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">電子郵件 *</label>
                            <input type="email" id="email" name="email" class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone" class="form-label">電話號碼</label>
                            <input type="tel" id="phone" name="phone" class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="service-type" class="form-label">服務類型 *</label>
                            <select id="service-type" name="service-type" class="form-select" required>
                                <option value="">請選擇服務類型</option>
                                <option value="personal">個人教練服務</option>
                                <option value="enterprise">企業教練服務</option>
                                <option value="both">兩者都有興趣</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">諮詢內容 *</label>
                        <textarea id="message" name="message" class="form-textarea" rows="5" placeholder="請詳細描述您的需求和期望達到的目標..." required></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-large">提交諮詢</button>
                    </div>
                </form>
                
                <div class="contact-info">
                    <h3 class="contact-info-title">聯繫方式</h3>
                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                        </div>
                        <div class="contact-details">
                            <h4>電話諮詢</h4>
                            <p>+886 2 1234 5678</p>
                            <p>週一至週五 9:00-18:00</p>
                        </div>
                    </div>
                    
                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="2" fill="none"/>
                                <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                        </div>
                        <div class="contact-details">
                            <h4>電子郵件</h4>
                            <p>service@coachplatform.com</p>
                            <p>24小時內回覆</p>
                        </div>
                    </div>
                    
                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" fill="none"/>
                                <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                        </div>
                        <div class="contact-details">
                            <h4>辦公地址</h4>
                            <p>台北市信義區信義路五段7號</p>
                            <p>台北101大樓 89樓</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
