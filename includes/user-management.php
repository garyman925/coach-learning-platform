<?php
/**
 * 用戶管理系統
 * 處理用戶註冊、登入、登出和權限管理
 */

// 防止直接訪問
if (!defined('SECURE_ACCESS') || !SECURE_ACCESS) {
    http_response_code(403);
    exit('直接訪問被禁止');
}

// PHP版本兼容性檢查和函數定義
if (!function_exists('password_hash')) {
    // 定義PASSWORD_DEFAULT常數（PHP 5.5.0+才有）
    if (!defined('PASSWORD_DEFAULT')) {
        define('PASSWORD_DEFAULT', 1);
    }
    if (!defined('PASSWORD_BCRYPT')) {
        define('PASSWORD_BCRYPT', 1);
    }
    
    /**
     * 為舊版PHP提供password_hash兼容性
     * 適用於PHP 5.3.7+
     */
    function password_hash($password, $algo, $options = array()) {
        // 使用crypt()函數作為後備方案
        // 生成隨機鹽值
        if (function_exists('openssl_random_pseudo_bytes')) {
            $salt = substr(str_replace('+', '.', base64_encode(openssl_random_pseudo_bytes(16))), 0, 22);
        } else {
            // 如果openssl不可用，使用其他方法生成鹽值
            $salt = substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(), mt_rand()))), 0, 22);
        }
        
        return crypt($password, '$2y$10$' . $salt);
    }
    
    /**
     * 為舊版PHP提供password_verify兼容性
     */
    function password_verify($password, $hash) {
        return crypt($password, $hash) === $hash;
    }
}

class UserManagement {
    private $users = [];
    private $sessions = [];
    
    public function __construct() {
        $this->initSession();
        $this->loadUsers();
        $this->checkRememberMe();
    }
    
    /**
     * 初始化會話
     */
    private function initSession() {
        if (session_status() === PHP_SESSION_NONE) {
            // 在會話啟動前設置參數
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
            ini_set('session.use_strict_mode', 1);
            ini_set('session.gc_maxlifetime', 7200);
            session_set_cookie_params(7200);
            
            // 啟動會話
            session_start();
        }
    }
    
    /**
     * 載入用戶數據
     */
    private function loadUsers() {
        // 模擬用戶數據 - 後續會替換為數據庫
        $this->users = [
            'admin' => [
                'username' => 'admin',
                'email' => 'admin@coach-platform.com',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
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
            'coach1' => [
                'username' => 'coach1',
                'email' => 'coach1@coach-platform.com',
                'password_hash' => password_hash('coach123', PASSWORD_DEFAULT),
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
            'user1' => [
                'username' => 'user1',
                'email' => 'user1@example.com',
                'password_hash' => password_hash('user123', PASSWORD_DEFAULT),
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
    }
    
    /**
     * 檢查記住我功能
     */
    private function checkRememberMe() {
        if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];
            $userId = $this->validateRememberToken($token);
            if ($userId) {
                $this->loginUser($userId);
            }
        }
    }
    
    /**
     * 用戶註冊
     */
    public function registerUser($username, $email, $password, $firstName, $lastName, $phone = '') {
        // 驗證輸入
        if (empty($username) || empty($email) || empty($password) || empty($firstName) || empty($lastName)) {
            return [
                'success' => false,
                'message' => '所有必填欄位都必須填寫'
            ];
        }
        
        // 檢查用戶名是否已存在
        if (isset($this->users[$username])) {
            return [
                'success' => false,
                'message' => '用戶名已存在，請選擇其他用戶名'
            ];
        }
        
        // 檢查郵箱是否已存在
        foreach ($this->users as $user) {
            if ($user['email'] === $email) {
                return [
                    'success' => false,
                    'message' => '郵箱地址已被使用'
                ];
            }
        }
        
        // 驗證郵箱格式
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => '郵箱格式不正確'
            ];
        }
        
        // 驗證密碼強度
        if (strlen($password) < 6) {
            return [
                'success' => false,
                'message' => '密碼長度至少需要6個字符'
            ];
        }
        
        // 創建新用戶
        $newUser = [
            'username' => $username,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user',
            'status' => 'active',
            'created_at' => date('Y-m-d'),
            'last_login' => null,
            'profile' => [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => $phone,
                'avatar' => null
            ]
        ];
        
        $this->users[$username] = $newUser;
        
        // 自動登入新註冊的用戶
        $this->loginUser($username);
        
        return [
            'success' => true,
            'message' => '註冊成功！歡迎加入教練學習平台',
            'user' => $newUser
        ];
    }
    
