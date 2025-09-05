<?php
/**
 * 教練學習平台 - 頁面頭部
 * 包含HTML head部分和導航
 */

// 防止直接訪問
if (!defined('SECURE_ACCESS') || !SECURE_ACCESS) {
    http_response_code(403);
    exit('直接訪問被禁止');
}

// 包含必要的函數文件
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/user-management.php';

// 獲取頁面標題
$pageTitle = isset($pageTitle) ? $pageTitle : SITE_NAME;
$pageDescription = isset($pageDescription) ? $pageDescription : SITE_DESCRIPTION;
$pageKeywords = isset($pageKeywords) ? $pageKeywords : '教練,培訓,課程,學習,教育';

// 獲取當前語言
$currentLanguage = isset($_SESSION['language']) ? $_SESSION['language'] : 'zh-TW';
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLanguage; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO Meta Tags -->
    <title><?php echo e($pageTitle); ?></title>
    <meta name="description" content="<?php echo e($pageDescription); ?>">
    <meta name="keywords" content="<?php echo e($pageKeywords); ?>">
    <meta name="author" content="<?php echo SITE_NAME; ?>">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo e($pageTitle); ?>">
    <meta property="og:description" content="<?php echo e($pageDescription); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo getCurrentURL(); ?>">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($pageTitle); ?>">
    <meta name="twitter:description" content="<?php echo e($pageDescription); ?>">
    
         <!-- Favicon -->
     <link rel="icon" type="image/svg+xml" href="<?php echo BASE_URL; ?>/assets/images/logos/favicon.svg">
     <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/assets/images/logos/favicon.ico">
     <link rel="apple-touch-icon" sizes="180x180" href="<?php echo BASE_URL; ?>/assets/images/logos/apple-touch-icon.svg">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/utilities/variables.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/utilities/helpers.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/navigation.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/buttons.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/cards.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/forms.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/search.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/modal.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/themes.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/responsive.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/pages/services.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/pages/services-detail.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/pages/about.css">
                <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/pages/courses.css">
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/pages/course-detail.css">
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/pages/alliance.css">
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/pages/contact.css">
            
                         <!-- Page Specific CSS -->
     <?php if (isset($pageCSS)): ?>
         <link rel="stylesheet" href="<?php echo BASE_URL; ?>/<?php echo $pageCSS; ?>">
     <?php endif; ?>
    
         <!-- Google Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+TC:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     
     <!-- Preload Critical Resources -->
     <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+TC:wght@300;400;500;600;700&display=swap" as="style">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?php echo SITE_NAME; ?>",
        "description": "<?php echo SITE_DESCRIPTION; ?>",
        "url": "<?php echo SITE_URL; ?>",
        "logo": "<?php echo SITE_URL; ?>assets/images/logos/logo-main.png",
        "sameAs": [
            "https://facebook.com/yourpage",
            "https://twitter.com/yourpage",
            "https://linkedin.com/company/yourcompany"
        ]
    }
    </script>
