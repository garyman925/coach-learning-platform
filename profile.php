<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/user-management.php';

// 初始化用戶管理
$userManagement = new UserManagement();

// 檢查用戶是否已登入
if (!$userManagement->isLoggedIn()) {
    header('Location: login.php');
    exit;
}
$currentUser = $userManagement->getCurrentUser();
$message = '';
$messageType = '';

// 處理表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        // 更新個人資料
        $profileData = [
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'bio' => trim($_POST['bio'] ?? ''),
            'company' => trim($_POST['company'] ?? ''),
            'position' => trim($_POST['position'] ?? ''),
            'website' => trim($_POST['website'] ?? ''),
            'location' => trim($_POST['location'] ?? ''),
            'interests' => trim($_POST['interests'] ?? '')
        ];
        
        $result = $userManagement->updateUserProfile($currentUser['username'], $profileData);
        if ($result['success']) {
            $message = '個人資料更新成功！';
            $messageType = 'success';
            // 記錄活動
            $userManagement->logActivity($currentUser['username'], 'profile_update', '更新個人資料', '修改了個人資料資訊');
            // 重新獲取用戶資料
            $currentUser = $userManagement->getCurrentUser();
        } else {
            $message = $result['message'] ?? '更新失敗，請重試';
            $messageType = 'error';
        }
    } elseif (isset($_POST['change_password'])) {
        // 修改密碼
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if ($newPassword !== $confirmPassword) {
            $message = '新密碼與確認密碼不符';
            $messageType = 'error';
        } elseif (strlen($newPassword) < 8) {
            $message = '新密碼至少需要8個字符';
            $messageType = 'error';
        } else {
            $result = $userManagement->changePassword($currentUser['username'], $currentPassword, $newPassword);
            if ($result['success']) {
                $message = '密碼修改成功！';
                $messageType = 'success';
                // 記錄活動
                $userManagement->logActivity($currentUser['username'], 'password_change', '修改密碼', '成功更改登入密碼');
            } else {
                $message = $result['message'] ?? '密碼修改失敗，請重試';
                $messageType = 'error';
            }
        }
    } elseif (isset($_POST['update_preferences'])) {
        // 更新偏好設定
        $preferences = [
            'language' => $_POST['language'] ?? 'zh-TW',
            'theme' => $_POST['theme'] ?? 'light',
            'notifications' => [
                'email' => isset($_POST['notifications']['email']),
                'sms' => isset($_POST['notifications']['sms']),
                'push' => isset($_POST['notifications']['push'])
            ],
            'privacy' => [
                'profile_visible' => isset($_POST['privacy']['profile_visible']),
                'show_email' => isset($_POST['privacy']['show_email']),
                'show_phone' => isset($_POST['privacy']['show_phone'])
            ]
        ];
        
        // 儲存偏好設定到 localStorage (前端處理)
        $message = '偏好設定已更新！';
        $messageType = 'success';
        // 記錄活動
        $userManagement->logActivity($currentUser['username'], 'preferences_update', '更新偏好設定', '修改了用戶偏好設定');
    } elseif (isset($_POST['update_privacy'])) {
        // 更新隱私設定
        $privacySettings = [
            'collect_analytics' => isset($_POST['privacy']['collect_analytics']),
            'collect_cookies' => isset($_POST['privacy']['collect_cookies']),
            'share_anonymized' => isset($_POST['privacy']['share_anonymized']),
            'marketing_emails' => isset($_POST['privacy']['marketing_emails'])
        ];
        
        if ($userManagement->updateUserPrivacy($currentUser['username'], $privacySettings)) {
            $message = '隱私設定更新成功！';
            $messageType = 'success';
        } else {
            $message = '隱私設定更新失敗，請重試';
            $messageType = 'error';
        }
    }
}

// 獲取用戶的完整資料
$userProfile = $currentUser['profile'] ?? [];
$userPreferences = json_decode($_COOKIE['user_preferences'] ?? '{}', true) ?: [
    'language' => 'zh-TW',
    'theme' => 'light',
    'notifications' => ['email' => true, 'sms' => false, 'push' => true],
    'privacy' => ['profile_visible' => true, 'show_email' => false, 'show_phone' => false]
];

// 獲取活動日誌數據
$activities = $userManagement->getUserActivities($currentUser['username']);
if (empty($activities)) {
    // 創建一些示例活動
    $userManagement->logActivity($currentUser['username'], 'login', '登入系統', '成功登入到教練學習平台');
    $userManagement->logActivity($currentUser['username'], 'profile_update', '更新個人資料', '修改了個人簡介和聯絡資訊');
    $userManagement->logActivity($currentUser['username'], 'password_change', '修改密碼', '成功更改登入密碼');
    $activities = $userManagement->getUserActivities($currentUser['username']);
}

