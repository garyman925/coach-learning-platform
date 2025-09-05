<?php
/**
 * 教練學習平台 - 配置文件
 * 包含網站基本設置、數據庫配置等
 */

// 定義安全訪問常量
define('SECURE_ACCESS', true);

// 動態檢測基礎路徑
function detectBaseUrl() {
    $host = $_SERVER['HTTP_HOST'];
    
    // 強制根據域名設置路徑 - 最優先
    if ($host === 'i-learner.com.hk') {
        return '/gary/project/coach-learning-platform-mainpage';
    }
    
    // 本地環境
    if ($host === '192.168.1.21' || $host === 'localhost') {
        return '/coach-learning-platform-mainpage';
    }
    
    // 其他環境的動態檢測
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $requestUri = $_SERVER['REQUEST_URI'];
    $path = dirname($scriptName);
    
    // 使用REQUEST_URI進行更準確的檢測
    if (strpos($requestUri, '/gary/project/coach-learning-platform-mainpage') !== false) {
        return '/gary/project/coach-learning-platform-mainpage';
    }
    
    // 檢測服務器環境 - 優先檢測更長的路徑
    if (strpos($path, '/gary/project/coach-learning-platform-mainpage') !== false) {
        return '/gary/project/coach-learning-platform-mainpage';
    }
    
    // 檢測本地環境
    if (strpos($path, '/coach-learning-platform-mainpage') !== false) {
        return '/coach-learning-platform-mainpage';
    }
    
    // 檢測是否在根目錄
    if ($path === '/' || $path === '\\' || $path === '.') {
        return '';
    }
    
    // 默認返回檢測到的路徑
    return $path;
}

// 動態檢測網站URL
function detectSiteUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = detectBaseUrl();
    
    return $protocol . '://' . $host . $baseUrl;
}

// 網站基本設置
define('SITE_NAME', '教練學習平台');
define('SITE_URL', detectSiteUrl());
define('BASE_URL', detectBaseUrl());
define('SITE_VERSION', '1.0.0');
define('SITE_DESCRIPTION', '專業的教練培訓課程和服務平台');

// 時區設置
date_default_timezone_set('Asia/Taipei');

// 錯誤報告設置（開發環境）
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 生產環境設置（部署時取消註釋）
// error_reporting(0);
// ini_set('display_errors', 0);

// 數據庫配置
define('DB_HOST', 'localhost');
define('DB_NAME', 'coach_platform');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// 會話設置
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // 生產環境設為1

// 安全設置
define('CSRF_TOKEN_NAME', 'csrf_token');
define('PASSWORD_COST', 12);

// 文件上傳設置
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
// 注意：PHP 7.0 以下版本不支持數組常量，改用函數返回
define('UPLOAD_PATH', __DIR__ . '/../uploads/');

// 緩存設置
define('CACHE_ENABLED', true);
define('CACHE_PATH', __DIR__ . '/../cache/');
define('CACHE_TIME', 3600); // 1小時

// 語言設置
define('DEFAULT_LANGUAGE', 'zh-TW');
// 注意：PHP 7.0 以下版本不支持數組常量，改用函數返回

// 分頁設置
define('ITEMS_PER_PAGE', 12);

// 開發模式
define('DEBUG_MODE', true);

// PHP 7.0 以下版本兼容函數
if (!function_exists('getAllowedImageTypes')) {
    function getAllowedImageTypes() {
        return array('jpg', 'jpeg', 'png', 'gif', 'webp');
    }
}

if (!function_exists('getAvailableLanguages')) {
    function getAvailableLanguages() {
        return array('zh-TW', 'zh-CN', 'en');
    }
}

// 自動加載函數
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// 啟動會話
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 設置安全標頭
if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
}
