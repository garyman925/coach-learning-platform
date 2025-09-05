<?php
require_once 'includes/config.php';
require_once 'includes/header.php';
require_once 'includes/user-management.php';

// 初始化用戶管理系統
$userManagement = new UserManagement();

// 檢查重置令牌
$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

$isValidToken = false;
$message = '';
$messageType = '';

// 驗證令牌
if ($token && $email) {
    // 在實際應用中，這裡會從數據庫驗證令牌
    // 現在我們使用 session 來模擬
    if (isset($_SESSION['reset_token']) && 
        isset($_SESSION['reset_email']) && 
        isset($_SESSION['reset_expiry']) &&
        $_SESSION['reset_token'] === $token &&
        $_SESSION['reset_email'] === $email &&
        time() < $_SESSION['reset_expiry']) {
        $isValidToken = true;
    } else {
        $message = '無效或已過期的重置連結，請重新申請密碼重置。';
        $messageType = 'error';
    }
} else {
    $message = '缺少必要的參數，請檢查您的重置連結。';
    $messageType = 'error';
}

// 處理新密碼設置
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isValidToken) {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($newPassword) || empty($confirmPassword)) {
        $message = '請填寫所有必填欄位';
        $messageType = 'error';
    } elseif (strlen($newPassword) < 8) {
        $message = '密碼長度至少需要8個字符';
        $messageType = 'error';
    } elseif ($newPassword !== $confirmPassword) {
        $message = '兩次輸入的密碼不一致';
        $messageType = 'error';
    } else {
        // 更新密碼
        $user = $userManagement->getUserByEmail($email);
        if ($user) {
            $success = $userManagement->changePassword($user['username'], '', $newPassword);
            if ($success) {
                // 清除重置令牌
                unset($_SESSION['reset_token']);
                unset($_SESSION['reset_email']);
                unset($_SESSION['reset_expiry']);
                
                $message = '密碼重置成功！請使用新密碼登入。';
                $messageType = 'success';
                
                // 3秒後跳轉到登入頁面
                header('refresh:3;url=' . BASE_URL . '/login');
            } else {
                $message = '密碼重置失敗，請重試。';
                $messageType = 'error';
            }
        } else {
            $message = '用戶不存在，請檢查您的重置連結。';
            $messageType = 'error';
        }
    }
}
?>

