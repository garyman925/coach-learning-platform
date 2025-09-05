<?php
require_once 'includes/config.php';
require_once 'includes/user-management.php';
require_once 'includes/functions.php';

// 檢查用戶是否已登入
if (!$userManagement->isLoggedIn()) {
    header('Location: ' . BASE_URL . '/login-page');
    exit;
}

$currentUser = $userManagement->getCurrentUser();
$username = $currentUser['username'];

// 設置頁面特定變數
$pageTitle = '我的課程與服務 - ' . SITE_NAME;
$pageDescription = '管理您的學習進度和課程服務';
$pageKeywords = '我的課程,學習進度,課程服務,個人中心';
$pageCSS = ['pages/my-courses.css', 'pages/user-layout.css'];
$pageJS = ['my-courses.js', 'learning-progress.js'];

// 模擬用戶課程數據
$userCourses = [
    [
        'id' => 'professional',
        'title' => '專業教練認證課程',
        'instructor' => '張教練',
        'status' => 'in_progress',
        'progress' => 65,
        'enrolled_date' => '2024-01-15',
        'completion_date' => null,
        'next_session' => '2024-02-15 14:00',
        'total_sessions' => 12,
        'completed_sessions' => 8,
        'certificate' => false,
        'rating' => null,
        'notes' => '課程內容豐富，教練專業'
    ],
    [
        'id' => 'team',
        'title' => '團隊教練技巧',
        'instructor' => '李教練',
        'status' => 'completed',
        'progress' => 100,
        'enrolled_date' => '2023-11-20',
        'completion_date' => '2024-01-10',
        'next_session' => null,
        'total_sessions' => 8,
        'completed_sessions' => 8,
        'certificate' => true,
        'rating' => 5,
        'notes' => '非常實用的課程，推薦！'
    ],
    // 家長教練基礎課程暫時隱藏
    /*
    [
        'id' => 'parent',
        'title' => '家長教練基礎',
        'instructor' => '王教練',
        'status' => 'enrolled',
        'progress' => 0,
        'enrolled_date' => '2024-02-01',
        'completion_date' => null,
        'next_session' => '2024-02-20 10:00',
        'total_sessions' => 6,
        'completed_sessions' => 0,
        'certificate' => false,
        'rating' => null,
        'notes' => ''
    ]
    */
];

// 模擬用戶服務數據
$userServices = [
    [
        'id' => 'service_001',
        'type' => 'personal_coaching',
        'title' => '個人教練服務',
        'coach' => '陳教練',
        'status' => 'scheduled',
        'scheduled_date' => '2024-02-18 15:00',
        'duration' => 60,
        'location' => '線上會議',
        'notes' => '討論職業發展規劃',
        'rating' => null,
        'feedback' => ''
    ],
    [
        'id' => 'service_002',
        'type' => 'enterprise_coaching',
        'title' => '企業團隊教練',
        'coach' => '劉教練',
        'status' => 'completed',
        'scheduled_date' => '2024-01-25 09:00',
        'duration' => 120,
        'location' => '公司會議室',
        'notes' => '團隊協作改善',
        'rating' => 4,
        'feedback' => '教練很專業，團隊收穫很大'
    ]
];

// 計算統計數據
$totalCourses = count($userCourses);
$completedCourses = count(array_filter($userCourses, function($course) { return $course['status'] === 'completed'; }));
$inProgressCourses = count(array_filter($userCourses, function($course) { return $course['status'] === 'in_progress'; }));
$totalServices = count($userServices);
$completedServices = count(array_filter($userServices, function($service) { return $service['status'] === 'completed'; }));

