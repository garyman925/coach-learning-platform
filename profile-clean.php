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
            'bio' => trim(isset($_POST['bio']) ? $_POST['bio'] : ''),
            'company' => trim(isset($_POST['company']) ? $_POST['company'] : ''),
            'position' => trim(isset($_POST['position']) ? $_POST['position'] : ''),
            'website' => trim(isset($_POST['website']) ? $_POST['website'] : ''),
            'location' => trim(isset($_POST['location']) ? $_POST['location'] : ''),
            'interests' => trim(isset($_POST['interests']) ? $_POST['interests'] : '')
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
                    <div class="col-lg-8">
                        <h1 class="page-title">個人資料管理</h1>
                        <p class="page-subtitle">管理您的個人資料</p>
                    </div>
                    <div class="col-lg-4 text-end">
                        <div class="user-avatar">
                            <img src="<?php echo e(isset($userProfile['avatar']) ? $userProfile['avatar'] : 'assets/images/default-avatar.svg'); ?>" 
                                 alt="<?php echo e($currentUser['username']); ?>" 
                                 class="avatar-img">
                            <div class="avatar-status online"></div>
                        </div>
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
                    <!-- 側邊欄 -->
                    <div class="col-lg-3">
                        <div class="profile-sidebar">
                            <div class="sidebar-section">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#profile" data-bs-toggle="pill">
                                            <i class="fas fa-user me-2"></i>個人資料
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="sidebar-section">
                                <h5>帳戶狀態</h5>
                                <div class="account-status">
                                    <div class="status-item">
                                        <span class="status-label">會員等級</span>
                                        <span class="status-value"><?php echo e($currentUser['role'] === 'admin' ? '管理員' : '一般會員'); ?></span>
                                    </div>
                                    <div class="status-item">
                                        <span class="status-label">註冊時間</span>
                                        <span class="status-value"><?php echo e(date('Y-m-d', strtotime($currentUser['created_at']))); ?></span>
                                    </div>
                                    <div class="status-item">
                                        <span class="status-label">最後登入</span>
                                        <span class="status-value"><?php echo e($currentUser['last_login'] ? date('Y-m-d H:i', strtotime($currentUser['last_login'])) : '從未登入'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 主要內容 -->
                    <div class="col-lg-9">
                        <div class="tab-content">
                            <!-- 個人資料標籤 -->
                            <div class="tab-pane fade show active" id="profile">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-user me-2"></i>個人資料</h4>
                                        <p>更新您的個人資訊</p>
                                    </div>
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
                                                        <label for="location">所在地</label>
                                                        <input type="text" id="location" name="location" 
                                                               class="form-control" 
                                                               value="<?php echo e(isset($userProfile['location']) ? $userProfile['location'] : ''); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="company">公司/組織</label>
                                                        <input type="text" id="company" name="company" 
                                                               class="form-control" 
                                                               value="<?php echo e(isset($userProfile['company']) ? $userProfile['company'] : ''); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="position">職位</label>
                                                        <input type="text" id="position" name="position" 
                                                               class="form-control" 
                                                               value="<?php echo e(isset($userProfile['position']) ? $userProfile['position'] : ''); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="website">個人網站</label>
                                                <input type="url" id="website" name="website" 
                                                       class="form-control" 
                                                       value="<?php echo e(isset($userProfile['website']) ? $userProfile['website'] : ''); ?>">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="bio">個人簡介</label>
                                                <textarea id="bio" name="bio" class="form-control" rows="4" 
                                                          placeholder="請簡短介紹您自己..."><?php echo e(isset($userProfile['bio']) ? $userProfile['bio'] : ''); ?></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="interests">興趣專長</label>
                                                <textarea id="interests" name="interests" class="form-control" rows="3" 
                                                          placeholder="請列出您的興趣和專長..."><?php echo e(isset($userProfile['interests']) ? $userProfile['interests'] : ''); ?></textarea>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php require_once 'includes/footer-user.php'; ?>
