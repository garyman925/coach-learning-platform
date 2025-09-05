<?php
require_once 'includes/config.php';
require_once 'includes/user-management.php';
require_once 'includes/functions.php';

// 檢查用戶是否已登入
if (!$userManagement->isLoggedIn()) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

$currentUser = $userManagement->getCurrentUser();
$username = $currentUser['username'];

// 獲取搜索參數
$query = $_GET['q'] ?? '';
$type = $_GET['type'] ?? 'all';
$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? 'relevance';
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 12;
$offset = ($page - 1) * $limit;

// 模擬搜索數據
$searchResults = [
    'users' => [
        [
            'id' => 'user_001',
            'username' => 'coach_zhang',
            'name' => '張教練',
            'title' => '專業教練',
            'avatar' => 'default-avatar.svg',
            'followers' => 1250,
            'courses' => 8,
            'rating' => 4.8,
            'is_online' => true,
            'bio' => '擁有10年教練經驗，專精於個人發展和領導力培訓',
            'tags' => ['個人教練', '領導力', '職業發展'],
            'match_score' => 95
        ],
        [
            'id' => 'user_002',
            'username' => 'coach_li',
            'name' => '李教練',
            'title' => '團隊教練',
            'avatar' => 'default-avatar.svg',
            'followers' => 890,
            'courses' => 5,
            'rating' => 4.6,
            'is_online' => false,
            'bio' => '專注於團隊建設和組織發展，幫助企業提升團隊效能',
            'tags' => ['團隊教練', '組織發展', '團隊建設'],
            'match_score' => 88
        ],
        [
            'id' => 'user_003',
            'username' => 'coach_wang',
            'name' => '王教練',
            'title' => '生活教練',
            'avatar' => 'default-avatar.svg',
            'followers' => 650,
            'courses' => 3,
            'rating' => 4.7,
            'is_online' => true,
            'bio' => '幫助客戶實現工作與生活的平衡，提升生活品質',
            'tags' => ['生活教練', '工作平衡', '生活品質'],
            'match_score' => 82
        ]
    ],
    'courses' => [
        [
            'id' => 'course_001',
            'title' => '專業教練認證課程',
            'instructor' => '張教練',
            'instructor_id' => 'coach_zhang',
            'description' => '完整的專業教練認證課程，涵蓋教練核心技能和實踐應用',
            'category' => '專業教練',
            'level' => '中級',
            'duration' => '12週',
            'price' => 15000,
            'rating' => 4.8,
            'students' => 156,
            'image' => 'course-1.jpg',
            'tags' => ['教練認證', '專業技能', '實踐應用'],
            'match_score' => 92
        ],
        [
            'id' => 'course_002',
            'title' => '團隊教練技巧實戰',
            'instructor' => '李教練',
            'instructor_id' => 'coach_li',
            'description' => '學習有效的團隊教練技巧，提升團隊協作和效能',
            'category' => '團隊教練',
            'level' => '高級',
            'duration' => '8週',
            'price' => 12000,
            'rating' => 4.6,
            'students' => 89,
            'image' => 'course-2.jpg',
            'tags' => ['團隊教練', '協作技巧', '效能提升'],
            'match_score' => 85
        ],
        [
            'id' => 'course_003',
            'title' => '生活教練基礎入門',
            'instructor' => '王教練',
            'instructor_id' => 'coach_wang',
            'description' => '生活教練的基礎概念和實用技巧，幫助他人改善生活品質',
            'category' => '生活教練',
            'level' => '初級',
            'duration' => '6週',
            'price' => 8000,
            'rating' => 4.7,
            'students' => 234,
            'image' => 'course-3.jpg',
            'tags' => ['生活教練', '基礎入門', '生活品質'],
            'match_score' => 78
        ]
    ],
    'services' => [
        [
            'id' => 'service_001',
            'title' => '個人教練服務',
            'coach' => '張教練',
            'coach_id' => 'coach_zhang',
            'description' => '一對一個人教練服務，專注於個人發展和目標達成',
            'type' => 'personal_coaching',
            'duration' => 60,
            'price' => 2000,
            'rating' => 4.8,
            'sessions' => 45,
            'tags' => ['個人教練', '目標達成', '個人發展'],
            'match_score' => 90
        ],
        [
            'id' => 'service_002',
            'title' => '團隊教練服務',
            'coach' => '李教練',
            'coach_id' => 'coach_li',
            'description' => '專業團隊教練服務，提升團隊協作和組織效能',
            'type' => 'team_coaching',
            'duration' => 120,
            'price' => 5000,
            'rating' => 4.6,
            'sessions' => 23,
            'tags' => ['團隊教練', '組織效能', '團隊協作'],
            'match_score' => 87
        ]
    ],
    'discussions' => [
        [
            'id' => 'disc_001',
            'title' => '如何提高教練的傾聽技巧？',
            'content' => '在教練過程中，傾聽是非常重要的一項技能。我想請教各位有經驗的教練，如何提高傾聽技巧？',
            'author' => 'coach_zhang',
            'author_name' => '張教練',
            'category' => '教練技巧',
            'replies' => 12,
            'views' => 156,
            'likes' => 8,
            'timestamp' => '2024-02-15 09:30',
            'tags' => ['傾聽技巧', '教練技能', '溝通'],
            'match_score' => 88
        ],
        [
            'id' => 'disc_002',
            'title' => '團隊教練中的常見挑戰',
            'content' => '在進行團隊教練時，經常會遇到各種挑戰。大家有什麼好的解決方案嗎？',
            'author' => 'coach_li',
            'author_name' => '李教練',
            'category' => '團隊教練',
            'replies' => 8,
            'views' => 89,
            'likes' => 5,
            'timestamp' => '2024-02-14 16:20',
            'tags' => ['團隊教練', '挑戰解決', '最佳實踐'],
            'match_score' => 82
        ]
    ]
];