// 處理表單提交
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cancel_course'])) {
        $courseId = $_POST['course_id'];
        $message = '課程已取消，我們將盡快處理您的退款申請';
        $messageType = 'success';
        $userManagement->logActivity($username, 'course_cancel', '取消課程', "取消了課程 ID: {$courseId}");
    } elseif (isset($_POST['rate_course'])) {
        $courseId = $_POST['course_id'];
        $rating = $_POST['rating'];
        $message = '課程評價已提交，感謝您的反饋！';
        $messageType = 'success';
        $userManagement->logActivity($username, 'course_rating', '課程評價', "對課程 ID: {$courseId} 給予 {$rating} 星評價");
    } elseif (isset($_POST['cancel_service'])) {
        $serviceId = $_POST['service_id'];
        $message = '服務預約已取消';
        $messageType = 'success';
        $userManagement->logActivity($username, 'service_cancel', '取消服務', "取消了服務 ID: {$serviceId}");
    } elseif (isset($_POST['rate_service'])) {
        $serviceId = $_POST['service_id'];
        $rating = $_POST['rating'];
        $message = '服務評價已提交，感謝您的反饋！';
        $messageType = 'success';
        $userManagement->logActivity($username, 'service_rating', '服務評價', "對服務 ID: {$serviceId} 給予 {$rating} 星評價");
    }
}
?>

