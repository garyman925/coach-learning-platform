<?php
/**
 * 管理員後台 - 用戶管理
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/user-management.php';

// 檢查管理員權限
if (!$isAdmin) {
    http_response_code(403);
    exit('無權限訪問管理員後台');
}

// 處理用戶操作
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete_user':
                $userId = (int)$_POST['user_id'];
                $result = $userManagement->deleteUser($userId);
                if ($result['success']) {
                    $message = '用戶刪除成功';
                    $messageType = 'success';
                } else {
                    $message = $result['message'];
                    $messageType = 'error';
                }
                break;
                
            case 'update_status':
                $userId = (int)$_POST['user_id'];
                $status = $_POST['status'];
                $result = $userManagement->updateUserStatus($userId, $status);
                if ($result['success']) {
                    $message = '用戶狀態更新成功';
                    $messageType = 'success';
                } else {
                    $message = $result['message'];
                    $messageType = 'error';
                }
                break;
        }
    }
}

// 獲取用戶列表
$usersResult = $userManagement->getAllUsers();
$users = $usersResult['success'] ? $usersResult['users'] : [];

// 搜索和篩選
$search = $_GET['search'] ?? '';
$role = $_GET['role'] ?? '';
$status = $_GET['status'] ?? '';

// 篩選用戶
if ($search || $role || $status) {
    $users = array_filter($users, function($user) use ($search, $role, $status) {
        $matchesSearch = !$search || 
            stripos($user['username'], $search) !== false || 
            stripos($user['email'], $search) !== false;
        $matchesRole = !$role || $user['role'] === $role;
        $matchesStatus = !$status || $user['status'] === $status;
        
        return $matchesSearch && $matchesRole && $matchesStatus;
    });
}

// 設置頁面特定變數
$pageTitle = '用戶管理 - ' . SITE_NAME;
$pageDescription = '管理員後台用戶管理';
$pageKeywords = '用戶管理,管理員,後台';
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
        .users-container {
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
        
        .users-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .table-header {
            background: var(--light-bg);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .table-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        .users-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .users-table th,
        .users-table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        .users-table th {
            background: var(--light-bg);
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .users-table tr:hover {
            background: var(--light-bg);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-details h4 {
            margin: 0 0 0.25rem 0;
            font-size: 1rem;
            color: var(--text-primary);
        }
        
        .user-details p {
            margin: 0;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        
        .role-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .role-admin {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        .role-user {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        
        .role-coach {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-active {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        
        .status-inactive {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }
        
        .status-suspended {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        .action-buttons {
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
        
        .message {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .message.success {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
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
            
            .users-table th,
            .users-table td {
                padding: 0.75rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.25rem;
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
                    <li class="admin-nav-item active">
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
            <div class="users-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">用戶管理</h1>
                    <a href="/admin/users/create" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i>
                        新增用戶
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
                            <label for="search">搜索用戶</label>
                            <input type="text" id="search" name="search" placeholder="用戶名或電子郵件..." value="<?php echo e($search); ?>">
                        </div>
                        
                        <div class="filter-group">
                            <label for="role">用戶角色</label>
                            <select id="role" name="role">
                                <option value="">所有角色</option>
                                <option value="admin" <?php echo $role === 'admin' ? 'selected' : ''; ?>>管理員</option>
                                <option value="user" <?php echo $role === 'user' ? 'selected' : ''; ?>>一般用戶</option>
                                <option value="coach" <?php echo $role === 'coach' ? 'selected' : ''; ?>>教練</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="status">用戶狀態</label>
                            <select id="status" name="status">
                                <option value="">所有狀態</option>
                                <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>活躍</option>
                                <option value="inactive" <?php echo $status === 'inactive' ? 'selected' : ''; ?>>非活躍</option>
                                <option value="suspended" <?php echo $status === 'suspended' ? 'selected' : ''; ?>>暫停</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                篩選
                            </button>
                            <a href="/admin/users" class="btn btn-outline">
                                <i class="fas fa-times"></i>
                                清除
                            </a>
                        </div>
                    </form>
                </div>
                
                <!-- Users Table -->
                <div class="users-table">
                    <div class="table-header">
                        <h2 class="table-title">
                            用戶列表 
                            <span class="text-muted">(共 <?php echo count($users); ?> 個用戶)</span>
                        </h2>
                    </div>
                    
                    <div class="table-container">
                        <?php if (empty($users)): ?>
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <h3>沒有找到用戶</h3>
                                <p>請嘗試調整搜索條件或篩選器</p>
                            </div>
                        <?php else: ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>用戶</th>
                                        <th>角色</th>
                                        <th>狀態</th>
                                        <th>註冊時間</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td>
                                                <div class="user-info">
                                                    <div class="user-avatar">
                                                        <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                                                    </div>
                                                    <div class="user-details">
                                                        <h4><?php echo e($user['username']); ?></h4>
                                                        <p><?php echo e($user['email']); ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="role-badge role-<?php echo e($user['role']); ?>">
                                                    <?php echo e(ucfirst($user['role'])); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge status-<?php echo e($user['status']); ?>">
                                                    <?php 
                                                    $statusLabels = [
                                                        'active' => '活躍',
                                                        'inactive' => '非活躍',
                                                        'suspended' => '暫停'
                                                    ];
                                                    echo $statusLabels[$user['status']] ?? $user['status'];
                                                    ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo e($user['created_at']); ?>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-icon btn-view" title="查看詳情" onclick="viewUser(<?php echo $user['id']; ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn-icon btn-edit" title="編輯用戶" onclick="editUser(<?php echo $user['id']; ?>)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <?php if ($user['id'] != $currentUser['id']): ?>
                                                        <button class="btn-icon btn-delete" title="刪除用戶" onclick="deleteUser(<?php echo $user['id']; ?>, '<?php echo e($user['username']); ?>')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- JavaScript Files -->
    <script src="/coach-learning-platform-mainpage/assets/js/utils/helpers.js"></script>
    <script src="/coach-learning-platform-mainpage/assets/js/components/ScrollAnimator.js"></script>
    <script src="/coach-learning-platform-mainpage/assets/js/admin/admin.js"></script>
    
    <script>
        // 用戶管理功能
        function viewUser(userId) {
            // TODO: 實現查看用戶詳情
            alert('查看用戶詳情功能開發中...');
        }
        
        function editUser(userId) {
            // TODO: 實現編輯用戶
            alert('編輯用戶功能開發中...');
        }
        
        function deleteUser(userId, username) {
            if (confirm(`確定要刪除用戶 "${username}" 嗎？此操作無法撤銷。`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_user">
                    <input type="hidden" name="user_id" value="${userId}">
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
