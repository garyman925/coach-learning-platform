<?php
// 包含必要的文件
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/user-management.php';

// 啟動會話
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 檢查用戶是否已登入
$userManagement = new UserManagement();
if (!$userManagement->isLoggedIn()) {
    header('Location: ' . BASE_URL . '/login-page');
    exit;
}

// 獲取當前用戶信息
$currentUser = $userManagement->getCurrentUser();

// 設置頁面特定變數
$pageTitle = '課程學習 - ' . SITE_NAME;
$pageDescription = '在線學習專業教練課程';
$pageKeywords = '課程學習,在線教育,教練培訓,學習進度';
$pageCSS = ['course-learning.css', 'pages/user-layout.css'];

// 隱藏用戶導航列表
$hideUserNav = true;
$pageJS = ['course-learning.js', 'learning-progress.js'];

// 獲取課程ID
$courseId = isset($_GET['course']) ? $_GET['course'] : '';

// 模擬課程數據
$courseData = [
    'coffee-moment' => [
        'id' => 'coffee-moment',
        'title' => '教練咖啡時刻',
        'description' => '專業教練交流活動，分享教練經驗和技巧。',
        'instructor' => 'Gloria Hung',
        'duration' => '2小時',
        'lessons' => 1,
        'progress' => 0,
        'status' => 'enrolled',
        'lessons_data' => [
            [
                'id' => 'coffee_checkin',
                'title' => '教練咖啡時刻 - 打卡',
                'sidebar_title' => '打卡',
                'header_title' => '教練咖啡時刻 - 打卡活動',
                'duration' => '10分鐘',
                'video_url' => 'coffee_check.mp4',
                'completed' => false,
                'exercises' => 1,
                'exercises_data' => [
                    [
                        'id' => 'checkin_exercise',
                        'type' => 'checkin',
                        'title' => '打卡練習',
                        'description' => '請觀看影片後，填寫您的想法並上傳相關資料',
                        'video_url' => 'coffee_check.mp4',
                        'text_placeholder' => '請分享您對教練咖啡時刻的想法和期待...',
                        'file_upload_types' => ['image', 'video', 'audio'],
                        'completed' => false
                    ]
                ]
            ]
        ]
    ],
    'professional' => [
        'id' => 'professional',
        'title' => '專業教練認證課程',
        'description' => '這是一個全面的專業教練認證課程，涵蓋教練技能、溝通技巧、領導力發展等核心內容。',
        'instructor' => '張教練',
        'duration' => '8週',
        'lessons' => 12,
        'progress' => 60,
        'status' => 'in_progress',
        'lessons_data' => [
            [
                'id' => 'lesson_1',
                'title' => '第一課：教練基礎概念',
                'duration' => '45分鐘',
                'video_url' => 'coffee_check.mp4',
                'completed' => true,
                'exercises' => 5,
                'exercises_data' => [
                    // 類型1：只有影片 + 完成
                    [
                        'id' => 'ex_1_v1',
                        'type' => 'video',
                        'media_url' => 'coffee_check.mp4',
                        'question' => '請觀看以下短片，準備進入下一題。',
                        'explanation' => '',
                        'points' => 0
                    ],
                    [
                        'id' => 'ex_1_1',
                        'type' => 'mc',
                        'question' => '教練的核心目標是什麼？',
                        'options' => [
                            'A. 直接告訴學員答案',
                            'B. 幫助學員發現自己的潛能和解決方案',
                            'C. 批評學員的錯誤行為',
                            'D. 提供標準化的培訓內容'
                        ],
                        'correct_answer' => 1,
                        'explanation' => '教練的核心目標是通過提問和引導，幫助學員自己發現答案和解決方案，而不是直接給出答案。',
                        'points' => 10
                    ],
                    // 類型3：只有聲音 + 完成
                    [
                        'id' => 'ex_1_a1',
                        'type' => 'audio',
                        'media_url' => 'audios/exercise_audio_1.mp3',
                        'question' => '請聆聽以下音檔，準備進入下一題。',
                        'explanation' => '',
                        'points' => 0
                    ],
                    // 類型4：問題文字 + 完成
                    [
                        'id' => 'ex_1_t1',
                        'type' => 'text_block',
                        'text' => '想一想：在教練對話中，如何通過提問讓學員更聚焦？',
                        'question' => '閱讀上述文字後，點擊完成進入下一題。',
                        'explanation' => '',
                        'points' => 0
                    ],
                    [
                        'id' => 'ex_1_2',
                        'type' => 'text',
                        'question' => '請簡述GROW模型的四個階段分別代表什麼？',
                        'placeholder' => '請輸入您的答案...',
                        'correct_answers' => ['目標', '現狀', '選項', '意願', 'Goal', 'Reality', 'Options', 'Will'],
                        'explanation' => 'GROW模型包含四個階段：G-Goal（目標）、R-Reality（現狀）、O-Options（選項）、W-Will（意願）。這是一個系統性的教練會話框架。',
                        'points' => 15
                    ],
                    [
                        'id' => 'ex_1_3',
                        'type' => 'mc',
                        'question' => '以下哪個是教練與顧問的主要區別？',
                        'options' => [
                            'A. 教練收費更高',
                            'B. 教練專注於引導而非建議',
                            'C. 教練需要更多經驗',
                            'D. 教練只針對個人'
                        ],
                        'correct_answer' => 1,
                        'explanation' => '教練主要通過引導和提問幫助學員自己找到答案，而顧問則直接提供專業建議和解決方案。',
                        'points' => 10
                    ]
                ]
            ],
            [
                'id' => 'lesson_2',
                'title' => '第二課：有效溝通技巧',
                'duration' => '50分鐘',
                'video_url' => 'coffee_checkin.mp4',
                'completed' => true,
                'exercises' => 3,
                'exercises_data' => [
                    [
                        'id' => 'ex_2_1',
                        'type' => 'mc',
                        'question' => '傾聽的最高層次是什麼？',
                        'options' => [
                            'A. 聽到聲音',
                            'B. 理解內容',
                            'C. 感受情感',
                            'D. 給予回應'
                        ],
                        'correct_answer' => 2,
                        'explanation' => '傾聽的最高層次是感受情感，即不僅聽到內容，更要理解對方的情感和需求。',
                        'points' => 10
                    ],
                    [
                        'id' => 'ex_2_2',
                        'type' => 'text',
                        'question' => '請列舉三個開放式問題的例子，並說明為什麼它們是開放式的？',
                        'placeholder' => '例如：1. 你覺得... 2. 你認為... 3. 你如何...',
                        'correct_answers' => ['什麼', '如何', '為什麼', '你覺得', '你認為', '你如何', '開放式'],
                        'explanation' => '開放式問題通常以"什麼"、"如何"、"為什麼"、"你覺得"等詞開頭，能夠引導對方深入思考和表達，而不是簡單的是或否回答。',
                        'points' => 15
                    ],
                    [
                        'id' => 'ex_2_3',
                        'type' => 'mc',
                        'question' => '在教練會話中，什麼時候應該保持沉默？',
                        'options' => [
                            'A. 學員思考時',
                            'B. 學員情緒激動時',
                            'C. 學員表達困難時',
                            'D. 以上都是'
                        ],
                        'correct_answer' => 3,
                        'explanation' => '在教練會話中，適當的沉默可以給學員思考空間，讓情緒平復，或鼓勵他們繼續表達。',
                        'points' => 10
                    ]
                ]
            ],
            [
                'id' => 'lesson_3',
                'title' => '第三課：目標設定與規劃',
                'duration' => '40分鐘',
                'video_url' => 'coffee_checkin.mp4',
                'completed' => false,
                'exercises' => 3,
                'exercises_data' => [
                    [
                        'id' => 'ex_3_1',
                        'type' => 'mc',
                        'question' => 'SMART目標中的"S"代表什麼？',
                        'options' => [
                            'A. Specific（具體的）',
                            'B. Simple（簡單的）',
                            'C. Strong（強烈的）',
                            'D. Smart（聰明的）'
                        ],
                        'correct_answer' => 0,
                        'explanation' => 'SMART目標中的"S"代表Specific（具體的），目標應該明確具體，避免模糊不清。',
                        'points' => 10
                    ],
                    [
                        'id' => 'ex_3_2',
                        'type' => 'text',
                        'question' => '請寫出SMART目標的完整含義，並舉一個具體的例子？',
                        'placeholder' => 'S-具體的，M-可衡量的，A-可達成的，R-相關的，T-有時限的...',
                        'correct_answers' => ['Specific', 'Measurable', 'Achievable', 'Relevant', 'Time-bound', '具體', '可衡量', '可達成', '相關', '有時限'],
                        'explanation' => 'SMART目標包含：S-Specific（具體的）、M-Measurable（可衡量的）、A-Achievable（可達成的）、R-Relevant（相關的）、T-Time-bound（有時限的）。例如：在3個月內完成專業教練認證課程。',
                        'points' => 15
                    ],
                    [
                        'id' => 'ex_3_3',
                        'type' => 'mc',
                        'question' => '行動計劃應該包含哪些要素？',
                        'options' => [
                            'A. 只有時間安排',
                            'B. 只有資源需求',
                            'C. 時間、資源、責任人',
                            'D. 只有預算'
                        ],
                        'correct_answer' => 2,
                        'explanation' => '行動計劃應該包含時間安排、所需資源和責任人，這樣才能確保計劃的可執行性。',
                        'points' => 10
                    ]
                ]
            ],
            [
                'id' => 'lesson_4',
                'title' => '第四課：領導力發展',
                'duration' => '55分鐘',
                'video_url' => 'coffee_checkin.mp4',
                'completed' => false,
                'exercises' => 3,
                'exercises_data' => [
                    [
                        'id' => 'ex_4_1',
                        'type' => 'mc',
                        'question' => '變革型領導的核心特徵是什麼？',
                        'options' => [
                            'A. 嚴格控制',
                            'B. 激勵和啟發',
                            'C. 避免風險',
                            'D. 維持現狀'
                        ],
                        'correct_answer' => 1,
                        'explanation' => '變革型領導的核心特徵是激勵和啟發團隊成員，幫助他們超越自我，實現更高目標。',
                        'points' => 10
                    ],
                    [
                        'id' => 'ex_4_2',
                        'type' => 'text',
                        'question' => '請描述一個有效的團隊建設策略，並說明為什麼它有效？',
                        'placeholder' => '例如：建立信任、促進溝通、設定共同目標...',
                        'correct_answers' => ['信任', '溝通', '目標', '協作', '尊重', '透明', '反饋', '團隊'],
                        'explanation' => '有效的團隊建設策略包括：建立信任關係、促進開放溝通、設定共同目標、鼓勵協作、相互尊重、保持透明度、提供建設性反饋等。這些策略能夠增強團隊凝聚力和工作效率。',
                        'points' => 15
                    ],
                    [
                        'id' => 'ex_4_3',
                        'type' => 'mc',
                        'question' => '領導力發展的基礎是什麼？',
                        'options' => [
                            'A. 職位權力',
                            'B. 自我認知',
                            'C. 外部認可',
                            'D. 團隊規模'
                        ],
                        'correct_answer' => 1,
                        'explanation' => '領導力發展的基礎是自我認知，了解自己的優勢、劣勢和價值觀是成為有效領導者的前提。',
                        'points' => 10
                    ]
                ]
            ]
        ]
    ],
    
];