// 模擬推薦數據
$recommendations = [
    'trending' => [
        [
            'id' => 'course_004',
            'title' => 'AI時代的教練技能',
            'instructor' => '陳教練',
            'category' => '未來趨勢',
            'rating' => 4.9,
            'students' => 89,
            'trend_score' => 95
        ],
        [
            'id' => 'course_005',
            'title' => '數位化團隊管理',
            'instructor' => '劉教練',
            'category' => '數位轉型',
            'rating' => 4.7,
            'students' => 67,
            'trend_score' => 88
        ]
    ],
    'personalized' => [
        [
            'id' => 'course_006',
            'title' => '基於您的學習歷史推薦',
            'instructor' => '推薦系統',
            'category' => '個人化推薦',
            'rating' => 4.8,
            'students' => 123,
            'recommendation_reason' => '基於您對個人教練的興趣'
        ],
        [
            'id' => 'service_003',
            'title' => '個人化教練服務',
            'coach' => '推薦教練',
            'type' => 'personal_coaching',
            'rating' => 4.9,
            'sessions' => 34,
            'recommendation_reason' => '符合您的學習目標'
        ]
    ],
    'similar_users' => [
        [
            'id' => 'user_004',
            'username' => 'similar_user1',
            'name' => '相似用戶1',
            'title' => '學習者',
            'common_interests' => ['個人教練', '團隊建設'],
            'followers' => 45
        ],
        [
            'id' => 'user_005',
            'username' => 'similar_user2',
            'name' => '相似用戶2',
            'title' => '學習者',
            'common_interests' => ['生活教練', '工作平衡'],
            'followers' => 32
        ]
    ]
];

// 搜索統計
$searchStats = [
    'total_results' => 0,
    'users_count' => 0,
    'courses_count' => 0,
    'services_count' => 0,
    'discussions_count' => 0
];

// 計算搜索結果統計
if ($query) {
    $searchStats['users_count'] = count($searchResults['users']);
    $searchStats['courses_count'] = count($searchResults['courses']);
    $searchStats['services_count'] = count($searchResults['services']);
    $searchStats['discussions_count'] = count($searchResults['discussions']);
    $searchStats['total_results'] = $searchStats['users_count'] + $searchStats['courses_count'] + $searchStats['services_count'] + $searchStats['discussions_count'];
}

