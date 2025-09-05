<?php
require_once '../../includes/config.php';
require_once '../../includes/header.php';
?>

<main class="personal-coaching-page">
    <!-- Hero Section -->
    <section class="personal-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title" data-animate="fadeInUp">個人教練服務</h1>
                <p class="hero-description" data-animate="fadeInUp" data-delay="200">
                    專注於個人成長與發展，幫助您突破自我限制，實現人生目標
                </p>
                <div class="hero-actions" data-animate="fadeInUp" data-delay="400">
                    <a href="#coaching-areas" class="btn btn-primary">了解服務領域</a>
                    <a href="#booking" class="btn btn-outline">立即預約</a>
                </div>
            </div>
            <div class="hero-visual" data-animate="fadeInRight" data-delay="300">
                <div class="hero-image">
                    <svg width="400" height="300" viewBox="0 0 400 300" fill="none">
                        <defs>
                            <linearGradient id="personalGradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:var(--color-primary);stop-opacity:1" />
                                <stop offset="100%" style="stop-color:var(--color-accent);stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <circle cx="200" cy="150" r="120" fill="url(#personalGradient1)" opacity="0.8"/>
                        <path d="M160 120 L200 160 L240 120 M160 180 L200 140 L240 180" stroke="white" stroke-width="4" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Coaching Areas -->
    <section id="coaching-areas" class="coaching-areas">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">教練服務領域</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    我們專注於以下核心領域，為您提供專業的個人教練服務
                </p>
            </div>
            
            <div class="areas-grid">
                <div class="area-card" data-animate="fadeInUp" data-delay="300">
                    <div class="area-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <path d="M30 5 L35 20 L50 20 L37.5 30 L42.5 45 L30 35 L17.5 45 L22.5 30 L10 20 L25 20 Z" fill="var(--color-primary)"/>
                        </svg>
                    </div>
                    <h3 class="area-title">職涯規劃與發展</h3>
                    <p class="area-description">
                        幫助您明確職業方向，制定發展策略，實現職涯目標
                    </p>
                    <ul class="area-features">
                        <li>職業興趣探索</li>
                        <li>技能評估與提升</li>
                        <li>職涯路徑規劃</li>
                        <li>面試與談判技巧</li>
                    </ul>
                </div>
                
                <div class="area-card" data-animate="fadeInUp" data-delay="400">
                    <div class="area-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <circle cx="30" cy="30" r="25" fill="var(--color-secondary)"/>
                            <path d="M20 30 L27 37 L40 23" stroke="white" stroke-width="3" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="area-title">領導力提升</h3>
                    <p class="area-description">
                        培養領導素質，提升管理能力，成為優秀的領導者
                    </p>
                    <ul class="area-features">
                        <li>領導風格識別</li>
                        <li>溝通與影響力</li>
                        <li>團隊建設與管理</li>
                        <li>決策與問題解決</li>
                    </ul>
                </div>
                
                <div class="area-card" data-animate="fadeInUp" data-delay="500">
                    <div class="area-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <rect x="15" y="15" width="30" height="30" rx="6" fill="var(--color-accent)"/>
                            <path d="M25 25 L35 25 M25 30 L35 30 M25 35 L35 35" stroke="white" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="area-title">工作生活平衡</h3>
                    <p class="area-description">
                        幫助您找到工作與生活的平衡點，提升整體生活品質
                    </p>
                    <ul class="area-features">
                        <li>時間管理優化</li>
                        <li>壓力管理技巧</li>
                        <li>健康生活習慣</li>
                        <li>家庭關係維護</li>
                    </ul>
                </div>
                
                <div class="area-card" data-animate="fadeInUp" data-delay="600">
                    <div class="area-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <circle cx="30" cy="30" r="25" fill="var(--color-primary)" opacity="0.8"/>
                            <path d="M20 20 L40 40 M40 20 L20 40" stroke="white" stroke-width="3" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="area-title">個人效能優化</h3>
                    <p class="area-description">
                        提升個人效能，培養高效能習慣，實現卓越表現
                    </p>
                    <ul class="area-features">
                        <li>目標設定與執行</li>
                        <li>習慣養成與改變</li>
                        <li>專注力與生產力</li>
                        <li>學習與成長策略</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Coaching Process -->
    <section class="coaching-process">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">教練流程</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    系統化的教練流程，確保每次會談都能產生實質的改變
                </p>
            </div>
            
            <div class="process-timeline">
                <div class="timeline-item" data-animate="fadeInUp" data-delay="300">
                    <div class="timeline-marker">1</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">初始評估</h3>
                        <p class="timeline-description">
                            深入了解您的現況、目標和挑戰，建立信任關係
                        </p>
                        <div class="timeline-duration">1-2 次會談</div>
                    </div>
                </div>
                
                <div class="timeline-item" data-animate="fadeInUp" data-delay="400">
                    <div class="timeline-marker">2</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">目標設定</h3>
                        <p class="timeline-description">
                            共同制定明確、可測量、可實現的具體目標
                        </p>
                        <div class="timeline-duration">1 次會談</div>
                    </div>
                </div>
                
                <div class="timeline-item" data-animate="fadeInUp" data-delay="500">
                    <div class="timeline-marker">3</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">行動規劃</h3>
                        <p class="timeline-description">
                            設計具體的行動步驟和時間表，確保目標可執行
                        </p>
                        <div class="timeline-duration">1 次會談</div>
                    </div>
                </div>
                
                <div class="timeline-item" data-animate="fadeInUp" data-delay="600">
                    <div class="timeline-marker">4</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">執行與跟進</h3>
                        <p class="timeline-description">
                            定期會談，檢視進展，調整策略，持續支持
                        </p>
                        <div class="timeline-duration">每 2-4 週一次</div>
                    </div>
                </div>
                
                <div class="timeline-item" data-animate="fadeInUp" data-delay="700">
                    <div class="timeline-marker">5</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">成果評估</h3>
                        <p class="timeline-description">
                            評估目標達成情況，慶祝成功，規劃下一步
                        </p>
                        <div class="timeline-duration">1 次會談</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Plans -->
    <section class="pricing-plans">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">服務方案</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    靈活的服務方案，滿足不同階段的需求
                </p>
            </div>
            
            <div class="plans-grid">
                <div class="plan-card" data-animate="fadeInUp" data-delay="300">
                    <div class="plan-header">
                        <h3 class="plan-name">單次諮詢</h3>
                        <div class="plan-price">
                            <span class="price-amount">NT$ 2,500</span>
                            <span class="price-unit">/ 次</span>
                        </div>
                    </div>
                    <div class="plan-features">
                        <ul>
                            <li>90分鐘深度會談</li>
                            <li>問題分析與建議</li>
                            <li>行動計劃制定</li>
                            <li>會後總結報告</li>
                        </ul>
                    </div>
                    <div class="plan-actions">
                        <a href="#booking" class="btn btn-outline">立即預約</a>
                    </div>
                </div>
                
                <div class="plan-card featured" data-animate="fadeInUp" data-delay="400">
                    <div class="plan-badge">推薦</div>
                    <div class="plan-header">
                        <h3 class="plan-name">標準方案</h3>
                        <div class="plan-price">
                            <span class="price-amount">NT$ 18,000</span>
                            <span class="price-unit">/ 3個月</span>
                        </div>
                    </div>
                    <div class="plan-features">
                        <ul>
                            <li>6次教練會談</li>
                            <li>每次90分鐘</li>
                            <li>進度跟進與調整</li>
                            <li>電子郵件支持</li>
                            <li>資源與工具提供</li>
                        </ul>
                    </div>
                    <div class="plan-actions">
                        <a href="#booking" class="btn btn-primary">立即預約</a>
                    </div>
                </div>
                
                <div class="plan-card" data-animate="fadeInUp" data-delay="500">
                    <div class="plan-header">
                        <h3 class="plan-name">深度方案</h3>
                        <div class="plan-price">
                            <span class="price-amount">NT$ 32,000</span>
                            <span class="price-unit">/ 6個月</span>
                        </div>
                    </div>
                    <div class="plan-features">
                        <ul>
                            <li>12次教練會談</li>
                            <li>每次90分鐘</li>
                            <li>全方位個人發展</li>
                            <li>優先預約權限</li>
                            <li>24小時緊急支持</li>
                            <li>季度進度報告</li>
                        </ul>
                    </div>
                    <div class="plan-actions">
                        <a href="#booking" class="btn btn-outline">立即預約</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">客戶見證</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    聽聽其他客戶的真實體驗和成功故事
                </p>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card" data-animate="fadeInUp" data-delay="300">
                    <div class="testimonial-content">
                        <p>"教練幫助我重新審視自己的職涯規劃，讓我找到了真正熱愛的方向。現在的工作讓我充滿動力！"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <circle cx="20" cy="20" r="20" fill="var(--color-primary)" opacity="0.2"/>
                                <circle cx="20" cy="15" r="6" fill="var(--color-primary)"/>
                                <path d="M8 35 C8 28 13 23 20 23 C27 23 32 28 32 35" fill="var(--color-primary)"/>
                            </svg>
                        </div>
                        <div class="author-info">
                            <h4 class="author-name">張小姐</h4>
                            <p class="author-title">行銷經理</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card" data-animate="fadeInUp" data-delay="400">
                    <div class="testimonial-content">
                        <p>"通過教練的指導，我學會了如何平衡工作與家庭，現在的生活品質大大提升了。"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <circle cx="20" cy="20" r="20" fill="var(--color-secondary)" opacity="0.2"/>
                                <circle cx="20" cy="15" r="6" fill="var(--color-secondary)"/>
                                <path d="M8 35 C8 28 13 23 20 23 C27 23 32 28 32 35" fill="var(--color-secondary)"/>
                            </svg>
                        </div>
                        <div class="author-info">
                            <h4 class="author-name">李先生</h4>
                            <p class="author-title">軟體工程師</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card" data-animate="fadeInUp" data-delay="500">
                    <div class="testimonial-content">
                        <p>"教練幫助我建立了領導自信，現在我能夠更好地帶領團隊，處理複雜的職場挑戰。"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <circle cx="20" cy="20" r="20" fill="var(--color-accent)" opacity="0.2"/>
                                <circle cx="20" cy="15" r="6" fill="var(--color-accent)"/>
                                <path d="M8 35 C8 28 13 23 20 23 C27 23 32 28 32 35" fill="var(--color-accent)"/>
                            </svg>
                        </div>
                        <div class="author-info">
                            <h4 class="author-name">王小姐</h4>
                            <p class="author-title">專案主管</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="booking-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-animate="fadeInUp">立即預約</h2>
                <p class="section-description" data-animate="fadeInUp" data-delay="200">
                    開始您的個人成長之旅，與專業教練一起實現目標
                </p>
            </div>
            
            <div class="booking-container">
                <form class="booking-form" id="personal-coaching-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="booking-name" class="form-label">姓名 *</label>
                            <input type="text" id="booking-name" name="name" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="booking-email" class="form-label">電子郵件 *</label>
                            <input type="email" id="booking-email" name="email" class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="booking-phone" class="form-label">電話號碼 *</label>
                            <input type="tel" id="booking-phone" name="phone" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="booking-plan" class="form-label">選擇方案 *</label>
                            <select id="booking-plan" name="plan" class="form-select" required>
                                <option value="">請選擇服務方案</option>
                                <option value="single">單次諮詢 - NT$ 2,500</option>
                                <option value="standard">標準方案 - NT$ 18,000</option>
                                <option value="premium">深度方案 - NT$ 32,000</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="booking-goals" class="form-label">主要目標 *</label>
                        <textarea id="booking-goals" name="goals" class="form-textarea" rows="4" placeholder="請描述您希望通過教練服務達到的目標..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="booking-preferred-time" class="form-label">偏好時間</label>
                        <select id="booking-preferred-time" name="preferred-time" class="form-select">
                            <option value="">請選擇偏好時間</option>
                            <option value="morning">上午 (9:00-12:00)</option>
                            <option value="afternoon">下午 (14:00-17:00)</option>
                            <option value="evening">晚上 (18:00-21:00)</option>
                            <option value="weekend">週末</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-large">提交預約</button>
                    </div>
                </form>
                
                <div class="booking-info">
                    <h3 class="booking-info-title">預約須知</h3>
                    <div class="info-item">
                        <h4>預約流程</h4>
                        <p>提交預約後，我們將在24小時內與您聯繫，確認會談時間和地點</p>
                    </div>
                    <div class="info-item">
                        <h4>會談方式</h4>
                        <p>支持面對面會談、視訊會議或電話諮詢，根據您的需求靈活安排</p>
                    </div>
                    <div class="info-item">
                        <h4>取消政策</h4>
                        <p>如需取消或改期，請提前24小時通知，我們將為您重新安排</p>
                    </div>
                    <div class="info-item">
                        <h4>付款方式</h4>
                        <p>支持銀行轉帳、信用卡付款或現金支付，詳情請聯繫我們</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../../includes/footer.php'; ?>