<main class="reset-password-page">
    <!-- Hero Section -->
    <section class="reset-password-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title" data-animate="fadeInUp">重置密碼</h1>
                <p class="hero-description" data-animate="fadeInUp" data-delay="200">
                    <?php if ($isValidToken): ?>
                        請設置您的新密碼
                    <?php else: ?>
                        密碼重置連結無效或已過期
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </section>

    <!-- 密碼重置表單 -->
    <section class="reset-password-form-section">
        <div class="container">
            <div class="form-container">
                <div class="form-card">
                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $messageType; ?>" role="alert">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($isValidToken): ?>
                        <div class="form-header">
                            <h2 class="form-title">設置新密碼</h2>
                            <p class="form-description">
                                請為您的帳戶設置一個新的安全密碼
                            </p>
                        </div>

                        <form method="POST" class="reset-password-form" data-animate="fadeInUp" data-delay="300">
                            <div class="form-group">
                                <label for="new_password" class="form-label">新密碼</label>
                                <div class="input-group">
                                    <div class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15 7.5V5.5C15 4.11929 13.8807 3 12.5 3H7.5C6.11929 3 5 4.11929 5 5.5V7.5M15 7.5H5M15 7.5V16.5C15 17.8807 13.8807 19 12.5 19H7.5C6.11929 19 5 17.8807 5 16.5V7.5M10 11.5V14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <input 
                                        type="password" 
                                        id="new_password" 
                                        name="new_password" 
                                        class="form-input" 
                                        placeholder="請輸入新密碼"
                                        required
                                        minlength="8"
                                    >
                                    <button type="button" class="password-toggle" onclick="togglePassword('new_password')">
                                        <svg class="eye-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M1 10C1 10 4 4 10 4C16 4 19 10 19 10C19 10 16 16 10 16C4 16 1 10 1 10Z" stroke="currentColor" stroke-width="1.5"/>
                                            <circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.5"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="password-requirements">
                                    <p class="requirement-text">密碼要求：</p>
                                    <ul class="requirement-list">
                                        <li class="requirement-item" data-requirement="length">
                                            <span class="requirement-icon">✗</span>
                                            至少8個字符
                                        </li>
                                        <li class="requirement-item" data-requirement="match">
                                            <span class="requirement-icon">✗</span>
                                            兩次輸入的密碼一致
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password" class="form-label">確認新密碼</label>
                                <div class="input-group">
                                    <div class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15 7.5V5.5C15 4.11929 13.8807 3 12.5 3H7.5C6.11929 3 5 4.11929 5 5.5V7.5M15 7.5H5M15 7.5V16.5C15 17.8807 13.8807 19 12.5 19H7.5C6.11929 19 5 17.8807 5 16.5V7.5M10 11.5V14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <input 
                                        type="password" 
                                        id="confirm_password" 
                                        name="confirm_password" 
                                        class="form-input" 
                                        placeholder="請再次輸入新密碼"
                                        required
                                        minlength="8"
                                    >
                                    <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')">
                                        <svg class="eye-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M1 10C1 10 4 4 10 4C16 4 19 10 19 10C19 10 16 16 10 16C4 16 1 10 1 10Z" stroke="currentColor" stroke-width="1.5"/>
                                            <circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.5"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary btn-full">
                                    <span class="btn-text">重置密碼</span>
                                    <div class="btn-loading" style="display: none;">
                                        <div class="spinner"></div>
                                        <span>處理中...</span>
                                    </div>
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="error-content">
                            <div class="error-icon">
                                <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                                    <circle cx="32" cy="32" r="30" stroke="currentColor" stroke-width="2"/>
                                    <path d="M20 20L44 44M44 20L20 44" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <h3 class="error-title">連結無效</h3>
                            <p class="error-description">
                                您的密碼重置連結已過期或無效，請重新申請密碼重置。
                            </p>
                            <div class="error-actions">
                                <a href="<?php echo BASE_URL; ?>/forgot-password" class="btn btn-primary">
                                    重新申請重置
                                </a>
                                <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline">
                                    返回登入
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* 重置密碼頁面樣式 */
.reset-password-page {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--primary-50) 0%, var(--accent-50) 100%);
}

.reset-password-hero {
    padding: var(--spacing-20) 0 var(--spacing-16);
    text-align: center;
}

.hero-title {
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    font-weight: 700;
    color: var(--neutral-900);
    margin-bottom: var(--spacing-4);
}

.hero-description {
    font-size: var(--text-lg);
    color: var(--neutral-600);
    max-width: 600px;
    margin: 0 auto;
}

.reset-password-form-section {
    padding: var(--spacing-16) 0;
}

.form-container {
    max-width: 500px;
    margin: 0 auto;
}

.form-card {
    background: white;
    border-radius: var(--radius-xl);
    padding: var(--spacing-8);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--neutral-200);
}

.form-header {
    text-align: center;
    margin-bottom: var(--spacing-8);
}

.form-title {
    font-size: var(--text-2xl);
    font-weight: 600;
    color: var(--neutral-900);
    margin-bottom: var(--spacing-2);
}

.form-description {
    color: var(--neutral-600);
    font-size: var(--text-base);
}

.reset-password-form {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-6);
}

.input-group {
    position: relative;
}

.input-icon {
    position: absolute;
    left: var(--spacing-4);
    top: 50%;
    transform: translateY(-50%);
    color: var(--neutral-400);
    z-index: 2;
}

.password-toggle {
    position: absolute;
    right: var(--spacing-4);
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--neutral-400);
    cursor: pointer;
    padding: var(--spacing-1);
    border-radius: var(--radius-sm);
    transition: color 0.2s ease;
}

.password-toggle:hover {
    color: var(--neutral-600);
}

.form-input {
    width: 100%;
    padding: var(--spacing-4) 3rem var(--spacing-4) 3rem;
    border: 2px solid var(--neutral-300);
    border-radius: var(--radius-lg);
    font-size: var(--text-base);
    background-color: #f4f4f4;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-500);
    background-color: #ffffff;
    box-shadow: 0 0 0 3px var(--primary-100);
    transform: translateY(-1px);
}

.form-input:hover {
    background-color: #f8f8f8;
    border-color: var(--neutral-400);
}

.password-requirements {
    margin-top: var(--spacing-3);
    padding: var(--spacing-3);
    background: var(--neutral-50);
    border-radius: var(--radius-md);
    border: 1px solid var(--neutral-200);
}

