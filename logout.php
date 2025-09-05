<?php
/**
 * 教練學習平台 - 用戶登出
 */

require_once 'includes/config.php';

// 開始會話
session_start();

// 清除所有會話變數
$_SESSION = array();

// 刪除會話 cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 銷毀會話
session_destroy();

// 重定向到首頁
header('Location: ' . BASE_URL . '/');
exit;
?>