// 獲取當前課程數據
$currentCourse = isset($courseData[$courseId]) ? $courseData[$courseId] : null;

// 如果課程不存在，重定向到我的課程頁面
if (!$currentCourse) {
    header('Location: ' . BASE_URL . '/my-courses');
    exit;
}

// 獲取當前課程章節
$currentLessonId = isset($_GET['lesson']) ? $_GET['lesson'] : $currentCourse['lessons_data'][0]['id'];
$currentLesson = null;

foreach ($currentCourse['lessons_data'] as $lesson) {
    if ($lesson['id'] === $currentLessonId) {
        $currentLesson = $lesson;
        break;
    }
}

// 如果章節不存在，使用第一個章節
if (!$currentLesson) {
    $currentLesson = $currentCourse['lessons_data'][0];
    $currentLessonId = $currentLesson['id'];
}

// 包含用戶頁面 header
require_once 'includes/header-user.php';
?>

    <!-- Main Content -->
    <main class="course-learning-main">

        <!-- Learning Content -->
        <section class="learning-content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar - Course Navigation -->
                    <div class="col-lg-3 col-md-4">
                        <div class="course-sidebar">
                            <div class="sidebar-header">
                                <h3>課程章節</h3>
                                <button class="sidebar-toggle d-lg-none" type="button">
                                    <i class="fas fa-bars"></i>
                                </button>
                            </div>
                            
                            <div class="sidebar-content">
                                <div class="lessons-list">
                                    <?php foreach ($currentCourse['lessons_data'] as $index => $lesson): ?>
                                        <div class="lesson-item <?php echo $lesson['id'] === $currentLessonId ? 'active' : ''; ?> <?php echo $lesson['completed'] ? 'completed' : ''; ?>">
                                            <a href="<?php echo BASE_URL; ?>/course-learning?course=<?php echo $courseId; ?>&lesson=<?php echo $lesson['id']; ?>" class="lesson-link">
                                                <div class="lesson-number">
                                                    <?php if ($lesson['completed']): ?>
                                                        <i class="fas fa-check-circle"></i>
                                                    <?php else: ?>
                                                        <span><?php echo $index + 1; ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="lesson-content">
                                                    <h4 class="lesson-title"><?php echo e(isset($lesson['sidebar_title']) ? $lesson['sidebar_title'] : $lesson['title']); ?></h4>
                                                    <div class="lesson-meta">
                                                        <span class="lesson-duration">
                                                            <i class="fas fa-clock me-1"></i>
                                                            <?php echo e($currentCourse['duration']); ?>
                                                        </span>
                                                        <span class="lesson-instructor">
                                                            <i class="fas fa-user me-1"></i>
                                                            <?php echo e($currentCourse['instructor']); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Area -->
                    <div class="col-lg-9 col-md-8">
                        <div class="learning-main">
                            <!-- Current Lesson Header -->
                            <div class="lesson-header">
                                <div class="lesson-header-top">
                                    <h2 class="lesson-title"><?php echo e(isset($currentLesson['header_title']) ? $currentLesson['header_title'] : $currentLesson['title']); ?></h2>
                                    <a href="<?php echo BASE_URL; ?>/my-courses" class="btn-back-to-courses">
                                        <i class="fas fa-arrow-left me-2"></i>返回主目錄
                                    </a>
                                </div>
                                <div class="lesson-meta">
                                    <span class="lesson-duration">
                                        <i class="fas fa-clock me-1"></i>
                                        <?php echo e($currentCourse['duration']); ?>
                                    </span>
                                    <span class="lesson-instructor">
                                        <i class="fas fa-user me-1"></i>
                                        <?php echo e($currentCourse['instructor']); ?>
                                    </span>
                                    <?php if ($currentLesson['completed']): ?>
                                        <span class="lesson-status completed">
                                            <i class="fas fa-check-circle me-1"></i>
                                            已完成
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Video Player Area -->
                            <?php
                            $embedVideoInExercises = false;
                            if (isset($currentLesson['exercises_data']) && is_array($currentLesson['exercises_data'])) {
                                foreach ($currentLesson['exercises_data'] as $ex) {
                                    if (isset($ex['type']) && ($ex['type'] === 'mc' || $ex['type'] === 'video')) {
                                        $embedVideoInExercises = true;
                                        break;
                                    }
                                }
                            }
                            if (!$embedVideoInExercises && !isset($currentLesson['exercises_data'][0]['type']) || (isset($currentLesson['exercises_data'][0]['type']) && $currentLesson['exercises_data'][0]['type'] !== 'checkin')):
                            ?>
                            <div class="video-section">
                                <div class="video-container">
                                    <div class="video-player" id="video-player">
                                        <video id="lesson-video" preload="metadata" poster="<?php echo BASE_URL; ?>/assets/images/video-poster.jpg">
                                            <!-- 課程視頻源 -->
                                            <source src="<?php echo BASE_URL; ?>/assets/videos/<?php echo e($currentLesson['video_url']); ?>" type="video/mp4">
                                            您的瀏覽器不支持視頻播放。
                                        </video>
                                        
                                        <!-- Custom Video Controls -->
                                        <div class="video-controls-overlay" id="video-controls-overlay">
                                            <div class="video-controls-top">
                                                <div class="video-title">
                                                    <h4><?php echo e($currentLesson['title']); ?></h4>
                                                </div>
                                                <div class="video-actions">
                                                    <button class="control-btn" id="quality-btn" title="視頻質量">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <button class="control-btn" id="pip-btn" title="畫中畫">
                                                        <i class="fas fa-expand-arrows-alt"></i>
                                                    </button>
                                                    <button class="control-btn" id="fullscreen-btn" title="全屏">
                                                        <i class="fas fa-expand"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="video-controls-center">
                                                <button class="play-btn-large" id="play-btn-large">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            </div>
                                            
                                            <div class="video-controls-bottom">
                                                <div class="progress-container">
                                                    <div class="progress-bar" id="progress-bar">
                                                        <div class="progress-fill" id="progress-fill"></div>
                                                        <div class="progress-handle" id="progress-handle"></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-buttons">
                                                    <div class="left-controls">
                                                        <button class="control-btn" id="play-pause-btn" title="播放/暫停">
                                                            <i class="fas fa-play"></i>
                                                        </button>
                                                        <button class="control-btn" id="rewind-btn" title="快退10秒">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                        <button class="control-btn" id="forward-btn" title="快進10秒">
                                                            <i class="fas fa-redo"></i>
                                                        </button>
                                                        <div class="volume-control">
                                                            <button class="control-btn" id="mute-btn" title="靜音">
                                                                <i class="fas fa-volume-up"></i>
                                                            </button>
                                                            <div class="volume-slider" id="volume-slider">
                                                                <div class="volume-fill" id="volume-fill"></div>
                                                                <div class="volume-handle" id="volume-handle"></div>
                                                            </div>
                                                        </div>
                                                        <div class="time-display">
                                                            <span id="current-time">0:00</span>
                                                            <span class="time-separator">/</span>
                                                            <span id="duration">0:00</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="right-controls">
                                                        <div class="speed-control">
                                                            <button class="control-btn" id="speed-btn" title="播放速度">
                                                                <span id="speed-text">1x</span>
                                                            </button>
                                                            <div class="speed-menu" id="speed-menu">
                                                                <button class="speed-option" data-speed="0.5">0.5x</button>
                                                                <button class="speed-option" data-speed="0.75">0.75x</button>
                                                                <button class="speed-option active" data-speed="1">1x</button>
                                                                <button class="speed-option" data-speed="1.25">1.25x</button>
                                                                <button class="speed-option" data-speed="1.5">1.5x</button>
                                                                <button class="speed-option" data-speed="2">2x</button>
                                                            </div>
                                                        </div>
                                                        <button class="control-btn" id="settings-btn" title="設置">
                                                            <i class="fas fa-cog"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Quality Menu -->
                                        <div class="quality-menu" id="quality-menu">
                                            <div class="menu-header">
                                                <h5>視頻質量</h5>
                                                <button class="close-menu" id="close-quality-menu">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="quality-options">
                                                <button class="quality-option active" data-quality="auto">
                                                    <span class="quality-label">自動</span>
                                                    <span class="quality-desc">根據網絡自動調整</span>
                                                </button>
                                                <button class="quality-option" data-quality="1080p">
                                                    <span class="quality-label">1080p</span>
                                                    <span class="quality-desc">高清</span>
                                                </button>
                                                <button class="quality-option" data-quality="720p">
                                                    <span class="quality-label">720p</span>
                                                    <span class="quality-desc">標清</span>
                                                </button>
                                                <button class="quality-option" data-quality="480p">
                                                    <span class="quality-label">480p</span>
                                                    <span class="quality-desc">流暢</span>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Loading Spinner -->
                                        <div class="video-loading" id="video-loading">
                                            <div class="loading-spinner">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </div>
                                            <p>視頻加載中...</p>
                                        </div>
                                        
                                        <!-- Error Message -->
                                        <div class="video-error" id="video-error" style="display: none;">
                                            <div class="error-content">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                <h4>視頻加載失敗</h4>
                                                <p>請檢查網絡連接或稍後再試</p>
                                                <button class="btn btn-primary" id="retry-btn">
                                                    <i class="fas fa-redo me-1"></i>
                                                    重新加載
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Exercise Section -->
                            <div class="exercise-section">
                                
                                
                                <!-- Exercise Container -->
                                <div class="exercise-container" id="exercise-container">
                                    <?php if (isset($currentLesson['exercises_data']) && !empty($currentLesson['exercises_data'])): ?>
                                        <!-- Exercise Navigation -->
                                        <div class="exercise-navigation">
                                            <div class="exercise-tabs">
                                                <?php foreach ($currentLesson['exercises_data'] as $index => $exercise): ?>
                                                    <button class="exercise-tab <?php echo $index === 0 ? 'active' : ''; ?>" 
                                                            data-exercise="<?php echo $index; ?>">
                                                        <span class="tab-number"><?php echo $index + 1; ?></span>
                                                        <span class="tab-status" id="tab-status-<?php echo $index; ?>">
                                                            <i class="fas fa-circle"></i>
                                                        </span>
                                                    </button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        
                                        <!-- Exercise Content -->
                                        <div class="exercise-content">
                                            <?php foreach ($currentLesson['exercises_data'] as $index => $exercise): ?>
                                                <div class="exercise-question <?php echo $index === 0 ? 'active' : ''; ?>" 
                                                     id="exercise-<?php echo $index; ?>" data-exercise-id="<?php echo e($exercise['id']); ?>" data-exercise-type="<?php echo e($exercise['type']); ?>">
                                                    
                                                    <!-- Question Header - 隱藏 -->
                                                    <div class="question-header" style="display: none;">
                                                        <div class="question-number">
                                                            <span>第 <?php echo $index + 1; ?> 題</span>
                                                        </div>
                                                        <div class="exercise-info">
                                                            <span class="exercise-count">共 <?php echo e($currentLesson['exercises']); ?> 題</span>
                                                            <span class="exercise-progress" id="exercise-progress">0/<?php echo e($currentLesson['exercises']); ?></span>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Question Content -->
                                                    <div class="question-content">
                                                        <?php if ($exercise['type'] === 'mc'): ?>
                                                            <div class="video-section" style="padding: 1rem;">
                                                                <div class="video-container">
                                                                    <video controls width="100%">
                                                                        <source src="<?php echo BASE_URL; ?>/assets/<?php echo e($currentLesson['video_url']); ?>" type="video/mp4">
                                                                    </video>
                                                                </div>
                                                            </div>
                                                            <p style="margin: 1rem; color: #6b7280;">觀看影片後回答以下選擇題：</p>
                                                             <h4 class="question-text"><?php echo e($exercise['question']); ?></h4>
                                                             <!-- Multiple Choice Options -->
                                                             <div class="answer-options">
                                                                 <?php foreach ($exercise['options'] as $optionIndex => $option): ?>
                                                                     <div class="option-item" data-option="<?php echo $optionIndex; ?>">
                                                                         <input type="radio" 
                                                                                name="answer-<?php echo $index; ?>" 
                                                                                value="<?php echo $optionIndex; ?>" 
                                                                                id="option-<?php echo $index; ?>-<?php echo $optionIndex; ?>"
                                                                                class="option-input">
                                                                         <label for="option-<?php echo $index; ?>-<?php echo $optionIndex; ?>" class="option-label">
                                                                             <span class="option-letter"><?php echo chr(65 + $optionIndex); ?></span>
                                                                             <span class="option-text"><?php echo e($option); ?></span>
                                                                         </label>
                                                                     </div>
                                                                 <?php endforeach; ?>
                                                             </div>
                                                         <?php elseif ($exercise['type'] === 'text'): ?>
                                                             <h4 class="question-text"><?php echo e($exercise['question']); ?></h4>
                                                             <!-- Text Input -->
                                                             <div class="text-answer-container">
                                                                 <textarea 
                                                                     id="text-answer-<?php echo $index; ?>" 
                                                                     name="text-answer-<?php echo $index; ?>" 
                                                                     class="text-answer-input" 
                                                                     placeholder="<?php echo e($exercise['placeholder']); ?>"
                                                                     rows="4"
                                                                     data-exercise-index="<?php echo $index; ?>"></textarea>
                                                                 <div class="text-answer-hint">
                                                                     <i class="fas fa-info-circle"></i>
                                                                     <span>請詳細回答問題，答案將根據關鍵詞進行評分</span>
                                                                 </div>
                                                             </div>
                                                         <?php elseif ($exercise['type'] === 'video'): ?>
                                                            <div class="video-section" style="padding: 1rem;">
                                                                <div class="video-container">
                                                                    <video controls width="100%">
                                                                        <source src="<?php echo BASE_URL; ?>/assets/<?php echo e($exercise['media_url']); ?>" type="video/mp4">
                                                                    </video>
                                                                </div>
                                                            </div>
                                                            <p style="margin: 1rem; color: #6b7280;">觀看影片後，點擊完成前往下一題。</p>
                                                        <?php elseif ($exercise['type'] === 'audio'): ?>
                                                            <div style="padding: 1rem;">
                                                                <audio controls style="width:100%">
                                                                    <source src="<?php echo BASE_URL; ?>/assets/<?php echo e($exercise['media_url']); ?>" type="audio/mpeg">
                                                                </audio>
                                                            </div>
                                                            <p style="margin: 1rem; color: #6b7280;">聆聽音檔後，點擊完成前往下一題。</p>
                                                        <?php elseif ($exercise['type'] === 'text_block'): ?>
                                                            <div style="padding: 1rem;">
                                                                <div style="background:#f8f9fa; border:1px solid #e9ecef; border-radius:12px; padding:1rem; line-height:1.6; color:#374151;">
                                                                    <?php echo nl2br(e($exercise['text'])); ?>
                                                                </div>
                                                            </div>
                                                            <p style="margin: 1rem; color: #6b7280;">閱讀後，點擊完成前往下一題。</p>
                                                        <?php elseif ($exercise['type'] === 'checkin'): ?>
                                                            <!-- 打卡題型 -->
                                                            <div class="checkin-exercise">
                                                                <!-- 影片部分 -->
                                                                <div class="video-section" style="padding: 1rem;">
                                                                    <div class="video-container">
                                                                        <video controls width="100%">
                                                                            <source src="<?php echo BASE_URL; ?>/assets/videos/<?php echo e($exercise['video_url']); ?>" type="video/mp4">
                                                                        </video>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- 文字填寫部分 -->
                                                                <div class="text-input-section" style="padding: 1rem;">
                                                                    <h5 class="mb-3">請分享您的想法：</h5>
                                                                    <textarea class="form-control" rows="4" placeholder="<?php echo e($exercise['text_placeholder']); ?>" id="checkin-text-<?php echo $index; ?>"></textarea>
                                                                </div>
                                                                
                                                                <!-- 文件上傳部分 -->
                                                                <div class="file-upload-section" style="padding: 1rem;">
                                                                    <h5 class="mb-3">上傳資料：</h5>
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label class="upload-area" data-type="image" for="image-upload-<?php echo $index; ?>">
                                                                                <div class="upload-content">
                                                                                    <i class="fas fa-image fa-2x mb-2"></i>
                                                                                    <p>上傳照片</p>
                                                                                </div>
                                                                                <input type="file" accept="image/*" class="file-input" id="image-upload-<?php echo $index; ?>">
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label class="upload-area" data-type="video" for="video-upload-<?php echo $index; ?>">
                                                                                <div class="upload-content">
                                                                                    <i class="fas fa-video fa-2x mb-2"></i>
                                                                                    <p>上傳影片</p>
                                                                                </div>
                                                                                <input type="file" accept="video/*" class="file-input" id="video-upload-<?php echo $index; ?>">
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label class="upload-area" data-type="audio" for="audio-upload-<?php echo $index; ?>">
                                                                                <div class="upload-content">
                                                                                    <i class="fas fa-microphone fa-2x mb-2"></i>
                                                                                    <p>上傳錄音</p>
                                                                                </div>
                                                                                <input type="file" accept="audio/*" class="file-input" id="audio-upload-<?php echo $index; ?>">
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <!-- Question Actions - 已移除提交按鈕 -->
                                                    
                                                    <!-- Answer Feedback -->
                                                    <div class="answer-feedback" id="feedback-<?php echo $index; ?>" style="display: none;">
                                                        <div class="feedback-content">
                                                            <div class="feedback-header">
                                                                <div class="feedback-icon">
                                                                    <i class="fas fa-check-circle correct-icon" style="display: none;"></i>
                                                                    <i class="fas fa-times-circle incorrect-icon" style="display: none;"></i>
                                                                </div>
                                                                <div class="feedback-title">
                                                                    <h5 class="feedback-result"></h5>
                                                                    <p class="feedback-score"></p>
                                                                </div>
                                                            </div>
                                                            <div class="feedback-explanation">
                                                                <h6>解析：</h6>
                                                                <p><?php echo e($exercise['explanation']); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        
                                        <!-- Exercise Summary -->
                                        <div class="exercise-summary" id="exercise-summary" style="display: none;">
                                            <div class="summary-content">
                                                <div class="summary-header">
                                                    <h4><i class="fas fa-trophy me-2"></i>練習完成！</h4>
                                                </div>
                                                <div class="summary-stats">
                                                    <div class="stat-item">
                                                        <span class="stat-label">總分數</span>
                                                        <span class="stat-value" id="total-score">0</span>
                                                    </div>
                                                    <div class="stat-item">
                                                        <span class="stat-label">正確率</span>
                                                        <span class="stat-value" id="accuracy-rate">0%</span>
                                                    </div>
                                                    <div class="stat-item">
                                                        <span class="stat-label">用時</span>
                                                        <span class="stat-value" id="total-time">0:00</span>
                                                    </div>
                                                </div>
                                                <div class="summary-actions">
                                                    <button class="btn btn-outline-primary" id="review-answers">
                                                        <i class="fas fa-eye me-1"></i>
                                                        查看答案
                                                    </button>
                                                    <button class="btn btn-primary" id="next-lesson">
                                                        <i class="fas fa-arrow-right me-1"></i>
                                                        下一課
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="exercise-placeholder">
                                            <div class="placeholder-content">
                                                <i class="fas fa-question-circle"></i>
                                                <h4>暫無練習題</h4>
                                                <p>此章節暫無練習題，請觀看視頻學習。</p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="lesson-navigation">
                                <div class="nav-buttons">
                                    <?php
                                    // 兼容 PHP 5.4：手動實現 array_column 功能
                                    $lessonIds = array();
                                    foreach ($currentCourse['lessons_data'] as $lesson) {
                                        $lessonIds[] = $lesson['id'];
                                    }
                                    $currentIndex = array_search($currentLessonId, $lessonIds);
                                    $prevLesson = $currentIndex > 0 ? $currentCourse['lessons_data'][$currentIndex - 1] : null;
                                    $nextLesson = $currentIndex < count($currentCourse['lessons_data']) - 1 ? $currentCourse['lessons_data'][$currentIndex + 1] : null;
                                    
                                    // 檢查當前課程是否有下一題
                                    $hasNextExercise = isset($currentLesson['exercises_data']) && count($currentLesson['exercises_data']) > 1;
                                    ?>
                                    
                                    <?php if ($prevLesson): ?>
                                        <a href="<?php echo BASE_URL; ?>/course-learning?course=<?php echo $courseId; ?>&lesson=<?php echo $prevLesson['id']; ?>" class="btn btn-outline-primary">
                                            <i class="fas fa-chevron-left me-1"></i>
                                            上一課：<?php echo e($prevLesson['title']); ?>
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-outline-secondary" disabled>
                                            <i class="fas fa-chevron-left me-1"></i>
                                            沒有上一課
                                        </button>
                                    <?php endif; ?>
                                    
                                    <?php if ($hasNextExercise): ?>
                                        <button class="btn btn-primary" id="next-exercise-btn">
                                            前往下一題
                                            <i class="fas fa-chevron-right ms-1"></i>
                                        </button>
                                    <?php elseif ($nextLesson): ?>
                                        <a href="<?php echo BASE_URL; ?>/course-learning?course=<?php echo $courseId; ?>&lesson=<?php echo $nextLesson['id']; ?>" class="btn btn-primary">
                                            下一課：<?php echo e($nextLesson['title']); ?>
                                            <i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-success" id="submit-assignment-btn">
                                            <i class="fas fa-paper-plane me-1"></i>
                                            遞交作業給教練
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- 讚賞 Popup -->
    <div id="success-popup" class="success-popup-overlay" style="display: none;">
        <div class="success-popup-content">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="success-title">作業提交成功！</h3>
            <p class="success-message">感謝您的用心完成，教練將會仔細查看您的作業內容。</p>
            <div class="success-countdown">
                <span id="countdown-text">5</span> 秒後自動返回主目錄
            </div>
            <div class="success-actions">
                <button class="btn btn-primary" id="return-now-btn">立即返回</button>
            </div>
        </div>
    </div>

