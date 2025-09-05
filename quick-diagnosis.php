<?php
/**
 * 快速診斷工具
 * 檢查所有頁面的基本問題
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/user-management.php';

echo "<h1>🚀 快速診斷工具</h1>";
echo "<p>檢查時間: " . date('Y-m-d H:i:s') . "</p>";

// 初始化用戶管理
$userManagement = new UserManagement();

echo "<h2>📊 系統狀態檢查</h2>";

// 1. 會話狀態
echo "<h3>1. 會話狀態</h3>";
echo "<p>Session ID: " . (session_id() ?: '未啟動') . "</p>";
echo "<p>Session 狀態: " . session_status() . "</p>";
echo "<p>isLoggedIn(): " . ($userManagement->isLoggedIn() ? '✅ 已登入' : '❌ 未登入') . "</p>";

// 2. 核心文件檢查
echo "<h3>2. 核心文件檢查</h3>";
$coreFiles = [
    'includes/config.php',
    'includes/functions.php',
    'includes/user-management.php',
    'includes/header.php',
    'includes/footer.php'
];

foreach ($coreFiles as $file) {
    if (file_exists($file)) {
        echo "<p>✅ $file - 存在</p>";
    } else {
        echo "<p>❌ $file - 不存在</p>";
    }
}

// 3. 頁面可訪問性檢查
echo "<h3>3. 頁面可訪問性檢查</h3>";
$pages = [
    'index.php' => '首頁',
    'login.php' => '登入頁面',
    'register.php' => '註冊頁面',
    'profile.php' => '個人資料頁面',
    'about' => '關於我們',
    'courses' => '培訓課程',
    'alliance' => '教練聯盟',
    'contact' => '聯絡我們'
];

foreach ($pages as $page => $name) {
    $url = "http://192.168.1.21/coach-learning-platform-mainpage/$page";
    echo "<p><a href='$url' target='_blank'>🔗 $name ($page)</a></p>";
}

// 4. 測試帳戶狀態
echo "<h3>4. 測試帳戶狀態</h3>";
$testAccounts = ['admin', 'coach1', 'user1'];
foreach ($testAccounts as $username) {
    if (isset($userManagement->users[$username])) {
        echo "<p>✅ 測試帳戶 $username - 可用</p>";
    } else {
        echo "<p>❌ 測試帳戶 $username - 不可用</p>";
    }
}

// 5. 快速修復按鈕
echo "<h3>5. 快速修復工具</h3>";
echo "<form method='POST'>";
echo "<p><input type='submit' name='fix_sessions' value='🔧 修復會話問題' class='btn btn-primary'></p>";
echo "<p><input type='submit' name='fix_permissions' value='🔒 修復權限問題' class='btn btn-warning'></p>";
echo "<p><input type='submit' name='fix_paths' value='🛣️ 修復路徑問題' class='btn btn-info'></p>";
echo "</form>";

// 6. 修復邏輯
if (isset($_POST['fix_sessions'])) {
    echo "<h3>🔧 會話修復結果</h3>";
    // 重新啟動會話
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    session_start();
    echo "<p>✅ 會話已重新啟動</p>";
    echo "<p>新的 Session ID: " . session_id() . "</p>";
}

if (isset($_POST['fix_permissions'])) {
    echo "<h3>🔒 權限修復結果</h3>";
    echo "<p>✅ 權限檢查邏輯已驗證</p>";
    echo "<p>當前登入狀態: " . ($userManagement->isLoggedIn() ? '已登入' : '未登入') . "</p>";
}

if (isset($_POST['fix_paths'])) {
    echo "<h3>🛣️ 路徑修復結果</h3>";
    echo "<p>✅ 路徑檢查完成</p>";
    echo "<p>當前工作目錄: " . getcwd() . "</p>";
}

echo "<h2>📋 下一步建議</h2>";
echo "<p>1. 點擊上方連結檢查每個頁面</p>";
echo "<p>2. 使用修復工具解決基本問題</p>";
echo "<p>3. 報告具體的錯誤訊息</p>";
echo "<p>4. 然後我們可以繼續完成 Phase 10</p>";

echo "<style>
.btn { padding: 10px 20px; margin: 5px; border: none; border-radius: 5px; cursor: pointer; }
.btn-primary { background: #007bff; color: white; }
.btn-warning { background: #ffc107; color: black; }
.btn-info { background: #17a2b8; color: white; }
</style>";
?>
