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
if (!$currentUser) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}
$username = $currentUser['username'];

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

// 模擬用戶關注數據
$following = [
    [
        'id' => 'user_001',
        'username' => 'coach_zhang',
        'name' => '張教練',
        'avatar' => 'default-avatar.svg',
        'title' => '專業教練',
        'followers' => 1250,
        'courses' => 8,
        'is_online' => true,
        'last_active' => '剛剛'
    ],
    [
        'id' => 'user_002',
        'username' => 'coach_li',
        'name' => '李教練',
        'avatar' => 'default-avatar.svg',
        'title' => '團隊教練',
        'followers' => 890,
        'courses' => 5,
        'is_online' => false,
        'last_active' => '2小時前'
    ]
];

$followers = [
    [
        'id' => 'user_003',
        'username' => 'student_wang',
        'name' => '王同學',
        'avatar' => 'default-avatar.svg',
        'title' => '學習者',
        'followers' => 45,
        'courses' => 3,
        'is_online' => true,
        'last_active' => '5分鐘前'
    ],
    [
        'id' => 'user_004',
        'username' => 'student_chen',
        'name' => '陳同學',
        'avatar' => 'default-avatar.svg',
        'title' => '學習者',
        'followers' => 23,
        'courses' => 2,
        'is_online' => false,
        'last_active' => '1天前'
    ]
];

// 模擬消息數據
$messages = [
    [
        'id' => 'msg_001',
        'from_user' => 'coach_zhang',
        'from_name' => '張教練',
        'to_user' => $username,
        'subject' => '關於課程問題',
        'content' => '您好！我看到您在課程中提出的問題，我來為您詳細解答...',
        'timestamp' => '2024-02-15 14:30',
        'is_read' => false,
        'type' => 'inbox'
    ],
    [
        'id' => 'msg_002',
        'from_user' => $username,
        'from_name' => getUserDisplayName($currentUser),
        'to_user' => 'coach_li',
        'to_name' => '李教練',
        'subject' => '感謝您的指導',
        'content' => '李教練，感謝您在課程中的耐心指導，我收穫很多！',
        'timestamp' => '2024-02-14 16:45',
        'is_read' => true,
        'type' => 'sent'
    ]
];

// 模擬學習小組數據
$studyGroups = [
    [
        'id' => 'group_001',
        'name' => '專業教練學習小組',
        'description' => '專注於專業教練技能提升的學習小組',
        'members' => 25,
        'max_members' => 50,
        'creator' => 'coach_zhang',
        'created_date' => '2024-01-15',
        'last_activity' => '2024-02-15 10:30',
        'is_joined' => true,
        'is_creator' => false
    ],
    [
        'id' => 'group_002',
        'name' => '團隊教練實踐小組',
        'description' => '分享團隊教練實踐經驗和案例討論',
        'members' => 18,
        'max_members' => 30,
        'creator' => 'coach_li',
        'created_date' => '2024-01-20',
        'last_activity' => '2024-02-14 15:20',
        'is_joined' => false,
        'is_creator' => false
    ],
    [
        'id' => 'group_003',
        'name' => '我的學習小組',
        'description' => '我創建的學習小組，歡迎大家一起學習交流',
        'members' => 8,
        'max_members' => 20,
        'creator' => $username,
        'created_date' => '2024-02-01',
        'last_activity' => '2024-02-15 09:15',
        'is_joined' => true,
        'is_creator' => true
    ]
];

// 模擬討論區數據
$discussions = [
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
        'is_pinned' => true,
        'is_liked' => false
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
        'is_pinned' => false,
        'is_liked' => true
    ],
    [
        'id' => 'disc_003',
        'title' => '新手教練的成長建議',
        'content' => '作為一個新手教練，想請教各位前輩，有什麼成長建議嗎？',
        'author' => $username,
        'author_name' => getUserDisplayName($currentUser),
        'category' => '新手求助',
        'replies' => 15,
        'views' => 234,
        'likes' => 12,
        'timestamp' => '2024-02-13 14:45',
        'is_pinned' => false,
        'is_liked' => false
    ]
];