<?php require_once 'includes/footer-user.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing upload areas...');
    
    // 處理文件選擇事件
    const fileInputs = document.querySelectorAll('.file-input');
    console.log('Found file inputs:', fileInputs.length);
    
    fileInputs.forEach(function(fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const uploadArea = this.closest('.upload-area');
                if (uploadArea) {
                    // 添加已選擇文件的視覺反饋
                    uploadArea.classList.add('has-file');
                    
                    // 更新顯示文字
                    const uploadContent = uploadArea.querySelector('.upload-content p');
                    if (uploadContent) {
                        uploadContent.textContent = '已選擇: ' + file.name;
                    }
                    
                    console.log('選擇的文件:', file.name, '類型:', file.type);
                }
            }
        });
    });
    
    // 處理拖拽功能
    const uploadAreas = document.querySelectorAll('.upload-area');
    
    uploadAreas.forEach(function(uploadArea) {
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const fileInput = this.querySelector('.file-input');
                if (fileInput) {
                    // 模擬文件選擇
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(files[0]);
                    fileInput.files = dataTransfer.files;
                    
                    // 觸發 change 事件
                    const event = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(event);
                }
            }
        });
    });
    
    // 處理下一題按鈕
    const nextExerciseBtn = document.getElementById('next-exercise-btn');
    if (nextExerciseBtn) {
        nextExerciseBtn.addEventListener('click', function() {
            // 這裡可以添加切換到下一題的邏輯
            console.log('前往下一題');
            // 暫時顯示提示
            alert('前往下一題功能待實現');
        });
    }
    
    // 處理遞交作業按鈕
    const submitAssignmentBtn = document.getElementById('submit-assignment-btn');
    if (submitAssignmentBtn) {
        submitAssignmentBtn.addEventListener('click', function() {
            // 這裡可以添加遞交作業的邏輯
            console.log('遞交作業給教練');
            
            // 收集表單數據
            const textInput = document.querySelector('#checkin-text-0');
            const imageInput = document.querySelector('#image-upload-0');
            const videoInput = document.querySelector('#video-upload-0');
            const audioInput = document.querySelector('#audio-upload-0');
            
            let submissionData = {
                text: textInput ? textInput.value : '',
                files: {
                    image: imageInput ? imageInput.files[0] : null,
                    video: videoInput ? videoInput.files[0] : null,
                    audio: audioInput ? audioInput.files[0] : null
                }
            };
            
            console.log('提交的數據:', submissionData);
            
            // 顯示成功 popup
            showSuccessPopup();
            
            // 可以添加實際的提交邏輯，例如發送到服務器
        });
    }
    
    // 顯示成功 popup 的函數
    function showSuccessPopup() {
        const popup = document.getElementById('success-popup');
        const countdownText = document.getElementById('countdown-text');
        const returnNowBtn = document.getElementById('return-now-btn');
        
        // 顯示 popup
        popup.style.display = 'flex';
        
        // 防止背景滾動
        document.body.style.overflow = 'hidden';
        
        // 倒計時功能
        let countdown = 5;
        countdownText.textContent = countdown;
        
        const countdownInterval = setInterval(function() {
            countdown--;
            countdownText.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                // 自動跳轉到 my-courses.php
                window.location.href = '<?php echo BASE_URL; ?>/my-courses';
            }
        }, 1000);
        
        // 立即返回按鈕
        returnNowBtn.addEventListener('click', function() {
            clearInterval(countdownInterval);
            window.location.href = '<?php echo BASE_URL; ?>/my-courses';
        });
        
        // ESC 鍵關閉 popup
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                clearInterval(countdownInterval);
                popup.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
        
        // 點擊 overlay 關閉 popup
        popup.addEventListener('click', function(e) {
            if (e.target === popup) {
                clearInterval(countdownInterval);
                popup.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    }
});
</script>
