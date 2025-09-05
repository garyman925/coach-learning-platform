<?php
/**
 * 管理員登出
 */

require_once '../includes/config.php';
require_once '../includes/user-management.php';

// 執行登出
$result = $userManagement->logout();

// 重定向到首頁
header('Location: /');
exit();
?>