// 處理表單提交
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['follow_user'])) {
        $targetUser = $_POST['target_user'];
        $message = '已關注用戶：' . $targetUser;
        $messageType = 'success';
        $userManagement->logActivity($username, 'user_follow', '關注用戶', "關注了用戶：{$targetUser}");
    } elseif (isset($_POST['unfollow_user'])) {
        $targetUser = $_POST['target_user'];
        $message = '已取消關注用戶：' . $targetUser;
        $messageType = 'success';
        $userManagement->logActivity($username, 'user_unfollow', '取消關注', "取消關注用戶：{$targetUser}");
    } elseif (isset($_POST['join_group'])) {
        $groupId = $_POST['group_id'];
        $message = '已加入學習小組';
        $messageType = 'success';
        $userManagement->logActivity($username, 'group_join', '加入小組', "加入了學習小組：{$groupId}");
    } elseif (isset($_POST['leave_group'])) {
        $groupId = $_POST['group_id'];
        $message = '已退出學習小組';
        $messageType = 'success';
        $userManagement->logActivity($username, 'group_leave', '退出小組', "退出了學習小組：{$groupId}");
    } elseif (isset($_POST['send_message'])) {
        $toUser = $_POST['to_user'];
        $subject = $_POST['subject'];
        $content = $_POST['content'];
        $message = '消息已發送';
        $messageType = 'success';
        $userManagement->logActivity($username, 'message_send', '發送消息', "發送消息給用戶：{$toUser}");
    } elseif (isset($_POST['create_discussion'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $message = '討論已發布';
        $messageType = 'success';
        $userManagement->logActivity($username, 'discussion_create', '創建討論', "創建了討論：{$title}");
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO Meta Tags -->
    <title>社區互動 - <?php echo e($siteName); ?></title>
    <meta name="description" content="與其他學習者和教練互動交流，分享學習經驗">
    <meta name="keywords" content="社區, 互動, 學習小組, 討論區, 消息">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="社區互動 - <?php echo e($siteName); ?>">
    <meta property="og:description" content="與其他學習者和教練互動交流，分享學習經驗">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo BASE_URL; ?>/community">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo BASE_URL; ?>/assets/images/favicon.svg">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/assets/css/main.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/assets/css/community.css" rel="stylesheet">
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
                    <h1 class="hero-title">社區互動</h1>
                    <p class="hero-description">與其他學習者和教練互動交流，分享學習經驗</p>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="main-content">
            <div class="container">
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                        <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-triangle'; ?> me-2"></i>
                        <?php echo e($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Navigation Tabs -->
                <div class="content-tabs">
                    <ul class="nav nav-pills nav-fill" id="communityTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="connections-tab" data-bs-toggle="pill" data-bs-target="#connections" type="button" role="tab">
                                <i class="fas fa-users me-2"></i>關注與粉絲
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="messages-tab" data-bs-toggle="pill" data-bs-target="#messages" type="button" role="tab">
                                <i class="fas fa-envelope me-2"></i>消息中心
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="groups-tab" data-bs-toggle="pill" data-bs-target="#groups" type="button" role="tab">
                                <i class="fas fa-users-cog me-2"></i>學習小組
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="discussions-tab" data-bs-toggle="pill" data-bs-target="#discussions" type="button" role="tab">
                                <i class="fas fa-comments me-2"></i>討論區
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="communityTabContent">
                    <!-- Connections Tab -->
                    <div class="tab-pane fade show active" id="connections" role="tabpanel">
                        <div class="row">
                            <!-- Following -->
                            <div class="col-md-6">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-user-plus me-2"></i>我關注的人</h4>
                                        <p>您關注的用戶列表</p>
                                    </div>
                                    <div class="card-body">
                                        <?php if (empty($following)): ?>
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <i class="fas fa-user-plus"></i>
                                                </div>
                                                <h3 class="empty-title">還沒有關注任何人</h3>
                                                <p class="empty-description">關注其他用戶，建立學習網絡</p>
                                            </div>
                                        <?php else: ?>
                                            <div class="users-list">
                                                <?php foreach ($following as $user): ?>
                                                    <div class="user-item">
                                                        <div class="user-avatar">
                                                            <img src="<?php echo BASE_URL; ?>/assets/images/<?php echo e($user['avatar']); ?>" alt="<?php echo e($user['name']); ?>">
                                                            <?php if ($user['is_online']): ?>
                                                                <span class="online-indicator"></span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="user-info">
                                                            <h6 class="user-name"><?php echo e($user['name']); ?></h6>
                                                            <p class="user-title"><?php echo e($user['title']); ?></p>
                                                            <div class="user-stats">
                                                                <span><i class="fas fa-users me-1"></i><?php echo $user['followers']; ?> 粉絲</span>
                                                                <span><i class="fas fa-graduation-cap me-1"></i><?php echo $user['courses']; ?> 課程</span>
                                                            </div>
                                                            <div class="user-status">
                                                                <?php if ($user['is_online']): ?>
                                                                    <span class="status-online">在線</span>
                                                                <?php else: ?>
                                                                    <span class="status-offline"><?php echo e($user['last_active']); ?></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div class="user-actions">
                                                            <button class="btn btn-outline-primary btn-sm" onclick="sendMessage('<?php echo e($user['username']); ?>')">
                                                                <i class="fas fa-envelope me-1"></i>發消息
                                                            </button>
                                                            <form method="POST" style="display: inline;">
                                                                <input type="hidden" name="target_user" value="<?php echo e($user['username']); ?>">
                                                                <button type="submit" name="unfollow_user" class="btn btn-outline-danger btn-sm">
                                                                    <i class="fas fa-user-minus me-1"></i>取消關注
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Followers -->
                            <div class="col-md-6">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-heart me-2"></i>我的粉絲</h4>
                                        <p>關注您的用戶列表</p>
                                    </div>
                                    <div class="card-body">
                                        <?php if (empty($followers)): ?>
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <i class="fas fa-heart"></i>
                                                </div>
                                                <h3 class="empty-title">還沒有粉絲</h3>
                                                <p class="empty-description">分享您的學習經驗，吸引更多關注</p>
                                            </div>
                                        <?php else: ?>
                                            <div class="users-list">
                                                <?php foreach ($followers as $user): ?>
                                                    <div class="user-item">
                                                        <div class="user-avatar">
                                                            <img src="<?php echo BASE_URL; ?>/assets/images/<?php echo e($user['avatar']); ?>" alt="<?php echo e($user['name']); ?>">
                                                            <?php if ($user['is_online']): ?>
                                                                <span class="online-indicator"></span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="user-info">
                                                            <h6 class="user-name"><?php echo e($user['name']); ?></h6>
                                                            <p class="user-title"><?php echo e($user['title']); ?></p>
                                                            <div class="user-stats">
                                                                <span><i class="fas fa-users me-1"></i><?php echo $user['followers']; ?> 粉絲</span>
                                                                <span><i class="fas fa-graduation-cap me-1"></i><?php echo $user['courses']; ?> 課程</span>
                                                            </div>
                                                            <div class="user-status">
                                                                <?php if ($user['is_online']): ?>
                                                                    <span class="status-online">在線</span>
                                                                <?php else: ?>
                                                                    <span class="status-offline"><?php echo e($user['last_active']); ?></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div class="user-actions">
                                                            <button class="btn btn-outline-primary btn-sm" onclick="sendMessage('<?php echo e($user['username']); ?>')">
                                                                <i class="fas fa-envelope me-1"></i>發消息
                                                            </button>
                                                            <form method="POST" style="display: inline;">
                                                                <input type="hidden" name="target_user" value="<?php echo e($user['username']); ?>">
                                                                <button type="submit" name="follow_user" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-user-plus me-1"></i>關注
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Tab -->
                    <div class="tab-pane fade" id="messages" role="tabpanel">
                        <div class="content-card">
                            <div class="card-header">
                                <h4><i class="fas fa-envelope me-2"></i>消息中心</h4>
                                <p>管理您的私信和通知</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendMessageModal">
                                    <i class="fas fa-plus me-2"></i>發送消息
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="messages-tabs">
                                    <ul class="nav nav-tabs" id="messagesTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="inbox-tab" data-bs-toggle="tab" data-bs-target="#inbox" type="button" role="tab">
                                                <i class="fas fa-inbox me-2"></i>收件箱
                                                <span class="badge bg-danger ms-2"><?php echo count(array_filter($messages, fn($msg) => $msg['type'] === 'inbox' && !$msg['is_read'])); ?></span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent" type="button" role="tab">
                                                <i class="fas fa-paper-plane me-2"></i>已發送
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="tab-content" id="messagesTabContent">
                                    <!-- Inbox -->
                                    <div class="tab-pane fade show active" id="inbox" role="tabpanel">
                                        <?php 
                                        $inboxMessages = array_filter($messages, fn($msg) => $msg['type'] === 'inbox');
                                        if (empty($inboxMessages)): 
                                        ?>
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <i class="fas fa-inbox"></i>
                                                </div>
                                                <h3 class="empty-title">收件箱為空</h3>
                                                <p class="empty-description">您還沒有收到任何消息</p>
                                            </div>
                                        <?php else: ?>
                                            <div class="messages-list">
                                                <?php foreach ($inboxMessages as $message): ?>
                                                    <div class="message-item <?php echo !$message['is_read'] ? 'unread' : ''; ?>">
                                                        <div class="message-avatar">
                                                            <img src="<?php echo BASE_URL; ?>/assets/images/default-avatar.svg" alt="<?php echo e($message['from_name']); ?>">
                                                        </div>
                                                        <div class="message-content">
                                                            <div class="message-header">
                                                                <h6 class="message-sender"><?php echo e($message['from_name']); ?></h6>
                                                                <span class="message-time"><?php echo e($message['timestamp']); ?></span>
                                                            </div>
                                                            <h5 class="message-subject"><?php echo e($message['subject']); ?></h5>
                                                            <p class="message-preview"><?php echo e(substr($message['content'], 0, 100)); ?>...</p>
                                                        </div>
                                                        <div class="message-actions">
                                                            <button class="btn btn-outline-primary btn-sm" onclick="viewMessage('<?php echo $message['id']; ?>')">
                                                                <i class="fas fa-eye me-1"></i>查看
                                                            </button>
                                                            <button class="btn btn-outline-secondary btn-sm" onclick="replyMessage('<?php echo e($message['from_user']); ?>')">
                                                                <i class="fas fa-reply me-1"></i>回覆
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Sent -->
                                    <div class="tab-pane fade" id="sent" role="tabpanel">
                                        <?php 
                                        $sentMessages = array_filter($messages, fn($msg) => $msg['type'] === 'sent');
                                        if (empty($sentMessages)): 
                                        ?>
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <i class="fas fa-paper-plane"></i>
                                                </div>
                                                <h3 class="empty-title">沒有已發送的消息</h3>
                                                <p class="empty-description">您還沒有發送任何消息</p>
                                            </div>
                                        <?php else: ?>
                                            <div class="messages-list">
                                                <?php foreach ($sentMessages as $message): ?>
                                                    <div class="message-item">
                                                        <div class="message-avatar">
                                                            <img src="<?php echo BASE_URL; ?>/assets/images/default-avatar.svg" alt="<?php echo e($message['to_name']); ?>">
                                                        </div>
                                                        <div class="message-content">
                                                            <div class="message-header">
                                                                <h6 class="message-recipient">發送給：<?php echo e($message['to_name']); ?></h6>
                                                                <span class="message-time"><?php echo e($message['timestamp']); ?></span>
                                                            </div>
                                                            <h5 class="message-subject"><?php echo e($message['subject']); ?></h5>
                                                            <p class="message-preview"><?php echo e(substr($message['content'], 0, 100)); ?>...</p>
                                                        </div>
                                                        <div class="message-actions">
                                                            <button class="btn btn-outline-primary btn-sm" onclick="viewMessage('<?php echo $message['id']; ?>')">
                                                                <i class="fas fa-eye me-1"></i>查看
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Groups Tab -->
                    <div class="tab-pane fade" id="groups" role="tabpanel">
                        <div class="content-card">
                            <div class="card-header">
                                <h4><i class="fas fa-users-cog me-2"></i>學習小組</h4>
                                <p>加入或創建學習小組，與其他學習者交流</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGroupModal">
                                    <i class="fas fa-plus me-2"></i>創建小組
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="groups-grid">
                                    <?php foreach ($studyGroups as $group): ?>
                                        <div class="group-card">
                                            <div class="group-header">
                                                <div class="group-info">
                                                    <h5 class="group-name"><?php echo e($group['name']); ?></h5>
                                                    <p class="group-description"><?php echo e($group['description']); ?></p>
                                                </div>
                                                <div class="group-badge">
                                                    <?php if ($group['is_creator']): ?>
                                                        <span class="badge bg-primary">創建者</span>
                                                    <?php elseif ($group['is_joined']): ?>
                                                        <span class="badge bg-success">已加入</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">未加入</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            
                                            <div class="group-stats">
                                                <div class="stat-item">
                                                    <i class="fas fa-users me-2"></i>
                                                    <span><?php echo $group['members']; ?>/<?php echo $group['max_members']; ?> 成員</span>
                                                </div>
                                                <div class="stat-item">
                                                    <i class="fas fa-clock me-2"></i>
                                                    <span>最後活動：<?php echo e($group['last_activity']); ?></span>
                                                </div>
                                            </div>
                                            
                                            <div class="group-actions">
                                                <?php if ($group['is_joined']): ?>
                                                    <button class="btn btn-primary btn-sm" onclick="viewGroup('<?php echo $group['id']; ?>')">
                                                        <i class="fas fa-eye me-1"></i>進入小組
                                                    </button>
                                                    <?php if (!$group['is_creator']): ?>
                                                        <form method="POST" style="display: inline;">
                                                            <input type="hidden" name="group_id" value="<?php echo $group['id']; ?>">
                                                            <button type="submit" name="leave_group" class="btn btn-outline-danger btn-sm">
                                                                <i class="fas fa-sign-out-alt me-1"></i>退出
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="group_id" value="<?php echo $group['id']; ?>">
                                                        <button type="submit" name="join_group" class="btn btn-success btn-sm">
                                                            <i class="fas fa-user-plus me-1"></i>加入
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Discussions Tab -->
                    <div class="tab-pane fade" id="discussions" role="tabpanel">
                        <div class="content-card">
                            <div class="card-header">
                                <h4><i class="fas fa-comments me-2"></i>討論區</h4>
                                <p>參與討論，分享知識和經驗</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDiscussionModal">
                                    <i class="fas fa-plus me-2"></i>發布討論
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="discussions-list">
                                    <?php foreach ($discussions as $discussion): ?>
                                        <div class="discussion-item <?php echo $discussion['is_pinned'] ? 'pinned' : ''; ?>">
                                            <?php if ($discussion['is_pinned']): ?>
                                                <div class="discussion-pin">
                                                    <i class="fas fa-thumbtack"></i>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="discussion-content">
                                                <div class="discussion-header">
                                                    <h5 class="discussion-title">
                                                        <a href="#" onclick="viewDiscussion('<?php echo $discussion['id']; ?>')">
                                                            <?php echo e($discussion['title']); ?>
                                                        </a>
                                                    </h5>
                                                    <div class="discussion-meta">
                                                        <span class="discussion-category"><?php echo e($discussion['category']); ?></span>
                                                        <span class="discussion-time"><?php echo e($discussion['timestamp']); ?></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="discussion-body">
                                                    <p><?php echo e(substr($discussion['content'], 0, 150)); ?>...</p>
                                                </div>
                                                
                                                <div class="discussion-footer">
                                                    <div class="discussion-author">
                                                        <img src="<?php echo BASE_URL; ?>/assets/images/default-avatar.svg" alt="<?php echo e($discussion['author_name']); ?>">
                                                        <span><?php echo e($discussion['author_name']); ?></span>
                                                    </div>
                                                    <div class="discussion-stats">
                                                        <span><i class="fas fa-comment me-1"></i><?php echo $discussion['replies']; ?></span>
                                                        <span><i class="fas fa-eye me-1"></i><?php echo $discussion['views']; ?></span>
                                                        <button class="btn-like <?php echo $discussion['is_liked'] ? 'liked' : ''; ?>" onclick="toggleLike('<?php echo $discussion['id']; ?>')">
                                                            <i class="fas fa-heart me-1"></i><?php echo $discussion['likes']; ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- Modals -->
    <!-- Send Message Modal -->
    <div class="modal fade" id="sendMessageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">發送消息</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="to_user" class="form-label">發送給</label>
                            <input type="text" class="form-control" id="to_user" name="to_user" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">主題</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">內容</label>
                            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <button type="submit" name="send_message" class="btn btn-primary">發送</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Group Modal -->
    <div class="modal fade" id="createGroupModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">創建學習小組</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="group_name" class="form-label">小組名稱</label>
                            <input type="text" class="form-control" id="group_name" name="group_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="group_description" class="form-label">小組描述</label>
                            <textarea class="form-control" id="group_description" name="group_description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="max_members" class="form-label">最大成員數</label>
                            <input type="number" class="form-control" id="max_members" name="max_members" value="20" min="5" max="100" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <button type="submit" name="create_group" class="btn btn-primary">創建</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Discussion Modal -->
    <div class="modal fade" id="createDiscussionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">發布討論</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">討論標題</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">分類</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">選擇分類</option>
                                <option value="教練技巧">教練技巧</option>
                                <option value="團隊教練">團隊教練</option>
                                <option value="個人發展">個人發展</option>
                                <option value="新手求助">新手求助</option>
                                <option value="經驗分享">經驗分享</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">討論內容</label>
                            <textarea class="form-control" id="content" name="content" rows="8" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <button type="submit" name="create_discussion" class="btn btn-primary">發布</button>
                    </div>
                </form>
            </div>
        </div>
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

        // 發送消息
        function sendMessage(username) {
            document.getElementById('to_user').value = username;
            new bootstrap.Modal(document.getElementById('sendMessageModal')).show();
        }

        // 查看消息
        function viewMessage(messageId) {
            // 在實際應用中，這裡會跳轉到消息詳情頁面
            alert('查看消息：' + messageId);
        }

        // 回覆消息
        function replyMessage(username) {
            document.getElementById('to_user').value = username;
            new bootstrap.Modal(document.getElementById('sendMessageModal')).show();
        }

        // 查看小組
        function viewGroup(groupId) {
            // 在實際應用中，這裡會跳轉到小組詳情頁面
            alert('進入小組：' + groupId);
        }

        // 查看討論
        function viewDiscussion(discussionId) {
            // 在實際應用中，這裡會跳轉到討論詳情頁面
            alert('查看討論：' + discussionId);
        }

        // 切換點讚
        function toggleLike(discussionId) {
            const button = event.target.closest('.btn-like');
            const isLiked = button.classList.contains('liked');
            
            if (isLiked) {
                button.classList.remove('liked');
                // 在實際應用中，這裡會發送取消點讚的請求
            } else {
                button.classList.add('liked');
                // 在實際應用中，這裡會發送點讚的請求
            }
        }
    </script>
</body>
</html>
