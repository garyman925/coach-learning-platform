<?php
/**
 * 管理員後台 - 系統設定
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/user-management.php';

// 檢查管理員權限
if (!$isAdmin) {
    http_response_code(403);
    exit('無權限訪問管理員後台');
}

// 處理設定更新
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_general':
                $result = updateGeneralSettings($_POST);
                if ($result['success']) {
                    $message = '基本設定更新成功';
                    $messageType = 'success';
                } else {
                    $message = $result['message'];
                    $messageType = 'error';
                }
                break;
                
            case 'clear_cache':
                $result = clearSystemCache();
                if ($result['success']) {
                    $message = '系統快取清除成功';
                    $messageType = 'success';
                } else {
                    $message = $result['message'];
                    $messageType = 'error';
                }
                break;
        }
    }
}

// 獲取當前設定
$settings = getCurrentSettings();

// 設置頁面特定變數
$pageTitle = '系統設定 - ' . SITE_NAME;
$pageDescription = '管理員後台系統設定';
$pageKeywords = '系統設定,管理員,後台';

// 模擬設定數據
function getCurrentSettings() {
    return [
        'general' => [
            'site_name' => '教練學習平台',
            'site_description' => '專業的教練培訓和服務平台',
            'site_url' => 'http://192.168.1.21/coach-learning-platform-mainpage',
            'admin_email' => 'admin@coach-platform.com',
            'timezone' => 'Asia/Taipei',
            'maintenance_mode' => false
        ]
    ];
}

// 模擬設定更新
function updateGeneralSettings($data) {
    if (empty($data['site_name']) || empty($data['site_url'])) {
        return [
            'success' => false,
            'message' => '網站名稱和網址不能為空'
        ];
    }
    
    return [
        'success' => true,
        'message' => '基本設定更新成功'
    ];
}

function clearSystemCache() {
    return [
        'success' => true,
        'message' => '系統快取清除成功'
    ];
}
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
    
    <style>
        .settings-container {
            padding: 2rem;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .quick-action-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        
        .quick-action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .quick-action-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .quick-action-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        
        .icon-backup {
            background: linear-gradient(135deg, #28a745, #20c997);
        }
        
        .icon-cache {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
        }
        
        .icon-logs {
            background: linear-gradient(135deg, #6f42c1, #e83e8c);
        }
        
        .icon-maintenance {
            background: linear-gradient(135deg, #dc3545, #fd7e14);
        }
        
        .quick-action-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }
        
        .quick-action-description {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin: 0 0 1rem 0;
            line-height: 1.4;
        }
        
        .settings-form {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            max-width: 800px;
        }
        
        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: var(--light-bg);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }
        
        .form-section h3 {
            margin: 0 0 1rem 0;
            color: var(--text-primary);
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .form-section h3 i {
            color: var(--primary-color);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }
        
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .form-group .help-text {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin: 0;
        }
        
        .checkbox-group label {
            margin: 0;
            cursor: pointer;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }
        
        .message {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .message.success {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
            border: 1px solid rgba(25, 135, 84, 0.3);
        }
        
        .message.error {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        
        .system-info {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }
        
        .system-info h3 {
            margin: 0 0 1rem 0;
            color: var(--text-primary);
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .info-item {
            padding: 1rem;
            background: var(--light-bg);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }
        
        .info-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .info-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                grid-template-columns: 1fr;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
                    <a href="/admin" class="btn btn-outline btn-sm">返回儀表板</a>
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
                    <li class="admin-nav-item">
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
                    <li class="admin-nav-item active">
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
            <div class="settings-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">系統設定</h1>
                </div>
                
                <!-- Message Display -->
                <?php if ($message): ?>
                    <div class="message <?php echo $messageType; ?>">
                        <?php echo e($message); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Quick Actions -->
                <div class="quick-actions">
                    <div class="quick-action-card">
                        <div class="quick-action-header">
                            <div class="quick-action-icon icon-backup">
                                <i class="fas fa-database"></i>
                            </div>
                            <h3 class="quick-action-title">系統備份</h3>
                        </div>
                        <p class="quick-action-description">創建系統數據和文件的完整備份</p>
                        <button class="btn btn-primary btn-sm" onclick="createBackup()">
                            <i class="fas fa-download"></i>
                            創建備份
                        </button>
                    </div>
                    
                    <div class="quick-action-card">
                        <div class="quick-action-header">
                            <div class="quick-action-icon icon-cache">
                                <i class="fas fa-broom"></i>
                            </div>
                            <h3 class="quick-action-title">清除快取</h3>
                        </div>
                        <p class="quick-action-description">清除系統快取以提升性能</p>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="clear_cache">
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-trash"></i>
                                清除快取
                            </button>
                        </form>
                    </div>
                    
                    <div class="quick-action-card">
                        <div class="quick-action-header">
                            <div class="quick-action-icon icon-logs">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h3 class="quick-action-title">系統日誌</h3>
                        </div>
                        <p class="quick-action-description">查看系統運行日誌和錯誤記錄</p>
                        <button class="btn btn-info btn-sm" onclick="viewLogs()">
                            <i class="fas fa-eye"></i>
                            查看日誌
                        </button>
                    </div>
                    
                    <div class="quick-action-card">
                        <div class="quick-action-header">
                            <div class="quick-action-icon icon-maintenance">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h3 class="quick-action-title">維護模式</h3>
                        </div>
                        <p class="quick-action-description">啟用維護模式以進行系統維護</p>
                        <button class="btn btn-danger btn-sm" onclick="toggleMaintenance()">
                            <i class="fas fa-toggle-on"></i>
                            切換模式
                        </button>
                    </div>
                </div>
                
                <!-- System Information -->
                <div class="system-info">
                    <h3><i class="fas fa-info-circle"></i> 系統信息</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">PHP 版本</div>
                            <div class="info-value"><?php echo PHP_VERSION; ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">伺服器軟體</div>
                            <div class="info-value"><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">資料庫狀態</div>
                            <div class="info-value">模擬模式</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">最後備份</div>
                            <div class="info-value">2024-01-30 15:30</div>
                        </div>
                    </div>
                </div>
                
                <!-- Settings Form -->
                <div class="settings-form">
                    <form method="POST">
                        <input type="hidden" name="action" value="update_general">
                        
                        <div class="form-section">
                            <h3><i class="fas fa-globe"></i> 網站基本設定</h3>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="site_name">網站名稱</label>
                                    <input type="text" id="site_name" name="site_name" value="<?php echo e($settings['general']['site_name']); ?>" required>
                                    <div class="help-text">顯示在瀏覽器標題和頁面中的網站名稱</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="site_url">網站網址</label>
                                    <input type="url" id="site_url" name="site_url" value="<?php echo e($settings['general']['site_url']); ?>" required>
                                    <div class="help-text">網站的完整網址，包含 http:// 或 https://</div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="site_description">網站描述</label>
                                <textarea id="site_description" name="site_description"><?php echo e($settings['general']['site_description']); ?></textarea>
                                <div class="help-text">網站的簡要描述，用於SEO和社交媒體分享</div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="admin_email">管理員郵箱</label>
                                    <input type="email" id="admin_email" name="admin_email" value="<?php echo e($settings['general']['admin_email']); ?>" required>
                                    <div class="help-text">系統通知和管理員聯繫郵箱</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="timezone">時區設定</label>
                                    <select id="timezone" name="timezone">
                                        <option value="Asia/Taipei" <?php echo $settings['general']['timezone'] === 'Asia/Taipei' ? 'selected' : ''; ?>>台北 (UTC+8)</option>
                                        <option value="Asia/Shanghai" <?php echo $settings['general']['timezone'] === 'Asia/Shanghai' ? 'selected' : ''; ?>>上海 (UTC+8)</option>
                                        <option value="Asia/Hong_Kong" <?php echo $settings['general']['timezone'] === 'Asia/Hong_Kong' ? 'selected' : ''; ?>>香港 (UTC+8)</option>
                                        <option value="UTC" <?php echo $settings['general']['timezone'] === 'UTC' ? 'selected' : ''; ?>>UTC (UTC+0)</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="checkbox-group">
                                <input type="checkbox" id="maintenance_mode" name="maintenance_mode" <?php echo $settings['general']['maintenance_mode'] ? 'checked' : ''; ?>>
                                <label for="maintenance_mode">啟用維護模式</label>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                保存設定
                            </button>
                            <button type="reset" class="btn btn-outline">
                                <i class="fas fa-undo"></i>
                                重置
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    
    <!-- JavaScript Files -->
    <script src="/coach-learning-platform-mainpage/assets/js/utils/helpers.js"></script>
    <script src="/coach-learning-platform-mainpage/assets/js/components/ScrollAnimator.js"></script>
    <script src="/coach-learning-platform-mainpage/assets/js/admin/admin.js"></script>
    
    <script>
        // 快速操作功能
        function createBackup() {
            if (confirm('確定要創建系統備份嗎？這可能需要一些時間。')) {
                alert('備份功能開發中...');
            }
        }
        
        function viewLogs() {
            alert('日誌查看功能開發中...');
        }
        
        function toggleMaintenance() {
            if (confirm('確定要切換維護模式嗎？')) {
                alert('維護模式切換功能開發中...');
            }
        }
        
        // 初始化頁面
        document.addEventListener('DOMContentLoaded', function() {
            // 初始化滾動動畫
            if (typeof ScrollAnimator !== 'undefined') {
                new ScrollAnimator();
            }
            
            // 自動隱藏消息
            const messages = document.querySelectorAll('.message');
            messages.forEach(message => {
                setTimeout(() => {
                    message.style.opacity = '0';
                    setTimeout(() => message.remove(), 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>
