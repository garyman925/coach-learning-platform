<?php
/**
 * 教練學習平台 - 登入處理
 */

require_once 'includes/config.php';
require_once 'includes/user-management.php';
require_once 'includes/functions.php';

// 檢查是否為 POST 請求
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/login-page');
    exit;
}

// 獲取表單數據
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// 驗證輸入
if (empty($email) || empty($password)) {
    header('Location: ' . BASE_URL . '/login-page?error=missing_fields');
    exit;
}

// 模擬用戶數據（與 user-management.php 保持一致）
$mockUsers = [
    'admin@example.com' => [
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => 'admin123',
        'role' => 'admin',
        'status' => 'active',
        'created_at' => '2024-01-01',
        'last_login' => null,
        'profile' => [
            'first_name' => '系統',
            'last_name' => '管理員',
            'phone' => '0912-345-678',
            'avatar' => null
        ]
    ],
    'user@example.com' => [
        'username' => 'user',
        'email' => 'user@example.com',
        'password' => 'user123',
        'role' => 'user',
        'status' => 'active',
        'created_at' => '2024-01-15',
        'last_login' => null,
        'profile' => [
            'first_name' => '用',
            'last_name' => '戶',
            'phone' => '0923-456-789',
            'avatar' => null
        ]
    ],
    'admin@coach-platform.com' => [
        'username' => 'admin',
        'email' => 'admin@coach-platform.com',
        'password' => 'admin123',
        'role' => 'admin',
        'status' => 'active',
        'created_at' => '2024-01-01',
        'last_login' => null,
        'profile' => [
            'first_name' => '系統',
            'last_name' => '管理員',
            'phone' => '0912-345-678',
            'avatar' => null
        ]
    ],
    'coach1@coach-platform.com' => [
        'username' => 'coach1',
        'email' => 'coach1@coach-platform.com',
        'password' => 'coach123',
        'role' => 'coach',
        'status' => 'active',
        'created_at' => '2024-01-15',
        'last_login' => null,
        'profile' => [
            'first_name' => '張',
            'last_name' => '教練',
            'phone' => '0923-456-789',
            'avatar' => null
        ]
    ],
    'user1@example.com' => [
        'username' => 'user1',
        'email' => 'user1@example.com',
        'password' => 'user123',
        'role' => 'user',
        'status' => 'active',
        'created_at' => '2024-01-20',
        'last_login' => null,
        'profile' => [
            'first_name' => '李',
            'last_name' => '學員',
            'phone' => '0934-567-890',
            'avatar' => null
        ]
    ]
];

// 檢查用戶是否存在
if (!isset($mockUsers[$email])) {
    header('Location: ' . BASE_URL . '/login-page?error=invalid_credentials');
    exit;
}

$user = $mockUsers[$email];

// 驗證密碼
if ($password !== $user['password']) {
    header('Location: ' . BASE_URL . '/login-page?error=invalid_credentials');
    exit;
}

// 登入成功，設置 session
// 初始化用戶管理系統來處理 session
$userManagement = new UserManagement();
$_SESSION['user_id'] = $user['username']; // 使用 username 作為 key，與 user-management.php 一致
$_SESSION['user'] = $user;
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

// 記錄登入活動
if (isset($userManagement)) {
    $userManagement->logActivity($user['username'], 'login', '用戶登入', '成功登入系統');
}

// 重定向到 my-courses
header('Location: ' . BASE_URL . '/my-courses');
exit;
?>