    /**
     * 用戶登入
     */
    public function loginUser($username, $password = null, $rememberMe = false) {
        // 如果只傳入用戶名，表示是記住我功能或自動登入
        if ($password === null) {
            if (isset($this->users[$username])) {
                $user = $this->users[$username];
                if ($user['status'] === 'active') {
                    $this->setUserSession($username, $rememberMe);
                    $this->updateLastLogin($username);
                    return [
                        'success' => true,
                        'message' => '登入成功',
                        'user' => $user
                    ];
                }
            }
            return [
                'success' => false,
                'message' => '用戶不存在或已被停用'
            ];
        }
        
        // 正常登入流程
        if (!isset($this->users[$username])) {
            return [
                'success' => false,
                'message' => '用戶名或密碼錯誤'
            ];
        }
        
        $user = $this->users[$username];
        
        // 檢查用戶狀態
        if ($user['status'] !== 'active') {
            return [
                'success' => false,
                'message' => '帳戶已被停用，請聯繫管理員'
            ];
        }
        
        // 驗證密碼
        if (!password_verify($password, $user['password_hash'])) {
            return [
                'success' => false,
                'message' => '用戶名或密碼錯誤'
            ];
        }
        
        // 設置用戶會話
        $this->setUserSession($username, $rememberMe);
        $this->updateLastLogin($username);
        
        return [
            'success' => true,
            'message' => '登入成功',
            'user' => $user
        ];
    }
    
    /**
     * 設置用戶會話
     */
    private function setUserSession($username, $rememberMe = false) {
        $_SESSION['user_id'] = $username;
        $_SESSION['login_time'] = time();
        
        if ($rememberMe) {
            $token = $this->generateRememberToken($username);
            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', isset($_SERVER['HTTPS']), true);
        }
    }
    
    /**
     * 生成記住我令牌
     */
    private function generateRememberToken($username) {
        $token = bin2hex(random_bytes(32));
        $this->sessions[$token] = [
            'username' => $username,
            'created_at' => time(),
            'expires_at' => time() + (30 * 24 * 60 * 60)
        ];
        return $token;
    }
    
    /**
     * 驗證記住我令牌
     */
    private function validateRememberToken($token) {
        if (isset($this->sessions[$token])) {
            $session = $this->sessions[$token];
            if ($session['expires_at'] > time()) {
                return $session['username'];
            } else {
                unset($this->sessions[$token]);
            }
        }
        return false;
    }
    
    /**
     * 更新最後登入時間
     */
    private function updateLastLogin($username) {
        if (isset($this->users[$username])) {
            $this->users[$username]['last_login'] = date('Y-m-d H:i:s');
        }
    }
    
    /**
     * 用戶登出
     */
    public function logout() {
        // 清除會話
        session_unset();
        session_destroy();
        
        // 清除記住我cookie
        if (isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];
            unset($this->sessions[$token]);
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        return [
            'success' => true,
            'message' => '登出成功'
        ];
    }
    
    /**
     * 重置密碼
     */
    public function resetPassword($email) {
        // 查找用戶
        $user = null;
        foreach ($this->users as $u) {
            if ($u['email'] === $email) {
                $user = $u;
                break;
            }
        }
        
        if (!$user) {
            return [
                'success' => false,
                'message' => '找不到該郵箱地址的用戶'
            ];
        }
        
        if ($user['status'] !== 'active') {
            return [
                'success' => false,
                'message' => '該帳戶已被停用'
            ];
        }
        
        // 生成重置令牌（模擬）
        $resetToken = bin2hex(random_bytes(16));
        
        // 在實際應用中，這裡會發送郵件
        // 目前模擬發送成功
        
        return [
            'success' => true,
            'message' => '密碼重置郵件已發送，請檢查您的郵箱',
            'reset_token' => $resetToken // 僅用於測試
        ];
    }
    
