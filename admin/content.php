<?php
/**
 * 管理員後台 - 內容管理
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/user-management.php';

// 檢查管理員權限
if (!$isAdmin) {
    http_response_code(403);
    exit('無權限訪問管理員後台');
}

// 處理內容操作
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete_content':
                $contentId = (int)$_POST['content_id'];
                $result = deleteContent($contentId);
                if ($result['success']) {
                    $message = '內容刪除成功';
                    $messageType = 'success';
                } else {
                    $message = $result['message'];
                    $messageType = 'error';
                }
                break;
                
            case 'update_status':
                $contentId = (int)$_POST['content_id'];
                $status = $_POST['status'];
                $result = updateContentStatus($contentId, $status);
                if ($result['success']) {
                    $message = '內容狀態更新成功';
                    $messageType = 'success';
                } else {
                    $message = $result['message'];
                    $messageType = 'error';
                }
                break;
        }
    }
}

// 獲取內容列表
$contents = getMockContents();

// 搜索和篩選
$search = $_GET['search'] ?? '';
$type = $_GET['type'] ?? '';
$status = $_GET['status'] ?? '';
$category = $_GET['category'] ?? '';

// 篩選內容
if ($search || $type || $status || $category) {
    $contents = array_filter($contents, function($content) use ($search, $type, $status, $category) {
        $matchesSearch = !$search || 
            stripos($content['title'], $search) !== false || 
            stripos($content['excerpt'], $search) !== false;
        $matchesType = !$type || $content['type'] === $type;
        $matchesStatus = !$status || $content['status'] === $status;
        $matchesCategory = !$category || $content['category'] === $category;
        
        return $matchesSearch && $matchesType && $matchesStatus && $matchesCategory;
    });
}

// 設置頁面特定變數
$pageTitle = '內容管理 - ' . SITE_NAME;
$pageDescription = '管理員後台內容管理';
$pageKeywords = '內容管理,管理員,後台';

// 模擬內容數據
function getMockContents() {
    return [
        [
            'id' => 1,
            'title' => '教練行業發展趨勢分析',
            'excerpt' => '深入分析2024年教練行業的發展趨勢，包括市場需求、技術應用和未來展望...',
            'type' => 'article',
            'category' => 'industry',
            'author' => '張教練',
            'status' => 'published',
            'views' => 1247,
            'likes' => 89,
            'created_at' => '2024-01-15',
            'updated_at' => '2024-01-20',
            'featured' => true,
            'tags' => ['趨勢分析', '行業發展', '市場研究']
        ],
        [
            'id' => 2,
            'title' => '如何成為一名優秀的教練',
            'excerpt' => '分享成為優秀教練的關鍵要素，包括技能培養、心態建設和實戰經驗...',
            'type' => 'article',
            'category' => 'coaching',
            'author' => '李教練',
            'status' => 'published',
            'views' => 2156,
            'likes' => 156,
            'created_at' => '2024-01-10',
            'updated_at' => '2024-01-15',
            'featured' => true,
            'tags' => ['教練技能', '職業發展', '實戰經驗']
        ],
        [
            'id' => 3,
            'title' => '2024年春季教練培訓活動',
            'excerpt' => '春季教練培訓活動即將開始，包含專業技能提升、實戰演練和認證考試...',
            'type' => 'news',
            'category' => 'events',
            'author' => '系統管理員',
            'status' => 'published',
            'views' => 892,
            'likes' => 45,
            'created_at' => '2024-01-25',
            'updated_at' => '2024-01-25',
            'featured' => false,
            'tags' => ['培訓活動', '春季課程', '技能認證']
        ],
        [
            'id' => 4,
            'title' => '九型人格在教練中的應用',
            'excerpt' => '探討九型人格理論在教練實踐中的應用，幫助教練更好地理解客戶需求...',
            'type' => 'article',
            'category' => 'psychology',
            'author' => '王教練',
            'status' => 'draft',
            'views' => 0,
            'likes' => 0,
            'created_at' => '2024-02-01',
            'updated_at' => '2024-02-01',
            'featured' => false,
            'tags' => ['九型人格', '心理學', '教練應用']
        ],
        [
            'id' => 5,
            'title' => '企業教練服務案例分享',
            'excerpt' => '分享成功企業教練案例，展示教練服務在企業發展中的重要作用...',
            'type' => 'case_study',
            'category' => 'enterprise',
            'author' => '陳教練',
            'status' => 'published',
            'views' => 567,
            'likes' => 34,
            'created_at' => '2024-01-20',
            'updated_at' => '2024-01-25',
            'featured' => false,
            'tags' => ['企業教練', '案例分享', '成功經驗']
        ],
        [
            'id' => 6,
            'title' => '教練聯盟合作夥伴招募',
            'excerpt' => '教練聯盟正在招募新的合作夥伴，歡迎優秀的教練加入我們的大家庭...',
            'type' => 'announcement',
            'category' => 'partnership',
            'author' => '系統管理員',
            'status' => 'published',
            'views' => 1234,
            'likes' => 67,
            'created_at' => '2024-01-30',
            'updated_at' => '2024-01-30',
            'featured' => true,
            'tags' => ['合作招募', '聯盟夥伴', '教練發展']
        ]
    ];
}

// 模擬內容操作
function deleteContent($contentId) {
    return [
        'success' => true,
        'message' => '內容刪除成功'
    ];
}

function updateContentStatus($contentId, $status) {
    $validStatuses = ['published', 'draft', 'archived'];
    if (!in_array($status, $validStatuses)) {
        return [
            'success' => false,
            'message' => '無效的狀態值'
        ];
    }
    
    return [
        'success' => true,
        'message' => '內容狀態更新成功'
    ];
}

// 內容類型標籤
$typeLabels = [
    'article' => '文章',
    'news' => '新聞',
    'case_study' => '案例研究',
    'announcement' => '公告'
];

// 內容分類標籤
$categoryLabels = [
    'industry' => '行業趨勢',
    'coaching' => '教練技能',
    'events' => '活動資訊',
    'psychology' => '心理學',
    'enterprise' => '企業教練',
    'partnership' => '合作夥伴'
];

// 狀態標籤
$statusLabels = [
    'published' => '已發布',
    'draft' => '草稿',
    'archived' => '已歸檔'
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
        .content-container {
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
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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
        
        .content-list {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .content-item {
            display: grid;
            grid-template-columns: 1fr auto auto auto auto;
            gap: 1rem;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        
        .content-item:last-child {
            border-bottom: none;
        }
        
        .content-item:hover {
            background: var(--light-bg);
        }
        
        .content-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .content-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            line-height: 1.3;
        }
        
        .content-excerpt {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.4;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .content-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .content-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }
        
        .tag {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            background: var(--light-bg);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }
        
        .content-stats {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            min-width: 80px;
        }
        
        .stat-number {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-align: center;
        }
        
        .content-status {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            min-width: 100px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-align: center;
        }
        
        .status-published {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        
        .status-draft {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        
        .status-archived {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }
        
        .content-actions {
            display: flex;
            gap: 0.5rem;
            min-width: 120px;
        }
        
        .btn-icon {
            padding: 0.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            font-size: 0.875rem;
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
        
        .content-header {
            display: grid;
            grid-template-columns: 1fr auto auto auto auto;
            gap: 1rem;
            align-items: center;
            padding: 1rem 1.5rem;
            background: var(--light-bg);
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
        }
        
        .content-header > div:first-child {
            grid-column: 1;
        }
        
        .content-header > div:nth-child(2) {
            grid-column: 2;
            text-align: center;
        }
        
        .content-header > div:nth-child(3) {
            grid-column: 3;
            text-align: center;
        }
        
        .content-header > div:nth-child(4) {
            grid-column: 4;
            text-align: center;
        }
        
        .content-header > div:last-child {
            grid-column: 5;
            text-align: center;
        }
        
        .featured-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #856404;
            margin-left: 0.5rem;
        }
        
        .type-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            background: var(--accent-color);
            color: white;
            margin-right: 0.5rem;
        }
        
        .category-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            background: var(--secondary-color);
            color: white;
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
        
        @media (max-width: 1024px) {
            .content-item {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .content-header {
                display: none;
            }
            
            .content-stats,
            .content-status,
            .content-actions {
                justify-self: start;
            }
            
            .content-stats {
                flex-direction: row;
                gap: 1rem;
            }
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
            
            .content-meta {
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .content-tags {
                flex-wrap: wrap;
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
                    <li class="admin-nav-item active">
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
            <div class="content-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">內容管理</h1>
                    <a href="/admin/content/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        新增內容
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
                            <label for="search">搜索內容</label>
                            <input type="text" id="search" name="search" placeholder="標題或摘要..." value="<?php echo e($search); ?>">
                        </div>
                        
                        <div class="filter-group">
                            <label for="type">內容類型</label>
                            <select id="type" name="type">
                                <option value="">所有類型</option>
                                <option value="article" <?php echo $type === 'article' ? 'selected' : ''; ?>>文章</option>
                                <option value="news" <?php echo $type === 'news' ? 'selected' : ''; ?>>新聞</option>
                                <option value="case_study" <?php echo $type === 'case_study' ? 'selected' : ''; ?>>案例研究</option>
                                <option value="announcement" <?php echo $type === 'announcement' ? 'selected' : ''; ?>>公告</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="category">內容分類</label>
                            <select id="category" name="category">
                                <option value="">所有分類</option>
                                <option value="industry" <?php echo $category === 'industry' ? 'selected' : ''; ?>>行業趨勢</option>
                                <option value="coaching" <?php echo $category === 'coaching' ? 'selected' : ''; ?>>教練技能</option>
                                <option value="events" <?php echo $category === 'events' ? 'selected' : ''; ?>>活動資訊</option>
                                <option value="psychology" <?php echo $category === 'psychology' ? 'selected' : ''; ?>>心理學</option>
                                <option value="enterprise" <?php echo $category === 'enterprise' ? 'selected' : ''; ?>>企業教練</option>
                                <option value="partnership" <?php echo $category === 'partnership' ? 'selected' : ''; ?>>合作夥伴</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="status">內容狀態</label>
                            <select id="status" name="status">
                                <option value="">所有狀態</option>
                                <option value="published" <?php echo $status === 'published' ? 'selected' : ''; ?>>已發布</option>
                                <option value="draft" <?php echo $status === 'draft' ? 'selected' : ''; ?>>草稿</option>
                                <option value="archived" <?php echo $status === 'archived' ? 'selected' : ''; ?>>已歸檔</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                篩選
                            </button>
                            <a href="/admin/content" class="btn btn-outline">
                                <i class="fas fa-times"></i>
                                清除
                            </a>
                        </div>
                    </form>
                </div>
                
                <!-- Content List -->
                <?php if (empty($contents)): ?>
                    <div class="empty-state">
                        <i class="fas fa-file-alt"></i>
                        <h3>沒有找到內容</h3>
                        <p>請嘗試調整搜索條件或篩選器</p>
                    </div>
                <?php else: ?>
                    <div class="content-list">
                        <!-- Content Header -->
                        <div class="content-header">
                            <div>內容信息</div>
                            <div>統計數據</div>
                            <div>狀態</div>
                            <div>操作</div>
                        </div>
                        
                        <!-- Content Items -->
                        <?php foreach ($contents as $content): ?>
                            <div class="content-item" data-animate="fadeInUp">
                                <div class="content-info">
                                    <h3 class="content-title">
                                        <?php if ($content['featured']): ?>
                                            <span class="featured-badge">精選</span>
                                        <?php endif; ?>
                                        <span class="type-badge"><?php echo e($typeLabels[$content['type']]); ?></span>
                                        <span class="category-badge"><?php echo e($categoryLabels[$content['category']]); ?></span>
                                        <?php echo e($content['title']); ?>
                                    </h3>
                                    <p class="content-excerpt"><?php echo e($content['excerpt']); ?></p>
                                    <div class="content-meta">
                                        <span><i class="fas fa-user"></i> <?php echo e($content['author']); ?></span>
                                        <span><i class="fas fa-calendar"></i> <?php echo e($content['created_at']); ?></span>
                                        <?php if ($content['updated_at'] !== $content['created_at']): ?>
                                            <span><i class="fas fa-edit"></i> <?php echo e($content['updated_at']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="content-tags">
                                        <?php foreach ($content['tags'] as $tag): ?>
                                            <span class="tag"><?php echo e($tag); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                
                                <div class="content-stats">
                                    <div>
                                        <span class="stat-number"><?php echo e($content['views']); ?></span>
                                        <span class="stat-label">瀏覽</span>
                                    </div>
                                    <div>
                                        <span class="stat-number"><?php echo e($content['likes']); ?></span>
                                        <span class="stat-label">讚</span>
                                    </div>
                                </div>
                                
                                <div class="content-status">
                                    <span class="status-badge status-<?php echo e($content['status']); ?>">
                                        <?php echo e($statusLabels[$content['status']]); ?>
                                    </span>
                                </div>
                                
                                <div class="content-actions">
                                    <button class="btn-icon btn-view" title="查看內容" onclick="viewContent(<?php echo $content['id']; ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-icon btn-edit" title="編輯內容" onclick="editContent(<?php echo $content['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-icon btn-preview" title="預覽內容" onclick="previewContent(<?php echo $content['id']; ?>)">
                                        <i class="fas fa-external-link-alt"></i>
                                    </button>
                                    <button class="btn-icon btn-delete" title="刪除內容" onclick="deleteContent(<?php echo $content['id']; ?>, '<?php echo e($content['title']); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
        // 內容管理功能
        function viewContent(contentId) {
            // TODO: 實現查看內容
            alert('查看內容功能開發中...');
        }
        
        function editContent(contentId) {
            // TODO: 實現編輯內容
            alert('編輯內容功能開發中...');
        }
        
        function previewContent(contentId) {
            // TODO: 實現預覽內容
            alert('預覽內容功能開發中...');
        }
        
        function deleteContent(contentId, title) {
            if (confirm(`確定要刪除內容 "${title}" 嗎？此操作無法撤銷。`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_content">
                    <input type="hidden" name="content_id" value="${contentId}">
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
