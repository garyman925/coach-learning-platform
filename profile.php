<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/user-management.php';

// 初始化用戶管理
$userManagement = new UserManagement();

// 檢查用戶是否已登入
if (!$userManagement->isLoggedIn()) {
    header('Location: ' . BASE_URL . '/login-page');
    exit;
}
$currentUser = $userManagement->getCurrentUser();

// 檢查是否為管理員（根據用戶郵件判斷）
$currentUserEmail = $currentUser['email'] ?? '';
$isAdmin = in_array($currentUserEmail, [
    'admin@example.com',
    'admin@coach-platform.com'
]);
$message = '';
$messageType = '';

// 設置頁面特定變數
$pageTitle = '個人資料 - ' . SITE_NAME;
$pageDescription = '管理您的個人資料和帳戶設置';
$pageKeywords = '個人資料,帳戶設置,用戶管理,個人中心';
$pageCSS = ['pages/profile.css', 'pages/user-layout.css'];
$pageJS = ['profile.js'];

// 處理表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        // 更新個人資料
        $profileData = [
            'first_name' => trim(isset($_POST['first_name']) ? $_POST['first_name'] : ''),
            'last_name' => trim(isset($_POST['last_name']) ? $_POST['last_name'] : ''),
            'phone' => trim(isset($_POST['phone']) ? $_POST['phone'] : ''),
            'email' => trim(isset($_POST['email']) ? $_POST['email'] : '')
        ];
        
        $result = $userManagement->updateUserProfile($currentUser['username'], $profileData);
        if ($result['success']) {
            $message = '個人資料更新成功！';
            $messageType = 'success';
            // 記錄活動
            $userManagement->logActivity($currentUser['username'], 'profile_update', '更新個人資料', '修改了個人資料資訊');
            // 重新獲取用戶資料
            $currentUser = $userManagement->getCurrentUser();
        } else {
            $message = isset($result['message']) ? $result['message'] : '更新失敗，請重試';
            $messageType = 'error';
        }
    }
}

// 獲取用戶的完整資料
$userProfile = isset($currentUser['profile']) ? $currentUser['profile'] : array();

// 包含用戶頁面 header
require_once 'includes/header-user.php';
?>

        <!-- 頁面標題區域 -->
        <section class="page-hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h1 class="page-title">個人資料管理</h1>
                        <p class="page-subtitle">管理您的個人資料</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 主要內容區域 -->
        <section class="profile-content">
            <div class="container">
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                        <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?> me-2"></i>
                        <?php echo e($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <!-- 主要內容 -->
                    <div class="col-12">
                        <div class="tab-content">
                            <!-- 個人資料標籤 -->
                            <div class="tab-pane fade show active" id="profile">
                                <div class="content-card">

                                    <div class="card-body">
                                        <form method="POST" class="profile-form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="first_name">名字</label>
                                                        <input type="text" id="first_name" name="first_name" 
                                                               class="form-control" 
                                                               value="<?php echo e(isset($userProfile['first_name']) ? $userProfile['first_name'] : ''); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="last_name">姓氏</label>
                                                        <input type="text" id="last_name" name="last_name" 
                                                               class="form-control" 
                                                               value="<?php echo e(isset($userProfile['last_name']) ? $userProfile['last_name'] : ''); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">電話號碼</label>
                                                        <input type="tel" id="phone" name="phone" 
                                                               class="form-control" 
                                                               value="<?php echo e(isset($userProfile['phone']) ? $userProfile['phone'] : ''); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">電郵</label>
                                                        <input type="email" id="email" name="email" 
                                                               class="form-control" 
                                                               value="<?php echo e($currentUser['email']); ?>" readonly>
                                                        <small class="form-text text-muted">電郵無法修改</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-actions">
                                                <button type="submit" name="update_profile" class="btn btn-primary">
                                                    <i class="fas fa-save me-2"></i>儲存變更
                                                </button>
                                                <button type="reset" class="btn btn-secondary">
                                                    <i class="fas fa-undo me-2"></i>重置
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($isAdmin): ?>
                            <!-- 學生管理標籤 -->
                            <div class="tab-pane fade" id="student-management">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-users-cog me-2"></i>學生管理</h4>
                                        <p>管理學生作業提交和查看學習進度</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="mb-4">
                                                <i class="fas fa-users-cog text-primary" style="font-size: 3rem;"></i>
                                            </div>
                                            <h5>學生管理功能</h5>
                                            <p class="text-muted mb-4">您可以使用學生管理功能來查看和管理學生的作業提交情況。</p>
                                            <a href="<?php echo BASE_URL; ?>/student-management" class="btn btn-primary">
                                                <i class="fas fa-external-link-alt me-2"></i>前往學生管理頁面
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php require_once 'includes/footer-user.php'; ?>
