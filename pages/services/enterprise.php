<?php
require_once '../../includes/config.php';
require_once '../../includes/header.php';
?>

<main class="enterprise-coaching-page">
    <!-- Hero Section -->
    <section class="enterprise-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title" data-animate="fadeInUp">企業教練服務</h1>
                <p class="hero-description" data-animate="fadeInUp" data-delay="200">
                    為企業組織提供專業的教練服務，提升團隊效能，塑造卓越文化
                </p>
                <div class="hero-actions" data-animate="fadeInUp" data-delay="400">
                    <a href="#enterprise-services" class="btn btn-primary">了解服務內容</a>
                    <a href="#enterprise-contact" class="btn btn-outline">企業諮詢</a>
                </div>
            </div>
            <div class="hero-visual" data-animate="fadeInRight" data-delay="300">
                <div class="hero-image">
                    <svg width="400" height="300" viewBox="0 0 400 300" fill="none">
                        <defs>
                            <linearGradient id="enterpriseGradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:var(--color-secondary);stop-opacity:1" />
                                <stop offset="100%" style="stop-color:var(--color-primary);stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <rect x="50" y="50" width="300" height="200" rx="20" fill="url(#enterpriseGradient1)" opacity="0.8"/>
                        <circle cx="200" cy="150" r="60" fill="white" opacity="0.9"/>
                        <path d="M180 130 L200 150 L220 130 M180 170 L200 150 L220 170" stroke="var(--color-secondary)" stroke-width="3" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Enterprise Services -->
    <section id="enterprise-services" class="enterprise-services">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">企業服務內容</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    全方位的企業教練服務，助力組織發展與團隊成長
                </p>
            </div>
            
            <div class="services-grid">
                <div class="service-card" data-animate="fadeInUp" data-delay="300">
                    <div class="service-icon">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="35" fill="var(--color-primary)" opacity="0.1"/>
                            <circle cx="40" cy="40" r="25" fill="var(--color-primary)"/>
                            <path d="M30 40 L36 46 L50 32" stroke="white" stroke-width="3" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="service-title">團隊效能提升</h3>
                    <p class="service-description">
                        通過系統化的團隊建設活動，提升團隊協作能力和整體效能
                    </p>
                    <ul class="service-features">
                        <li>團隊動態分析</li>
                        <li>溝通模式優化</li>
                        <li>衝突解決策略</li>
                        <li>協作流程改善</li>
                    </ul>
                    <div class="service-duration">
                        <span class="duration-label">服務週期：</span>
                        <span class="duration-value">3-6個月</span>
                    </div>
                </div>
                
                <div class="service-card" data-animate="fadeInUp" data-delay="400">
                    <div class="service-icon">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <rect x="20" y="20" width="40" height="40" rx="8" fill="var(--color-secondary)" opacity="0.1"/>
                            <rect x="25" y="25" width="30" height="30" rx="6" fill="var(--color-secondary)"/>
                            <path d="M35 35 L45 35 M35 40 L45 40 M35 45 L45 45" stroke="white" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="service-title">組織文化建設</h3>
                    <p class="service-description">
                        協助企業建立積極正向的組織文化，提升員工歸屬感和工作滿意度
                    </p>
                    <ul class="service-features">
                        <li>文化價值觀梳理</li>
                        <li>行為規範制定</li>
                        <li>文化傳播策略</li>
                        <li>文化落地執行</li>
                    </ul>
                    <div class="service-duration">
                        <span class="duration-label">服務週期：</span>
                        <span class="duration-value">6-12個月</span>
                    </div>
                </div>
                
                <div class="service-card" data-animate="fadeInUp" data-delay="500">
                    <div class="service-icon">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <path d="M30 5 L35 20 L50 20 L37.5 30 L42.5 45 L30 35 L17.5 45 L22.5 30 L10 20 L25 20 Z" fill="var(--color-accent)"/>
                        </svg>
                    </div>
                    <h3 class="service-title">變革管理</h3>
                    <p class="service-description">
                        在組織變革過程中提供專業指導，確保變革順利實施並達到預期效果
                    </p>
                    <ul class="service-features">
                        <li>變革需求評估</li>
                        <li>變革策略制定</li>
                        <li>阻力分析與處理</li>
                        <li>變革效果評估</li>
                    </ul>
                    <div class="service-duration">
                        <span class="duration-label">服務週期：</span>
                        <span class="duration-value">6-18個月</span>
                    </div>
                </div>
                
                <div class="service-card" data-animate="fadeInUp" data-delay="600">
                    <div class="service-icon">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="35" fill="var(--color-primary)" opacity="0.8"/>
                            <path d="M20 20 L40 40 L60 20 M20 60 L40 40 L60 60" stroke="white" stroke-width="3" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="service-title">領導團隊發展</h3>
                    <p class="service-description">
                        培養高層管理團隊的領導能力，建立高效能的領導團隊
                    </p>
                    <ul class="service-features">
                        <li>領導力評估</li>
                        <li>團隊角色定位</li>
                        <li>決策機制優化</li>
                        <li>領導風格調適</li>
                    </ul>
                    <div class="service-duration">
                        <span class="duration-label">服務週期：</span>
                        <span class="duration-value">12-24個月</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Benefits -->
    <section class="service-benefits">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">服務優勢</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    選擇我們的企業教練服務，為您的組織帶來實質的改變和成長
                </p>
            </div>
            
            <div class="benefits-grid">
                <div class="benefit-item" data-animate="fadeInUp" data-delay="300">
                    <div class="benefit-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <circle cx="30" cy="30" r="25" fill="var(--color-primary)" opacity="0.1"/>
                            <path d="M20 30 L27 37 L40 23" stroke="var(--color-primary)" stroke-width="3" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="benefit-title">專業團隊</h3>
                    <p class="benefit-description">
                        擁有豐富企業經驗的專業教練團隊，深入了解企業運作和挑戰
                    </p>
                </div>
                
                <div class="benefit-item" data-animate="fadeInUp" data-delay="400">
                    <div class="benefit-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <rect x="15" y="15" width="30" height="30" rx="6" fill="var(--color-secondary)" opacity="0.1"/>
                            <path d="M25 25 L35 25 M25 30 L35 30 M25 35 L35 35" stroke="var(--color-secondary)" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="benefit-title">客製化方案</h3>
                    <p class="benefit-description">
                        根據企業的具體情況和需求，量身定制專屬的服務方案
                    </p>
                </div>
                
                <div class="benefit-item" data-animate="fadeInUp" data-delay="500">
                    <div class="benefit-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <path d="M30 5 L35 20 L50 20 L37.5 30 L42.5 45 L30 35 L17.5 45 L22.5 30 L10 20 L25 20 Z" fill="var(--color-accent)"/>
                        </svg>
                    </div>
                    <h3 class="benefit-title">持續跟進</h3>
                    <p class="benefit-description">
                        提供長期的跟進服務，確保服務效果持續發揮，組織持續進步
                    </p>
                </div>
                
                <div class="benefit-item" data-animate="fadeInUp" data-delay="600">
                    <div class="benefit-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <circle cx="30" cy="30" r="25" fill="var(--color-primary)" opacity="0.8"/>
                            <path d="M20 20 L40 40 M40 20 L20 40" stroke="white" stroke-width="3" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="benefit-title">效果可測</h3>
                    <p class="benefit-description">
                        建立科學的評估體系，讓服務效果可量化、可追蹤、可驗證
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Case Studies -->
    <section class="case-studies">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">成功案例</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    看看我們如何幫助不同企業實現組織發展目標
                </p>
            </div>
            
            <div class="cases-grid">
                <div class="case-card" data-animate="fadeInUp" data-delay="300">
                    <div class="case-header">
                        <h3 class="case-title">科技公司團隊效能提升</h3>
                        <span class="case-industry">科技產業</span>
                    </div>
                    <div class="case-content">
                        <p class="case-description">
                            協助一家快速成長的科技公司提升研發團隊的協作效能，通過6個月的教練服務，團隊生產力提升了35%，項目交付時間縮短了20%。
                        </p>
                        <div class="case-results">
                            <div class="result-item">
                                <span class="result-label">團隊生產力</span>
                                <span class="result-value">+35%</span>
                            </div>
                            <div class="result-item">
                                <span class="result-label">交付時間</span>
                                <span class="result-value">-20%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="case-card" data-animate="fadeInUp" data-delay="400">
                    <div class="case-header">
                        <h3 class="case-title">製造業組織文化轉型</h3>
                        <span class="case-industry">製造業</span>
                    </div>
                    <div class="case-content">
                        <p class="case-description">
                            幫助傳統製造業企業建立以創新和持續改進為核心的組織文化，員工滿意度從65%提升到88%，離職率降低了40%。
                        </p>
                        <div class="case-results">
                            <div class="result-item">
                                <span class="result-label">員工滿意度</span>
                                <span class="result-value">+23%</span>
                            </div>
                            <div class="result-item">
                                <span class="result-label">離職率</span>
                                <span class="result-value">-40%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="case-card" data-animate="fadeInUp" data-delay="500">
                    <div class="case-header">
                        <h3 class="case-title">金融業變革管理</h3>
                        <span class="case-industry">金融業</span>
                    </div>
                    <div class="case-content">
                        <p class="case-description">
                            在金融業數位轉型過程中提供變革管理支持，成功幫助企業在18個月內完成組織重構，新業務增長達到預期目標的120%。
                        </p>
                        <div class="case-results">
                            <div class="result-item">
                                <span class="result-label">變革成功率</span>
                                <span class="result-value">95%</span>
                            </div>
                            <div class="result-item">
                                <span class="result-label">新業務增長</span>
                                <span class="result-value">+120%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Packages -->
    <section class="service-packages">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">服務方案</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    靈活的企業服務方案，滿足不同規模和需求的企業
                </p>
            </div>
            
            <div class="packages-grid">
                <div class="package-card" data-animate="fadeInUp" data-delay="300">
                    <div class="package-header">
                        <h3 class="package-name">基礎方案</h3>
                        <div class="package-price">
                            <span class="price-amount">NT$ 150,000</span>
                            <span class="price-unit">/ 3個月</span>
                        </div>
                    </div>
                    <div class="package-features">
                        <ul>
                            <li>團隊效能評估</li>
                            <li>每月2次教練會談</li>
                            <li>基礎培訓課程</li>
                            <li>月度進度報告</li>
                            <li>電子郵件支持</li>
                        </ul>
                    </div>
                    <div class="package-actions">
                        <a href="#enterprise-contact" class="btn btn-outline">諮詢詳情</a>
                    </div>
                </div>
                
                <div class="package-card featured" data-animate="fadeInUp" data-delay="400">
                    <div class="package-badge">熱門</div>
                    <div class="package-header">
                        <h3 class="package-name">標準方案</h3>
                        <div class="package-price">
                            <span class="price-amount">NT$ 300,000</span>
                            <span class="price-unit">/ 6個月</span>
                        </div>
                    </div>
                    <div class="package-features">
                        <ul>
                            <li>全方位組織診斷</li>
                            <li>每週1次教練會談</li>
                            <li>專項培訓與工作坊</li>
                            <li>雙週進度報告</li>
                            <li>優先響應支持</li>
                            <li>季度效果評估</li>
                        </ul>
                    </div>
                    <div class="package-actions">
                        <a href="#enterprise-contact" class="btn btn-primary">諮詢詳情</a>
                    </div>
                </div>
                
                <div class="package-card" data-animate="fadeInUp" data-delay="500">
                    <div class="package-header">
                        <h3 class="package-name">企業方案</h3>
                        <div class="package-price">
                            <span class="price-amount">NT$ 600,000</span>
                            <span class="price-unit">/ 12個月</span>
                        </div>
                    </div>
                    <div class="package-features">
                        <ul>
                            <li>深度組織變革</li>
                            <li>每週2次教練會談</li>
                            <li>定制化培訓體系</li>
                            <li>週度進度追蹤</li>
                            <li>24小時緊急支持</li>
                            <li>月度效果評估</li>
                            <li>年度戰略規劃</li>
                        </ul>
                    </div>
                    <div class="package-actions">
                        <a href="#enterprise-contact" class="btn btn-outline">諮詢詳情</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enterprise Contact -->
    <section id="enterprise-contact" class="enterprise-contact">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">企業諮詢</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    聯繫我們的企業服務團隊，為您的組織量身定制專業的教練服務方案
                </p>
            </div>
            
            <div class="contact-container">
                <form class="enterprise-form" id="enterprise-contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="company-name" class="form-label">公司名稱 *</label>
                            <input type="text" id="company-name" name="company-name" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-person" class="form-label">聯絡人 *</label>
                            <input type="text" id="contact-person" name="contact-person" class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact-email" class="form-label">聯絡郵箱 *</label>
                            <input type="email" id="contact-email" name="contact-email" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-phone" class="form-label">聯絡電話 *</label>
                            <input type="tel" id="contact-phone" name="contact-phone" class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="company-size" class="form-label">公司規模</label>
                            <select id="company-size" name="company-size" class="form-select">
                                <option value="">請選擇公司規模</option>
                                <option value="startup">新創公司 (1-50人)</option>
                                <option value="small">中小企業 (51-200人)</option>
                                <option value="medium">中型企業 (201-1000人)</option>
                                <option value="large">大型企業 (1000人以上)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="service-interest" class="form-label">感興趣的服務 *</label>
                            <select id="service-interest" name="service-interest" class="form-select" required>
                                <option value="">請選擇服務類型</option>
                                <option value="team">團隊效能提升</option>
                                <option value="culture">組織文化建設</option>
                                <option value="change">變革管理</option>
                                <option value="leadership">領導團隊發展</option>
                                <option value="multiple">多項服務</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="company-challenges" class="form-label">組織挑戰描述 *</label>
                        <textarea id="company-challenges" name="company-challenges" class="form-textarea" rows="5" placeholder="請詳細描述您的組織目前面臨的挑戰和希望達到的目標..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="expected-timeline" class="form-label">期望服務時間</label>
                        <select id="expected-timeline" name="expected-timeline" class="form-select">
                            <option value="">請選擇期望時間</option>
                            <option value="immediate">立即開始</option>
                            <option value="1month">1個月內</option>
                            <option value="3months">3個月內</option>
                            <option value="6months">6個月內</option>
                            <option value="flexible">時間彈性</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-large">提交諮詢</button>
                    </div>
                </form>
                
                <div class="enterprise-info">
                    <h3 class="enterprise-info-title">企業服務專線</h3>
                    <div class="info-item">
                        <h4>專線電話</h4>
                        <p>+886 2 1234 5678 轉 888</p>
                        <p>週一至週五 9:00-18:00</p>
                    </div>
                    <div class="info-item">
                        <h4>企業郵箱</h4>
                        <p>enterprise@coachplatform.com</p>
                        <p>24小時內回覆</p>
                    </div>
                    <div class="info-item">
                        <h4>服務流程</h4>
                        <p>初步諮詢 → 需求評估 → 方案制定 → 服務實施 → 效果評估</p>
                    </div>
                    <div class="info-item">
                        <h4>服務承諾</h4>
                        <p>專業團隊、客製方案、持續跟進、效果保證</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../../includes/footer.php'; ?>
