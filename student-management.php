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

// 檢查是否為管理員
$isAdmin = true; // 暫時設為 true 用於演示
if (!$isAdmin) {
    header('Location: ' . BASE_URL . '/my-courses');
    exit;
}

$currentUser = $userManagement->getCurrentUser();

// 設置頁面特定變數
$pageTitle = '學生管理 - ' . SITE_NAME;
$pageDescription = '管理學生作業提交和查看學習進度';
$pageKeywords = '學生管理,作業管理,學習進度,管理員';
$pageCSS = ['student-management.css', 'pages/user-layout.css'];
$pageJS = ['student-management.js'];

// 模擬學生數據
$studentData = [
    'coffee-moment' => [
        'course_name' => '教練咖啡時刻',
        'students' => [
            [
                'id' => 'student_001',
                'name' => '張小明',
                'email' => 'zhang@example.com',
                'phone' => '0912-345-678',
                'submissions' => [
                    [
                        'id' => 'sub_001',
                        'type' => 'image',
                        'filename' => 'homework_photo_1.jpg',
                        'original_name' => '作業照片_1.jpg',
                        'upload_time' => '2024-09-25 14:30',
                        'status' => 'submitted',
                        'file_size' => '2.3 MB'
                    ],
                    [
                        'id' => 'sub_002',
                        'type' => 'video',
                        'filename' => 'homework_video_1.mp4',
                        'original_name' => '練習影片.mp4',
                        'upload_time' => '2024-09-25 15:45',
                        'status' => 'submitted',
                        'file_size' => '15.7 MB'
                    ]
                ]
            ],
            [
                'id' => 'student_002',
                'name' => '李美華',
                'email' => 'li@example.com',
                'phone' => '0987-654-321',
                'submissions' => [
                    [
                        'id' => 'sub_003',
                        'type' => 'audio',
                        'filename' => 'homework_audio_1.mp3',
                        'original_name' => '語音作業.mp3',
                        'upload_time' => '2024-09-25 16:20',
                        'status' => 'submitted',
                        'file_size' => '5.2 MB'
                    ]
                ]
            ],
            [
                'id' => 'student_003',
                'name' => '王大偉',
                'email' => 'wang@example.com',
                'phone' => '0933-111-222',
                'submissions' => []
            ]
        ]
    ],
    'professional' => [
        'course_name' => '專業教練認證課程',
        'students' => [
            [
                'id' => 'student_004',
                'name' => '陳小芳',
                'email' => 'chen@example.com',
                'phone' => '0922-333-444',
                'submissions' => [
                    [
                        'id' => 'sub_004',
                        'type' => 'image',
                        'filename' => 'homework_photo_2.jpg',
                        'original_name' => '案例分析.jpg',
                        'upload_time' => '2024-09-24 10:15',
                        'status' => 'submitted',
                        'file_size' => '1.8 MB'
                    ]
                ]
            ]
        ]
    ]
];

// 獲取當前選擇的課程
$selectedCourse = isset($_GET['course']) ? $_GET['course'] : 'coffee-moment';
$currentCourseData = isset($studentData[$selectedCourse]) ? $studentData[$selectedCourse] : $studentData['coffee-moment'];

// 包含用戶專用 Header
require_once 'includes/header-user.php';
?>

