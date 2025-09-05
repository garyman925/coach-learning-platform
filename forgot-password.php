<?php
require_once 'includes/config.php';
require_once 'includes/header.php';
require_once 'includes/user-management.php';

// 初始化用戶管理系統
$userManagement = new UserManagement();

// 處理表單提交
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    
    if (empty($email)) {
        $message = '請輸入電子郵件地址';
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = '請輸入有效的電子郵件地址';
        $messageType = 'error';
    } else {
        // 檢查用戶是否存在
        $user = $userManagement->getUserByEmail($email);
        
        if ($user) {
            // 生成重置令牌（模擬）
            $resetToken = bin2hex(random_bytes(32));
            $expiryTime = time() + 3600; // 1小時後過期
            
            // 在實際應用中，這裡會發送郵件
            // 現在我們模擬發送成功
            $message = '密碼重置連結已發送到您的電子郵件地址，請檢查您的收件箱。';
            $messageType = 'success';
            
            // 在實際應用中，這裡會保存令牌到數據庫
            // 現在我們使用 session 來模擬
            $_SESSION['reset_token'] = $resetToken;
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_expiry'] = $expiryTime;
        } else {
            $message = '該電子郵件地址未註冊，請檢查後重試。';
            $messageType = 'error';
        }
    }
}
?>

<main class="forgot-password-page">
    <!-- Hero Section -->
    <section class="forgot-password-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title" data-animate="fadeInUp">忘記密碼</h1>
                <p class="hero-description" data-animate="fadeInUp" data-delay="200">
                    請輸入您的電子郵件地址，我們將發送密碼重置連結給您
                </p>
            </div>
        </div>
    </section>

    <!-- 密碼重置表單 -->
    <section class="forgot-password-form-section">
        <div class="container">
            <div class="form-container">
                <div class="form-card">
                    <div class="form-header">
                        <h2 class="form-title">重置密碼</h2>
                        <p class="form-description">
                            輸入您的電子郵件地址，我們將發送密碼重置連結
                        </p>
                    </div>

                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $messageType; ?>" role="alert">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="forgot-password-form" data-animate="fadeInUp" data-delay="300">
                        <div class="form-group">
                            <label for="email" class="form-label">電子郵件地址</label>
                            <div class="input-group">
                                <div class="input-icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M2.5 6.25L10 10.625L17.5 6.25M2.5 6.25L10 2.5L17.5 6.25M2.5 6.25V15C2.5 15.3315 2.6317 15.6495 2.86612 15.8839C3.10054 16.1183 3.41848 16.25 3.75 16.25H16.25C16.5815 16.25 16.8995 16.1183 17.1339 15.8839C17.3683 15.6495 17.5 15.3315 17.5 15V6.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="form-input" 
                                    placeholder="請輸入您的電子郵件地址"
                                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-full">
                                <span class="btn-text">發送重置連結</span>
                                <div class="btn-loading" style="display: none;">
                                    <div class="spinner"></div>
                                    <span>發送中...</span>
                                </div>
                            </button>
                        </div>

                        <div class="form-footer">
                            <p class="form-help">
                                記起密碼了？
                                <a href="<?php echo BASE_URL; ?>/login" class="form-link">返回登入</a>
                            </p>
                        </div>
                    </form>
                </div>

                <!-- 幫助信息 -->
                <div class="help-section" data-animate="fadeInUp" data-delay="400">
                    <div class="help-card">
                        <div class="help-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                                <path d="M9.09 9C9.3251 8.33167 9.78915 7.76811 10.4 7.40913C11.0108 7.05016 11.7289 6.91894 12.4272 7.03871C13.1255 7.15849 13.7588 7.52152 14.2151 8.06353C14.6713 8.60553 14.9211 9.29152 14.92 10C14.92 12 11.92 13 11.92 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 17H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3 class="help-title">需要幫助？</h3>
                        <p class="help-description">
                            如果您在重置密碼時遇到問題，請聯繫我們的客服團隊。
                        </p>
                        <a href="<?php echo BASE_URL; ?>/contact" class="help-link">聯繫客服</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* 忘記密碼頁面樣式 */
.forgot-password-page {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--primary-50) 0%, var(--accent-50) 100%);
}

.forgot-password-hero {
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

.forgot-password-form-section {
    padding: var(--spacing-16) 0;
}

.form-container {
    max-width: 500px;
    margin: 0 auto;
    display: grid;
    gap: var(--spacing-8);
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

.forgot-password-form {
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

.form-input {
    width: 100%;
    padding: var(--spacing-4) var(--spacing-4) var(--spacing-4) 3rem;
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

.form-footer {
    text-align: center;
    margin-top: var(--spacing-4);
}

.form-help {
    color: var(--neutral-600);
    font-size: var(--text-sm);
}

.form-link {
    color: var(--primary-600);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.form-link:hover {
    color: var(--primary-700);
    text-decoration: underline;
}

.help-section {
    margin-top: var(--spacing-8);
}

.help-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: var(--spacing-6);
    text-align: center;
    border: 1px solid var(--neutral-200);
}

.help-icon {
    width: 48px;
    height: 48px;
    margin: 0 auto var(--spacing-4);
    color: var(--primary-500);
}

.help-title {
    font-size: var(--text-lg);
    font-weight: 600;
    color: var(--neutral-900);
    margin-bottom: var(--spacing-2);
}

.help-description {
    color: var(--neutral-600);
    margin-bottom: var(--spacing-4);
}

.help-link {
    color: var(--primary-600);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.help-link:hover {
    color: var(--primary-700);
    text-decoration: underline;
}

/* 響應式設計 */
@media (max-width: 768px) {
    .forgot-password-hero {
        padding: var(--spacing-16) 0 var(--spacing-12);
    }
    
    .form-card {
        padding: var(--spacing-6);
        margin: 0 var(--spacing-4);
    }
    
    .form-container {
        max-width: none;
    }
}
</style>

<script>
// 表單提交處理
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.forgot-password-form');
    const submitBtn = form.querySelector('button[type="submit"]');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    
    form.addEventListener('submit', function(e) {
        // 顯示載入狀態
        btnText.style.display = 'none';
        btnLoading.style.display = 'flex';
        submitBtn.disabled = true;
        
        // 模擬發送延遲
        setTimeout(() => {
            // 恢復按鈕狀態
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            submitBtn.disabled = false;
        }, 2000);
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>