    /**
     * 使用重置令牌更新密碼
     */
    public function updatePasswordWithToken($resetToken, $newPassword) {
        // 在實際應用中，這裡會驗證重置令牌
        // 目前模擬驗證成功
        
        if (strlen($newPassword) < 6) {
            return [
                'success' => false,
                'message' => '密碼長度至少需要6個字符'
            ];
        }
        
        // 模擬更新密碼成功
        return [
            'success' => true,
            'message' => '密碼更新成功，請使用新密碼登入'
        ];
    }
    
    /**
     * 檢查用戶是否已登入
     */
    public function isLoggedIn() {
        return isset($_SESSION['user_id']) && isset($this->users[$_SESSION['user_id']]);
    }
    
    /**
     * 獲取當前用戶
     */
    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            return $this->users[$_SESSION['user_id']];
        }
        return null;
    }
    
    /**
     * 檢查是否為管理員
     */
    public function isAdmin() {
        $user = $this->getCurrentUser();
        return $user && $user['role'] === 'admin';
    }
    
    /**
     * 檢查權限
     */
    public function hasPermission($permission) {
        $user = $this->getCurrentUser();
        if (!$user) return false;
        
        switch ($permission) {
            case 'manage_users':
                return $user['role'] === 'admin';
            case 'manage_courses':
                return in_array($user['role'], ['admin', 'coach']);
            case 'manage_services':
                return in_array($user['role'], ['admin', 'coach']);
            case 'edit_profile':
                return true;
            case 'view_courses':
                return true;
            case 'book_courses':
                return $user['role'] === 'user';
            default:
                return false;
        }
    }
    
    /**
     * 更新用戶狀態（管理員功能）
     */
    public function updateUserStatus($userId, $status) {
        if (!$this->hasPermission('manage_users')) {
            return [
                'success' => false,
                'message' => '無權限更新用戶狀態'
            ];
        }
        
        if (!isset($this->users[$userId])) {
            return [
                'success' => false,
                'message' => '用戶不存在'
            ];
        }
        
        // 防止管理員停用自己的帳戶
        if ($userId === $_SESSION['user_id']) {
            return [
                'success' => false,
                'message' => '不能停用自己的帳戶'
            ];
        }
        
        $validStatuses = ['active', 'inactive', 'suspended'];
        if (!in_array($status, $validStatuses)) {
            return [
                'success' => false,
                'message' => '無效的狀態值'
            ];
        }
        
        $this->users[$userId]['status'] = $status;
        
        return [
            'success' => true,
            'message' => '用戶狀態更新成功'
        ];
    }
    
    /**
     * 獲取用戶詳情
     */
    public function getUserById($userId) {
        if (!$this->hasPermission('manage_users')) {
            return [
                'success' => false,
                'message' => '無權限查看用戶詳情'
            ];
        }
        
        if (!isset($this->users[$userId])) {
            return [
                'success' => false,
                'message' => '用戶不存在'
            ];
        }
        
        return [
            'success' => true,
            'user' => $this->users[$userId]
        ];
    }
    
    /**
     * 根據郵箱獲取用戶
     */
    public function getUserByEmail($email) {
        foreach ($this->users as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }
        return null;
    }
    
    /**
     * 獲取所有用戶（管理員功能）
     */
    public function getAllUsers() {
        if (!$this->hasPermission('manage_users')) {
            return [];
        }
        
        return $this->users;
    }
    
    /**
     * 獲取用戶偏好設定
     */
    public function getUserPreferences($username) {
        if (!isset($this->users[$username])) {
            return [];
        }
        
        return isset($this->users[$username]['preferences']) ? $this->users[$username]['preferences'] : array();
    }
    
    /**
     * 更新用戶偏好設定
     */
    public function updateUserPreferences($username, $preferences) {
        if (!isset($this->users[$username])) {
            return false;
        }
        
        $this->users[$username]['preferences'] = $preferences;
        $this->users[$username]['updated_at'] = date('Y-m-d H:i:s');
        
        // 在實際應用中，這裡會保存到數據庫
        return true;
    }
    
    /**
     * 導出用戶數據
     */
    public function exportUserData($username) {
        if (!isset($this->users[$username])) {
            return false;
        }
        
        $user = $this->users[$username];
        
        // 移除敏感信息
        unset($user['password_hash']);
        
        return [
            'user_info' => [
                'username' => $user['username'],
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'phone' => $user['phone'],
                'role' => $user['role'],
                'status' => $user['status'],
                'created_at' => $user['created_at'],
                'updated_at' => $user['updated_at']
            ],
            'preferences' => isset($user['preferences']) ? $user['preferences'] : array(),
            'profile' => isset($user['profile']) ? $user['profile'] : array(),
            'export_date' => date('Y-m-d H:i:s'),
            'export_version' => '1.0'
        ];
    }
    
    /**
     * 清除用戶緩存
     */
    public function clearUserCache($username) {
        if (!isset($this->users[$username])) {
            return false;
        }
        
        // 在實際應用中，這裡會清除相關的緩存數據
        // 現在我們模擬清除成功
        return true;
    }
    
    /**
     * 更新用戶個人資料
     */
    public function updateUserProfile($userId, $profileData) {
        if (!$this->isLoggedIn()) {
            return [
                'success' => false,
                'message' => '請先登入'
            ];
        }
        
        // 用戶只能更新自己的資料，管理員可以更新任何用戶
        if ($userId !== $_SESSION['user_id'] && !$this->isAdmin()) {
            return [
                'success' => false,
                'message' => '無權限更新其他用戶的資料'
            ];
        }
        
        if (!isset($this->users[$userId])) {
            return [
                'success' => false,
                'message' => '用戶不存在'
            ];
        }
        
        // 更新個人資料
        $this->users[$userId]['profile'] = array_merge(
            isset($this->users[$userId]['profile']) ? $this->users[$userId]['profile'] : array(),
            $profileData
        );
        
        return [
            'success' => true,
            'message' => '個人資料更新成功'
        ];
    }
    
    /**
     * 修改密碼
     */
    public function changePassword($userId, $currentPassword, $newPassword) {
        if (!$this->isLoggedIn()) {
            return [
                'success' => false,
                'message' => '請先登入'
            ];
        }
        
        // 用戶只能修改自己的密碼
        if ($userId !== $_SESSION['user_id']) {
            return [
                'success' => false,
                'message' => '無權限修改其他用戶的密碼'
            ];
        }
        
        if (!isset($this->users[$userId])) {
            return [
                'success' => false,
                'message' => '用戶不存在'
            ];
        }
        
        // 驗證當前密碼
        if (!password_verify($currentPassword, $this->users[$userId]['password_hash'])) {
            return [
                'success' => false,
                'message' => '當前密碼不正確'
            ];
        }
        
        // 驗證新密碼
        if (strlen($newPassword) < 6) {
            return [
                'success' => false,
                'message' => '新密碼長度至少需要6個字符'
            ];
        }
        
        // 更新密碼
        $this->users[$userId]['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
        
        return [
            'success' => true,
            'message' => '密碼修改成功'
        ];
    }
    
    /**
     * 記錄用戶活動
     */
    public function logActivity($username, $type, $title, $description, $status = 'success') {
        $activity = [
            'id' => uniqid(),
            'username' => $username,
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'timestamp' => date('Y-m-d H:i:s'),
            'ip_address' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown',
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown',
            'status' => $status
        ];
        
        // 在實際應用中，這裡會將活動記錄保存到數據庫
        // 目前我們使用 session 來模擬存儲
        if (!isset($_SESSION['user_activities'])) {
            $_SESSION['user_activities'] = [];
        }
        
        $_SESSION['user_activities'][] = $activity;
        
        // 限制活動記錄數量（保留最近100條）
        if (count($_SESSION['user_activities']) > 100) {
            $_SESSION['user_activities'] = array_slice($_SESSION['user_activities'], -100);
        }
        
        return $activity;
    }
    
    /**
     * 獲取用戶活動記錄
     */
    public function getUserActivities($username, $limit = 50) {
        if (!isset($_SESSION['user_activities'])) {
            return [];
        }
        
        $activities = array_filter($_SESSION['user_activities'], function($activity) use ($username) {
            return $activity['username'] === $username;
        });
        
        // 按時間排序（最新的在前）
        usort($activities, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });
        
        return array_slice($activities, 0, $limit);
    }
    
    /**
     * 獲取活動統計
     */
    public function getActivityStats($username) {
        $activities = $this->getUserActivities($username);
        
        $stats = [
            'total' => count($activities),
            'today' => 0,
            'week' => 0,
            'month' => 0,
            'by_type' => []
        ];
        
        $today = date('Y-m-d');
        $weekAgo = date('Y-m-d', strtotime('-1 week'));
        $monthAgo = date('Y-m-d', strtotime('-1 month'));
        
        foreach ($activities as $activity) {
            $activityDate = date('Y-m-d', strtotime($activity['timestamp']));
            
            // 統計今日活動
            if ($activityDate === $today) {
                $stats['today']++;
            }
            
            // 統計本週活動
            if (strtotime($activity['timestamp']) >= strtotime('-1 week')) {
                $stats['week']++;
            }
            
            // 統計本月活動
            if (strtotime($activity['timestamp']) >= strtotime('-1 month')) {
                $stats['month']++;
            }
            
            // 按類型統計
            if (!isset($stats['by_type'][$activity['type']])) {
                $stats['by_type'][$activity['type']] = 0;
            }
            $stats['by_type'][$activity['type']]++;
        }
        
        return $stats;
    }
    
    /**
     * 清除用戶活動記錄
     */
    public function clearUserActivities($username) {
        if (!isset($_SESSION['user_activities'])) {
            return true;
        }
        
        $_SESSION['user_activities'] = array_filter($_SESSION['user_activities'], function($activity) use ($username) {
            return $activity['username'] !== $username;
        });
        
        return true;
    }
    
    /**
     * 創建通知
     */
    public function createNotification($username, $type, $title, $message, $priority = 'medium', $actionUrl = null, $actionText = null) {
        $notification = [
            'id' => uniqid(),
            'username' => $username,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s'),
            'is_read' => false,
            'priority' => $priority,
            'action_url' => $actionUrl,
            'action_text' => $actionText
        ];
        
        // 在實際應用中，這裡會將通知保存到數據庫
        // 目前我們使用 session 來模擬存儲
        if (!isset($_SESSION['user_notifications'])) {
            $_SESSION['user_notifications'] = [];
        }
        
        $_SESSION['user_notifications'][] = $notification;
        
        // 限制通知數量（保留最近200條）
        if (count($_SESSION['user_notifications']) > 200) {
            $_SESSION['user_notifications'] = array_slice($_SESSION['user_notifications'], -200);
        }
        
        return $notification;
    }
    
    /**
     * 獲取用戶通知
     */
    public function getUserNotifications($username, $limit = 50) {
        if (!isset($_SESSION['user_notifications'])) {
            return [];
        }
        
        $notifications = array_filter($_SESSION['user_notifications'], function($notification) use ($username) {
            return $notification['username'] === $username;
        });
        
        // 按時間排序（最新的在前）
        usort($notifications, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });
        
        return array_slice($notifications, 0, $limit);
    }
    
    /**
     * 標記通知為已讀
     */
    public function markNotificationAsRead($notificationId) {
        if (!isset($_SESSION['user_notifications'])) {
            return false;
        }
        
        foreach ($_SESSION['user_notifications'] as &$notification) {
            if ($notification['id'] === $notificationId) {
                $notification['is_read'] = true;
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * 標記所有通知為已讀
     */
    public function markAllNotificationsAsRead($username) {
        if (!isset($_SESSION['user_notifications'])) {
            return false;
        }
        
        $updated = false;
        foreach ($_SESSION['user_notifications'] as &$notification) {
            if ($notification['username'] === $username && !$notification['is_read']) {
                $notification['is_read'] = true;
                $updated = true;
            }
        }
        
        return $updated;
    }
    
    /**
     * 獲取通知統計
     */
    public function getNotificationStats($username) {
        $notifications = $this->getUserNotifications($username);
        
        $stats = [
            'total' => count($notifications),
            'unread' => 0,
            'today' => 0,
            'week' => 0,
            'by_type' => []
        ];
        
        $today = date('Y-m-d');
        
        foreach ($notifications as $notification) {
            // 統計未讀通知
            if (!$notification['is_read']) {
                $stats['unread']++;
            }
            
            // 統計今日通知
            if (date('Y-m-d', strtotime($notification['timestamp'])) === $today) {
                $stats['today']++;
            }
            
            // 統計本週通知
            if (strtotime($notification['timestamp']) >= strtotime('-1 week')) {
                $stats['week']++;
            }
            
            // 按類型統計
            if (!isset($stats['by_type'][$notification['type']])) {
                $stats['by_type'][$notification['type']] = 0;
            }
            $stats['by_type'][$notification['type']]++;
        }
        
        return $stats;
    }
    
    /**
     * 刪除通知
     */
    public function deleteNotification($notificationId) {
        if (!isset($_SESSION['user_notifications'])) {
            return false;
        }
        
        foreach ($_SESSION['user_notifications'] as $key => $notification) {
            if ($notification['id'] === $notificationId) {
                unset($_SESSION['user_notifications'][$key]);
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * 清除所有通知
     */
    public function clearAllNotifications($username) {
        if (!isset($_SESSION['user_notifications'])) {
            return true;
        }
        
        $_SESSION['user_notifications'] = array_filter($_SESSION['user_notifications'], function($notification) use ($username) {
            return $notification['username'] !== $username;
        });
        
        return true;
    }

    /**
     * 更新用戶隱私設定
     */
    public function updateUserPrivacy($username, $privacySettings) {
        if (!isset($_SESSION['user_privacy'])) {
            $_SESSION['user_privacy'] = [];
        }
        
        $_SESSION['user_privacy'][$username] = array_merge(
            isset($_SESSION['user_privacy'][$username]) ? $_SESSION['user_privacy'][$username] : array(),
            $privacySettings
        );
        
        // 記錄活動
        $this->logActivity($username, 'privacy_update', '更新隱私設定', '修改了隱私和數據使用設定');
        
        return true;
    }

    /**
     * 獲取用戶隱私設定
     */
    public function getUserPrivacy($username) {
        return isset($_SESSION['user_privacy'][$username]) ? $_SESSION['user_privacy'][$username] : array(
            'collect_analytics' => true,
            'collect_cookies' => true,
            'share_anonymized' => false,
            'marketing_emails' => false
        );
    }

    /**
     * 請求刪除帳戶
     */
    public function requestAccountDeletion($username, $reason = '') {
        if (!isset($_SESSION['deletion_requests'])) {
            $_SESSION['deletion_requests'] = [];
        }
        
        $_SESSION['deletion_requests'][$username] = [
            'username' => $username,
            'requestDate' => date('Y-m-d H:i:s'),
            'reason' => $reason,
            'status' => 'pending'
        ];
        
        $this->logActivity($username, 'account_deletion_request', '請求刪除帳戶', '用戶提交了帳戶刪除請求');
        
        return true;
    }
}

// 初始化用戶管理系統
$userManagement = new UserManagement();

// 設置全局變數
$currentUser = $userManagement->getCurrentUser();
$isLoggedIn = $userManagement->isLoggedIn();
$isAdmin = $userManagement->isAdmin();
?>
