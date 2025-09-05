<?php
/**
 * PHP 版本和配置信息檢查
 * 用於診斷服務器兼容性問題
 */

// 顯示 PHP 版本
echo "<h1>PHP 版本信息</h1>";
echo "<p><strong>PHP 版本:</strong> " . phpversion() . "</p>";

// 檢查關鍵功能支持
echo "<h2>功能支持檢查</h2>";

$features = array(
    '空合併運算符 (??)' => version_compare(PHP_VERSION, '7.0.0', '>='),
    '數組常量' => version_compare(PHP_VERSION, '7.0.0', '>='),
    '類型聲明' => version_compare(PHP_VERSION, '7.0.0', '>='),
    '匿名類' => version_compare(PHP_VERSION, '7.0.0', '>='),
    '標量類型聲明' => version_compare(PHP_VERSION, '7.0.0', '>='),
    '返回類型聲明' => version_compare(PHP_VERSION, '7.0.0', '>='),
    'null 合併運算符' => version_compare(PHP_VERSION, '7.0.0', '>='),
    '太空船運算符' => version_compare(PHP_VERSION, '7.0.0', '>=')
);

echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>功能</th><th>支持狀態</th></tr>";
foreach ($features as $feature => $supported) {
    $status = $supported ? '<span style="color: green;">✓ 支持</span>' : '<span style="color: red;">✗ 不支持</span>';
    echo "<tr><td>{$feature}</td><td>{$status}</td></tr>";
}
echo "</table>";

// 顯示 PHP 配置
echo "<h2>重要 PHP 配置</h2>";
echo "<ul>";
echo "<li><strong>session.auto_start:</strong> " . ini_get('session.auto_start') . "</li>";
echo "<li><strong>session.cookie_httponly:</strong> " . ini_get('session.cookie_httponly') . "</li>";
echo "<li><strong>session.use_strict_mode:</strong> " . ini_get('session.use_strict_mode') . "</li>";
echo "<li><strong>upload_max_filesize:</strong> " . ini_get('upload_max_filesize') . "</li>";
echo "<li><strong>post_max_size:</strong> " . ini_get('post_max_size') . "</li>";
echo "<li><strong>max_execution_time:</strong> " . ini_get('max_execution_time') . "</li>";
echo "<li><strong>memory_limit:</strong> " . ini_get('memory_limit') . "</li>";
echo "</ul>";

// 檢查擴展
echo "<h2>重要 PHP 擴展</h2>";
$extensions = array('mysqli', 'pdo', 'pdo_mysql', 'json', 'mbstring', 'openssl', 'curl', 'gd', 'zip');
echo "<ul>";
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    $status = $loaded ? '<span style="color: green;">✓ 已加載</span>' : '<span style="color: red;">✗ 未加載</span>';
    echo "<li><strong>{$ext}:</strong> {$status}</li>";
}
echo "</ul>";

// 建議
echo "<h2>建議</h2>";
if (version_compare(PHP_VERSION, '7.0.0', '<')) {
    echo "<div style='background: #ffebee; padding: 15px; border-left: 4px solid #f44336;'>";
    echo "<h3 style='color: #d32f2f; margin-top: 0;'>PHP 版本過舊</h3>";
    echo "<p>您的服務器使用 PHP " . phpversion() . "，建議升級到 PHP 7.4 或更高版本以獲得更好的性能和安全性。</p>";
    echo "<p>如果無法升級，我們已經修復了代碼以兼容舊版本 PHP。</p>";
    echo "</div>";
} else {
    echo "<div style='background: #e8f5e8; padding: 15px; border-left: 4px solid #4caf50;'>";
    echo "<h3 style='color: #2e7d32; margin-top: 0;'>PHP 版本良好</h3>";
    echo "<p>您的 PHP 版本 " . phpversion() . " 支持所有現代功能。</p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><em>檢查完成時間: " . date('Y-m-d H:i:s') . "</em></p>";
echo "<p><a href='index.php'>返回首頁</a></p>";
?>
