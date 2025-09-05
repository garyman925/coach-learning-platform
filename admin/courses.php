<?php
/**
 * 管理員後台 - 課程管理
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/user-management.php';

// 檢查管理員權限
if (!$isAdmin) {
    http_response_code(403);
    exit('無權限訪問管理員後台');
}

// 處理課程操作
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete_course':
                $courseId = (int)$_POST['course_id'];
                $result = deleteCourse($courseId);
                if ($result['success']) {
                    $message = '課程刪除成功';
                    $messageType = 'success';
                } else {
                    $message = $result['message'];
                    $messageType = 'error';
                }
                break;
                
            case 'update_status':
                $courseId = (int)$_POST['course_id'];
                $status = $_POST['status'];
                $result = updateCourseStatus($courseId, $status);
                if ($result['success']) {
                    $message = '課程狀態更新成功';
                    $messageType = 'success';
                } else {
                    $message = $result['message'];
                    $messageType = 'error';
                }
                break;
        }
    }
}

// 獲取課程列表
$courses = getMockCourses();

// 搜索和篩選
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$status = $_GET['status'] ?? '';

// 篩選課程
if ($search || $category || $status) {
    $courses = array_filter($courses, function($course) use ($search, $category, $status) {
        $matchesSearch = !$search || 
            stripos($course['title'], $search) !== false || 
            stripos($course['description'], $search) !== false;
        $matchesCategory = !$category || $course['category'] === $category;
        $matchesStatus = !$status || $course['status'] === $status;
        
        return $matchesSearch && $matchesCategory && $matchesStatus;
    });
}

// 設置頁面特定變數
$pageTitle = '課程管理 - ' . SITE_NAME;
$pageDescription = '管理員後台課程管理';
$pageKeywords = '課程管理,管理員,後台';

// 模擬課程數據
function getMockCourses() {
    return [
        [
            'id' => 1,
            'title' => '專業教練培訓課程',
            'description' => '培養專業教練技能的綜合培訓課程',
            'category' => 'professional',
            'duration' => '12週',
            'price' => 15000,
            'status' => 'active',
            'enrolled' => 45,
            'rating' => 4.8,
            'created_at' => '2024-01-15',
            'image' => 'professional-coaching.jpg'
        ],
        [
            'id' => 2,
            'title' => '團隊教練課程',
            'description' => '專注於團隊建設和領導力發展',
            'category' => 'team',
            'duration' => '8週',
            'price' => 12000,
            'status' => 'active',
            'enrolled' => 32,
            'rating' => 4.6,
            'created_at' => '2024-01-20',
            'image' => 'team-coaching.jpg'
        ],
        [
            'id' => 3,
            'title' => '家長教練課程',
            'description' => '幫助家長提升親子溝通和教育技巧',
            'category' => 'parent',
            'duration' => '6週',
            'price' => 8000,
            'status' => 'active',
            'enrolled' => 28,
            'rating' => 4.9,
            'created_at' => '2024-01-25',
            'image' => 'parent-coaching.jpg'
        ],
        [
            'id' => 4,
            'title' => '九型人格分析課程',
            'description' => '深入學習九型人格理論和應用',
            'category' => 'enneagram',
            'duration' => '10週',
            'price' => 10000,
            'status' => 'draft',
            'enrolled' => 0,
            'rating' => 0,
            'created_at' => '2024-02-01',
            'image' => 'enneagram.jpg'
        ]
    ];
}

// 模擬課程操作
function deleteCourse($courseId) {
    return [
        'success' => true,
        'message' => '課程刪除成功'
    ];
}

function updateCourseStatus($courseId, $status) {
    $validStatuses = ['active', 'inactive', 'draft'];
    if (!in_array($status, $validStatuses)) {
        return [
            'success' => false,
            'message' => '無效的狀態值'
        ];
    }
    
    return [
        'success' => true,
        'message' => '課程狀態更新成功'
    ];
}

// 課程分類標籤
$categoryLabels = [
    'professional' => '專業教練',
    'team' => '團隊教練',
    'parent' => '家長教練',
    'enneagram' => '九型人格'
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
        .courses-container {
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
        
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .course-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .course-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .course-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            opacity: 0.8;
        }
        
        .course-content {
            padding: 1.5rem;
        }
        
        .course-header {
            margin-bottom: 1rem;
        }
        
        .course-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 0.5rem 0;
            line-height: 1.3;
        }
        
        .course-description {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.5;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .course-meta {
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
            padding: 0.75rem;
            background: var(--light-bg);
            border-radius: 8px;
        }
        
        .meta-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .meta-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .course-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: var(--light-bg);
            border-radius: 8px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            display: block;
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-transform: uppercase;
        }
        
        .course-actions {
            display: flex;
            gap: 0.5rem;
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
        
        .category-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }
        
        .category-professional {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }
        
        .category-team {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        
        .category-parent {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        
        .category-enneagram {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .status-active {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        
        .status-inactive {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }
        
        .status-draft {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
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
        
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
            
            .filters-form {
                grid-template-columns: 1fr;
            }
            
            .courses-grid {
                grid-template-columns: 1fr;
            }
            
            .course-meta {
                grid-template-columns: 1fr;
            }
            
            .course-stats {
                flex-direction: column;
                gap: 1rem;
            }
            
            .course-actions {
                flex-wrap: wrap;
                justify-content: center;
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
                    <li class="admin-nav-item active">
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
            <div class="courses-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">課程管理</h1>
                    <a href="/admin/courses/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        新增課程
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
                            <label for="search">搜索課程</label>
                            <input type="text" id="search" name="search" placeholder="課程標題或描述..." value="<?php echo e($search); ?>">
                        </div>
                        
                        <div class="filter-group">
                            <label for="category">課程分類</label>
                            <select id="category" name="category">
                                <option value="">所有分類</option>
                                <option value="professional" <?php echo $category === 'professional' ? 'selected' : ''; ?>>專業教練</option>
                                <option value="team" <?php echo $category === 'team' ? 'selected' : ''; ?>>團隊教練</option>
                                <option value="parent" <?php echo $category === 'parent' ? 'selected' : ''; ?>>家長教練</option>
                                <option value="enneagram" <?php echo $category === 'enneagram' ? 'selected' : ''; ?>>九型人格</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="status">課程狀態</label>
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
                            <a href="/admin/courses" class="btn btn-outline">
                                <i class="fas fa-times"></i>
                                清除
                            </a>
                        </div>
                    </form>
                </div>
                
                <!-- Courses Grid -->
                <?php if (empty($courses)): ?>
                    <div class="empty-state">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>沒有找到課程</h3>
                        <p>請嘗試調整搜索條件或篩選器</p>
                    </div>
                <?php else: ?>
                    <div class="courses-grid">
                        <?php foreach ($courses as $course): ?>
                            <div class="course-card" data-animate="fadeInUp">
                                <div class="course-image">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                
                                <div class="course-content">
                                    <div class="course-header">
                                        <span class="category-badge category-<?php echo e($course['category']); ?>">
                                            <?php echo e($categoryLabels[$course['category']]); ?>
                                        </span>
                                        <span class="status-badge status-<?php echo e($course['status']); ?>">
                                            <?php echo e($statusLabels[$course['status']]); ?>
                                        </span>
                                        
                                        <h3 class="course-title"><?php echo e($course['title']); ?></h3>
                                        <p class="course-description"><?php echo e($course['description']); ?></p>
                                    </div>
                                    
                                    <div class="course-meta">
                                        <div class="meta-item">
                                            <span class="meta-label">課程時長</span>
                                            <span class="meta-value"><?php echo e($course['duration']); ?></span>
                                        </div>
                                        <div class="meta-item">
                                            <span class="meta-label">課程價格</span>
                                            <span class="meta-value">NT$ <?php echo number_format($course['price']); ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="course-stats">
                                        <div class="stat-item">
                                            <span class="stat-number"><?php echo e($course['enrolled']); ?></span>
                                            <span class="stat-label">已報名</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-number"><?php echo e($course['rating']); ?></span>
                                            <span class="stat-label">評分</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-number"><?php echo e($course['created_at']); ?></span>
                                            <span class="stat-label">創建日期</span>
                                        </div>
                                    </div>
                                    
                                    <div class="course-actions">
                                        <button class="btn-icon btn-view" title="查看詳情" onclick="viewCourse(<?php echo $course['id']; ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-icon btn-edit" title="編輯課程" onclick="editCourse(<?php echo $course['id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon btn-preview" title="預覽課程" onclick="previewCourse(<?php echo $course['id']; ?>)">
                                            <i class="fas fa-external-link-alt"></i>
                                        </button>
                                        <button class="btn-icon btn-delete" title="刪除課程" onclick="deleteCourse(<?php echo $course['id']; ?>, '<?php echo e($course['title']); ?>')">
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
        // 課程管理功能
        function viewCourse(courseId) {
            // TODO: 實現查看課程詳情
            alert('查看課程詳情功能開發中...');
        }
        
        function editCourse(courseId) {
            // TODO: 實現編輯課程
            alert('編輯課程功能開發中...');
        }
        
        function previewCourse(courseId) {
            // TODO: 實現預覽課程
            alert('預覽課程功能開發中...');
        }
        
        function deleteCourse(courseId, title) {
            if (confirm(`確定要刪除課程 "${title}" 嗎？此操作無法撤銷。`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_course">
                    <input type="hidden" name="course_id" value="${courseId}">
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