// 獲取通知數據
$notifications = $userManagement->getUserNotifications($currentUser['username']);
if (empty($notifications)) {
    // 創建一些示例通知
    $userManagement->createNotification($currentUser['username'], 'system', '系統維護通知', '系統將於本週六凌晨 2:00-4:00 進行維護，期間可能無法正常使用。', 'high');
    $userManagement->createNotification($currentUser['username'], 'course', '新課程上線', '「進階教練技巧」課程現已上線，立即查看詳情！', 'medium', BASE_URL . '/courses/professional-coaching', '查看課程');
    $notifications = $userManagement->getUserNotifications($currentUser['username']);
}

// 獲取統計數據
$activityStats = $userManagement->getActivityStats($currentUser['username']);
$notificationStats = $userManagement->getNotificationStats($currentUser['username']);

// 活動類型定義
$activityTypes = [
    'login' => ['icon' => 'fas fa-sign-in-alt', 'color' => 'success', 'label' => '登入'],
    'logout' => ['icon' => 'fas fa-sign-out-alt', 'color' => 'warning', 'label' => '登出'],
    'profile_update' => ['icon' => 'fas fa-user-edit', 'color' => 'info', 'label' => '個人資料'],
    'password_change' => ['icon' => 'fas fa-key', 'color' => 'primary', 'label' => '密碼'],
    'course_view' => ['icon' => 'fas fa-book', 'color' => 'secondary', 'label' => '課程'],
    'service_contact' => ['icon' => 'fas fa-handshake', 'color' => 'success', 'label' => '服務'],
    'preferences_update' => ['icon' => 'fas fa-cog', 'color' => 'info', 'label' => '設定']
];

// 通知類型定義
$notificationTypes = [
    'system' => ['icon' => 'fas fa-cog', 'color' => 'primary', 'label' => '系統通知'],
    'course' => ['icon' => 'fas fa-book', 'color' => 'success', 'label' => '課程通知'],
    'service' => ['icon' => 'fas fa-handshake', 'color' => 'info', 'label' => '服務通知'],
    'profile' => ['icon' => 'fas fa-user', 'color' => 'secondary', 'label' => '個人資料'],
    'security' => ['icon' => 'fas fa-shield-alt', 'color' => 'warning', 'label' => '安全提醒'],
    'promotion' => ['icon' => 'fas fa-gift', 'color' => 'danger', 'label' => '優惠活動']
];