// 獲取用戶顯示名稱的輔助函數
function getUserDisplayName($user) {
    if (!isset($user['profile']) || !is_array($user['profile'])) {
        return $user['username'];
    }
    
    $firstName = $user['profile']['first_name'] ?? '';
    $lastName = $user['profile']['last_name'] ?? '';
    
    if ($firstName || $lastName) {
        return trim($firstName . ' ' . $lastName);
    }
    
    return $user['username'];
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO Meta Tags -->
    <title><?php echo $query ? "搜索「{$query}」" : '搜索與發現'; ?> - <?php echo e($siteName); ?></title>
    <meta name="description" content="搜索用戶、課程、服務和討論，發現更多學習機會">
    <meta name="keywords" content="搜索, 發現, 用戶, 課程, 服務, 討論">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo $query ? "搜索「{$query}」" : '搜索與發現'; ?> - <?php echo e($siteName); ?>">
    <meta property="og:description" content="搜索用戶、課程、服務和討論，發現更多學習機會">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo BASE_URL; ?>/search">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo BASE_URL; ?>/assets/images/favicon.svg">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/assets/css/main.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/assets/css/search.css" rel="stylesheet">
</head>
<body>
    <div id="page-loader">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <p>載入中...</p>
        </div>
    </div>

    <div id="main-content" style="display: none;">
        <?php include 'includes/header.php'; ?>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-background">
                <div class="hero-overlay"></div>
            </div>
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">搜索與發現</h1>
                    <p class="hero-description">探索用戶、課程、服務和討論，發現更多學習機會</p>
                    
                    <!-- Search Form -->
                    <div class="search-form-container">
                        <form class="search-form" method="GET" action="<?php echo BASE_URL; ?>/search">
                            <div class="search-input-group">
                                <input type="text" name="q" class="search-input" placeholder="搜索用戶、課程、服務..." value="<?php echo e($query); ?>" autocomplete="off">
                                <button type="submit" class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="search-filters">
                                <select name="type" class="filter-select">
                                    <option value="all" <?php echo $type === 'all' ? 'selected' : ''; ?>>全部</option>
                                    <option value="users" <?php echo $type === 'users' ? 'selected' : ''; ?>>用戶</option>
                                    <option value="courses" <?php echo $type === 'courses' ? 'selected' : ''; ?>>課程</option>
                                    <option value="services" <?php echo $type === 'services' ? 'selected' : ''; ?>>服務</option>
                                    <option value="discussions" <?php echo $type === 'discussions' ? 'selected' : ''; ?>>討論</option>
                                </select>
                                <select name="category" class="filter-select">
                                    <option value="">所有分類</option>
                                    <option value="專業教練" <?php echo $category === '專業教練' ? 'selected' : ''; ?>>專業教練</option>
                                    <option value="團隊教練" <?php echo $category === '團隊教練' ? 'selected' : ''; ?>>團隊教練</option>
                                    <option value="生活教練" <?php echo $category === '生活教練' ? 'selected' : ''; ?>>生活教練</option>
                                </select>
                                <select name="sort" class="filter-select">
                                    <option value="relevance" <?php echo $sort === 'relevance' ? 'selected' : ''; ?>>相關性</option>
                                    <option value="rating" <?php echo $sort === 'rating' ? 'selected' : ''; ?>>評分</option>
                                    <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>最新</option>
                                    <option value="popular" <?php echo $sort === 'popular' ? 'selected' : ''; ?>>最受歡迎</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="main-content">
            <div class="container">
                <?php if ($query): ?>
                    <!-- Search Results -->
                    <div class="search-results">
                        <!-- Search Stats -->
                        <div class="search-stats">
                            <h3>搜索結果</h3>
                            <p>找到 <strong><?php echo $searchStats['total_results']; ?></strong> 個結果</p>
                            <div class="result-breakdown">
                                <?php if ($searchStats['users_count'] > 0): ?>
                                    <span class="result-type">用戶: <?php echo $searchStats['users_count']; ?></span>
                                <?php endif; ?>
                                <?php if ($searchStats['courses_count'] > 0): ?>
                                    <span class="result-type">課程: <?php echo $searchStats['courses_count']; ?></span>
                                <?php endif; ?>
                                <?php if ($searchStats['services_count'] > 0): ?>
                                    <span class="result-type">服務: <?php echo $searchStats['services_count']; ?></span>
                                <?php endif; ?>
                                <?php if ($searchStats['discussions_count'] > 0): ?>
                                    <span class="result-type">討論: <?php echo $searchStats['discussions_count']; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Results Tabs -->
                        <div class="results-tabs">
                            <ul class="nav nav-pills" id="resultsTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="all-results-tab" data-bs-toggle="pill" data-bs-target="#all-results" type="button" role="tab">
                                        全部結果
                                    </button>
                                </li>
                                <?php if ($searchStats['users_count'] > 0): ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="users-results-tab" data-bs-toggle="pill" data-bs-target="#users-results" type="button" role="tab">
                                            用戶 (<?php echo $searchStats['users_count']; ?>)
                                        </button>
                                    </li>
                                <?php endif; ?>
                                <?php if ($searchStats['courses_count'] > 0): ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="courses-results-tab" data-bs-toggle="pill" data-bs-target="#courses-results" type="button" role="tab">
                                            課程 (<?php echo $searchStats['courses_count']; ?>)
                                        </button>
                                    </li>
                                <?php endif; ?>
                                <?php if ($searchStats['services_count'] > 0): ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="services-results-tab" data-bs-toggle="pill" data-bs-target="#services-results" type="button" role="tab">
                                            服務 (<?php echo $searchStats['services_count']; ?>)
                                        </button>
                                    </li>
                                <?php endif; ?>
                                <?php if ($searchStats['discussions_count'] > 0): ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="discussions-results-tab" data-bs-toggle="pill" data-bs-target="#discussions-results" type="button" role="tab">
                                            討論 (<?php echo $searchStats['discussions_count']; ?>)
                                        </button>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content" id="resultsTabContent">
                            <!-- All Results -->
                            <div class="tab-pane fade show active" id="all-results" role="tabpanel">
                                <div class="results-grid">
                                    <!-- Users Results -->
                                    <?php if (!empty($searchResults['users'])): ?>
                                        <div class="results-section">
                                            <h4 class="section-title">用戶</h4>
                                            <div class="users-grid">
                                                <?php foreach ($searchResults['users'] as $user): ?>
                                                    <div class="user-card">
                                                        <div class="user-avatar">
                                                            <img src="<?php echo BASE_URL; ?>/assets/images/<?php echo e($user['avatar']); ?>" alt="<?php echo e($user['name']); ?>">
                                                            <?php if ($user['is_online']): ?>
                                                                <span class="online-indicator"></span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="user-info">
                                                            <h5 class="user-name"><?php echo e($user['name']); ?></h5>
                                                            <p class="user-title"><?php echo e($user['title']); ?></p>
                                                            <p class="user-bio"><?php echo e($user['bio']); ?></p>
                                                            <div class="user-stats">
                                                                <span><i class="fas fa-users me-1"></i><?php echo $user['followers']; ?> 粉絲</span>
                                                                <span><i class="fas fa-graduation-cap me-1"></i><?php echo $user['courses']; ?> 課程</span>
                                                                <span><i class="fas fa-star me-1"></i><?php echo $user['rating']; ?></span>
                                                            </div>
                                                            <div class="user-tags">
                                                                <?php foreach ($user['tags'] as $tag): ?>
                                                                    <span class="tag"><?php echo e($tag); ?></span>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                        <div class="user-actions">
                                                            <button class="btn btn-primary btn-sm" onclick="followUser('<?php echo e($user['username']); ?>')">
                                                                <i class="fas fa-user-plus me-1"></i>關注
                                                            </button>
                                                            <button class="btn btn-outline-primary btn-sm" onclick="sendMessage('<?php echo e($user['username']); ?>')">
                                                                <i class="fas fa-envelope me-1"></i>發消息
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Courses Results -->
                                    <?php if (!empty($searchResults['courses'])): ?>
                                        <div class="results-section">
                                            <h4 class="section-title">課程</h4>
                                            <div class="courses-grid">
                                                <?php foreach ($searchResults['courses'] as $course): ?>
                                                    <div class="course-card">
                                                        <div class="course-image">
                                                            <img src="<?php echo BASE_URL; ?>/assets/images/<?php echo e($course['image']); ?>" alt="<?php echo e($course['title']); ?>">
                                                            <div class="course-badge"><?php echo e($course['level']); ?></div>
                                                        </div>
                                                        <div class="course-content">
                                                            <h5 class="course-title"><?php echo e($course['title']); ?></h5>
                                                            <p class="course-instructor">講師：<?php echo e($course['instructor']); ?></p>
                                                            <p class="course-description"><?php echo e($course['description']); ?></p>
                                                            <div class="course-meta">
                                                                <span><i class="fas fa-clock me-1"></i><?php echo e($course['duration']); ?></span>
                                                                <span><i class="fas fa-users me-1"></i><?php echo $course['students']; ?> 學員</span>
                                                                <span><i class="fas fa-star me-1"></i><?php echo $course['rating']; ?></span>
                                                            </div>
                                                            <div class="course-tags">
                                                                <?php foreach ($course['tags'] as $tag): ?>
                                                                    <span class="tag"><?php echo e($tag); ?></span>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                        <div class="course-actions">
                                                            <div class="course-price">NT$ <?php echo number_format($course['price']); ?></div>
                                                            <button class="btn btn-primary btn-sm" onclick="viewCourse('<?php echo $course['id']; ?>')">
                                                                <i class="fas fa-eye me-1"></i>查看詳情
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Services Results -->
                                    <?php if (!empty($searchResults['services'])): ?>
                                        <div class="results-section">
                                            <h4 class="section-title">服務</h4>
                                            <div class="services-grid">
                                                <?php foreach ($searchResults['services'] as $service): ?>
                                                    <div class="service-card">
                                                        <div class="service-header">
                                                            <h5 class="service-title"><?php echo e($service['title']); ?></h5>
                                                            <div class="service-type"><?php echo e($service['type']); ?></div>
                                                        </div>
                                                        <div class="service-content">
                                                            <p class="service-coach">教練：<?php echo e($service['coach']); ?></p>
                                                            <p class="service-description"><?php echo e($service['description']); ?></p>
                                                            <div class="service-meta">
                                                                <span><i class="fas fa-clock me-1"></i><?php echo $service['duration']; ?> 分鐘</span>
                                                                <span><i class="fas fa-users me-1"></i><?php echo $service['sessions']; ?> 次服務</span>
                                                                <span><i class="fas fa-star me-1"></i><?php echo $service['rating']; ?></span>
                                                            </div>
                                                            <div class="service-tags">
                                                                <?php foreach ($service['tags'] as $tag): ?>
                                                                    <span class="tag"><?php echo e($tag); ?></span>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                        <div class="service-actions">
                                                            <div class="service-price">NT$ <?php echo number_format($service['price']); ?></div>
                                                            <button class="btn btn-primary btn-sm" onclick="viewService('<?php echo $service['id']; ?>')">
                                                                <i class="fas fa-eye me-1"></i>查看詳情
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Discussions Results -->
                                    <?php if (!empty($searchResults['discussions'])): ?>
                                        <div class="results-section">
                                            <h4 class="section-title">討論</h4>
                                            <div class="discussions-list">
                                                <?php foreach ($searchResults['discussions'] as $discussion): ?>
                                                    <div class="discussion-card">
                                                        <div class="discussion-content">
                                                            <h5 class="discussion-title">
                                                                <a href="#" onclick="viewDiscussion('<?php echo $discussion['id']; ?>')">
                                                                    <?php echo e($discussion['title']); ?>
                                                                </a>
                                                            </h5>
                                                            <p class="discussion-preview"><?php echo e(substr($discussion['content'], 0, 150)); ?>...</p>
                                                            <div class="discussion-meta">
                                                                <span class="discussion-author">
                                                                    <img src="<?php echo BASE_URL; ?>/assets/images/default-avatar.svg" alt="<?php echo e($discussion['author_name']); ?>">
                                                                    <?php echo e($discussion['author_name']); ?>
                                                                </span>
                                                                <span class="discussion-category"><?php echo e($discussion['category']); ?></span>
                                                                <span class="discussion-time"><?php echo e($discussion['timestamp']); ?></span>
                                                            </div>
                                                            <div class="discussion-stats">
                                                                <span><i class="fas fa-comment me-1"></i><?php echo $discussion['replies']; ?></span>
                                                                <span><i class="fas fa-eye me-1"></i><?php echo $discussion['views']; ?></span>
                                                                <span><i class="fas fa-heart me-1"></i><?php echo $discussion['likes']; ?></span>
                                                            </div>
                                                            <div class="discussion-tags">
                                                                <?php foreach ($discussion['tags'] as $tag): ?>
                                                                    <span class="tag"><?php echo e($tag); ?></span>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Individual Result Tabs -->
                            <?php if ($searchStats['users_count'] > 0): ?>
                                <div class="tab-pane fade" id="users-results" role="tabpanel">
                                    <div class="users-grid">
                                        <?php foreach ($searchResults['users'] as $user): ?>
                                            <div class="user-card">
                                                <div class="user-avatar">
                                                    <img src="<?php echo BASE_URL; ?>/assets/images/<?php echo e($user['avatar']); ?>" alt="<?php echo e($user['name']); ?>">
                                                    <?php if ($user['is_online']): ?>
                                                        <span class="online-indicator"></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="user-info">
                                                    <h5 class="user-name"><?php echo e($user['name']); ?></h5>
                                                    <p class="user-title"><?php echo e($user['title']); ?></p>
                                                    <p class="user-bio"><?php echo e($user['bio']); ?></p>
                                                    <div class="user-stats">
                                                        <span><i class="fas fa-users me-1"></i><?php echo $user['followers']; ?> 粉絲</span>
                                                        <span><i class="fas fa-graduation-cap me-1"></i><?php echo $user['courses']; ?> 課程</span>
                                                        <span><i class="fas fa-star me-1"></i><?php echo $user['rating']; ?></span>
                                                    </div>
                                                    <div class="user-tags">
                                                        <?php foreach ($user['tags'] as $tag): ?>
                                                            <span class="tag"><?php echo e($tag); ?></span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="user-actions">
                                                    <button class="btn btn-primary btn-sm" onclick="followUser('<?php echo e($user['username']); ?>')">
                                                        <i class="fas fa-user-plus me-1"></i>關注
                                                    </button>
                                                    <button class="btn btn-outline-primary btn-sm" onclick="sendMessage('<?php echo e($user['username']); ?>')">
                                                        <i class="fas fa-envelope me-1"></i>發消息
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Similar structure for other tabs... -->
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Discovery Section -->
                    <div class="discovery-section">
                        <div class="row">
                            <!-- Trending -->
                            <div class="col-md-6">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-fire me-2"></i>熱門趨勢</h4>
                                        <p>最受歡迎的課程和服務</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="trending-list">
                                            <?php foreach ($recommendations['trending'] as $item): ?>
                                                <div class="trending-item">
                                                    <div class="trending-info">
                                                        <h6 class="trending-title"><?php echo e($item['title']); ?></h6>
                                                        <p class="trending-instructor"><?php echo e($item['instructor']); ?></p>
                                                        <div class="trending-stats">
                                                            <span><i class="fas fa-star me-1"></i><?php echo $item['rating']; ?></span>
                                                            <span><i class="fas fa-users me-1"></i><?php echo $item['students']; ?> 學員</span>
                                                        </div>
                                                    </div>
                                                    <div class="trending-score">
                                                        <div class="score-circle">
                                                            <span><?php echo $item['trend_score']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Personalized Recommendations -->
                            <div class="col-md-6">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-magic me-2"></i>為您推薦</h4>
                                        <p>基於您的興趣和學習歷史</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="recommendations-list">
                                            <?php foreach ($recommendations['personalized'] as $item): ?>
                                                <div class="recommendation-item">
                                                    <div class="recommendation-info">
                                                        <h6 class="recommendation-title"><?php echo e($item['title']); ?></h6>
                                                        <p class="recommendation-reason"><?php echo e($item['recommendation_reason']); ?></p>
                                                        <div class="recommendation-stats">
                                                            <span><i class="fas fa-star me-1"></i><?php echo $item['rating']; ?></span>
                                                            <?php if (isset($item['students'])): ?>
                                                                <span><i class="fas fa-users me-1"></i><?php echo $item['students']; ?> 學員</span>
                                                            <?php elseif (isset($item['sessions'])): ?>
                                                                <span><i class="fas fa-calendar me-1"></i><?php echo $item['sessions']; ?> 次服務</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Similar Users -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-users me-2"></i>相似用戶</h4>
                                        <p>與您有相似興趣的用戶</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="similar-users-grid">
                                            <?php foreach ($recommendations['similar_users'] as $user): ?>
                                                <div class="similar-user-card">
                                                    <div class="user-avatar">
                                                        <img src="<?php echo BASE_URL; ?>/assets/images/default-avatar.svg" alt="<?php echo e($user['name']); ?>">
                                                    </div>
                                                    <div class="user-info">
                                                        <h6 class="user-name"><?php echo e($user['name']); ?></h6>
                                                        <p class="user-title"><?php echo e($user['title']); ?></p>
                                                        <div class="common-interests">
                                                            <?php foreach ($user['common_interests'] as $interest): ?>
                                                                <span class="interest-tag"><?php echo e($interest); ?></span>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <div class="user-stats">
                                                            <span><i class="fas fa-users me-1"></i><?php echo $user['followers']; ?> 粉絲</span>
                                                        </div>
                                                    </div>
                                                    <div class="user-actions">
                                                        <button class="btn btn-primary btn-sm" onclick="followUser('<?php echo e($user['username']); ?>')">
                                                            <i class="fas fa-user-plus me-1"></i>關注
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/main.js"></script>
    
    <script>
        // 頁面載入完成後隱藏載入動畫
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.getElementById('page-loader').style.display = 'none';
                document.getElementById('main-content').style.display = 'block';
            }, 500);
        });

        // 搜索功能
        function performSearch() {
            const form = document.querySelector('.search-form');
            form.submit();
        }

        // 關注用戶
        function followUser(username) {
            // 在實際應用中，這裡會發送 AJAX 請求
            alert('關注用戶：' + username);
        }

        // 發送消息
        function sendMessage(username) {
            // 在實際應用中，這裡會跳轉到消息頁面
            window.location.href = '<?php echo BASE_URL; ?>/community#messages';
        }

        // 查看課程
        function viewCourse(courseId) {
            // 在實際應用中，這裡會跳轉到課程詳情頁面
            window.location.href = '<?php echo BASE_URL; ?>/courses/' + courseId;
        }

        // 查看服務
        function viewService(serviceId) {
            // 在實際應用中，這裡會跳轉到服務詳情頁面
            window.location.href = '<?php echo BASE_URL; ?>/services/' + serviceId;
        }

        // 查看討論
        function viewDiscussion(discussionId) {
            // 在實際應用中，這裡會跳轉到討論詳情頁面
            alert('查看討論：' + discussionId);
        }

        // 搜索建議
        let searchTimeout;
        document.querySelector('.search-input').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // 在實際應用中，這裡會顯示搜索建議
                console.log('搜索建議：', this.value);
            }, 300);
        });
    </script>
</body>
</html>
