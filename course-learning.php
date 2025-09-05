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
$pageJS = ['course-learning.js', 'learning-progress.js'];

// 獲取課程ID
$courseId = isset($_GET['course']) ? $_GET['course'] : '';

// 模擬課程數據
$courseData = [
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
                'video_url' => 'videos/lesson_1.mp4',
                'completed' => true,
                'exercises' => 3,
                'exercises_data' => [
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
                'video_url' => 'videos/lesson_2.mp4',
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
                'video_url' => 'videos/lesson_3.mp4',
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
                'video_url' => 'videos/lesson_4.mp4',
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
    // 家長教練基礎課程暫時隱藏
    /*
    'parent' => [
        'id' => 'parent',
        'title' => '家長教練基礎',
        'description' => '專為家長設計的教練基礎課程，幫助家長掌握有效的教練技巧，提升親子溝通和家庭教育效果。',
        'instructor' => '王教練',
        'duration' => '6週',
        'lessons' => 8,
        'progress' => 0,
        'status' => 'enrolled',
        'lessons_data' => [
            [
                'id' => 'parent_lesson_1',
                'title' => '第一課：家長教練的基本概念',
                'duration' => '40分鐘',
                'video_url' => 'videos/parent_lesson_1.mp4',
                'completed' => false,
                'exercises' => 2,
                'exercises_data' => [
                    [
                        'id' => 'parent_ex_1_1',
                        'type' => 'mc',
                        'question' => '家長教練的核心目標是什麼？',
                        'options' => [
                            'A. 控制孩子的行為',
                            'B. 幫助孩子發現自己的潛能',
                            'C. 提供標準答案',
                            'D. 批評孩子的錯誤'
                        ],
                        'correct_answer' => 1,
                        'explanation' => '家長教練的核心目標是通過引導和提問，幫助孩子發現自己的潛能和解決問題的能力。',
                        'points' => 10
                    ],
                    [
                        'id' => 'parent_ex_1_2',
                        'type' => 'text',
                        'question' => '請簡述家長教練與傳統教育方式的區別？',
                        'placeholder' => '請輸入您的答案...',
                        'correct_answers' => ['引導', '提問', '自主', '發現', '潛能', '解決問題'],
                        'explanation' => '家長教練注重引導和提問，讓孩子自主發現答案，而不是直接給出答案或控制行為。',
                        'points' => 15
                    ]
                ]
            ],
            [
                'id' => 'parent_lesson_2',
                'title' => '第二課：有效的親子溝通技巧',
                'duration' => '45分鐘',
                'video_url' => 'videos/parent_lesson_2.mp4',
                'completed' => false,
                'exercises' => 3,
                'exercises_data' => [
                    [
                        'id' => 'parent_ex_2_1',
                        'type' => 'mc',
                        'question' => '以下哪種溝通方式最符合教練式溝通？',
                        'options' => [
                            'A. "你應該這樣做"',
                            'B. "你覺得這樣做會怎麼樣？"',
                            'C. "聽我的就對了"',
                            'D. "你錯了"'
                        ],
                        'correct_answer' => 1,
                        'explanation' => '教練式溝通注重提問和引導，讓孩子自己思考和發現答案。',
                        'points' => 10
                    ],
                    [
                        'id' => 'parent_ex_2_2',
                        'type' => 'mc',
                        'question' => '傾聽在親子溝通中的重要性是什麼？',
                        'options' => [
                            'A. 讓孩子知道你在關注',
                            'B. 了解孩子的真實想法',
                            'C. 建立信任關係',
                            'D. 以上都是'
                        ],
                        'correct_answer' => 3,
                        'explanation' => '傾聽不僅能讓孩子感受到關注，還能了解真實想法，建立信任關係。',
                        'points' => 10
                    ],
                    [
                        'id' => 'parent_ex_2_3',
                        'type' => 'text',
                        'question' => '請描述一個有效的傾聽技巧？',
                        'placeholder' => '請輸入您的答案...',
                        'correct_answers' => ['眼神接觸', '點頭', '重複', '總結', '不插話', '專注'],
                        'explanation' => '有效的傾聽包括眼神接觸、點頭示意、重複關鍵詞、總結內容、不插話等技巧。',
                        'points' => 15
                    ]
                ]
            ],
            [
                'id' => 'parent_lesson_3',
                'title' => '第三課：設定親子目標',
                'duration' => '35分鐘',
                'video_url' => 'videos/parent_lesson_3.mp4',
                'completed' => false,
                'exercises' => 2,
                'exercises_data' => [
                    [
                        'id' => 'parent_ex_3_1',
                        'type' => 'mc',
                        'question' => 'SMART目標中的S代表什麼？',
                        'options' => [
                            'A. Simple（簡單）',
                            'B. Specific（具體）',
                            'C. Smart（聰明）',
                            'D. Strong（強壯）'
                        ],
                        'correct_answer' => 1,
                        'explanation' => 'SMART目標中的S代表Specific（具體），目標要明確具體。',
                        'points' => 10
                    ],
                    [
                        'id' => 'parent_ex_3_2',
                        'type' => 'text',
                        'question' => '請為孩子設定一個SMART目標的例子？',
                        'placeholder' => '請輸入您的答案...',
                        'correct_answers' => ['具體', '可衡量', '可達成', '相關', '有時限'],
                        'explanation' => 'SMART目標應該包含：具體、可衡量、可達成、相關、有時限五個要素。',
                        'points' => 20
                    ]
                ]
            ],
            [
                'id' => 'parent_lesson_4',
                'title' => '第四課：處理親子衝突',
                'duration' => '50分鐘',
                'video_url' => 'videos/parent_lesson_4.mp4',
                'completed' => false,
                'exercises' => 2,
                'exercises_data' => [
                    [
                        'id' => 'parent_ex_4_1',
                        'type' => 'mc',
                        'question' => '處理親子衝突的第一步是什麼？',
                        'options' => [
                            'A. 立即解決問題',
                            'B. 冷靜下來',
                            'C. 批評孩子',
                            'D. 忽略問題'
                        ],
                        'correct_answer' => 1,
                        'explanation' => '處理衝突的第一步是讓自己和對方都冷靜下來，避免情緒化反應。',
                        'points' => 10
                    ],
                    [
                        'id' => 'parent_ex_4_2',
                        'type' => 'text',
                        'question' => '請描述一個處理親子衝突的步驟？',
                        'placeholder' => '請輸入您的答案...',
                        'correct_answers' => ['冷靜', '傾聽', '理解', '溝通', '解決', '共識'],
                        'explanation' => '處理衝突的步驟包括：冷靜、傾聽、理解對方、有效溝通、尋找解決方案、達成共識。',
                        'points' => 15
                    ]
                ]
            ],
            [
                'id' => 'parent_lesson_5',
                'title' => '第五課：培養孩子的自主性',
                'duration' => '40分鐘',
                'video_url' => 'videos/parent_lesson_5.mp4',
                'completed' => false,
                'exercises' => 2,
                'exercises_data' => [
                    [
                        'id' => 'parent_ex_5_1',
                        'type' => 'mc',
                        'question' => '培養孩子自主性的關鍵是什麼？',
                        'options' => [
                            'A. 完全放手不管',
                            'B. 給予適當的選擇權',
                            'C. 嚴格控制',
                            'D. 替孩子做決定'
                        ],
                        'correct_answer' => 1,
                        'explanation' => '培養自主性的關鍵是給予孩子適當的選擇權，讓他們學會自己做決定。',
                        'points' => 10
                    ],
                    [
                        'id' => 'parent_ex_5_2',
                        'type' => 'text',
                        'question' => '如何幫助孩子建立責任感？',
                        'placeholder' => '請輸入您的答案...',
                        'correct_answers' => ['責任', '後果', '選擇', '承擔', '學習'],
                        'explanation' => '幫助孩子建立責任感需要讓他們理解選擇的後果，並承擔相應的責任。',
                        'points' => 15
                    ]
                ]
            ],
            [
                'id' => 'parent_lesson_6',
                'title' => '第六課：建立積極的家庭氛圍',
                'duration' => '45分鐘',
                'video_url' => 'videos/parent_lesson_6.mp4',
                'completed' => false,
                'exercises' => 2,
                'exercises_data' => [
                    [
                        'id' => 'parent_ex_6_1',
                        'type' => 'mc',
                        'question' => '積極家庭氛圍的核心是什麼？',
                        'options' => [
                            'A. 嚴格的家規',
                            'B. 無條件的愛和支持',
                            'C. 物質獎勵',
                            'D. 完美主義'
                        ],
                        'correct_answer' => 1,
                        'explanation' => '積極家庭氛圍的核心是無條件的愛和支持，讓孩子感受到安全和被接納。',
                        'points' => 10
                    ],
                    [
                        'id' => 'parent_ex_6_2',
                        'type' => 'text',
                        'question' => '如何創造積極的家庭氛圍？',
                        'placeholder' => '請輸入您的答案...',
                        'correct_answers' => ['愛', '支持', '鼓勵', '溝通', '尊重', '理解'],
                        'explanation' => '創造積極家庭氛圍需要：表達愛意、提供支持、給予鼓勵、保持溝通、相互尊重、理解包容。',
                        'points' => 15
                    ]
                ]
            ],
            [
                'id' => 'parent_lesson_7',
                'title' => '第七課：教練式提問技巧',
                'duration' => '50分鐘',
                'video_url' => 'videos/parent_lesson_7.mp4',
                'completed' => false,
                'exercises' => 3,
                'exercises_data' => [
                    [
                        'id' => 'parent_ex_7_1',
                        'type' => 'mc',
                        'question' => '以下哪個是開放式問題？',
                        'options' => [
                            'A. "你今天開心嗎？"',
                            'B. "你覺得今天發生了什麼有趣的事？"',
                            'C. "你吃飯了嗎？"',
                            'D. "你作業做完了嗎？"'
                        ],
                        'correct_answer' => 1,
                        'explanation' => '開放式問題鼓勵孩子思考和表達，而不是簡單的是非回答。',
                        'points' => 10
                    ],
                    [
                        'id' => 'parent_ex_7_2',
                        'type' => 'mc',
                        'question' => '教練式提問的目的是什麼？',
                        'options' => [
                            'A. 獲取信息',
                            'B. 幫助孩子自己發現答案',
                            'C. 測試孩子',
                            'D. 控制對話'
                        ],
                        'correct_answer' => 1,
                        'explanation' => '教練式提問的目的是幫助孩子自己思考和發現答案，而不是直接給出答案。',
                        'points' => 10
                    ],
                    [
                        'id' => 'parent_ex_7_3',
                        'type' => 'text',
                        'question' => '請舉例說明一個有效的教練式問題？',
                        'placeholder' => '請輸入您的答案...',
                        'correct_answers' => ['你覺得', '你認為', '你如何', '什麼', '如何', '為什麼'],
                        'explanation' => '有效的教練式問題通常以「你覺得」、「你認為」、「你如何」等開頭，鼓勵孩子思考。',
                        'points' => 15
                    ]
                ]
            ],
            [
                'id' => 'parent_lesson_8',
                'title' => '第八課：實踐與總結',
                'duration' => '60分鐘',
                'video_url' => 'videos/parent_lesson_8.mp4',
                'completed' => false,
                'exercises' => 1,
                'exercises_data' => [
                    [
                        'id' => 'parent_ex_8_1',
                        'type' => 'text',
                        'question' => '請總結你在本課程中學到的最重要的三點？',
                        'placeholder' => '請輸入您的答案...',
                        'correct_answers' => ['教練', '溝通', '引導', '提問', '傾聽', '目標', '衝突', '自主'],
                        'explanation' => '本課程涵蓋了家長教練的基本概念、溝通技巧、目標設定、衝突處理、自主性培養、家庭氛圍和提問技巧等核心內容。',
                        'points' => 30
                    ]
                ]
            ]
        ]
    ],
    */
    'team' => [
        'id' => 'team',
        'title' => '團隊教練培訓課程',
        'description' => '專注於團隊建設、協作和領導的教練培訓課程。',
        'instructor' => '李教練',
        'duration' => '6週',
        'lessons' => 8,
        'progress' => 25,
        'status' => 'in_progress',
        'lessons_data' => [
            [
                'id' => 'lesson_1',
                'title' => '第一課：團隊動力學',
                'duration' => '40分鐘',
                'video_url' => 'videos/team_lesson_1.mp4',
                'completed' => true,
                'exercises' => 2
            ],
            [
                'id' => 'lesson_2',
                'title' => '第二課：團隊協作技巧',
                'duration' => '45分鐘',
                'video_url' => 'videos/team_lesson_2.mp4',
                'completed' => false,
                'exercises' => 3
            ]
        ]
    ]
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
        <!-- Course Header -->
        <section class="course-header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="course-header-content">
                            <!-- Breadcrumb -->
                            <nav aria-label="breadcrumb" class="course-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo BASE_URL; ?>/">首頁</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo BASE_URL; ?>/my-courses">
                                            <i class="fas fa-graduation-cap me-1"></i>我的課程
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?php echo e($currentCourse['title']); ?>
                                    </li>
                                </ol>
                            </nav>
                            
                            <!-- Course Info -->
                            <div class="course-info">
                                <div class="course-title-section">
                                    <h1 class="course-title"><?php echo e($currentCourse['title']); ?></h1>
                                    <div class="course-meta">
                                        <span class="course-instructor">
                                            <i class="fas fa-user-tie me-1"></i>
                                            指導教練：<?php echo e($currentCourse['instructor']); ?>
                                        </span>
                                        <span class="course-duration">
                                            <i class="fas fa-clock me-1"></i>
                                            課程時長：<?php echo e($currentCourse['duration']); ?>
                                        </span>
                                        <span class="course-lessons">
                                            <i class="fas fa-play-circle me-1"></i>
                                            共 <?php echo e($currentCourse['lessons']); ?> 個章節
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Progress Section -->
                                <div class="course-progress-section">
                                    <div class="progress-info">
                                        <span class="progress-label">學習進度</span>
                                        <span class="progress-percentage"><?php echo e($currentCourse['progress']); ?>%</span>
                                    </div>
                                    <div class="progress-bar-container">
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: <?php echo e($currentCourse['progress']); ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
                                                    <h4 class="lesson-title"><?php echo e($lesson['title']); ?></h4>
                                                    <div class="lesson-meta">
                                                        <span class="lesson-duration">
                                                            <i class="fas fa-clock me-1"></i>
                                                            <?php echo e($lesson['duration']); ?>
                                                        </span>
                                                        <span class="lesson-exercises">
                                                            <i class="fas fa-question-circle me-1"></i>
                                                            <?php echo e($lesson['exercises']); ?> 個練習
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
                                <h2 class="lesson-title"><?php echo e($currentLesson['title']); ?></h2>
                                <div class="lesson-meta">
                                    <span class="lesson-duration">
                                        <i class="fas fa-clock me-1"></i>
                                        <?php echo e($currentLesson['duration']); ?>
                                    </span>
                                    <span class="lesson-exercises">
                                        <i class="fas fa-question-circle me-1"></i>
                                        <?php echo e($currentLesson['exercises']); ?> 個練習
                                    </span>
                                    <?php if ($currentLesson['completed']): ?>
                                        <span class="lesson-status completed">
                                            <i class="fas fa-check-circle me-1"></i>
                                            已完成
                                        </span>
                                    <?php else: ?>
                                        <span class="lesson-status pending">
                                            <i class="fas fa-play-circle me-1"></i>
                                            進行中
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Video Player Area -->
                            <div class="video-section">
                                <div class="video-container">
                                    <div class="video-player" id="video-player">
                                        <video id="lesson-video" preload="metadata" poster="<?php echo BASE_URL; ?>/assets/images/video-poster.jpg">
                                            <!-- 演示用視頻源 - 可以替換為實際視頻文件 -->
                                            <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4">
                                            <!-- 備用本地視頻源 -->
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

                            <!-- Exercise Section -->
                            <div class="exercise-section">
                                <div class="section-header">
                                    <h3>練習題</h3>
                                    <div class="exercise-info">
                                        <span class="exercise-count">共 <?php echo e($currentLesson['exercises']); ?> 題</span>
                                        <span class="exercise-progress" id="exercise-progress">0/<?php echo e($currentLesson['exercises']); ?></span>
                                    </div>
                                </div>
                                
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
                                                     id="exercise-<?php echo $index; ?>" data-exercise-id="<?php echo e($exercise['id']); ?>">
                                                    
                                                    <!-- Question Header -->
                                                    <div class="question-header">
                                                        <div class="question-number">
                                                            <span>第 <?php echo $index + 1; ?> 題</span>
                                                            <span class="question-points"><?php echo e($exercise['points']); ?> 分</span>
                                                        </div>
                                                        <div class="question-timer" id="timer-<?php echo $index; ?>">
                                                            <i class="fas fa-clock"></i>
                                                            <span>建議時間：2分鐘</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Question Content -->
                                                    <div class="question-content">
                                                        <h4 class="question-text"><?php echo e($exercise['question']); ?></h4>
                                                        
                                                        <?php if ($exercise['type'] === 'mc'): ?>
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
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <!-- Question Actions -->
                                                    <div class="question-actions">
                                                        <button class="btn btn-outline-secondary" id="hint-btn-<?php echo $index; ?>" disabled>
                                                            <i class="fas fa-lightbulb me-1"></i>
                                                            提示
                                                        </button>
                                                        <button class="btn btn-primary" id="submit-btn-<?php echo $index; ?>" disabled>
                                                            <i class="fas fa-check me-1"></i>
                                                            提交答案
                                                        </button>
                                                    </div>
                                                    
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
                                    $currentIndex = array_search($currentLessonId, array_column($currentCourse['lessons_data'], 'id'));
                                    $prevLesson = $currentIndex > 0 ? $currentCourse['lessons_data'][$currentIndex - 1] : null;
                                    $nextLesson = $currentIndex < count($currentCourse['lessons_data']) - 1 ? $currentCourse['lessons_data'][$currentIndex + 1] : null;
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
                                    
                                    <?php if ($nextLesson): ?>
                                        <a href="<?php echo BASE_URL; ?>/course-learning?course=<?php echo $courseId; ?>&lesson=<?php echo $nextLesson['id']; ?>" class="btn btn-primary">
                                            下一課：<?php echo e($nextLesson['title']); ?>
                                            <i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-success">
                                            <i class="fas fa-certificate me-1"></i>
                                            完成課程
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

<?php require_once 'includes/footer-user.php'; ?>
    <!-- JavaScript 由 footer-user.php 處理 -->
