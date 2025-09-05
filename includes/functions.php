<?php
/**
 * 教練學習平台 - 通用函數
 * 包含常用的輔助函數
 */

// 防止直接訪問
if (!defined('SECURE_ACCESS')) {
    http_response_code(403);
    exit('直接訪問被禁止');
}

/**
 * 安全輸出HTML
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * 生成CSRF令牌
 */
function generateCSRFToken() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * 驗證CSRF令牌
 */
function validateCSRFToken($token) {
    return isset($_SESSION[CSRF_TOKEN_NAME]) && 
           hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

/**
 * 重定向到指定URL
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * 獲取當前頁面URL
 */
function getCurrentURL() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    return $protocol . '://' . $host . $uri;
}

/**
 * 獲取基礎URL
 */
function getBaseURL() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['SCRIPT_NAME']);
    return $protocol . '://' . $host . $path;
}

/**
 * 生成隨機字符串
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

/**
 * 格式化日期
 */
function formatDate($date, $format = 'Y-m-d H:i:s') {
    if (is_string($date)) {
        $date = new DateTime($date);
    }
    return $date->format($format);
}

/**
 * 計算時間差
 */
function timeAgo($datetime) {
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;
    
    if ($diff < 60) {
        return '剛剛';
    } elseif ($diff < 3600) {
        return floor($diff / 60) . '分鐘前';
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . '小時前';
    } elseif ($diff < 2592000) {
        return floor($diff / 86400) . '天前';
    } else {
        return formatDate($datetime, 'Y-m-d');
    }
}

/**
 * 截取字符串
 */
function truncate($string, $length = 100, $suffix = '...') {
    if (mb_strlen($string) <= $length) {
        return $string;
    }
    return mb_substr($string, 0, $length) . $suffix;
}

/**
 * 生成SEO友好的URL
 */
function generateSlug($string) {
    // 轉換為小寫
    $string = mb_strtolower($string, 'UTF-8');
    
    // 替換中文字符
    $string = str_replace([' ', '_', '-'], '-', $string);
    
    // 移除特殊字符
    $string = preg_replace('/[^a-z0-9\-]/', '', $string);
    
    // 移除多餘的連字符
    $string = preg_replace('/-+/', '-', $string);
    
    // 移除首尾連字符
    return trim($string, '-');
}

/**
 * 檢查是否為AJAX請求
 */
function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * 返回JSON響應
 */
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * 記錄日誌
 */
function logMessage($message, $level = 'INFO', $file = 'app.log') {
    $logDir = __DIR__ . '/../logs/';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $logFile = $logDir . $file;
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] [{$level}] {$message}" . PHP_EOL;
    
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

/**
 * 獲取客戶端IP地址
 */
function getClientIP() {
    $ipKeys = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_CLIENT_IP', 'HTTP_X_REAL_IP', 'REMOTE_ADDR'];
    
    foreach ($ipKeys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
    
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
}

/**
 * 檢查是否為移動設備
 */
function isMobileDevice() {
    $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $mobileKeywords = ['Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone'];
    
    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            return true;
        }
    }
    
    return false;
}

/**
 * 獲取文件擴展名
 */
function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * 檢查文件類型是否允許
 */
function isAllowedFileType($filename) {
    $extension = getFileExtension($filename);
    return in_array($extension, ALLOWED_IMAGE_TYPES);
}

/**
 * 創建縮略圖
 */
function createThumbnail($sourcePath, $destinationPath, $width = 300, $height = 300) {
    if (!file_exists($sourcePath)) {
        return false;
    }
    
    $imageInfo = getimagesize($sourcePath);
    if (!$imageInfo) {
        return false;
    }
    
    $sourceWidth = $imageInfo[0];
    $sourceHeight = $imageInfo[1];
    $sourceType = $imageInfo[2];
    
    // 計算縮放比例
    $ratio = min($width / $sourceWidth, $height / $sourceHeight);
    $newWidth = round($sourceWidth * $ratio);
    $newHeight = round($sourceHeight * $ratio);
    
    // 創建目標圖像
    $destinationImage = imagecreatetruecolor($newWidth, $newHeight);
    
    // 根據源圖像類型創建源圖像
    switch ($sourceType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        default:
            return false;
    }
    
    // 調整圖像大小
    imagecopyresampled($destinationImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);
    
    // 保存縮略圖
    $result = imagejpeg($destinationImage, $destinationPath, 85);
    
    // 釋放內存
    imagedestroy($sourceImage);
    imagedestroy($destinationImage);
    
    return $result;
}
