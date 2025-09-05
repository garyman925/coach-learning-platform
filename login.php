<?php
/**
 * 用戶登入頁面
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/user-management.php';

// 初始化用戶管理
$userManagement = new UserManagement();

// 如果用戶已登入，重定向到首頁
if ($userManagement->isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$message = '';
$messageType = '';
$formData = [];

// 處理登入表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['remember_me']);
    
    // 保存用戶名（用於錯誤時重新填充）
    $formData = ['username' => $username];
    
    // 驗證必填欄位
    if (empty($username) || empty($password)) {
        $message = '請輸入用戶名和密碼';
        $messageType = 'error';
    } else {
        // 嘗試登入用戶
        $result = $userManagement->loginUser($username, $password, $rememberMe);
        
        if ($result['success']) {
            $message = $result['message'];
            $messageType = 'success';
            
            // 記錄登入活動
            $userManagement->logActivity($username, 'login', '登入系統', '成功登入到教練學習平台');
            
            // 2秒後重定向到首頁
            header('refresh:2;url=index.php');
        } else {
            $message = $result['message'];
            $messageType = 'error';
        }
    }
}

// 設置頁面特定變數
$pageTitle = '用戶登入 - ' . SITE_NAME;
$pageDescription = '登入教練學習平台，繼續您的學習之旅';
$pageKeywords = '用戶登入,會員登入,教練學習平台';
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
    <link rel="stylesheet" href="assets/css/utilities/variables.css">
    <link rel="stylesheet" href="assets/css/utilities/helpers.css">
    <link rel="stylesheet" href="assets/css/components/buttons.css">
    <link rel="stylesheet" href="assets/css/components/forms.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+TC:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            animation: slideInUp 0.6s ease-out;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }
        
        .login-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }
        
        .login-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin: 0;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-group input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--light-bg);
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .remember-me input[type="checkbox"] {
            width: auto;
            margin: 0;
        }
        
        .remember-me label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin: 0;
            cursor: pointer;
        }
        
        .forgot-password {
            font-size: 0.9rem;
        }
        
        .forgot-password a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        .login-button {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.3);
        }
        
        .login-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .register-link {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .message {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            text-align: center;
        }
        
        .message.success {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
            border: 1px solid rgba(25, 135, 84, 0.3);
        }
        
        .message.error {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        
        .demo-accounts {
            background: var(--light-bg);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }
        
        .demo-accounts h4 {
            margin: 0 0 1rem 0;
            color: var(--text-primary);
            font-size: 1rem;
            font-weight: 600;
        }
        
        .demo-account {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .demo-account:last-child {
            border-bottom: none;
        }
        
        .account-info {
            font-size: 0.9rem;
        }
        
        .account-role {
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .copy-button {
            background: var(--accent-color);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .copy-button:hover {
            background: var(--accent-color-dark);
            transform: scale(1.05);
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .login-container {
                padding: 1rem;
            }
            
            .login-card {
                border-radius: 16px;
            }
            
            .login-header {
                padding: 1.5rem;
            }
            
            .login-body {
                padding: 1.5rem;
            }
            
            .checkbox-group {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Login Header -->
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <h1 class="login-title">歡迎回來</h1>
                <p class="login-subtitle">登入您的帳戶繼續學習</p>
            </div>
            
            <!-- Login Body -->
            <div class="login-body">
                <!-- Message Display -->
                <?php if ($message): ?>
                    <div class="message <?php echo $messageType; ?>">
                        <?php echo e($message); ?>
                        <?php if ($messageType === 'success'): ?>
                            <br><small>2秒後將自動跳轉到首頁...</small>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Demo Accounts -->
                <div class="demo-accounts">
                    <h4><i class="fas fa-info-circle"></i> 測試帳戶</h4>
                    <div class="demo-account">
                        <div class="account-info">
                            <div>管理員帳戶</div>
                            <div class="account-role">admin</div>
                        </div>
                        <button class="copy-button" onclick="copyToClipboard('admin', 'admin123')">
                            複製
                        </button>
                    </div>
                    <div class="demo-account">
                        <div class="account-info">
                            <div>教練帳戶</div>
                            <div class="account-role">coach</div>
                        </div>
                        <button class="copy-button" onclick="copyToClipboard('coach1', 'coach123')">
                            複製
                        </button>
                    </div>
                    <div class="demo-account">
                        <div class="account-info">
                            <div>學員帳戶</div>
                            <div class="account-role">user</div>
                        </div>
                        <button class="copy-button" onclick="copyToClipboard('user1', 'user123')">
                            複製
                        </button>
                    </div>
                </div>
                
                <!-- Login Form -->
                <form method="POST" id="loginForm">
                    <div class="form-group">
                        <label for="username">用戶名或電子郵箱 <span class="required">*</span></label>
                        <input type="text" id="username" name="username" value="<?php echo e($formData['username'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">密碼 <span class="required">*</span></label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="checkbox-group">
                        <div class="remember-me">
                            <input type="checkbox" id="remember_me" name="remember_me">
                            <label for="remember_me">記住我</label>
                        </div>
                        
                                                 <div class="forgot-password">
                             <a href="<?php echo BASE_URL; ?>/forgot-password">忘記密碼？</a>
                         </div>
                    </div>
                    
                    <button type="submit" class="login-button" id="submitBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        立即登入
                    </button>
                </form>
                
                <div class="register-link">
                    還沒有帳戶？ <a href="register.php">立即註冊</a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // 複製帳戶信息到剪貼板
        function copyToClipboard(username, password) {
            const text = `用戶名: ${username}\n密碼: ${password}`;
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    showCopySuccess();
                }).catch(() => {
                    fallbackCopyTextToClipboard(text);
                });
            } else {
                fallbackCopyTextToClipboard(text);
            }
        }
        
        // 備用複製方法
        function fallbackCopyTextToClipboard(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.top = '0';
            textArea.style.left = '0';
            textArea.style.position = 'fixed';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                document.execCommand('copy');
                showCopySuccess();
            } catch (err) {
                console.error('複製失敗:', err);
            }
            
            document.body.removeChild(textArea);
        }
        
        // 顯示複製成功提示
        function showCopySuccess() {
            const button = event.target;
            const originalText = button.textContent;
            
            button.textContent = '已複製！';
            button.style.background = '#198754';
            
            setTimeout(() => {
                button.textContent = originalText;
                button.style.background = '';
            }, 2000);
        }
        
        // 自動填充測試帳戶
        function autoFillAccount(username, password) {
            document.getElementById('username').value = username;
            document.getElementById('password').value = password;
        }
        
        // 表單驗證
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                e.preventDefault();
                alert('請填寫所有必填欄位');
                return false;
            }
            
            // 顯示載入狀態
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 登入中...';
            submitBtn.disabled = true;
        });
        
        // 按Enter鍵快速登入測試帳戶
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === '1') {
                autoFillAccount('admin', 'admin123');
            } else if (e.ctrlKey && e.key === '2') {
                autoFillAccount('coach1', 'coach123');
            } else if (e.ctrlKey && e.key === '3') {
                autoFillAccount('user1', 'user123');
            }
        });
    </script>
</body>
</html>