<?php require_once 'includes/header-user.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">我的課程</li>
                        </ol>
                    </nav>
                    <h1 class="hero-title">我的課程與服務</h1>
                    <p class="hero-description">管理您的學習進度，查看課程狀態和服務預約</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-triangle'; ?> me-2"></i>
                <?php echo e($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?php echo $totalCourses; ?></h3>
                        <p class="stat-label">總課程數</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?php echo $completedCourses; ?></h3>
                        <p class="stat-label">已完成</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?php echo $inProgressCourses; ?></h3>
                        <p class="stat-label">進行中</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?php echo $totalServices; ?></h3>
                        <p class="stat-label">教練服務</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="content-tabs">
            <ul class="nav nav-pills nav-fill" id="coursesTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="my-courses-tab" data-bs-toggle="pill" data-bs-target="#my-courses" type="button" role="tab">
                        <i class="fas fa-graduation-cap me-2"></i>我的課程
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="my-services-tab" data-bs-toggle="pill" data-bs-target="#my-services" type="button" role="tab">
                        <i class="fas fa-user-tie me-2"></i>我的服務
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="progress-tab" data-bs-toggle="pill" data-bs-target="#progress" type="button" role="tab">
                        <i class="fas fa-chart-line me-2"></i>學習進度
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="coursesTabContent">
            <!-- My Courses Tab -->
            <div class="tab-pane fade show active" id="my-courses" role="tabpanel">
                <div class="content-card">
                    <div class="card-header">
                        <h4><i class="fas fa-graduation-cap me-2"></i>我的課程</h4>
                        <p>管理您的課程學習進度</p>
                    </div>
                    <div class="card-body">
                        <?php if (empty($userCourses)): ?>
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <h3 class="empty-title">還沒有報名任何課程</h3>
                                <p class="empty-description">探索我們的課程，開始您的學習之旅</p>
                                <a href="<?php echo BASE_URL; ?>/courses" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>瀏覽課程
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($userCourses as $course): ?>
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <div class="course-card">
                                            <div class="course-header">
                                                <div class="course-status status-<?php echo $course['status']; ?>">
                                                    <?php
                                                    $statusText = [
                                                        'enrolled' => '已報名',
                                                        'in_progress' => '進行中',
                                                        'completed' => '已完成'
                                                    ];
                                                    echo isset($statusText[$course['status']]) ? $statusText[$course['status']] : $course['status'];
                                                    ?>
                                                </div>
                                                <?php if ($course['certificate']): ?>
                                                    <div class="course-certificate">
                                                        <i class="fas fa-certificate"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="course-content">
                                                <h5 class="course-title"><?php echo e($course['title']); ?></h5>
                                                <p class="course-instructor">
                                                    <i class="fas fa-user me-2"></i><?php echo e($course['instructor']); ?>
                                                </p>
                                                
                                                <div class="course-progress">
                                                    <div class="progress-info">
                                                        <span>進度</span>
                                                        <span><?php echo $course['progress']; ?>%</span>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: <?php echo $course['progress']; ?>%"></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="course-sessions">
                                                    <i class="fas fa-calendar-alt me-2"></i>
                                                    已完成 <?php echo $course['completed_sessions']; ?>/<?php echo $course['total_sessions']; ?> 堂課
                                                </div>
                                                
                                                <?php if ($course['next_session']): ?>
                                                    <div class="course-next">
                                                        <i class="fas fa-clock me-2"></i>
                                                        下次課程：<?php echo date('m/d H:i', strtotime($course['next_session'])); ?>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <?php if ($course['notes']): ?>
                                                    <div class="course-notes">
                                                        <i class="fas fa-sticky-note me-2"></i>
                                                        <?php echo e($course['notes']); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="course-actions">
                                                <?php if ($course['status'] === 'enrolled' || $course['status'] === 'in_progress'): ?>
                                                    <a href="<?php echo BASE_URL; ?>/course-learning?course=<?php echo $course['id']; ?>" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-play me-2"></i>
                                                        <?php echo $course['progress'] > 0 ? '繼續學習' : '開始學習'; ?>
                                                    </a>
                                                    <button class="btn btn-outline-danger btn-sm" onclick="cancelCourse('<?php echo $course['id']; ?>')">
                                                        <i class="fas fa-times me-2"></i>取消課程
                                                    </button>
                                                <?php elseif ($course['status'] === 'completed'): ?>
                                                    <a href="<?php echo BASE_URL; ?>/course-learning?course=<?php echo $course['id']; ?>" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-redo me-2"></i>重新學習
                                                    </a>
                                                    <?php if ($course['certificate']): ?>
                                                        <button class="btn btn-success btn-sm" onclick="downloadCertificate('<?php echo $course['id']; ?>')">
                                                            <i class="fas fa-download me-2"></i>下載證書
                                                        </button>
                                                    <?php endif; ?>
                                                    <?php if (!$course['rating']): ?>
                                                        <button class="btn btn-warning btn-sm" onclick="rateCourse('<?php echo $course['id']; ?>')">
                                                            <i class="fas fa-star me-2"></i>評價課程
                                                        </button>
                                                    <?php else: ?>
                                                        <div class="course-rating">
                                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                <i class="fas fa-star <?php echo $i <= $course['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                                                            <?php endfor; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- My Services Tab -->
            <div class="tab-pane fade" id="my-services" role="tabpanel">
                <div class="content-card">
                    <div class="card-header">
                        <h4><i class="fas fa-user-tie me-2"></i>我的服務</h4>
                        <p>管理您的教練服務預約</p>
                    </div>
                    <div class="card-body">
                        <?php if (empty($userServices)): ?>
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <h3 class="empty-title">還沒有預約任何服務</h3>
                                <p class="empty-description">探索我們的教練服務，獲得專業指導</p>
                                <a href="<?php echo BASE_URL; ?>/services" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>瀏覽服務
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="services-list">
                                <?php foreach ($userServices as $service): ?>
                                    <div class="service-item">
                                        <div class="service-header">
                                            <div class="service-type">
                                                <i class="fas fa-<?php echo $service['type'] === 'personal_coaching' ? 'user' : 'users'; ?> me-2"></i>
                                                <?php echo e($service['title']); ?>
                                            </div>
                                            <div class="service-status status-<?php echo $service['status']; ?>">
                                                <?php
                                                $statusText = [
                                                    'scheduled' => '已預約',
                                                    'completed' => '已完成',
                                                    'cancelled' => '已取消'
                                                ];
                                                echo isset($statusText[$service['status']]) ? $statusText[$service['status']] : $service['status'];
                                                ?>
                                            </div>
                                        </div>
                                        
                                        <div class="service-content">
                                            <div class="service-info">
                                                <div class="service-coach">
                                                    <i class="fas fa-user-tie me-2"></i>
                                                    教練：<?php echo e($service['coach']); ?>
                                                </div>
                                                <div class="service-datetime">
                                                    <i class="fas fa-calendar-alt me-2"></i>
                                                    <?php echo date('Y-m-d H:i', strtotime($service['scheduled_date'])); ?>
                                                </div>
                                                <div class="service-duration">
                                                    <i class="fas fa-clock me-2"></i>
                                                    <?php echo $service['duration']; ?> 分鐘
                                                </div>
                                                <div class="service-location">
                                                    <i class="fas fa-map-marker-alt me-2"></i>
                                                    <?php echo e($service['location']); ?>
                                                </div>
                                            </div>
                                            
                                            <?php if ($service['notes']): ?>
                                                <div class="service-notes">
                                                    <i class="fas fa-sticky-note me-2"></i>
                                                    <?php echo e($service['notes']); ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if ($service['rating']): ?>
                                                <div class="service-rating">
                                                    <i class="fas fa-star me-2"></i>
                                                    評價：
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i class="fas fa-star <?php echo $i <= $service['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                                                    <?php endfor; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if ($service['feedback']): ?>
                                                <div class="service-feedback">
                                                    <i class="fas fa-comment me-2"></i>
                                                    <?php echo e($service['feedback']); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="service-actions">
                                            <?php if ($service['status'] === 'scheduled'): ?>
                                                <button class="btn btn-primary btn-sm" onclick="viewService('<?php echo $service['id']; ?>')">
                                                    <i class="fas fa-eye me-2"></i>查看詳情
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm" onclick="cancelService('<?php echo $service['id']; ?>')">
                                                    <i class="fas fa-times me-2"></i>取消預約
                                                </button>
                                            <?php elseif ($service['status'] === 'completed'): ?>
                                                <?php if (!$service['rating']): ?>
                                                    <button class="btn btn-warning btn-sm" onclick="rateService('<?php echo $service['id']; ?>')">
                                                        <i class="fas fa-star me-2"></i>評價服務
                                                    </button>
                                                <?php endif; ?>
                                                <button class="btn btn-outline-primary btn-sm" onclick="bookAgain('<?php echo $service['id']; ?>')">
                                                    <i class="fas fa-redo me-2"></i>再次預約
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Progress Tab -->
            <div class="tab-pane fade" id="progress" role="tabpanel">
                <!-- 統計概覽 -->
                <div class="content-card mb-4">
                    <div class="card-header">
                        <h4><i class="fas fa-chart-line me-2"></i>學習統計</h4>
                        <p>查看您的學習進度和成就統計</p>
                    </div>
                    <div class="card-body">
                        <div class="stats-grid" id="stats-grid">
                            <!-- 統計卡片將通過JavaScript動態生成 -->
                        </div>
                    </div>
                </div>

                <!-- 成就系統 -->
                <div class="content-card mb-4">
                    <div class="card-header">
                        <h4><i class="fas fa-trophy me-2"></i>成就徽章</h4>
                        <p>解鎖更多成就，展示您的學習成果</p>
                    </div>
                    <div class="card-body">
                        <div class="achievements-grid" id="achievements-grid">
                            <!-- 成就項目將通過JavaScript動態生成 -->
                        </div>
                    </div>
                </div>

                <!-- 課程進度 -->
                <div class="content-card mb-4">
                    <div class="card-header">
                        <h4><i class="fas fa-book me-2"></i>課程進度</h4>
                        <p>詳細的課程學習進度追蹤</p>
                    </div>
                    <div class="card-body">
                        <div id="course-progress-list">
                            <!-- 課程進度將通過JavaScript動態生成 -->
                        </div>
                    </div>
                </div>

                <!-- 數據導出 -->
                <div class="content-card">
                    <div class="card-header">
                        <h4><i class="fas fa-download me-2"></i>數據管理</h4>
                        <p>導出您的學習數據和成就記錄</p>
                    </div>
                    <div class="card-body">
                        <div class="export-buttons">
                            <button class="btn btn-primary me-3" onclick="exportLearningData('progress')">
                                <i class="fas fa-file-export me-2"></i>導出學習數據
                            </button>
                            <button class="btn btn-success me-3" onclick="exportLearningData('achievements')">
                                <i class="fas fa-trophy me-2"></i>導出成就記錄
                            </button>
                            <button class="btn btn-info me-3" onclick="exportLearningData('stats')">
                                <i class="fas fa-chart-bar me-2"></i>導出統計數據
                            </button>
                            <button class="btn btn-warning" onclick="clearAllLearningData()">
                                <i class="fas fa-trash me-2"></i>清除所有數據
                            </button>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                導出的數據將以JSON格式下載，可用於備份或分析您的學習進度
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 成就通知容器 -->
    <div id="achievement-notifications"></div>

    <!-- Modals -->
    <!-- Cancel Course Modal -->
    <div class="modal fade" id="cancelCourseModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">取消課程</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>確定要取消這門課程嗎？</p>
                    <p class="text-muted">取消後將無法復原，我們將盡快處理您的退款申請。</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="course_id" id="cancelCourseId">
                        <button type="submit" name="cancel_course" class="btn btn-danger">確認取消</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Rate Course Modal -->
    <div class="modal fade" id="rateCourseModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">評價課程</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="rating-input">
                            <label class="form-label">請為這門課程評分：</label>
                            <div class="star-rating">
                                <input type="radio" name="rating" value="5" id="star5">
                                <label for="star5"><i class="fas fa-star"></i></label>
                                <input type="radio" name="rating" value="4" id="star4">
                                <label for="star4"><i class="fas fa-star"></i></label>
                                <input type="radio" name="rating" value="3" id="star3">
                                <label for="star3"><i class="fas fa-star"></i></label>
                                <input type="radio" name="rating" value="2" id="star2">
                                <label for="star2"><i class="fas fa-star"></i></label>
                                <input type="radio" name="rating" value="1" id="star1">
                                <label for="star1"><i class="fas fa-star"></i></label>
                            </div>
                        </div>
                        <input type="hidden" name="course_id" id="rateCourseId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <button type="submit" name="rate_course" class="btn btn-primary">提交評價</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Cancel Service Modal -->
    <div class="modal fade" id="cancelServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">取消服務</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>確定要取消這個服務預約嗎？</p>
                    <p class="text-muted">取消後將無法復原。</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="service_id" id="cancelServiceId">
                        <button type="submit" name="cancel_service" class="btn btn-danger">確認取消</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Rate Service Modal -->
    <div class="modal fade" id="rateServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">評價服務</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="rating-input">
                            <label class="form-label">請為這個服務評分：</label>
                            <div class="star-rating">
                                <input type="radio" name="rating" value="5" id="serviceStar5">
                                <label for="serviceStar5"><i class="fas fa-star"></i></label>
                                <input type="radio" name="rating" value="4" id="serviceStar4">
                                <label for="serviceStar4"><i class="fas fa-star"></i></label>
                                <input type="radio" name="rating" value="3" id="serviceStar3">
                                <label for="serviceStar3"><i class="fas fa-star"></i></label>
                                <input type="radio" name="rating" value="2" id="serviceStar2">
                                <label for="serviceStar2"><i class="fas fa-star"></i></label>
                                <input type="radio" name="rating" value="1" id="serviceStar1">
                                <label for="serviceStar1"><i class="fas fa-star"></i></label>
                            </div>
                        </div>
                        <input type="hidden" name="service_id" id="rateServiceId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <button type="submit" name="rate_service" class="btn btn-primary">提交評價</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript 由 footer-user.php 處理 -->
    
    <script>
        // 頁面載入完成後隱藏載入動畫
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const pageLoader = document.getElementById('page-loader');
                const mainContent = document.getElementById('main-content');
                
                if (pageLoader) {
                    pageLoader.style.display = 'none';
                }
                if (mainContent) {
                    mainContent.style.display = 'block';
                }
            }, 500);
            
            // 初始化學習進度功能
            initializeLearningProgress();
        });

        // 取消課程
        function cancelCourse(courseId) {
            const cancelCourseIdElement = document.getElementById('cancelCourseId');
            if (cancelCourseIdElement) {
                cancelCourseIdElement.value = courseId;
            }
            const cancelModal = document.getElementById('cancelCourseModal');
            if (cancelModal) {
                new bootstrap.Modal(cancelModal).show();
            }
        }

        // 評價課程
        function rateCourse(courseId) {
            const rateCourseIdElement = document.getElementById('rateCourseId');
            if (rateCourseIdElement) {
                rateCourseIdElement.value = courseId;
            }
            const rateModal = document.getElementById('rateCourseModal');
            if (rateModal) {
                new bootstrap.Modal(rateModal).show();
            }
        }

        // 取消服務
        function cancelService(serviceId) {
            const cancelServiceIdElement = document.getElementById('cancelServiceId');
            if (cancelServiceIdElement) {
                cancelServiceIdElement.value = serviceId;
            }
            const cancelServiceModal = document.getElementById('cancelServiceModal');
            if (cancelServiceModal) {
                new bootstrap.Modal(cancelServiceModal).show();
            }
        }

        // 評價服務
        function rateService(serviceId) {
            const rateServiceIdElement = document.getElementById('rateServiceId');
            if (rateServiceIdElement) {
                rateServiceIdElement.value = serviceId;
            }
            const rateServiceModal = document.getElementById('rateServiceModal');
            if (rateServiceModal) {
                new bootstrap.Modal(rateServiceModal).show();
            }
        }

        // 查看課程詳情
        function viewCourse(courseId) {
            // 在實際應用中，這裡會跳轉到課程詳情頁面
            alert('跳轉到課程詳情頁面：' + courseId);
        }

        // 下載證書
        function downloadCertificate(courseId) {
            // 在實際應用中，這裡會下載證書文件
            alert('下載證書：' + courseId);
        }

        // 查看服務詳情
        function viewService(serviceId) {
            // 在實際應用中，這裡會跳轉到服務詳情頁面
            alert('跳轉到服務詳情頁面：' + serviceId);
        }

        // 再次預約
        function bookAgain(serviceId) {
            // 在實際應用中，這裡會跳轉到預約頁面
            alert('跳轉到預約頁面：' + serviceId);
        }

        // 開始學習
        function startLearning(courseId) {
            // 跳轉到課程學習頁面
            window.location.href = '<?php echo BASE_URL; ?>/course-learning?course=' + courseId + '&lesson=lesson_1';
        }

        // 學習進度功能
        let learningProgressInstance;

        function initializeLearningProgress() {
            // 初始化學習進度實例
            if (typeof LearningProgress !== 'undefined') {
                learningProgressInstance = new LearningProgress();
                loadProgressData();
            }
        }

        function loadProgressData() {
            if (!learningProgressInstance) return;

            // 載入統計數據
            loadStatsGrid();
            
            // 載入成就數據
            loadAchievementsGrid();
            
            // 載入課程進度
            loadCourseProgressList();
        }

        function loadStatsGrid() {
            const statsGrid = document.getElementById('stats-grid');
            if (!statsGrid || !learningProgressInstance) return;

            const stats = learningProgressInstance.stats;
            
            const statsHTML = `
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <h3>${formatTime(stats.totalStudyTime)}</h3>
                                <p>總學習時間</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="stat-content">
                                <h3>${stats.completedCourses}</h3>
                                <p>完成課程</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="stat-content">
                                <h3>${stats.completedLessons}</h3>
                                <p>完成課程</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-dumbbell"></i>
                            </div>
                            <div class="stat-content">
                                <h3>${stats.completedExercises}</h3>
                                <p>完成練習</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-content">
                                <h3>${stats.averageScore.toFixed(1)}</h3>
                                <p>平均分數</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="stat-content">
                                <h3>${stats.achievementsUnlocked}</h3>
                                <p>獲得成就</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            statsGrid.innerHTML = statsHTML;
        }

        function loadAchievementsGrid() {
            const achievementsGrid = document.getElementById('achievements-grid');
            if (!achievementsGrid || !learningProgressInstance) return;

            const achievements = learningProgressInstance.achievements || {};
            let achievementsHTML = '';

            for (const [key, achievement] of Object.entries(achievements)) {
                achievementsHTML += `
                    <div class="achievement-item ${achievement.unlocked ? 'earned' : 'locked'}">
                        <div class="achievement-icon">
                            <i class="${achievement.icon}"></i>
                        </div>
                        <div class="achievement-info">
                            <h6>${achievement.name}</h6>
                            <p>${achievement.description}</p>
                        </div>
                        <div class="achievement-status">
                            ${achievement.unlocked ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-lock text-muted"></i>'}
                        </div>
                    </div>
                `;
            }
            
            achievementsGrid.innerHTML = achievementsHTML;
        }

        function loadCourseProgressList() {
            const courseProgressList = document.getElementById('course-progress-list');
            if (!courseProgressList || !learningProgressInstance) return;

            const progress = learningProgressInstance.progress || {};
            let progressHTML = '';

            for (const [courseId, courseProgress] of Object.entries(progress)) {
                const lessons = courseProgress.lessons;
                const completedLessons = Object.keys(lessons).length;
                const totalLessons = 4; // 假設每門課程有4課
                const progressPercentage = Math.round((completedLessons / totalLessons) * 100);

                progressHTML += `
                    <div class="course-progress-item">
                        <div class="course-progress-header">
                            <h6>${getCourseTitle(courseId)}</h6>
                            <span class="progress-badge">${progressPercentage}%</span>
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar" style="width: ${progressPercentage}%"></div>
                        </div>
                        <div class="course-progress-stats">
                            <small class="text-muted">
                                已完成 ${completedLessons}/${totalLessons} 課 | 
                                總分數: ${courseProgress.totalScore} | 
                                學習時間: ${formatTime(courseProgress.totalStudyTime)}
                            </small>
                        </div>
                    </div>
                `;
            }

            if (progressHTML === '') {
                progressHTML = '<p class="text-muted text-center">尚未開始任何課程學習</p>';
            }
            
            courseProgressList.innerHTML = progressHTML;
        }

        function getCourseTitle(courseId) {
            const courseTitles = {
                'professional': '專業教練認證課程',
                'team': '團隊教練技巧',
                'parent': '家長教練基礎',
                'enneagram': '九型人格教練'
            };
            return courseTitles[courseId] || courseId;
        }

        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            if (hours > 0) {
                return `${hours}小時${minutes}分鐘`;
            } else {
                return `${minutes}分鐘`;
            }
        }

        // 數據導出功能
        function exportLearningData(dataType) {
            if (learningProgressInstance) {
                learningProgressInstance.exportData(dataType);
            } else {
                showNotification('學習進度系統未初始化', 'error');
            }
        }

        function clearAllLearningData() {
            if (learningProgressInstance) {
                learningProgressInstance.clearAllData();
            } else {
                showNotification('學習進度系統未初始化', 'error');
            }
        }

        // 確保 showNotification 函數可用
        if (typeof showNotification === 'undefined') {
            window.showNotification = (message, type = 'info') => {
                console.log(`Notification (${type}): ${message}`);
                alert(message);
            };
        }
    </script>
<?php require_once 'includes/footer-user.php'; ?>