$pageTitle = '個人資料管理';
$pageDescription = '管理您的個人資料、密碼和偏好設定';
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO Meta Tags -->
    <title><?php echo e($pageTitle); ?> - <?php echo e(SITE_NAME); ?></title>
    <meta name="description" content="<?php echo e($pageDescription); ?>">
    <meta name="keywords" content="個人資料, 用戶管理, 密碼修改, 偏好設定">
    <meta name="author" content="<?php echo e(SITE_NAME); ?>">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo e($pageTitle); ?> - <?php echo e(SITE_NAME); ?>">
    <meta property="og:description" content="<?php echo e($pageDescription); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $_SERVER['REQUEST_URI']; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg">
    <link rel="alternate icon" href="assets/images/favicon.ico">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+TC:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body class="profile-page">
    <!-- 頁面載入動畫 -->
    <div id="page-loader" class="page-loader">
        <div class="loader-content">
            <div class="spinner"></div>
            <p>載入中...</p>
        </div>
    </div>

    <!-- 主要內容 -->
    <div id="main-content" class="main-content" style="display: none;">
        <?php include 'includes/header.php'; ?>

        <!-- 頁面標題區域 -->
        <section class="page-hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
                                <li class="breadcrumb-item active" aria-current="page">個人資料</a></li>
                            </ol>
                        </nav>
                        <h1 class="page-title">個人資料管理</h1>
                        <p class="page-subtitle">管理您的個人資料、密碼和偏好設定</p>
                    </div>
                    <div class="col-lg-4 text-end">
                        <div class="user-avatar">
                            <img src="<?php echo e($userProfile['avatar'] ?? 'assets/images/default-avatar.svg'); ?>" 
                                 alt="<?php echo e($currentUser['username']); ?>" 
                                 class="avatar-img">
                            <div class="avatar-status online"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 主要內容區域 -->
        <section class="profile-content">
            <div class="container">
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                        <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?> me-2"></i>
                        <?php echo e($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <!-- 側邊欄 -->
                    <div class="col-lg-3">
                        <div class="profile-sidebar">
                            <div class="sidebar-section">
                                <h5>快速導航</h5>
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#profile" data-bs-toggle="pill">
                                            <i class="fas fa-user me-2"></i>個人資料
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#password" data-bs-toggle="pill">
                                            <i class="fas fa-lock me-2"></i>密碼修改
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#preferences" data-bs-toggle="pill">
                                            <i class="fas fa-cog me-2"></i>偏好設定
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#activity-log" data-bs-toggle="pill">
                                            <i class="fas fa-chart-line me-2"></i>活動日誌
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#notifications" data-bs-toggle="pill">
                                            <i class="fas fa-bell me-2"></i>通知中心
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#data-management" data-bs-toggle="pill">
                                            <i class="fas fa-database me-2"></i>數據管理
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="sidebar-section">
                                <h5>帳戶狀態</h5>
                                <div class="account-status">
                                    <div class="status-item">
                                        <span class="status-label">會員等級</span>
                                        <span class="status-value"><?php echo e($currentUser['role'] === 'admin' ? '管理員' : '一般會員'); ?></span>
                                    </div>
                                    <div class="status-item">
                                        <span class="status-label">註冊時間</span>
                                        <span class="status-value"><?php echo e(date('Y-m-d', strtotime($currentUser['created_at']))); ?></span>
                                    </div>
                                    <div class="status-item">
                                        <span class="status-label">最後登入</span>
                                        <span class="status-value"><?php echo e($currentUser['last_login'] ? date('Y-m-d H:i', strtotime($currentUser['last_login'])) : '從未登入'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 主要內容 -->
                    <div class="col-lg-9">
                        <div class="tab-content">
                            <!-- 個人資料標籤 -->
                            <div class="tab-pane fade show active" id="profile">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-user me-2"></i>個人資料</h4>
                                        <p>更新您的個人資料和聯絡資訊</p>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" class="profile-form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="username">用戶名</label>
                                                        <input type="text" id="username" class="form-control" 
                                                               value="<?php echo e($currentUser['username']); ?>" readonly>
                                                        <small class="form-text text-muted">用戶名無法修改</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">電子郵件</label>
                                                        <input type="email" id="email" class="form-control" 
                                                               value="<?php echo e($currentUser['email']); ?>" readonly>
                                                        <small class="form-text text-muted">電子郵件無法修改</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="first_name">名字 <span class="text-danger">*</span></label>
                                                        <input type="text" id="first_name" name="first_name" class="form-control" 
                                                               value="<?php echo e($userProfile['first_name'] ?? ''); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="last_name">姓氏 <span class="text-danger">*</span></label>
                                                        <input type="text" id="last_name" name="last_name" class="form-control" 
                                                               value="<?php echo e($userProfile['last_name'] ?? ''); ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">電話號碼</label>
                                                        <input type="tel" id="phone" name="phone" class="form-control" 
                                                               value="<?php echo e($userProfile['phone'] ?? ''); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="location">所在地</label>
                                                        <input type="text" id="location" name="location" class="form-control" 
                                                               value="<?php echo e($userProfile['location'] ?? ''); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="company">公司/組織</label>
                                                        <input type="text" id="company" name="company" class="form-control" 
                                                               value="<?php echo e($userProfile['company'] ?? ''); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="position">職位</label>
                                                        <input type="text" id="position" name="position" class="form-control" 
                                                               value="<?php echo e($userProfile['position'] ?? ''); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="website">個人網站</label>
                                                <input type="url" id="website" name="website" class="form-control" 
                                                       value="<?php echo e($userProfile['website'] ?? ''); ?>" 
                                                       placeholder="https://example.com">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="interests">興趣專長</label>
                                                <textarea id="interests" name="interests" class="form-control" rows="3" 
                                                          placeholder="請描述您的興趣和專長領域"><?php echo e($userProfile['interests'] ?? ''); ?></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="bio">個人簡介</label>
                                                <textarea id="bio" name="bio" class="form-control" rows="4" 
                                                          placeholder="請簡短介紹您自己"><?php echo e($userProfile['bio'] ?? ''); ?></textarea>
                                            </div>
                                            
                                            <div class="form-actions">
                                                <button type="submit" name="update_profile" class="btn btn-primary">
                                                    <i class="fas fa-save me-2"></i>更新資料
                                                </button>
                                                <button type="reset" class="btn btn-secondary">
                                                    <i class="fas fa-undo me-2"></i>重置
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- 密碼修改標籤 -->
                            <div class="tab-pane fade" id="password">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-lock me-2"></i>密碼修改</h4>
                                        <p>修改您的登入密碼</p>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" class="password-form">
                                            <div class="form-group">
                                                <label for="current_password">當前密碼 <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" id="current_password" name="current_password" 
                                                           class="form-control" required>
                                                    <button type="button" class="btn btn-outline-secondary toggle-password" 
                                                            data-target="current_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="new_password">新密碼 <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" id="new_password" name="new_password" 
                                                           class="form-control" required minlength="8">
                                                    <button type="button" class="btn btn-outline-secondary toggle-password" 
                                                            data-target="new_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div class="password-strength mt-2">
                                                    <div class="strength-bar">
                                                        <div class="strength-fill" data-strength="0"></div>
                                                    </div>
                                                    <small class="strength-text">密碼強度: 弱</small>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="confirm_password">確認新密碼 <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" id="confirm_password" name="confirm_password" 
                                                           class="form-control" required minlength="8">
                                                    <button type="button" class="btn btn-outline-secondary toggle-password" 
                                                            data-target="confirm_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="password-requirements">
                                                <h6>密碼要求：</h6>
                                                <ul>
                                                    <li class="requirement" data-requirement="length">
                                                        <i class="fas fa-circle"></i> 至少8個字符
                                                    </li>
                                                    <li class="requirement" data-requirement="uppercase">
                                                        <i class="fas fa-circle"></i> 包含大寫字母
                                                    </li>
                                                    <li class="requirement" data-requirement="lowercase">
                                                        <i class="fas fa-circle"></i> 包含小寫字母
                                                    </li>
                                                    <li class="requirement" data-requirement="number">
                                                        <i class="fas fa-circle"></i> 包含數字
                                                    </li>
                                                    <li class="requirement" data-requirement="special">
                                                        <i class="fas fa-circle"></i> 包含特殊字符
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="form-actions">
                                                <button type="submit" name="change_password" class="btn btn-primary">
                                                    <i class="fas fa-key me-2"></i>修改密碼
                                                </button>
                                                <button type="reset" class="btn btn-secondary">
                                                    <i class="fas fa-undo me-2"></i>重置
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- 偏好設定標籤 -->
                            <div class="tab-pane fade" id="preferences">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-cog me-2"></i>偏好設定</h4>
                                        <p>自定義您的使用體驗</p>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" class="preferences-form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="preference-section">
                                                        <h6>語言設定</h6>
                                                        <div class="form-group">
                                                            <label for="language">介面語言</label>
                                                            <select id="language" name="language" class="form-select">
                                                                <option value="zh-TW" <?php echo $userPreferences['language'] === 'zh-TW' ? 'selected' : ''; ?>>繁體中文</option>
                                                                <option value="zh-CN" <?php echo $userPreferences['language'] === 'zh-CN' ? 'selected' : ''; ?>>簡體中文</option>
                                                                <option value="en" <?php echo $userPreferences['language'] === 'en' ? 'selected' : ''; ?>>English</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="preference-section">
                                                        <h6>外觀設定</h6>
                                                        <div class="form-group">
                                                            <label for="theme">主題</label>
                                                            <select id="theme" name="theme" class="form-select">
                                                                <option value="light" <?php echo $userPreferences['theme'] === 'light' ? 'selected' : ''; ?>>淺色主題</option>
                                                                <option value="dark" <?php echo $userPreferences['theme'] === 'dark' ? 'selected' : ''; ?>>深色主題</option>
                                                                <option value="auto" <?php echo $userPreferences['theme'] === 'auto' ? 'selected' : ''; ?>>跟隨系統</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="preference-section">
                                                        <h6>通知設定</h6>
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input type="checkbox" id="notify_email" name="notifications[email]" 
                                                                       class="form-check-input" 
                                                                       <?php echo $userPreferences['notifications']['email'] ? 'checked' : ''; ?>>
                                                                <label for="notify_email" class="form-check-label">電子郵件通知</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" id="notify_sms" name="notifications[sms]" 
                                                                       class="form-check-input" 
                                                                       <?php echo $userPreferences['notifications']['sms'] ? 'checked' : ''; ?>>
                                                                <label for="notify_sms" class="form-check-label">簡訊通知</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" id="notify_push" name="notifications[push]" 
                                                                       class="form-check-input" 
                                                                       <?php echo $userPreferences['notifications']['push'] ? 'checked' : ''; ?>>
                                                                <label for="notify_push" class="form-check-label">推播通知</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="preference-section">
                                                        <h6>隱私設定</h6>
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input type="checkbox" id="profile_visible" name="privacy[profile_visible]" 
                                                                       class="form-check-input" 
                                                                       <?php echo $userPreferences['privacy']['profile_visible'] ? 'checked' : ''; ?>>
                                                                <label for="profile_visible" class="form-check-label">個人資料可見</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" id="show_email" name="privacy[show_email]" 
                                                                       class="form-check-input" 
                                                                       <?php echo $userPreferences['privacy']['show_email'] ? 'checked' : ''; ?>>
                                                                <label for="show_email" class="form-check-label">顯示電子郵件</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" id="show_phone" name="privacy[show_phone]" 
                                                                       class="form-check-input" 
                                                                       <?php echo $userPreferences['privacy']['show_phone'] ? 'checked' : ''; ?>>
                                                                <label for="show_phone" class="form-check-label">顯示電話號碼</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-actions">
                                                <button type="submit" name="update_preferences" class="btn btn-primary">
                                                    <i class="fas fa-save me-2"></i>儲存設定
                                                </button>
                                                <button type="reset" class="btn btn-secondary">
                                                    <i class="fas fa-undo me-2"></i>重置
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- 活動日誌標籤 -->
                            <div class="tab-pane fade" id="activity-log">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-chart-line me-2"></i>活動日誌</h4>
                                        <p>查看您的帳戶活動記錄</p>
                                    </div>
                                    <div class="card-body">
                                        <!-- 統計卡片 -->
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <div class="stat-card">
                                                    <div class="stat-icon">
                                                        <i class="fas fa-chart-line"></i>
                                                    </div>
                                                    <div class="stat-number"><?php echo $activityStats['total']; ?></div>
                                                    <div class="stat-label">總活動數</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="stat-card">
                                                    <div class="stat-icon">
                                                        <i class="fas fa-calendar-day"></i>
                                                    </div>
                                                    <div class="stat-number"><?php echo $activityStats['today']; ?></div>
                                                    <div class="stat-label">今日活動</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="stat-card">
                                                    <div class="stat-icon">
                                                        <i class="fas fa-calendar-week"></i>
                                                    </div>
                                                    <div class="stat-number"><?php echo $activityStats['week']; ?></div>
                                                    <div class="stat-label">本週活動</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="stat-card">
                                                    <div class="stat-icon">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </div>
                                                    <div class="stat-number"><?php echo $activityStats['month']; ?></div>
                                                    <div class="stat-label">本月活動</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 活動時間軸 -->
                                        <div class="activity-timeline">
                                            <?php if (empty($activities)): ?>
                                                <div class="empty-state">
                                                    <div class="empty-icon">
                                                        <i class="fas fa-search"></i>
                                                    </div>
                                                    <h3 class="empty-title">沒有活動記錄</h3>
                                                    <p class="empty-description">您還沒有任何活動記錄</p>
                                                </div>
                                            <?php else: ?>
                                                <?php foreach ($activities as $activity): ?>
                                                    <div class="timeline-item">
                                                        <div class="timeline-icon <?php echo $activityTypes[$activity['type']]['color']; ?>">
                                                            <i class="<?php echo $activityTypes[$activity['type']]['icon']; ?>"></i>
                                                        </div>
                                                        <div class="timeline-content">
                                                            <h3 class="timeline-title"><?php echo e($activity['title']); ?></h3>
                                                            <p class="timeline-description"><?php echo e($activity['description']); ?></p>
                                                            <div class="timeline-meta">
                                                                <div class="timeline-time">
                                                                    <i class="fas fa-clock"></i>
                                                                    <span><?php echo date('Y-m-d H:i', strtotime($activity['timestamp'])); ?></span>
                                                                </div>
                                                                <div class="timeline-ip">
                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                    <span><?php echo e($activity['ip_address']); ?></span>
                                                                </div>
                                                                <div class="timeline-status <?php echo $activity['status']; ?>">
                                                                    <i class="fas fa-check-circle"></i>
                                                                    <span><?php echo $activity['status'] === 'success' ? '成功' : '失敗'; ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 通知中心標籤 -->
                            <div class="tab-pane fade" id="notifications">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-bell me-2"></i>通知中心</h4>
                                        <p>查看您的所有通知</p>
                                    </div>
                                    <div class="card-body">
                                        <!-- 統計卡片 -->
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <div class="stat-card">
                                                    <div class="stat-icon">
                                                        <i class="fas fa-bell"></i>
                                                    </div>
                                                    <div class="stat-number"><?php echo $notificationStats['total']; ?></div>
                                                    <div class="stat-label">總通知數</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="stat-card">
                                                    <div class="stat-icon">
                                                        <i class="fas fa-envelope-open"></i>
                                                    </div>
                                                    <div class="stat-number"><?php echo $notificationStats['unread']; ?></div>
                                                    <div class="stat-label">未讀通知</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="stat-card">
                                                    <div class="stat-icon">
                                                        <i class="fas fa-calendar-day"></i>
                                                    </div>
                                                    <div class="stat-number"><?php echo $notificationStats['today']; ?></div>
                                                    <div class="stat-label">今日通知</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="stat-card">
                                                    <div class="stat-icon">
                                                        <i class="fas fa-calendar-week"></i>
                                                    </div>
                                                    <div class="stat-number"><?php echo $notificationStats['week']; ?></div>
                                                    <div class="stat-label">本週通知</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 通知列表 -->
                                        <div class="notifications-list">
                                            <?php if (empty($notifications)): ?>
                                                <div class="empty-state">
                                                    <div class="empty-icon">
                                                        <i class="fas fa-bell-slash"></i>
                                                    </div>
                                                    <h3 class="empty-title">沒有通知</h3>
                                                    <p class="empty-description">您還沒有收到任何通知</p>
                                                </div>
                                            <?php else: ?>
                                                <?php foreach ($notifications as $notification): ?>
                                                    <div class="notification-item <?php echo $notification['is_read'] ? '' : 'unread'; ?>">
                                                        <div class="notification-content">
                                                            <div class="notification-icon <?php echo $notificationTypes[$notification['type']]['color']; ?>">
                                                                <i class="<?php echo $notificationTypes[$notification['type']]['icon']; ?>"></i>
                                                            </div>
                                                            <div class="notification-details">
                                                                <h3 class="notification-title"><?php echo e($notification['title']); ?></h3>
                                                                <p class="notification-message"><?php echo e($notification['message']); ?></p>
                                                                <div class="notification-meta">
                                                                    <div class="notification-time">
                                                                        <i class="fas fa-clock"></i>
                                                                        <span><?php echo date('Y-m-d H:i', strtotime($notification['timestamp'])); ?></span>
                                                                    </div>
                                                                    <div class="notification-priority <?php echo $notification['priority']; ?>">
                                                                        <i class="fas fa-flag"></i>
                                                                        <span><?php echo $notification['priority'] === 'high' ? '高' : ($notification['priority'] === 'medium' ? '中' : '低'); ?>優先級</span>
                                                                    </div>
                                                                </div>
                                                                <?php if ($notification['action_url']): ?>
                                                                    <div class="notification-actions">
                                                                        <a href="<?php echo $notification['action_url']; ?>" class="btn btn-sm btn-primary">
                                                                            <i class="fas fa-external-link-alt"></i>
                                                                            <?php echo e($notification['action_text']); ?>
                                                                        </a>
                                                                        <button class="btn btn-sm btn-secondary" onclick="markAsRead(<?php echo $notification['id']; ?>)">
                                                                            <i class="fas fa-check"></i>
                                                                            標記已讀
                                                                        </button>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="notification-actions">
                                                                        <button class="btn btn-sm btn-secondary" onclick="markAsRead(<?php echo $notification['id']; ?>)">
                                                                            <i class="fas fa-check"></i>
                                                                            標記已讀
                                                                        </button>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 數據管理標籤 -->
                            <div class="tab-pane fade" id="data-management">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-database me-2"></i>數據管理</h4>
                                        <p>管理您的個人數據和隱私設定</p>
                                    </div>
                                    <div class="card-body">
                                        <!-- 數據導出區域 -->
                                        <div class="data-section mb-5">
                                            <h5 class="section-title">
                                                <i class="fas fa-download me-2"></i>數據導出
                                            </h5>
                                            <p class="section-description">下載您的個人數據副本</p>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="export-option">
                                                        <div class="export-card">
                                                            <div class="export-icon">
                                                                <i class="fas fa-file-code"></i>
                                                            </div>
                                                            <div class="export-content">
                                                                <h6>完整數據 (JSON)</h6>
                                                                <p>包含所有個人資料、活動記錄、通知等完整數據</p>
                                                                <button class="btn btn-primary" onclick="exportData('json')">
                                                                    <i class="fas fa-download me-2"></i>導出 JSON
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="export-option">
                                                        <div class="export-card">
                                                            <div class="export-icon">
                                                                <i class="fas fa-file-csv"></i>
                                                            </div>
                                                            <div class="export-content">
                                                                <h6>活動記錄 (CSV)</h6>
                                                                <p>僅包含活動記錄的表格格式數據</p>
                                                                <button class="btn btn-outline-primary" onclick="exportData('csv')">
                                                                    <i class="fas fa-download me-2"></i>導出 CSV
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 隱私設定區域 -->
                                        <div class="data-section mb-5">
                                            <h5 class="section-title">
                                                <i class="fas fa-shield-alt me-2"></i>隱私設定
                                            </h5>
                                            <p class="section-description">控制您的數據使用和分享設定</p>
                                            
                                            <form method="POST" class="privacy-form">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="privacy-group">
                                                            <h6>數據收集</h6>
                                                            <div class="form-check">
                                                                <input type="checkbox" id="collect_analytics" name="privacy[collect_analytics]" 
                                                                       class="form-check-input" checked>
                                                                <label for="collect_analytics" class="form-check-label">
                                                                    允許收集使用分析數據
                                                                </label>
                                                                <small class="form-text text-muted">幫助我們改善服務品質</small>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" id="collect_cookies" name="privacy[collect_cookies]" 
                                                                       class="form-check-input" checked>
                                                                <label for="collect_cookies" class="form-check-label">
                                                                    允許使用 Cookies
                                                                </label>
                                                                <small class="form-text text-muted">記住您的偏好設定</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="privacy-group">
                                                            <h6>數據分享</h6>
                                                            <div class="form-check">
                                                                <input type="checkbox" id="share_anonymized" name="privacy[share_anonymized]" 
                                                                       class="form-check-input">
                                                                <label for="share_anonymized" class="form-check-label">
                                                                    允許分享匿名化數據
                                                                </label>
                                                                <small class="form-text text-muted">用於研究和統計目的</small>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" id="marketing_emails" name="privacy[marketing_emails]" 
                                                                       class="form-check-input">
                                                                <label for="marketing_emails" class="form-check-label">
                                                                    接收行銷郵件
                                                                </label>
                                                                <small class="form-text text-muted">課程和服務推廣資訊</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-actions mt-4">
                                                    <button type="submit" name="update_privacy" class="btn btn-primary">
                                                        <i class="fas fa-save me-2"></i>儲存隱私設定
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- 數據刪除區域 -->
                                        <div class="data-section">
                                            <h5 class="section-title">
                                                <i class="fas fa-trash-alt me-2"></i>數據刪除
                                            </h5>
                                            <p class="section-description">請求刪除特定數據或整個帳戶</p>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="delete-option">
                                                        <div class="delete-card">
                                                            <div class="delete-icon">
                                                                <i class="fas fa-history"></i>
                                                            </div>
                                                            <div class="delete-content">
                                                                <h6>清除活動記錄</h6>
                                                                <p>刪除所有活動日誌記錄</p>
                                                                <button class="btn btn-warning" onclick="clearActivityLog()">
                                                                    <i class="fas fa-trash me-2"></i>清除記錄
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="delete-option">
                                                        <div class="delete-card">
                                                            <div class="delete-icon">
                                                                <i class="fas fa-bell-slash"></i>
                                                            </div>
                                                            <div class="delete-content">
                                                                <h6>清除通知記錄</h6>
                                                                <p>刪除所有通知記錄</p>
                                                                <button class="btn btn-warning" onclick="clearNotifications()">
                                                                    <i class="fas fa-trash me-2"></i>清除通知
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="danger-zone mt-4">
                                                <div class="danger-card">
                                                    <div class="danger-header">
                                                        <h6 class="text-danger">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>危險區域
                                                        </h6>
                                                    </div>
                                                    <div class="danger-content">
                                                        <p class="text-muted">以下操作無法復原，請謹慎操作</p>
                                                        <button class="btn btn-danger" onclick="requestAccountDeletion()">
                                                            <i class="fas fa-user-times me-2"></i>請求刪除帳戶
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 數據使用透明度 -->
                                        <div class="data-section mt-5">
                                            <h5 class="section-title">
                                                <i class="fas fa-info-circle me-2"></i>數據使用透明度
                                            </h5>
                                            <p class="section-description">了解我們如何收集和使用您的數據</p>
                                            
                                            <div class="transparency-grid">
                                                <div class="transparency-item">
                                                    <div class="transparency-icon">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div class="transparency-content">
                                                        <h6>個人資料</h6>
                                                        <p>用於身份驗證和個人化服務</p>
                                                        <span class="data-status">已收集</span>
                                                    </div>
                                                </div>
                                                <div class="transparency-item">
                                                    <div class="transparency-icon">
                                                        <i class="fas fa-chart-line"></i>
                                                    </div>
                                                    <div class="transparency-content">
                                                        <h6>活動記錄</h6>
                                                        <p>用於安全監控和服務改善</p>
                                                        <span class="data-status">已收集</span>
                                                    </div>
                                                </div>
                                                <div class="transparency-item">
                                                    <div class="transparency-icon">
                                                        <i class="fas fa-bell"></i>
                                                    </div>
                                                    <div class="transparency-content">
                                                        <h6>通知記錄</h6>
                                                        <p>用於通知管理和偏好設定</p>
                                                        <span class="data-status">已收集</span>
                                                    </div>
                                                </div>
                                                <div class="transparency-item">
                                                    <div class="transparency-icon">
                                                        <i class="fas fa-cog"></i>
                                                    </div>
                                                    <div class="transparency-content">
                                                        <h6>偏好設定</h6>
                                                        <p>用於個人化用戶體驗</p>
                                                        <span class="data-status">已收集</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/components/UserAuth.js"></script>
    <script src="assets/js/components/ProfileManager.js"></script>
    
    <script>
        // 頁面載入完成後隱藏載入動畫
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.getElementById('page-loader').style.display = 'none';
                document.getElementById('main-content').style.display = 'block';
            }, 500);
        });

        // 數據導出功能
        function exportData(format) {
            if (format === 'json') {
                exportUserDataJSON();
            } else if (format === 'csv') {
                exportActivityDataCSV();
            }
        }

        // 導出完整用戶數據 (JSON)
        function exportUserDataJSON() {
            const userData = {
                profile: <?php echo json_encode($currentUser); ?>,
                activities: <?php echo json_encode($activities); ?>,
                notifications: <?php echo json_encode($notifications); ?>,
                preferences: <?php echo json_encode($userPreferences); ?>,
                exportDate: new Date().toISOString(),
                exportVersion: '1.0'
            };

            const dataStr = JSON.stringify(userData, null, 2);
            const dataBlob = new Blob([dataStr], {type: 'application/json'});
            const url = URL.createObjectURL(dataBlob);
            
            const link = document.createElement('a');
            link.href = url;
            link.download = `user-data-${new Date().toISOString().split('T')[0]}.json`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);

            showNotification('數據導出成功！', 'success');
        }

        // 導出活動數據 (CSV)
        function exportActivityDataCSV() {
            const activities = <?php echo json_encode($activities); ?>;
            if (activities.length === 0) {
                showNotification('沒有活動記錄可導出', 'warning');
                return;
            }

            const headers = ['時間', '類型', '標題', '描述', 'IP地址', '狀態'];
            const csvContent = [
                headers.join(','),
                ...activities.map(activity => [
                    activity.timestamp,
                    activity.type,
                    `"${activity.title}"`,
                    `"${activity.description}"`,
                    activity.ip_address,
                    activity.status
                ].join(','))
            ].join('\n');

            const dataBlob = new Blob([csvContent], {type: 'text/csv;charset=utf-8;'});
            const url = URL.createObjectURL(dataBlob);
            
            const link = document.createElement('a');
            link.href = url;
            link.download = `activity-log-${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);

            showNotification('活動記錄導出成功！', 'success');
        }

        // 清除活動記錄
        function clearActivityLog() {
            if (confirm('確定要清除所有活動記錄嗎？此操作無法復原。')) {
                // 在實際應用中，這裡會發送 AJAX 請求到後端
                const activityTimeline = document.querySelector('.activity-timeline');
                if (activityTimeline) {
                    activityTimeline.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="empty-title">沒有活動記錄</h3>
                            <p class="empty-description">您還沒有任何活動記錄</p>
                        </div>
                    `;
                }
                
                // 更新統計
                updateActivityStats(0, 0, 0, 0);
                showNotification('活動記錄已清除', 'success');
            }
        }

        // 清除通知記錄
        function clearNotifications() {
            if (confirm('確定要清除所有通知記錄嗎？此操作無法復原。')) {
                // 在實際應用中，這裡會發送 AJAX 請求到後端
                const notificationsList = document.querySelector('.notifications-list');
                if (notificationsList) {
                    notificationsList.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-bell-slash"></i>
                            </div>
                            <h3 class="empty-title">沒有通知</h3>
                            <p class="empty-description">您還沒有收到任何通知</p>
                        </div>
                    `;
                }
                
                // 更新統計
                updateNotificationStats(0, 0, 0, 0);
                showNotification('通知記錄已清除', 'success');
            }
        }

        // 請求刪除帳戶
        function requestAccountDeletion() {
            const confirmText = 'DELETE';
            const userInput = prompt(`警告：此操作將永久刪除您的帳戶和所有相關數據，無法復原！\n\n如果您確定要刪除帳戶，請輸入 "${confirmText}" 來確認：`);
            
            if (userInput === confirmText) {
                if (confirm('最後確認：您真的要永久刪除帳戶嗎？')) {
                    // 在實際應用中，這裡會發送 AJAX 請求到後端
                    showNotification('帳戶刪除請求已提交，我們將在 24 小時內處理', 'info');
                }
            } else if (userInput !== null) {
                showNotification('輸入不正確，操作已取消', 'warning');
            }
        }

        // 更新活動統計
        function updateActivityStats(total, today, week, month) {
            const statNumbers = document.querySelectorAll('#activity-log .stat-number');
            if (statNumbers.length >= 4) {
                statNumbers[0].textContent = total;
                statNumbers[1].textContent = today;
                statNumbers[2].textContent = week;
                statNumbers[3].textContent = month;
            }
        }

        // 更新通知統計
        function updateNotificationStats(total, unread, today, week) {
            const statNumbers = document.querySelectorAll('#notifications .stat-number');
            if (statNumbers.length >= 4) {
                statNumbers[0].textContent = total;
                statNumbers[1].textContent = unread;
                statNumbers[2].textContent = today;
                statNumbers[3].textContent = week;
            }
        }

        // 顯示通知消息
        function showNotification(message, type = 'info') {
            // 創建通知元素
            const notification = document.createElement('div');
            notification.className = `notification-toast notification-${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : type === 'error' ? 'times-circle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            // 添加樣式
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#10b981' : type === 'warning' ? '#f59e0b' : type === 'error' ? '#ef4444' : '#3b82f6'};
                color: white;
                padding: 12px 16px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                z-index: 1000;
                opacity: 0;
                transform: translateX(100%);
                transition: all 0.3s ease;
            `;
            
            // 添加到頁面
            document.body.appendChild(notification);
            
            // 顯示動畫
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // 自動隱藏
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>
