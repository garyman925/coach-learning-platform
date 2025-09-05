<?php
/**
 * 管理員後台 - 主頁面
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/user-management.php';

// 檢查管理員權限
if (!$isAdmin) {
    http_response_code(403);
    exit('無權限訪問管理員後台');
}

// 設置頁面特定變數
$pageTitle = '管理員後台 - ' . SITE_NAME;
$pageDescription = '教練學習平台管理員後台';
$pageKeywords = '管理員,後台,用戶管理,內容管理';
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title><?php echo e($pageTitle); ?></title>
    <meta name="description" content="<?php echo e($pageDescription); ?>">
    <meta name="keywords" content="<?php echo e($pageKeywords); ?>">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="/coach-learning-platform-mainpage/assets/css/utilities/variables.css">
    <link rel="stylesheet" href="/coach-learning-platform-mainpage/assets/css/utilities/helpers.css">
    <link rel="stylesheet" href="/coach-learning-platform-mainpage/assets/css/components/buttons.css">
    <link rel="stylesheet" href="/coach-learning-platform-mainpage/assets/css/components/forms.css">
    <link rel="stylesheet" href="/coach-learning-platform-mainpage/assets/css/admin/admin.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+TC:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-body">
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="admin-header-content">
            <div class="admin-logo">
                <img src="/coach-learning-platform-mainpage/assets/images/logos/logo-main.svg" alt="<?php echo SITE_NAME; ?>" width="150" height="45">
                <span class="admin-title">管理員後台</span>
            </div>
            
            <div class="admin-user-menu">
                <div class="admin-user-info">
                    <span class="admin-username"><?php echo e($currentUser['username']); ?></span>
                    <span class="admin-role"><?php echo e(ucfirst($currentUser['role'])); ?></span>
                </div>
                <div class="admin-actions">
                    <a href="/" class="btn btn-outline btn-sm">返回前台</a>
                    <a href="/admin/logout" class="btn btn-outline btn-sm">登出</a>
                </div>
            </div>
        </div>
    </header>
    
    <div class="admin-container">
        <!-- Admin Sidebar -->
        <aside class="admin-sidebar">
            <nav class="admin-nav">
                <ul class="admin-nav-list">
                    <li class="admin-nav-item active">
                        <a href="/admin" class="admin-nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>儀表板</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="/admin/users" class="admin-nav-link">
                            <i class="fas fa-users"></i>
                            <span>用戶管理</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="/admin/courses" class="admin-nav-link">
                            <i class="fas fa-graduation-cap"></i>
                            <span>課程管理</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="/admin/services" class="admin-nav-link">
                            <i class="fas fa-cogs"></i>
                            <span>服務管理</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="/admin/content" class="admin-nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>內容管理</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="/admin/settings" class="admin-nav-link">
                            <i class="fas fa-cog"></i>
                            <span>系統設定</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- Admin Main Content -->
        <main class="admin-main">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1 class="dashboard-title">儀表板</h1>
                <p class="dashboard-subtitle">歡迎回來，<?php echo e($currentUser['username']); ?>！</p>
            </div>
            
            <!-- Dashboard Stats -->
            <div class="dashboard-stats">
                <div class="stat-card" data-animate="fadeInUp">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">156</h3>
                        <p class="stat-label">總用戶數</p>
                    </div>
                </div>
                
                <div class="stat-card" data-animate="fadeInUp" data-delay="200">
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">24</h3>
                        <p class="stat-label">活躍課程</p>
                    </div>
                </div>
                
                <div class="stat-card" data-animate="fadeInUp" data-delay="400">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">89%</h3>
                        <p class="stat-label">完成率</p>
                    </div>
                </div>
                
                <div class="stat-card" data-animate="fadeInUp" data-delay="600">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">4.8</h3>
                        <p class="stat-label">平均評分</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="quick-actions">
                <h2 class="section-title">快速操作</h2>
                <div class="action-grid">
                    <a href="/admin/users/create" class="action-card" data-animate="fadeInUp">
                        <div class="action-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h3>新增用戶</h3>
                        <p>創建新的用戶帳戶</p>
                    </a>
                    
                    <a href="/admin/courses/create" class="action-card" data-animate="fadeInUp" data-delay="200">
                        <div class="action-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <h3>新增課程</h3>
                        <p>創建新的培訓課程</p>
                    </a>
                    
                    <a href="/admin/content/news" class="action-card" data-animate="fadeInUp" data-delay="400">
                        <div class="action-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h3>發布新聞</h3>
                        <p>發布最新消息和公告</p>
                    </a>
                    
                    <a href="/admin/settings/backup" class="action-card" data-animate="fadeInUp" data-delay="600">
                        <div class="action-icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <h3>系統備份</h3>
                        <p>備份系統數據和設定</p>
                    </a>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="recent-activity">
                <h2 class="section-title">最近活動</h2>
                <div class="activity-list">
                    <div class="activity-item" data-animate="fadeInUp">
                        <div class="activity-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <h4>新用戶註冊</h4>
                            <p>用戶 "john_doe" 完成了註冊</p>
                            <span class="activity-time">2 小時前</span>
                        </div>
                    </div>
                    
                    <div class="activity-item" data-animate="fadeInUp" data-delay="200">
                        <div class="activity-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="activity-content">
                            <h4>課程更新</h4>
                            <p>課程 "專業教練培訓" 已更新</p>
                            <span class="activity-time">4 小時前</span>
                        </div>
                    </div>
                    
                    <div class="activity-item" data-animate="fadeInUp" data-delay="400">
                        <div class="activity-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="activity-content">
                            <h4>新聯絡訊息</h4>
                            <p>收到來自 "sarah@example.com" 的諮詢</p>
                            <span class="activity-time">6 小時前</span>
                        </div>
                    </div>
                    
                    <div class="activity-item" data-animate="fadeInUp" data-delay="600">
                        <div class="activity-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="activity-content">
                            <h4>新評價</h4>
                            <p>課程 "團隊教練課程" 收到 5 星評價</p>
                            <span class="activity-time">1 天前</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- JavaScript Files -->
    <script src="/coach-learning-platform-mainpage/assets/js/utils/helpers.js"></script>
    <script src="/coach-learning-platform-mainpage/assets/js/components/ScrollAnimator.js"></script>
    <script src="/coach-learning-platform-mainpage/assets/js/admin/admin.js"></script>
</body>
</html>
