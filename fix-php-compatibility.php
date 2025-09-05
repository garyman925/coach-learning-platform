<?php
/**
 * PHP 兼容性修復腳本
 * 將空合併運算符 ?? 替換為 isset() 三元運算符
 */

echo "<h1>PHP 兼容性修復腳本</h1>";
echo "<p>正在修復空合併運算符兼容性問題...</p>";

// 需要修復的文件列表
$files = [
    'includes/header.php',
    'includes/user-management.php', 
    'includes/functions.php',
    'my-courses.php',
    'course-learning.php',
    'includes/header-user.php',
    'login-page.php',
    'login-handler.php'
];

$totalFixed = 0;

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<h3>檢查文件: {$file}</h3>";
        
        $content = file_get_contents($file);
        $originalContent = $content;
        
        // 修復空合併運算符
        $patterns = [
            // 簡單變量
            '/(\$[a-zA-Z_][a-zA-Z0-9_]*(?:\[[^\]]+\])*)\s*\?\?\s*([^;,\s]+)/' => 'isset($1) ? $1 : $2',
            // 數組訪問
            '/(\$[a-zA-Z_][a-zA-Z0-9_]*(?:\[[^\]]+\])*)\s*\?\?\s*array\(\)/' => 'isset($1) ? $1 : array()',
            '/(\$[a-zA-Z_][a-zA-Z0-9_]*(?:\[[^\]]+\])*)\s*\?\?\s*\[\]/' => 'isset($1) ? $1 : array()',
            // 字符串
            '/(\$[a-zA-Z_][a-zA-Z0-9_]*(?:\[[^\]]+\])*)\s*\?\?\s*[\'"]([^\'"]*)[\'"]/' => 'isset($1) ? $1 : "$2"',
        ];
        
        $fixed = 0;
        foreach ($patterns as $pattern => $replacement) {
            $newContent = preg_replace($pattern, $replacement, $content);
            if ($newContent !== $content) {
                $fixed += substr_count($content, '??') - substr_count($newContent, '??');
                $content = $newContent;
            }
        }
        
        if ($content !== $originalContent) {
            file_put_contents($file, $content);
            echo "<p style='color: green;'>✓ 修復了 {$fixed} 個空合併運算符</p>";
            $totalFixed += $fixed;
        } else {
            echo "<p style='color: blue;'>- 無需修復</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ 文件不存在: {$file}</p>";
    }
}

echo "<hr>";
echo "<h2>修復完成</h2>";
echo "<p>總共修復了 <strong>{$totalFixed}</strong> 個空合併運算符</p>";

// 檢查剩餘的空合併運算符
echo "<h3>檢查剩餘的空合併運算符</h3>";
$remainingFiles = [];
foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        if (strpos($content, '??') !== false) {
            $remainingFiles[] = $file;
        }
    }
}

if (empty($remainingFiles)) {
    echo "<p style='color: green;'>✓ 所有文件都已修復完成！</p>";
} else {
    echo "<p style='color: orange;'>⚠ 以下文件仍有空合併運算符:</p>";
    echo "<ul>";
    foreach ($remainingFiles as $file) {
        echo "<li>{$file}</li>";
    }
    echo "</ul>";
}

echo "<hr>";
echo "<p><a href='index.php'>返回首頁</a></p>";
echo "<p><em>修復時間: " . date('Y-m-d H:i:s') . "</em></p>";
?>
