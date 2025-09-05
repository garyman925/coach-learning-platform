<?php
/**
 * 教練學習平台 - 獨立登入頁面
 */

require_once 'includes/config.php';

// 如果已經登入，重定向到 my-courses
if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/my-courses');
    exit;
}

// 設置頁面特定變數
$pageTitle = '登入 - ' . SITE_NAME;
$pageDescription = '登入教練學習平台，開始您的學習之旅';
$pageKeywords = '登入,用戶登入,教練平台,學習平台';
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo $pageDescription; ?>">
    <meta name="keywords" content="<?php echo $pageKeywords; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo BASE_URL; ?>/assets/images/favicon.svg">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/buttons.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components/forms.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/pages/auth.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="auth-page">
    <!-- 背景圖片 -->
    <div class="auth-background">
        <div class="auth-overlay"></div>
    </div>
    
    <!-- 登入容器 -->
    <div class="auth-container">
        <div class="auth-card">
            <!-- Logo 和標題 -->
            <div class="auth-header">
                <div class="auth-logo">
                    <img src="<?php echo BASE_URL; ?>/assets/images/logos/logo-main.svg" alt="<?php echo SITE_NAME; ?>" class="logo-img">
                </div>
                <h1 class="auth-title">歡迎回來</h1>
                <p class="auth-subtitle">登入您的帳戶以繼續學習</p>
            </div>
            
            <!-- 登入表單 -->
            <form id="loginForm" class="auth-form">
                <div class="form-group">
                    <label for="loginEmail">電子郵件</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="loginEmail" name="email" required placeholder="請輸入您的電子郵件">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="loginPassword">密碼</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="loginPassword" name="password" required placeholder="請輸入您的密碼">
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="passwordToggleIcon"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" id="rememberMe" name="rememberMe">
                        <span class="checkmark"></span>
                        記住我
                    </label>
                    <a href="<?php echo BASE_URL; ?>/forgot-password" class="forgot-link">忘記密碼？</a>
                </div>
                
                <button type="submit" class="btn btn-primary btn-large auth-submit">
                    <i class="fas fa-sign-in-alt"></i>
                    登入
                </button>
            </form>
            
            <!-- 註冊連結 -->
            <div class="auth-footer">
                <p>還沒有帳戶？ <a href="<?php echo BASE_URL; ?>/register" class="register-link">立即註冊</a></p>
                <div class="back-to-home">
                    <a href="<?php echo BASE_URL; ?>/" class="back-link">
                        <i class="fas fa-arrow-left"></i>
                        返回首頁
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="<?php echo BASE_URL; ?>/assets/js/utils/helpers.js"></script>
    <script>
        // 密碼顯示/隱藏切換
        function togglePassword() {
            const passwordInput = document.getElementById('loginPassword');
            const toggleIcon = document.getElementById('passwordToggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // 登入表單處理
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const email = formData.get('email');
            const password = formData.get('password');
            const rememberMe = formData.get('rememberMe');
            
            // 簡單的客戶端驗證
            if (!email || !password) {
                showNotification('請填寫所有必填欄位', 'error');
                return;
            }
            
            // 模擬登入處理
            const submitBtn = document.querySelector('.auth-submit');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 登入中...';
            submitBtn.disabled = true;
            
            // 模擬 API 請求
            setTimeout(() => {
                // 這裡應該是真實的登入 API 調用
                // 目前使用模擬數據
                const mockUsers = [
                    { email: 'admin@example.com', password: 'admin123', name: '管理員' },
                    { email: 'user@example.com', password: 'user123', name: '用戶' }
                ];
                
                const user = mockUsers.find(u => u.email === email && u.password === password);
                
                if (user) {
                    // 登入成功
                    showNotification('登入成功！正在跳轉...', 'success');
                    
                    // 使用表單提交到後端處理登入
                    setTimeout(() => {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '<?php echo BASE_URL; ?>/login-handler.php';
                        
                        const emailInput = document.createElement('input');
                        emailInput.type = 'hidden';
                        emailInput.name = 'email';
                        emailInput.value = email;
                        
                        const passwordInput = document.createElement('input');
                        passwordInput.type = 'hidden';
                        passwordInput.name = 'password';
                        passwordInput.value = password;
                        
                        form.appendChild(emailInput);
                        form.appendChild(passwordInput);
                        document.body.appendChild(form);
                        form.submit();
                    }, 1500);
                } else {
                    // 登入失敗
                    showNotification('電子郵件或密碼錯誤', 'error');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 2000);
        });
        
        // 顯示通知
        function showNotification(message, type = 'info') {
            // 創建通知元素
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            // 添加到頁面
            document.body.appendChild(notification);
            
            // 顯示動畫
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            // 自動隱藏
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>