</head>
<body class="<?php echo isset($bodyClass) ? $bodyClass : ''; ?>">
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="skip-link">跳過導航</a>
    
    <!-- Header -->
    <header class="site-header" role="banner">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="container">
                <div class="top-bar-content">
                                         <!-- Company Info -->
                     <div class="company-info">
                                                                           <div class="logo">
                             <a href="<?php echo BASE_URL; ?>/index.php" aria-label="<?php echo SITE_NAME; ?> 首頁">
                                 <img src="<?php echo BASE_URL; ?>/assets/images/logos/logo-main.svg" alt="<?php echo SITE_NAME; ?>" width="200" height="60">
                             </a>
                         </div>
                        <div class="slogan">
                            <span>專業教練培訓，成就卓越人生</span>
                        </div>
                    </div>
                    
                                         <!-- User Actions -->
                     <div class="user-actions">
                         <?php if ($isLoggedIn): ?>
                             <!-- Logged in user -->
                             <div class="user-menu">
                                 <button class="user-menu-toggle" aria-expanded="false" aria-haspopup="true">
                                     <span class="user-name"><?php echo e($currentUser['username']); ?></span>
                                     <svg class="dropdown-arrow" width="12" height="8" viewBox="0 0 12 8">
                                         <path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="2" fill="none"/>
                                     </svg>
                                 </button>
                                 <ul class="user-dropdown" role="menu">
                                                                           <?php if ($isAdmin): ?>
                                                                                 <li><a href="<?php echo BASE_URL; ?>/admin/" role="menuitem">管理員後台</a></li>
                                       <li><hr class="dropdown-divider"></li>
                                   <?php endif; ?>
                                   <li><a href="<?php echo BASE_URL; ?>/profile" role="menuitem">個人資料</a></li>
                                   <li><a href="<?php echo BASE_URL; ?>/my-courses" role="menuitem">我的課程</a></li>
                                   <li><a href="<?php echo BASE_URL; ?>/community" role="menuitem">社區互動</a></li>
                                   <li><a href="<?php echo BASE_URL; ?>/search" role="menuitem">搜索發現</a></li>
                                   <li><hr class="dropdown-divider"></li>
                                   <li><a href="<?php echo BASE_URL; ?>/logout" role="menuitem">登出</a></li>
                                 </ul>
                             </div>
                         <?php else: ?>
                             <!-- Guest user -->
                             <div class="auth-buttons">
                                 <a href="<?php echo BASE_URL; ?>/login-page" class="btn btn-outline">登入</a>
                                 <button type="button" class="btn btn-primary" onclick="showRegisterModal()">註冊</button>
                             </div>
                         <?php endif; ?>
                        
                        <!-- Language Switcher -->
                        <div class="language-switcher">
                            <button class="language-toggle" aria-expanded="false" aria-haspopup="true">
                                <span class="current-language">
                                    <?php
                                    $languageNames = [
                                        'zh-TW' => '繁體',
                                        'zh-CN' => '簡體',
                                        'en' => 'EN'
                                    ];
                                    echo isset($languageNames[$currentLanguage]) ? $languageNames[$currentLanguage] : '繁體';
                                    ?>
                                </span>
                                <svg class="dropdown-arrow" width="12" height="8" viewBox="0 0 12 8">
                                    <path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="2" fill="none"/>
                                </svg>
                            </button>
                            <ul class="language-dropdown" role="menu">
                                <li><a href="?lang=zh-TW" role="menuitem" data-lang="zh-TW">繁體中文</a></li>
                                <li><a href="?lang=zh-CN" role="menuitem" data-lang="zh-CN">簡體中文</a></li>
                                <li><a href="?lang=en" role="menuitem" data-lang="en">English</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation -->
        <nav class="main-navigation" role="navigation" aria-label="主要導航">
            <div class="container">
                <div class="nav-content">
                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-menu-toggle" aria-expanded="false" aria-controls="main-menu">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="sr-only">開啟選單</span>
                    </button>
                    
                                         <!-- Navigation Menu -->
                     <ul id="main-menu" class="nav-menu" role="menubar">
                                                   <li class="nav-item" role="none">
                              <a href="<?php echo BASE_URL; ?>/index.php" class="nav-link" role="menuitem">首頁</a>
                          </li>
                          
                          <li class="nav-item" role="none">
                              <a href="<?php echo BASE_URL; ?>/about" class="nav-link" role="menuitem">關於我們</a>
                          </li>
                         
                         <li class="nav-item has-dropdown" role="none">
                             <button class="nav-link dropdown-toggle" aria-expanded="false" aria-haspopup="true" role="menuitem">
                                 培訓課程
                                 <svg class="dropdown-arrow" width="12" height="8" viewBox="0 0 12 8">
                                     <path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="2" fill="none"/>
                                 </svg>
                             </button>
                                                           <ul class="dropdown-menu" role="menu">
                                  <li><a href="<?php echo BASE_URL; ?>/courses/professional-coaching" role="menuitem">專業教練課程</a></li>
                                  <li><a href="<?php echo BASE_URL; ?>/courses/team-coaching" role="menuitem">團隊教練課程</a></li>
                                  <li><a href="<?php echo BASE_URL; ?>/courses/parent-coaching" role="menuitem">家長課程</a></li>
                                  <li><a href="<?php echo BASE_URL; ?>/courses/enneagram" role="menuitem">9型人格課程</a></li>
                              </ul>
                         </li>
                         
                         <li class="nav-item has-dropdown" role="none">
                             <button class="nav-link dropdown-toggle" aria-expanded="false" aria-haspopup="true" role="menuitem">
                                 教練服務
                                 <svg class="dropdown-arrow" width="12" height="8" viewBox="0 0 12 5">
                                     <path d="M1 1l5 5 5-5" stroke="currentColor" stroke-width="2" fill="none"/>
                                 </svg>
                             </button>
                                                           <ul class="dropdown-menu" role="menu">
                                                   <li><a href="<?php echo BASE_URL; ?>/services/personal" role="menuitem">個人教練服務</a></li>
                 <li><a href="<?php echo BASE_URL; ?>/services/enterprise" role="menuitem">企業教練服務</a></li>
                              </ul>
                         </li>
                         
                                                   <li class="nav-item" role="none">
                              <a href="<?php echo BASE_URL; ?>/alliance" class="nav-link" role="menuitem">教練聯盟</a>
                          </li>
                          
                          <li class="nav-item" role="none">
                              <a href="<?php echo BASE_URL; ?>/contact" class="nav-link" role="menuitem">聯系我們</a>
                          </li>
                     </ul>
                    
                                         <!-- Mobile Menu (Hidden on desktop) -->
                     <div class="mobile-menu" id="mobile-menu">
                                                   <ul class="mobile-menu-list">
                              <li class="mobile-menu-item">
                                  <a href="<?php echo BASE_URL; ?>/index.php" class="mobile-menu-link">首頁</a>
                              </li>
                              <li class="mobile-menu-item">
                                  <a href="<?php echo BASE_URL; ?>/about" class="mobile-menu-link">關於我們</a>
                              </li>
                              <li class="mobile-menu-item">
                                  <a href="<?php echo BASE_URL; ?>/courses" class="mobile-menu-link">培訓課程</a>
                              </li>
                              <li class="mobile-menu-item">
                                  <a href="<?php echo BASE_URL; ?>/services" class="mobile-menu-link">教練服務</a>
                              </li>
                              <li class="mobile-menu-item">
                                  <a href="<?php echo BASE_URL; ?>/alliance" class="mobile-menu-link">教練聯盟</a>
                              </li>
                              <li class="mobile-menu-item">
                                  <a href="<?php echo BASE_URL; ?>/contact" class="mobile-menu-link">聯系我們</a>
                              </li>
                          </ul>
                     </div>
                    
                    <!-- Search Bar -->
                    <div class="search-container">
                        <form class="search-form" role="search">
                            <div class="search-input-wrapper">
                                <input type="search" class="search-input" placeholder="搜尋課程或服務..." aria-label="搜尋">
                                <button type="button" class="search-button" aria-label="搜尋" onclick="toggleSearch()">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                        <circle cx="8" cy="8" r="6"/>
                                        <path d="M12.5 12.5L18 18"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- 登入模態框 -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>用戶登入</h2>
                <button class="modal-close" aria-label="關閉">×</button>
            </div>
            <form id="login-form" class="modal-form">
                <div class="form-group">
                    <label for="login-username">用戶名</label>
                    <input type="text" id="login-username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="login-password">密碼</label>
                    <input type="password" id="login-password" name="password" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">登入</button>
                    <button type="button" class="btn btn-outline" onclick="showRegisterModal()">註冊新帳號</button>
                </div>
                <div class="form-footer">
                    <a href="<?php echo BASE_URL; ?>/forgot-password" class="forgot-password">忘記密碼？</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- 註冊模態框 -->
    <div id="register-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>用戶註冊</h2>
                <button class="modal-close" aria-label="關閉">×</button>
            </div>
            <form id="register-form" class="modal-form">
                <div class="form-group">
                    <label for="register-username">用戶名</label>
                    <input type="text" id="register-username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="register-email">電子郵件</label>
                    <input type="email" id="register-email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="register-password">密碼</label>
                    <input type="password" id="register-password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="register-confirm-password">確認密碼</label>
                    <input type="password" id="register-confirm-password" name="confirm_password" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">註冊</button>
                    <a href="<?php echo BASE_URL; ?>/login-page" class="btn btn-outline">已有帳號？登入</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- 模態框背景遮罩 -->
    <div class="modal-backdrop"></div>
    
    <!-- Main Content -->
    <main id="main-content" class="main-content" role="main">
