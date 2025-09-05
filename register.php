<?php
/**
 * 用戶註冊頁面
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/user-management.php';

// 如果用戶已登入，重定向到首頁
if ($isLoggedIn) {
    header('Location: /');
    exit;
}

$message = '';
$messageType = '';
$formData = [];

// 處理註冊表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(isset($_POST['username']) ? $_POST['username'] : '');
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $firstName = trim(isset($_POST['first_name']) ? $_POST['first_name'] : '');
    $lastName = trim(isset($_POST['last_name']) ? $_POST['last_name'] : '');
    $phone = trim(isset($_POST['phone']) ? $_POST['phone'] : '');
    $agreeTerms = isset($_POST['agree_terms']);
    
    // 保存表單數據（用於錯誤時重新填充）
    $formData = [
        'username' => $username,
        'email' => $email,
        'first_name' => $firstName,
        'last_name' => $lastName,
        'phone' => $phone
    ];
    
    // 驗證必填欄位
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword) || empty($firstName) || empty($lastName)) {
        $message = '所有必填欄位都必須填寫';
        $messageType = 'error';
    }
    // 驗證密碼確認
    elseif ($password !== $confirmPassword) {
        $message = '密碼確認不匹配';
        $messageType = 'error';
    }
    // 驗證密碼長度
    elseif (strlen($password) < 6) {
        $message = '密碼長度至少需要6個字符';
        $messageType = 'error';
    }
    // 驗證郵箱格式
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = '請輸入有效的郵箱地址';
        $messageType = 'error';
    }
    // 驗證用戶名格式
    elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $message = '用戶名只能包含字母、數字和下劃線，長度3-20個字符';
        $messageType = 'error';
    }
    // 驗證同意條款
    elseif (!$agreeTerms) {
        $message = '請同意服務條款和隱私政策';
        $messageType = 'error';
    }
    else {
        // 嘗試註冊用戶
        $result = $userManagement->registerUser($username, $email, $password, $firstName, $lastName, $phone);
        
        if ($result['success']) {
            $message = $result['message'];
            $messageType = 'success';
            $formData = []; // 清空表單數據
            
            // 3秒後重定向到首頁
            header('refresh:3;url=/');
        } else {
            $message = $result['message'];
            $messageType = 'error';
        }
    }
}

// 設置頁面特定變數
$pageTitle = '用戶註冊 - ' . SITE_NAME;
$pageDescription = '加入教練學習平台，開始您的學習之旅';
$pageKeywords = '用戶註冊,會員註冊,教練學習平台';
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
    <link rel="stylesheet" href="/coach-learning-platform-mainpage/assets/css/utilities/variables.css">
    <link rel="stylesheet" href="/coach-learning-platform-mainpage/assets/css/utilities/helpers.css">
    <link rel="stylesheet" href="/coach-learning-platform-mainpage/assets/css/components/buttons.css">
    <link rel="stylesheet" href="/coach-learning-platform-mainpage/assets/css/components/forms.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+TC:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .register-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
            animation: slideInUp 0.6s ease-out;
        }
        
        .register-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .register-logo {
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
        
        .register-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }
        
        .register-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin: 0;
        }
        
        .register-body {
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
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin: 0;
            margin-top: 0.25rem;
        }
        
        .checkbox-group label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.4;
            margin: 0;
        }
        
        .checkbox-group a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .checkbox-group a:hover {
            text-decoration: underline;
        }
        
        .register-button {
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
        
        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.3);
        }
        
        .register-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .login-link {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
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
        
        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.8rem;
        }
        
        .strength-bar {
            height: 4px;
            background: var(--border-color);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }
        
        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .strength-weak {
            background: #dc3545;
            width: 25%;
        }
        
        .strength-fair {
            background: #ffc107;
            width: 50%;
        }
        
        .strength-good {
            background: #fd7e14;
            width: 75%;
        }
        
        .strength-strong {
            background: #198754;
            width: 100%;
        }
        
        .strength-text {
            color: var(--text-secondary);
            font-size: 0.75rem;
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
            .register-container {
                padding: 1rem;
            }
            
            .register-card {
                border-radius: 16px;
            }
            
            .register-header {
                padding: 1.5rem;
            }
            
            .register-body {
                padding: 1.5rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <!-- Register Header -->
            <div class="register-header">
                <div class="register-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1 class="register-title">加入我們</h1>
                <p class="register-subtitle">開始您的教練學習之旅</p>
            </div>
            
            <!-- Register Body -->
            <div class="register-body">
                <!-- Message Display -->
                <?php if ($message): ?>
                    <div class="message <?php echo $messageType; ?>">
                        <?php echo e($message); ?>
                        <?php if ($messageType === 'success'): ?>
                            <br><small>3秒後將自動跳轉到首頁...</small>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Register Form -->
                <form method="POST" id="registerForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">姓氏 <span class="required">*</span></label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo e(isset($formData['first_name']) ? $formData['first_name'] : ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name">名字 <span class="required">*</span></label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo e(isset($formData['last_name']) ? $formData['last_name'] : ''); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="username">用戶名 <span class="required">*</span></label>
                        <input type="text" id="username" name="username" value="<?php echo e(isset($formData['username']) ? $formData['username'] : ''); ?>" required 
                               pattern="[a-zA-Z0-9_]{3,20}" 
                               title="用戶名只能包含字母、數字和下劃線，長度3-20個字符">
                        <small class="help-text">用戶名只能包含字母、數字和下劃線，長度3-20個字符</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">電子郵箱 <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="<?php echo e(isset($formData['email']) ? $formData['email'] : ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">聯絡電話</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo e(isset($formData['phone']) ? $formData['phone'] : ''); ?>" 
                               pattern="[0-9\-\(\)\s]+" title="請輸入有效的電話號碼">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">密碼 <span class="required">*</span></label>
                        <input type="password" id="password" name="password" required minlength="6">
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <div class="strength-text" id="strengthText">請輸入密碼</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">確認密碼 <span class="required">*</span></label>
                        <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="agree_terms" name="agree_terms" required>
                        <label for="agree_terms">
                            我同意 <a href="/terms" target="_blank">服務條款</a> 和 <a href="/privacy" target="_blank">隱私政策</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="register-button" id="submitBtn">
                        <i class="fas fa-user-plus"></i>
                        立即註冊
                    </button>
                </form>
                
                <div class="login-link">
                    已有帳戶？ <a href="/login">立即登入</a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // 密碼強度檢查
        const passwordInput = document.getElementById('password');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const submitBtn = document.getElementById('submitBtn');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let text = '';
            let className = '';
            
            if (password.length >= 6) strength++;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            switch (strength) {
                case 0:
                case 1:
                    text = '密碼強度：弱';
                    className = 'strength-weak';
                    break;
                case 2:
                case 3:
                    text = '密碼強度：一般';
                    className = 'strength-fair';
                    break;
                case 4:
                case 5:
                    text = '密碼強度：良好';
                    className = 'strength-good';
                    break;
                case 6:
                    text = '密碼強度：強';
                    className = 'strength-strong';
                    break;
            }
            
            strengthFill.className = `strength-fill ${className}`;
            strengthText.textContent = text;
        });
        
        // 密碼確認檢查
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (confirmPassword && password !== confirmPassword) {
                confirmPasswordInput.setCustomValidity('密碼確認不匹配');
                submitBtn.disabled = true;
            } else {
                confirmPasswordInput.setCustomValidity('');
                submitBtn.disabled = false;
            }
        }
        
        passwordInput.addEventListener('input', checkPasswordMatch);
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
        
        // 表單驗證
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('密碼確認不匹配');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('密碼長度至少需要6個字符');
                return false;
            }
            
            // 顯示載入狀態
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 註冊中...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>