.requirement-text {
    font-size: var(--text-sm);
    font-weight: 500;
    color: var(--neutral-700);
    margin-bottom: var(--spacing-2);
}

.requirement-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.requirement-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-2);
    font-size: var(--text-sm);
    color: var(--neutral-600);
    margin-bottom: var(--spacing-1);
}

.requirement-item:last-child {
    margin-bottom: 0;
}

.requirement-icon {
    font-size: var(--text-xs);
    font-weight: bold;
}

.requirement-item.valid .requirement-icon {
    color: var(--success-500);
}

.requirement-item.invalid .requirement-icon {
    color: var(--error-500);
}

.btn-full {
    width: 100%;
    justify-content: center;
}

.btn-loading {
    display: flex;
    align-items: center;
    gap: var(--spacing-2);
}

.spinner {
    width: 16px;
    height: 16px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* 錯誤內容樣式 */
.error-content {
    text-align: center;
    padding: var(--spacing-8) 0;
}

.error-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto var(--spacing-6);
    color: var(--error-500);
}

.error-title {
    font-size: var(--text-xl);
    font-weight: 600;
    color: var(--neutral-900);
    margin-bottom: var(--spacing-3);
}

.error-description {
    color: var(--neutral-600);
    margin-bottom: var(--spacing-8);
    line-height: 1.6;
}

.error-actions {
    display: flex;
    gap: var(--spacing-4);
    justify-content: center;
    flex-wrap: wrap;
}

/* 響應式設計 */
@media (max-width: 768px) {
    .reset-password-hero {
        padding: var(--spacing-16) 0 var(--spacing-12);
    }
    
    .form-card {
        padding: var(--spacing-6);
        margin: 0 var(--spacing-4);
    }
    
    .error-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .error-actions .btn {
        width: 100%;
        max-width: 200px;
    }
}
</style>

<script>
// 密碼顯示/隱藏切換
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    const eyeIcon = button.querySelector('.eye-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.innerHTML = `
            <path d="M1 10C1 10 4 4 10 4C16 4 19 10 19 10C19 10 16 16 10 16C4 16 1 10 1 10Z" stroke="currentColor" stroke-width="1.5"/>
            <path d="M3 3L17 17M17 3L3 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        `;
    } else {
        input.type = 'password';
        eyeIcon.innerHTML = `
            <path d="M1 10C1 10 4 4 10 4C16 4 19 10 19 10C19 10 16 16 10 16C4 16 1 10 1 10Z" stroke="currentColor" stroke-width="1.5"/>
            <circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.5"/>
        `;
    }
}

// 密碼驗證
document.addEventListener('DOMContentLoaded', function() {
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const form = document.querySelector('.reset-password-form');
    const submitBtn = form.querySelector('button[type="submit"]');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    
    function validatePassword() {
        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        // 檢查密碼長度
        const lengthRequirement = document.querySelector('[data-requirement="length"]');
        if (newPassword.length >= 8) {
            lengthRequirement.classList.add('valid');
            lengthRequirement.classList.remove('invalid');
            lengthRequirement.querySelector('.requirement-icon').textContent = '✓';
        } else {
            lengthRequirement.classList.add('invalid');
            lengthRequirement.classList.remove('valid');
            lengthRequirement.querySelector('.requirement-icon').textContent = '✗';
        }
        
        // 檢查密碼匹配
        const matchRequirement = document.querySelector('[data-requirement="match"]');
        if (newPassword && confirmPassword && newPassword === confirmPassword) {
            matchRequirement.classList.add('valid');
            matchRequirement.classList.remove('invalid');
            matchRequirement.querySelector('.requirement-icon').textContent = '✓';
        } else {
            matchRequirement.classList.add('invalid');
            matchRequirement.classList.remove('valid');
            matchRequirement.querySelector('.requirement-icon').textContent = '✗';
        }
    }
    
    newPasswordInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validatePassword);
    
    // 表單提交處理
    form.addEventListener('submit', function(e) {
        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (newPassword.length < 8 || newPassword !== confirmPassword) {
            e.preventDefault();
            return;
        }
        
        // 顯示載入狀態
        btnText.style.display = 'none';
        btnLoading.style.display = 'flex';
        submitBtn.disabled = true;
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
