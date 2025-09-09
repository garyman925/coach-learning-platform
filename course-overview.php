<?php
/**
 * 教練學習平台 - 課程介紹
 */

// 包含配置文件
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

// 設置頁面特定變量
$pageTitle = '課程介紹 - ' . SITE_NAME;
$pageDescription = '專業教練課程培訓介紹，包含ACTP認證課程、專業教練應用課程、團隊教練課程等';
$pageKeywords = '教練課程,ACTP認證,專業教練,團隊教練,教練培訓';
$pageCSS = 'assets/css/pages/course-overview.css';

// 包含頁面頭部
include 'includes/header.php';
?>

<main class="course-overview-page">
    <!-- Hero Section -->
    <section class="course-overview-hero">
        <div class="hero-background">
            <div class="hero-overlay"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">課程介紹</h1>
                <p class="hero-subtitle">專業教練培訓課程，助您成為優秀的教練人才</p>
            </div>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="introduction-section">
        <div class="container">
            <div class="intro-content">
                <div class="intro-video" data-animate="fadeInLeft">
                    <div class="video-container">
                        <video controls poster="assets/videos/course-overview/intro.mp4">
                            <source src="assets/videos/course-overview/intro.mp4" type="video/mp4">
                            您的瀏覽器不支持視頻播放。
                        </video>
                    </div>
                </div>
                <div class="intro-text" data-animate="fadeInRight">
                    <h2 class="section-title">專業教練的本質</h2>
                    <div class="intro-description">
                        <p>專業教練的本質是<strong>"賦能型陪伴"</strong>
                            專業教練的核心不是"替客戶解決問題"，而是通過專業知識、
                            系統方法和情感支持，幫助客戶成為"能自己解決問題的人"。其終極價值在於：
                        </p>
                        
                        <div class="value-points">
                            <div class="value-point">
                                <h4>短期</h4>
                                <span>加速目標達成，減少試錯成本</span>
                            </div>
                            <div class="value-point">
                                <h4>中期</h4>
                                <span>培養底層能力（如決策力、情緒管理），提升應對複雜問題的韌性</span>
                            </div>
                            <div class="value-point">
                                <h4>長期</h4>
                                <span>喚醒自我覺察與成長意識，讓人從"依賴外部指導"轉向"自主終身成長"</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Coach Training Section -->
    <section class="professional-training-section">
        <div class="container">
            <div class="section-content">
                <div class="content-text" data-animate="fadeInLeft">
                    <h2 class="section-title">專業教練課程培訓</h2>
                    
                    <div class="training-intro">
                        <p>我們的專業教練課程培訓，包含：ACTP認證課程、專業教練應用課程、團隊教練應用課程、團隊教練認證課程、教練督導課程等。</p>
                        <p>成為一名教練，是需要多方面的學習的，萬浬的Pillar學校為渴望成為教練的學員提供一個學習框架，可以在各方面有系統的成為一名教練。</p>
                        <p>ACTP認證課程，是成為一名專業教練的學習基礎，它是ICF專業認證教練培訓課程的簡稱，目前我們主要提供兩個級別的認證考試，分別是Pillar Coaching基礎課程（ACC）及Pillar Coaching進階課程（PCC）。</p>
                    </div>
                </div>
                
                <div class="content-image" data-animate="fadeInRight">
                    <img src="assets/images/course-overview/course-overview-1.png" alt="專業教練課程培訓" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Course Cards Section -->
    <section class="course-cards-section">
        <div class="container">
            <div class="section-content">
                <!-- ACC Course Card -->
                <div class="course-card" data-animate="fadeInLeft">
                    <div class="card-header">
                        <h3 class="course-title">Pillar Coaching ACTP基礎課程（ACC）</h3>
                    </div>
                    <div class="card-content">
                        <h4 class="content-title">課程學習目標</h4>
                        <p>本課程專為有意向掌握ICF PCC階段核心指導能力的學習者設計，提供階段性能力基礎。學習者需完成以下目標：</p>
                        
                        <ol class="learning-objectives">
                            <li><strong>認證與進階準備</strong>：完成60小時教練專項培訓，滿足ACTP申請ICF ACC認證要求，並為PCC階段課程學習奠定基礎</li>
                            <li><strong>基礎認知</strong>：明確"教練"定義，辨析其與其它人類發展方法論的差異</li>
                            <li><strong>模式掌握</strong>：學習多種教練模式</li>
                            <li><strong>技能應用</strong>：掌握並應用核心教練技能與框架</li>
                            <li><strong>工具融合</strong>：運用正向心理學、神經科學及情商工具/概念/方法，提升教練成效與可持續性</li>
                            <li><strong>自我發展</strong>：通過反思與能力評估，明確個人發展領域，制定後續學習計劃</li>
                            <li><strong>基礎夯實</strong>：強化行政與企業培訓基礎能力</li>
                        </ol>
                        
                        <div class="course-duration">
                            <strong>課程時長：</strong>Pillar Coaching基礎課程（ACC認證）：60小時
                        </div>
                    </div>
                </div>

                <!-- PCC Course Card -->
                <div class="course-card" data-animate="fadeInRight">
                    <div class="card-header">
                        <h3 class="course-title">Pillar Coaching ACTP進階課程（PCC）</h3>
                    </div>
                    <div class="card-content">
                        <h4 class="content-title">課程學習目標</h4>
                        <p>本課程專為有意向掌握ICF PCC階段核心指導能力的學習者設計，提供階段性能力基礎。學習者需完成以下目標：</p>
                        
                        <ol class="learning-objectives">
                            <li><strong>認證與進階準備</strong>：完成65小時面授學習時長，滿足ACTP申請ICF ACC認證要求，並為PCC階段課程學習奠定基礎</li>
                            <li><strong>基礎認知</strong>：明確"教練"定義，辨析其與其他人類發展方法論的差異</li>
                            <li><strong>模式掌握</strong>：學習多種教練模式</li>
                            <li><strong>技能應用</strong>：掌握並應用核心教練技能與框架</li>
                            <li><strong>工具融合</strong>：運用正向心理學、神經科學及情商工具/概念/方法，提升教練成效與可持續性</li>
                            <li><strong>自我發展</strong>：通過反思與能力評估，明確個人發展領域，制定後續學習計劃</li>
                            <li><strong>基礎夯實</strong>：強化行政與企業培訓基礎能力</li>
                        </ol>
                        
                        <div class="course-duration">
                            <strong>課程時長：</strong>Pillar Coaching進階課程：65小時
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Coach Application Section -->
    <section class="application-section">
        <div class="container">
            <div class="section-content">
                <div class="content-text" data-animate="fadeInLeft">
                    <h2 class="section-title">專業教練應用課程</h2>
                    <p>本課程聚焦"教練思維"的實戰轉化，專為希望將專業教練技巧深度融入個人生活與人生發展的學習者設計。課程跳脫理論框架，以真實場景為導向，系統教授教練核心技術——從精準傾聽、有力提問到目標拆解與行動賦能，通過情景模擬、案例演練與導師反饋，幫助學員快速掌握"用教練視角解決問題"的底層能力。</p>
                    <p>無論是應對職業瓶頸、優化親密關係，還是突破自我成長卡點，課程均以"個人人生應用"為核心目標，引導學員將所學工具轉化為日常行動策略。結課後，你將具備更敏銳的自我覺察力、更高效的問題解決力，以及用"教練式思維"推動生活正向循環的能力。</p>
                </div>
                
                <div class="content-image" data-animate="fadeInRight">
                    <img src="assets/images/course-overview/course-overview-2.png" alt="專業教練應用課程" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Team Coach Application Section -->
    <section class="team-application-section">
        <div class="container">
            <div class="section-content">
                <div class="content-text" data-animate="fadeInLeft">
                    <h2 class="section-title">團隊教練應用課程</h2>
                    <p>本課程聚焦團隊真實場景，專為團隊管理者、核心成員設計，旨在通過實戰工具提升團隊協作效能。</p>
                    <p>課程圍繞"目標對齊-溝通提效-衝突化解-動力激活"四大核心場景，提煉團隊教練常用方法（如協作框架、深度對話工具、角色分工策略等），結合真實團隊案例演練，幫助學員快速掌握"帶團隊"的關鍵動作。</p>
                    <p>無需複雜理論，直接對標日常工作難題（如目標模糊、成員協作低效、動力不足等），通過"學工具+練場景+得方案"的模式，讓學員課後能立刻將技巧應用於團隊管理，推動團隊從"各自為戰"轉向"高效共進"。</p>
                </div>
                <div class="content-image" data-animate="fadeInRight">
                    <img src="assets/images/course-overview/course-overview-3.png" alt="團隊教練應用課程" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Team Coach Certification Section -->
    <section class="team-certification-section">
        <div class="container">
            <div class="section-content">
                <div class="content-image" data-animate="fadeInLeft">
                    <img src="assets/images/course-overview/course-overview-4.png" alt="團隊教練認證課程" loading="lazy">
                </div>
                <div class="content-text" data-animate="fadeInRight">
                    <h2 class="section-title">團隊教練認證課程</h2>
                    <p>本課程為ICF（國際教練聯合會）認證培訓項目，專為希望成為專業團隊教練的學習者設計，系統培養團隊教練核心能力，助力通過認證並開展執業服務。</p>
                    <p>課程聚焦團隊教練實戰場景，覆蓋"團隊診斷-目標共識-協作賦能-動力激發"四大模塊，包含ICF認證要求的理論框架、核心工具（如團隊測評、深度對話技術、反饋模型等）及倫理規範學習。通過"理論講解+情景模擬+導師督導+實戰案例復盤"的閉環學習，確保學員掌握團隊教練全流程操作能力。</p>
                    <p>完成課程並通過考核後，學員將獲得ICF認證團隊教練資質，具備獨立為企業、組織提供團隊教練服務的專業能力，職業發展空間廣闊。</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Coach Supervision Section -->
    <section class="supervision-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">教練督導課程</h2>
                <p class="section-description">專為希望提升教練影響力、系統學習ICF標準能力的專業教練設計</p>
            </div>
            
            <div class="supervision-grid">
                <div class="supervision-card" data-animate="fadeInUp">
                    <div class="supervision-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="supervision-title">課程定位</h3>
                    <p class="supervision-description">
                        專為希望提升教練影響力、系統學習ICF標準能力的專業教練設計，兼顧ACC與PCC級別核心能力培養，夯實教練服務專業基礎。
                    </p>
                </div>

                <div class="supervision-card" data-animate="fadeInUp" data-delay="200">
                    <div class="supervision-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="supervision-title">學習形式與時長</h3>
                    <p class="supervision-description">
                        總時長18小時，包含8小時課堂入門培訓、每週5場2小時線上/線下實踐課、7小時MCC小組督導（符合ICF認證導師小時要求）。
                    </p>
                </div>

                <div class="supervision-card" data-animate="fadeInUp" data-delay="400">
                    <div class="supervision-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="supervision-title">核心內容</h3>
                    <p class="supervision-description">
                        圍繞ICF核心教練能力展開，涵蓋理論學習、實踐觀察、小組練習等，通過多元化方式（閱讀、討論、演示、同伴實驗室、反思日誌等）強化能力應用。
                    </p>
                </div>

                <div class="supervision-card" data-animate="fadeInUp" data-delay="600">
                    <div class="supervision-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="supervision-title">學習成果</h3>
                    <p class="supervision-description">
                        掌握ICF標準下教練特定監督能力，深入理解ACC/PCC級別核心能力，通過觀察教練互動、反饋討論，提升不同能力場景的應用技巧。
                    </p>
                </div>

                <div class="supervision-card" data-animate="fadeInUp" data-delay="800">
                    <div class="supervision-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="supervision-title">入學要求與費用</h3>
                    <p class="supervision-description">
                        需已完成至少60小時專業教練培訓機構課程。名額先到先得，開課一週前需全額支付學費（HK$9,500），錄音評估需額外繳交HK$1,000。
                    </p>
                </div>

                <div class="supervision-card" data-animate="fadeInUp" data-delay="1000">
                    <div class="supervision-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="supervision-title">課程特色</h3>
                    <p class="supervision-description">
                        緊扣ICF認證需求，理論與實踐結合，兼顧ACC與PCC能力提升，助你高效構建專業教練服務體系。
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// 包含頁面頁腳
include 'includes/footer.php';
?>
