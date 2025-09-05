<?php
/**
 * 教練學習平台 - 個人頁面專用 Header
 */

// 檢查是否已登入 - 使用 userManagement 系統
if (!isset($userManagement) || !$userManagement->isLoggedIn()) {
    header('Location: ' . BASE_URL . '/login-page');
    exit;
}

// 獲取當前用戶信息
$currentUser = $userManagement->getCurrentUser();
$isLoggedIn = $userManagement->isLoggedIn();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : '個人中心 - ' . SITE_NAME; ?></title>
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : '管理您的學習進度和個人資料'; ?>">
    <meta name="keywords" content="<?php echo isset($pageKeywords) ? $pageKeywords : '個人中心,學習進度,個人資料'; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo BASE_URL; ?>/assets/images/favicon.svg">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/utilities/variables.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/utilities/helpers.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/navigation.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/buttons.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/cards.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/forms.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/modal.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/themes.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/responsive.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/main.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- 頁面特定 CSS -->
    <?php if (isset($pageCSS)): ?>
        <?php foreach ($pageCSS as $css): ?>
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="user-page">
    <!-- 用戶專用導航 -->
    <header class="user-header">
        <div class="user-header-container">
            <!-- Logo 和返回主頁 -->
            <div class="user-header-left">
                <div class="user-logo">
                    <img src="<?php echo BASE_URL; ?>/assets/images/logos/logo-main.svg" alt="<?php echo SITE_NAME; ?>" class="logo-img">
                </div>
            </div>
            
            <!-- 用戶信息 -->
            <div class="user-header-center">
                <h1 class="user-page-title"><?php echo isset($pageTitle) ? $pageTitle : '個人中心'; ?></h1>
            </div>
            
            <!-- 用戶操作 -->
            <div class="user-header-right">
                <div class="user-menu">
                    <button class="user-menu-toggle" aria-expanded="false" aria-haspopup="true">
                        <div class="user-info">
                            <div class="user-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-details">
                                <span class="user-greeting">你好! 歡迎回來!</span>
                                <span class="user-name"><?php echo e(isset($currentUser['username']) ? $currentUser['username'] : '用戶'); ?></span>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="user-dropdown" role="menu">
                        <li><a href="<?php echo BASE_URL; ?>/profile" role="menuitem">
                            <i class="fas fa-user"></i> 個人資料
                        </a></li>
                        <li><a href="<?php echo BASE_URL; ?>/my-courses" role="menuitem">
                            <i class="fas fa-book"></i> 我的課程
                        </a></li>
                        <!-- 社區互動選項暫時隱藏 -->
                        <!--
                        <li><a href="<?php echo BASE_URL; ?>/community" role="menuitem">
                            <i class="fas fa-users"></i> 社區互動
                        </a></li>
                        -->
                        <!-- 搜索發現選項暫時隱藏 -->
                        <!--
                        <li><a href="<?php echo BASE_URL; ?>/search" role="menuitem">
                            <i class="fas fa-search"></i> 搜索發現
                        </a></li>
                        -->
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="<?php echo BASE_URL; ?>/logout" role="menuitem">
                            <i class="fas fa-sign-out-alt"></i> 登出
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    
    <!-- 用戶導航欄 -->
    <nav class="user-nav">
        <div class="user-nav-container">
            <!-- 移動端導航切換按鈕 -->
            <button class="user-nav-toggle d-md-none" aria-expanded="false" aria-controls="user-nav-list">
                <i class="fas fa-bars"></i>
                <span class="sr-only">切換導航菜單</span>
            </button>
            
            <ul class="user-nav-list" id="user-nav-list">
                <li class="user-nav-item">
                    <a href="<?php echo BASE_URL; ?>/my-courses" class="user-nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'my-courses.php' || basename($_SERVER['PHP_SELF']) == 'course-learning.php') ? 'active' : ''; ?>">
                        <i class="fas fa-book"></i>
                        <span>我的課程</span>
                    </a>
                </li>
                <li class="user-nav-item">
                    <a href="<?php echo BASE_URL; ?>/profile" class="user-nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'active' : ''; ?>">
                        <i class="fas fa-user"></i>
                        <span>個人資料</span>
                    </a>
                </li>
                <!-- 社區互動導航項目暫時隱藏 -->
                <!--
                <li class="user-nav-item">
                    <a href="<?php echo BASE_URL; ?>/community" class="user-nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'community.php') ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i>
                        <span>社區互動</span>
                    </a>
                </li>
                -->
                <!-- 搜索發現導航項目暫時隱藏 -->
                <!--
                <li class="user-nav-item">
                    <a href="<?php echo BASE_URL; ?>/search" class="user-nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'search.php') ? 'active' : ''; ?>">
                        <i class="fas fa-search"></i>
                        <span>搜索發現</span>
                    </a>
                </li>
                -->
            </ul>
        </div>
    </nav>
    
    <!-- 主要內容區域 -->
    <main class="user-main">
        <div class="user-container container">
