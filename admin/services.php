<?php
/**
 * 管理員後台 - 服務管理
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/user-management.php';

// 檢查管理員權限
if (!$isAdmin) {
    http_response_code(403);
    exit('無權限訪問管理員後台');
}

// 處理服務操作
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete_service':
                $serviceId = (int)$_POST['service_id'];
                $result = deleteService($serviceId);
                if ($result['success']) {
                    $message = '服務刪除成功';
                    $messageType = 'success';
                } else {
                    $message = $result['message'];
                    $messageType = 'error';
                }
                break;
                
            case 'update_status':
                $serviceId = (int)$_POST['service_id'];
                $status = $_POST['status'];
                $result = updateServiceStatus($serviceId, $status);
                if ($result['success']) {
                    $message = '服務狀態更新成功';
                    $messageType = 'success';
                } else {
                    $message = $result['message'];
                    $messageType = 'error';
                }
                break;
        }
    }
}

// 獲取服務列表
$services = getMockServices();

// 搜索和篩選
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$status = $_GET['status'] ?? '';

// 篩選服務
if ($search || $category || $status) {
    $services = array_filter($services, function($service) use ($search, $category, $status) {
        $matchesSearch = !$search || 
            stripos($service['title'], $search) !== false || 
            stripos($service['description'], $search) !== false;
        $matchesCategory = !$category || $service['category'] === $category;
        $matchesStatus = !$status || $service['status'] === $status;
        
        return $matchesSearch && $matchesCategory && $matchesStatus;
    });
}

// 設置頁面特定變數
$pageTitle = '服務管理 - ' . SITE_NAME;
$pageDescription = '管理員後台服務管理';
$pageKeywords = '服務管理,管理員,後台';

// 模擬服務數據
function getMockServices() {
    return [
        [
            'id' => 1,
            'title' => '個人教練服務',
            'description' => '一對一的專業教練服務，幫助個人實現目標和突破瓶頸',
            'category' => 'personal',
            'duration' => '60分鐘/次',
            'price' => 2000,
            'status' => 'active',
            'bookings' => 156,
            'rating' => 4.9,
            'created_at' => '2024-01-10',
            'coaches' => 8,
            'image' => 'personal-coaching.jpg'
        ],
        [
            'id' => 2,
            'title' => '企業教練服務',
            'description' => '為企業提供團隊建設、領導力發展和組織變革的專業服務',
            'category' => 'enterprise',
            'duration' => '4-8小時/天',
            'price' => 15000,
            'status' => 'active',
            'bookings' => 23,
            'rating' => 4.7,
            'created_at' => '2024-01-15',
            'coaches' => 5,
            'image' => 'enterprise-coaching.jpg'
        ],
        [
            'id' => 3,
            'title' => '團體教練服務',
            'description' => '小團體教練服務，促進團隊協作和共同成長',
            'category' => 'group',
            'duration' => '90分鐘/次',
            'price' => 800,
            'status' => 'active',
            'bookings' => 89,
            'rating' => 4.6,
            'created_at' => '2024-01-20',
            'coaches' => 12,
            'image' => 'group-coaching.jpg'
        ],
        [
            'id' => 4,
            'title' => '線上教練服務',
            'description' => '遠程教練服務，突破地理限制，隨時隨地獲得專業指導',
            'category' => 'online',
            'duration' => '45分鐘/次',
            'price' => 1500,
            'status' => 'draft',
            'bookings' => 0,
            'rating' => 0,
            'created_at' => '2024-02-05',
            'coaches' => 6,
            'image' => 'online-coaching.jpg'
        ],
        [
            'id' => 5,
            'title' => '專項技能教練',
            'description' => '針對特定技能領域的專業教練服務，如溝通、時間管理等',
            'category' => 'specialized',
            'duration' => '75分鐘/次',
            'price' => 2500,
            'status' => 'active',
            'bookings' => 67,
            'rating' => 4.8,
            'created_at' => '2024-01-25',
            'coaches' => 10,
            'image' => 'specialized-coaching.jpg'
        ]
    ];
}

// 模擬服務操作
function deleteService($serviceId) {
    return [
        'success' => true,
        'message' => '服務刪除成功'
    ];
}

function updateServiceStatus($serviceId, $status) {
    $validStatuses = ['active', 'inactive', 'draft'];
    if (!in_array($status, $validStatuses)) {
        return [
            'success' => false,
            'message' => '無效的狀態值'
        ];
    }
    
    return [
        'success' => true,
        'message' => '服務狀態更新成功'
    ];
}

// 服務分類標籤
$categoryLabels = [
    'personal' => '個人教練',
    'enterprise' => '企業教練',
    'group' => '團體教練',
    'online' => '線上教練',
    'specialized' => '專項技能'
];

// 狀態標籤
$statusLabels = [
    'active' => '已發布',
    'inactive' => '已下架',
    'draft' => '草稿'
];
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
        .services-container {
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
        
        .filters-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .filters-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        
        .filter-group label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }
        
        .filter-group select,
        .filter-group input {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .service-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }
        
        .service-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
        }
        
        .service-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            position: relative;
        }
        
        .service-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            pointer-events: none;
        }
        
        .service-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            margin-bottom: 0.75rem;
        }
        
        .service-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.9);
        }
        
        .status-active {
            color: #198754;
        }
        
        .status-inactive {
            color: #6c757d;
        }
        
        .status-draft {
            color: #ffc107;
        }
        
        .service-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0 0 0.5rem 0;
            line-height: 1.3;
        }
        
        .service-description {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.5;
            margin: 0;
        }
        
        .service-content {
            padding: 1.5rem;
        }
        
        .service-meta {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .meta-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 1rem;
            background: var(--light-bg);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }
        
        .meta-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .meta-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .service-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: var(--light-bg);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            display: block;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .service-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
        
        .btn-icon {
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        
        .btn-edit {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-edit:hover {
            background: var(--primary-color-dark);
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c82333;
        }
        
        .btn-view {
            background: var(--accent-color);
            color: white;
        }
        
        .btn-view:hover {
            background: var(--accent-color-dark);
        }
        
        .btn-preview {
            background: var(--secondary-color);
            color: white;
        }
        
        .btn-preview:hover {
            background: var(--secondary-color-dark);
        }
        
        .btn-schedule {
            background: #20c997;
            color: white;
        }
        
        .btn-schedule:hover {
            background: #1ba085;
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
        
        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--text-secondary);
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .empty-state h3 {
            margin: 0 0 0.5rem 0;
            color: var(--text-primary);
        }
        
        .empty-state p {
            margin: 0;
        }
        
        .service-highlight {
            position: relative;
            overflow: hidden;
        }
        
        .service-highlight::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .service-highlight:hover::after {
            left: 100%;
        }
        
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
            
            .filters-form {
                grid-template-columns: 1fr;
            }
            
            .services-grid {
                grid-template-columns: 1fr;
            }
            
            .service-meta {
                grid-template-columns: 1fr;
            }
            
            .service-stats {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            
            .service-actions {
                flex-wrap: wrap;
                gap: 0.25rem;
            }
            
            .btn-icon {
                width: 36px;
                height: 36px;
                font-size: 0.875rem;
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
                    <li class="admin-nav-item active">
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
            <div class="services-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">服務管理</h1>
                    <a href="/admin/services/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        新增服務
                    </a>
                </div>
                
                <!-- Message Display -->
                <?php if ($message): ?>
                    <div class="message <?php echo $messageType; ?>">
                        <?php echo e($message); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Filters Section -->
                <div class="filters-section">
                    <form class="filters-form" method="GET">
                        <div class="filter-group">
                            <label for="search">搜索服務</label>
                            <input type="text" id="search" name="search" placeholder="服務標題或描述..." value="<?php echo e($search); ?>">
                        </div>
                        
                        <div class="filter-group">
                            <label for="category">服務分類</label>
                            <select id="category" name="category">
                                <option value="">所有分類</option>
                                <option value="personal" <?php echo $category === 'personal' ? 'selected' : ''; ?>>個人教練</option>
                                <option value="enterprise" <?php echo $category === 'enterprise' ? 'selected' : ''; ?>>企業教練</option>
                                <option value="group" <?php echo $category === 'group' ? 'selected' : ''; ?>>團體教練</option>
                                <option value="online" <?php echo $category === 'online' ? 'selected' : ''; ?>>線上教練</option>
                                <option value="specialized" <?php echo $category === 'specialized' ? 'selected' : ''; ?>>專項技能</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="status">服務狀態</label>
                            <select id="status" name="status">
                                <option value="">所有狀態</option>
                                <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>已發布</option>
                                <option value="inactive" <?php echo $status === 'inactive' ? 'selected' : ''; ?>>已下架</option>
                                <option value="draft" <?php echo $status === 'draft' ? 'selected' : ''; ?>>草稿</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                篩選
                            </button>
                            <a href="/admin/services" class="btn btn-outline">
                                <i class="fas fa-times"></i>
                                清除
                            </a>
                        </div>
                    </form>
                </div>
                
                <!-- Services Grid -->
                <?php if (empty($services)): ?>
                    <div class="empty-state">
                        <i class="fas fa-cogs"></i>
                        <h3>沒有找到服務</h3>
                        <p>請嘗試調整搜索條件或篩選器</p>
                    </div>
                <?php else: ?>
                    <div class="services-grid">
                        <?php foreach ($services as $service): ?>
                            <div class="service-card service-highlight" data-animate="fadeInUp">
                                <div class="service-header">
                                    <span class="service-category">
                                        <?php echo e($categoryLabels[$service['category']]); ?>
                                    </span>
                                    <span class="service-status status-<?php echo e($service['status']); ?>">
                                        <?php echo e($statusLabels[$service['status']]); ?>
                                    </span>
                                    
                                    <h3 class="service-title"><?php echo e($service['title']); ?></h3>
                                    <p class="service-description"><?php echo e($service['description']); ?></p>
                                </div>
                                
                                <div class="service-content">
                                    <div class="service-meta">
                                        <div class="meta-item">
                                            <span class="meta-label">服務時長</span>
                                            <span class="meta-value"><?php echo e($service['duration']); ?></span>
                                        </div>
                                        <div class="meta-item">
                                            <span class="meta-label">服務價格</span>
                                            <span class="meta-value">NT$ <?php echo number_format($service['price']); ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="service-stats">
                                        <div class="stat-item">
                                            <span class="stat-number"><?php echo e($service['bookings']); ?></span>
                                            <span class="stat-label">預約次數</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-number"><?php echo e($service['rating']); ?></span>
                                            <span class="stat-label">評分</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-number"><?php echo e($service['coaches']); ?></span>
                                            <span class="stat-label">教練人數</span>
                                        </div>
                                    </div>
                                    
                                    <div class="service-actions">
                                        <button class="btn-icon btn-view" title="查看詳情" onclick="viewService(<?php echo $service['id']; ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-icon btn-edit" title="編輯服務" onclick="editService(<?php echo $service['id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon btn-preview" title="預覽服務" onclick="previewService(<?php echo $service['id']; ?>)">
                                            <i class="fas fa-external-link-alt"></i>
                                        </button>
                                        <button class="btn-icon btn-schedule" title="管理預約" onclick="manageSchedule(<?php echo $service['id']; ?>)">
                                            <i class="fas fa-calendar-alt"></i>
                                        </button>
                                        <button class="btn-icon btn-delete" title="刪除服務" onclick="deleteService(<?php echo $service['id']; ?>, '<?php echo e($service['title']); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
    
    <!-- JavaScript Files -->
    <script src="/coach-learning-platform-mainpage/assets/js/utils/helpers.js"></script>
    <script src="/coach-learning-platform-mainpage/assets/js/components/ScrollAnimator.js"></script>
    <script src="/coach-learning-platform-mainpage/assets/js/admin/admin.js"></script>
    
    <script>
        // 服務管理功能
        function viewService(serviceId) {
            // TODO: 實現查看服務詳情
            alert('查看服務詳情功能開發中...');
        }
        
        function editService(serviceId) {
            // TODO: 實現編輯服務
            alert('編輯服務功能開發中...');
        }
        
        function previewService(serviceId) {
            // TODO: 實現預覽服務
            alert('預覽服務功能開發中...');
        }
        
        function manageSchedule(serviceId) {
            // TODO: 實現管理預約
            alert('管理預約功能開發中...');
        }
        
        function deleteService(serviceId, title) {
            if (confirm(`確定要刪除服務 "${title}" 嗎？此操作無法撤銷。`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_service">
                    <input type="hidden" name="service_id" value="${serviceId}">
                `;
                document.body.appendChild(form);
                form.submit();
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
