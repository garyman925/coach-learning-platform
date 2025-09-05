<?php
/**
 * 教練學習平台 - 教練聯盟
 */

require_once '../includes/config.php';
require_once '../includes/header.php';

// 設置頁面特定變數
$pageTitle = '教練聯盟 - ' . SITE_NAME;
$pageDescription = '加入教練聯盟，與專業教練建立合作關係，共享資源，共同成長';
$pageKeywords = '教練聯盟,教練合作,資源共享,專業發展,教練社群';
?>

<main class="alliance-page">
    <!-- Hero Section -->
    <section class="alliance-hero">
        <div class="hero-background">
            <div class="hero-pattern"></div>
            <div class="hero-overlay"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">教練聯盟</h1>
                <p class="hero-subtitle">與專業教練攜手，共同創造更大的價值</p>
                <div class="hero-description">
                    <p>加入我們的教練聯盟，與來自不同領域的專業教練建立合作關係，共享資源和經驗，共同提升專業能力，為客戶提供更全面的服務。</p>
                </div>
                <div class="hero-actions">
                    <button class="btn btn-primary" onclick="showAllianceModal()">
                        <i class="fas fa-handshake"></i>
                        申請加入聯盟
                    </button>
                    <a href="#alliance-benefits" class="btn btn-outline">
                        <i class="fas fa-info-circle"></i>
                        了解更多
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Alliance Overview -->
    <section class="alliance-overview">
        <div class="container">
            <div class="overview-grid">
                <div class="overview-item" data-animate="fadeInUp">
                    <div class="overview-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>聯盟規模</h3>
                    <p class="overview-number">150+</p>
                    <p class="overview-label">專業教練</p>
                </div>
                <div class="overview-item" data-animate="fadeInUp" data-delay="200">
                    <div class="overview-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>服務範圍</h3>
                    <p class="overview-number">25+</p>
                    <p class="overview-label">城市</p>
                </div>
                <div class="overview-item" data-animate="fadeInUp" data-delay="400">
                    <div class="overview-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>客戶滿意度</h3>
                    <p class="overview-number">98%</p>
                    <p class="overview-label">滿意度</p>
                </div>
                <div class="overview-item" data-animate="fadeInUp" data-delay="600">
                    <div class="overview-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>合作項目</h3>
                    <p class="overview-number">200+</p>
                    <p class="overview-label">成功案例</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Alliance Benefits -->
    <section id="alliance-benefits" class="alliance-benefits">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">加入聯盟的優勢</h2>
                <p class="section-description">與我們合作，您將獲得以下優勢</p>
            </div>
            
            <div class="benefits-grid">
                <div class="benefit-card" data-animate="fadeInUp">
                    <div class="benefit-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>專業網絡</h3>
                    <p>與來自不同領域的專業教練建立聯繫，擴展您的專業人脈網絡</p>
                    <ul class="benefit-features">
                        <li>定期舉辦聯盟聚會</li>
                        <li>線上交流平台</li>
                        <li>專業研討會</li>
                    </ul>
                </div>

                <div class="benefit-card" data-animate="fadeInUp" data-delay="200">
                    <div class="benefit-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3>資源共享</h3>
                    <p>共享聯盟內的專業資源，包括工具、模板、案例研究等</p>
                    <ul class="benefit-features">
                        <li>教練工具庫</li>
                        <li>案例研究資料</li>
                        <li>專業模板</li>
                    </ul>
                </div>

                <div class="benefit-card" data-animate="fadeInUp" data-delay="400">
                    <div class="benefit-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>業務拓展</h3>
                    <p>通過聯盟合作，獲得更多業務機會和客戶推薦</p>
                    <ul class="benefit-features">
                        <li>客戶轉介</li>
                        <li>聯合項目</li>
                        <li>市場推廣</li>
                    </ul>
                </div>

                <div class="benefit-card" data-animate="fadeInUp" data-delay="600">
                    <div class="benefit-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>持續學習</h3>
                    <p>參與聯盟舉辦的培訓和進修課程，持續提升專業能力</p>
                    <ul class="benefit-features">
                        <li>專業培訓課程</li>
                        <li>認證考試</li>
                        <li>技能提升</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Alliance Members -->
    <section class="alliance-members">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">聯盟成員</h2>
                <p class="section-description">認識我們的優秀聯盟成員</p>
            </div>
            
            <div class="members-grid">
                <div class="member-card" data-animate="fadeInUp">
                    <div class="member-avatar">
                        <img src="/coach-learning-platform-mainpage/assets/images/alliance/member-1.jpg" alt="聯盟成員" loading="lazy">
                    </div>
                    <div class="member-info">
                        <h3 class="member-name">張美玲</h3>
                        <p class="member-title">資深企業教練</p>
                        <p class="member-specialty">專精於領導力發展和組織變革</p>
                        <div class="member-stats">
                            <span class="stat-item">
                                <i class="fas fa-users"></i>
                                50+ 客戶
                            </span>
                            <span class="stat-item">
                                <i class="fas fa-star"></i>
                                4.9/5
                            </span>
                        </div>
                    </div>
                </div>

                <div class="member-card" data-animate="fadeInUp" data-delay="200">
                    <div class="member-avatar">
                        <img src="/coach-learning-platform-mainpage/assets/images/alliance/member-2.jpg" alt="聯盟成員" loading="lazy">
                    </div>
                    <div class="member-info">
                        <h3 class="member-name">陳志強</h3>
                        <p class="member-title">團隊教練專家</p>
                        <p class="member-specialty">專精於團隊建設和衝突管理</p>
                        <div class="member-stats">
                            <span class="stat-item">
                                <i class="fas fa-users"></i>
                                30+ 團隊
                            </span>
                            <span class="stat-item">
                                <i class="fas fa-star"></i>
                                4.8/5
                            </span>
                        </div>
                    </div>
                </div>

                <div class="member-card" data-animate="fadeInUp" data-delay="400">
                    <div class="member-avatar">
                        <img src="/coach-learning-platform-mainpage/assets/images/alliance/member-3.jpg" alt="聯盟成員" loading="lazy">
                    </div>
                    <div class="member-info">
                        <h3 class="member-name">林雅芳</h3>
                        <p class="member-title">家庭教練顧問</p>
                        <p class="member-specialty">專精於親子關係和家庭教育</p>
                        <div class="member-stats">
                            <span class="stat-item">
                                <i class="fas fa-users"></i>
                                100+ 家庭
                            </span>
                            <span class="stat-item">
                                <i class="fas fa-star"></i>
                                4.9/5
                            </span>
                        </div>
                    </div>
                </div>

                <div class="member-card" data-animate="fadeInUp" data-delay="600">
                    <div class="member-avatar">
                        <img src="/coach-learning-platform-mainpage/assets/images/alliance/member-4.jpg" alt="聯盟成員" loading="lazy">
                    </div>
                    <div class="member-info">
                        <h3 class="member-name">王偉傑</h3>
                        <p class="member-title">九型人格教練</p>
                        <p class="member-specialty">專精於人格分析和自我認知</p>
                        <div class="member-stats">
                            <span class="stat-item">
                                <i class="fas fa-users"></i>
                                80+ 學員
                            </span>
                            <span class="stat-item">
                                <i class="fas fa-star"></i>
                                4.7/5
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Join -->
    <section class="how-to-join">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">如何加入聯盟</h2>
                <p class="section-description">簡單三步，成為聯盟成員</p>
            </div>
            
            <div class="join-steps">
                <div class="step-item" data-animate="fadeInUp">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>提交申請</h3>
                        <p>填寫聯盟申請表，提供您的專業背景和經驗</p>
                    </div>
                </div>

                <div class="step-item" data-animate="fadeInUp" data-delay="200">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>資格審核</h3>
                        <p>我們將審核您的專業資格和經驗，通常在3-5個工作日內完成</p>
                    </div>
                </div>

                <div class="step-item" data-animate="fadeInUp" data-delay="400">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>正式加入</h3>
                        <p>通過審核後，您將正式成為聯盟成員，享受所有聯盟權益</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="alliance-cta">
        <div class="container">
            <div class="cta-content">
                <h2>準備好加入教練聯盟了嗎？</h2>
                <p>與我們一起，創造更大的價值，實現共同的成長</p>
                <div class="cta-actions">
                    <button class="btn btn-primary btn-large" onclick="showAllianceModal()">
                        <i class="fas fa-handshake"></i>
                        立即申請加入
                    </button>
                    <a href="/contact" class="btn btn-outline btn-large">
                        <i class="fas fa-envelope"></i>
                        聯繫我們
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Alliance Application Modal -->
<div id="allianceModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>聯盟申請表</h3>
            <button class="modal-close" onclick="closeAllianceModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="allianceForm" class="alliance-form">
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
                    <label for="coachingExperience">教練經驗 *</label>
                    <select id="coachingExperience" name="coachingExperience" required>
                        <option value="">請選擇</option>
                        <option value="0-2">0-2年</option>
                        <option value="3-5">3-5年</option>
                        <option value="6-10">6-10年</option>
                        <option value="10+">10年以上</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="coachingSpecialty">專精領域 *</label>
                    <input type="text" id="coachingSpecialty" name="coachingSpecialty" placeholder="例如：領導力、團隊教練、家庭教練等" required>
                </div>
                <div class="form-group">
                    <label for="certifications">專業認證</label>
                    <input type="text" id="certifications" name="certifications" placeholder="例如：ICF、IAC等認證">
                </div>
                <div class="form-group">
                    <label for="motivation">加入動機 *</label>
                    <textarea id="motivation" name="motivation" rows="4" placeholder="請說明您希望加入聯盟的原因和期望" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">提交申請</button>
                    <button type="button" class="btn btn-outline" onclick="closeAllianceModal()">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