<div class="student-management-container">
    <!-- 頁面標題 -->
    <div class="page-header">
        <h2 class="page-title">
            學生作業管理
        </h2>
        <p class="page-description">管理學生作業提交和查看學習進度</p>
    </div>

    <!-- 課程選擇器 -->
    <div class="course-selector-section">
        <div class="row">
            <div class="col-md-4">
                <label for="courseSelect" class="form-label">選擇課程</label>
                <select class="form-select" id="courseSelect" onchange="loadCourseStudents(this.value)">
                    <option value="coffee-moment" <?php echo ($selectedCourse == 'coffee-moment') ? 'selected' : ''; ?>>
                        教練咖啡時刻
                    </option>
                </select>
            </div>
        </div>
    </div>

    <!-- 學生列表 -->
    <div class="students-section">

        <div class="students-table-container">
            <div class="table-responsive">
                <table class="table table-hover students-table">
                    <thead>
                        <tr>
                            <th>學生姓名</th>
                            <th>最後提交</th>
                            <th>累積打卡次數</th>
                            <th>狀態</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($currentCourseData['students'] as $student): ?>
                        <tr class="student-row" data-student-id="<?php echo e($student['id']); ?>">
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="student-details">
                                        <div class="student-name"><?php echo e($student['name']); ?></div>
                                        <div class="student-id">ID: <?php echo e($student['id']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php if (!empty($student['submissions'])): ?>
                                    <?php 
                                    $latestSubmission = end($student['submissions']);
                                    echo e($latestSubmission['upload_time']);
                                    ?>
                                <?php else: ?>
                                    <span class="text-muted">尚未提交</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-outline-info btn-sm checkin-count-btn" 
                                        onclick="showCheckinHistory('<?php echo e($student['id']); ?>', '<?php echo e($student['name']); ?>')"
                                        data-student-id="<?php echo e($student['id']); ?>">
                                    <i class="fas fa-calendar-check me-1"></i>
                                    <?php echo count($student['submissions']); ?> 次
                                </button>
                            </td>
                            <td>
                                <?php if (!empty($student['submissions'])): ?>
                                    <span class="status-badge status-submitted">
                                        <i class="fas fa-check-circle me-1"></i>
                                        已提交
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-clock me-1"></i>
                                        待提交
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <?php if (!empty($student['submissions'])): ?>
                                        <button class="btn btn-primary btn-sm" onclick="viewStudentSubmissions('<?php echo e($student['id']); ?>', '<?php echo e($student['name']); ?>')">
                                            <i class="fas fa-eye me-1"></i>
                                            查看作業
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-outline-secondary btn-sm" disabled>
                                            <i class="fas fa-eye-slash me-1"></i>
                                            無作業
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- 作業預覽彈窗 -->
<div class="modal fade" id="submissionsModal" tabindex="-1" aria-labelledby="submissionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submissionsModalLabel">
                    學生作業
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="submissionsContent">
                    <!-- 動態載入作業內容 -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                <button type="button" class="btn btn-primary" onclick="downloadAllSubmissions()">
                    <i class="fas fa-download me-1"></i>
                    下載全部
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 打卡歷史記錄彈窗 -->
<div class="modal fade" id="checkinHistoryModal" tabindex="-1" aria-labelledby="checkinHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <h5 class="modal-title" id="checkinHistoryModalLabel">
                    打卡歷史記錄
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="checkinHistoryContent">
                    <!-- 動態載入打卡歷史內容 -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer-user.php'; ?>

<script>
// 學生管理相關的 JavaScript 函數
function loadCourseStudents(courseId) {
    // 重新載入頁面並帶上課程參數
    window.location.href = '<?php echo BASE_URL; ?>/student-management?course=' + courseId;
}

function viewStudentSubmissions(studentId, studentName) {
    // 更新彈窗標題
    document.getElementById('submissionsModalLabel').innerHTML = 
        studentName + ' 的作業';
    
    // 顯示載入狀態
    document.getElementById('submissionsContent').innerHTML = 
        '<div class="text-center"><i class="fas fa-spinner fa-spin me-2"></i>載入作業中...</div>';
    
    // 顯示彈窗
    const modal = new bootstrap.Modal(document.getElementById('submissionsModal'));
    modal.show();
    
    // 模擬載入作業內容
    setTimeout(() => {
        loadStudentSubmissions(studentId);
    }, 800);
}

function loadStudentSubmissions(studentId) {
    // 模擬學生作業數據
    const mockSubmissions = [
        {
            id: 'sub_001',
            type: 'image',
            filename: 'homework_photo_1.jpg',
            original_name: '作業照片_1.jpg',
            upload_time: '2024-09-25 14:30',
            file_size: '2.3 MB'
        },
        {
            id: 'sub_002',
            type: 'video',
            filename: 'homework_video_1.mp4',
            original_name: '練習影片.mp4',
            upload_time: '2024-09-25 15:45',
            file_size: '15.7 MB'
        }
    ];
    
    let content = '<div class="submissions-list">';
    
    mockSubmissions.forEach(submission => {
        content += `
            <div class="submission-item">
                <div class="submission-header">
                    <div class="submission-info">
                        <h6 class="submission-name">${submission.original_name}</h6>
                        <div class="submission-meta">
                            <span class="upload-time">
                                <i class="fas fa-clock me-1"></i>
                                ${submission.upload_time}
                            </span>
                            <span class="file-size">
                                <i class="fas fa-file me-1"></i>
                                ${submission.file_size}
                            </span>
                        </div>
                    </div>
                    <div class="submission-actions">
                        <button class="btn btn-outline-primary btn-sm" onclick="previewSubmission('${submission.id}', '${submission.type}')">
                            <i class="fas fa-eye me-1"></i>
                            預覽
                        </button>
                        <button class="btn btn-success btn-sm" onclick="downloadSubmission('${submission.id}')">
                            <i class="fas fa-download me-1"></i>
                            下載
                        </button>
                    </div>
                </div>
                <div class="submission-preview" id="preview-${submission.id}" style="display: none;">
                    <!-- 預覽內容將在這裡顯示 -->
                </div>
            </div>
        `;
    });
    
    content += '</div>';
    document.getElementById('submissionsContent').innerHTML = content;
}

function previewSubmission(submissionId, type) {
    const previewDiv = document.getElementById('preview-' + submissionId);
    
    if (previewDiv.style.display === 'none') {
        previewDiv.style.display = 'block';
        
        let previewContent = '';
        switch(type) {
            case 'image':
                previewContent = `
                    <div class="image-preview">
                        <img src="assets/images/placeholder.jpg" alt="作業圖片" class="img-fluid rounded">
                    </div>
                `;
                break;
            case 'video':
                previewContent = `
                    <div class="video-preview">
                        <video controls class="w-100 rounded">
                            <source src="assets/videos/placeholder.mp4" type="video/mp4">
                            您的瀏覽器不支持視頻播放。
                        </video>
                    </div>
                `;
                break;
            case 'audio':
                previewContent = `
                    <div class="audio-preview">
                        <audio controls class="w-100">
                            <source src="assets/audio/placeholder.mp3" type="audio/mpeg">
                            您的瀏覽器不支持音頻播放。
                        </audio>
                    </div>
                `;
                break;
        }
        
        previewDiv.innerHTML = previewContent;
    } else {
        previewDiv.style.display = 'none';
    }
}

function downloadSubmission(submissionId) {
    // 模擬下載功能
    alert('下載作業: ' + submissionId);
}

function downloadAllSubmissions() {
    // 模擬批量下載
    alert('開始下載所有作業...');
}

function exportStudentData() {
    // 模擬匯出功能
    alert('匯出學生資料...');
}

// 顯示打卡歷史記錄
function showCheckinHistory(studentId, studentName) {
    // 更新彈窗標題
    document.getElementById('checkinHistoryModalLabel').innerHTML = 
        studentName + ' 的打卡歷史記錄';
    
    // 顯示載入狀態
    document.getElementById('checkinHistoryContent').innerHTML = 
        '<div class="text-center"><i class="fas fa-spinner fa-spin me-2"></i>載入打卡記錄中...</div>';
    
    // 顯示彈窗
    const modal = new bootstrap.Modal(document.getElementById('checkinHistoryModal'));
    modal.show();
    
    // 模擬載入打卡歷史內容
    setTimeout(() => {
        loadCheckinHistory(studentId, studentName);
    }, 800);
}

// 載入打卡歷史記錄
function loadCheckinHistory(studentId, studentName) {
    // 模擬打卡歷史數據
    const checkinHistory = [
        {
            date: '2024-09-25',
            time: '14:30',
            type: 'image',
            filename: 'homework_photo_1.jpg',
            status: 'submitted'
        },
        {
            date: '2024-09-25',
            time: '15:45',
            type: 'video',
            filename: 'homework_video_1.mp4',
            status: 'submitted'
        },
        {
            date: '2024-09-24',
            time: '16:20',
            type: 'text',
            content: '完成了今天的練習，感覺很有收穫！',
            status: 'submitted'
        },
        {
            date: '2024-09-23',
            time: '10:15',
            type: 'audio',
            filename: 'voice_note_1.mp3',
            status: 'submitted'
        }
    ];
    
    let historyHTML = `
        <div class="checkin-history">
            <div class="history-timeline">
    `;
    
    checkinHistory.forEach((record, index) => {
        historyHTML += `
            <div class="timeline-item-simple">
                ${record.date} ${record.time} 完成打卡作業
            </div>
        `;
    });
    
    historyHTML += `
            </div>
        </div>
    `;
    
    document.getElementById('checkinHistoryContent').innerHTML = historyHTML;
}

</script>
