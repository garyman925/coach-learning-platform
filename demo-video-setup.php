<?php
/**
 * 演示視頻設置工具
 * 用於快速設置演示視頻或上傳實際視頻文件
 */

// 包含必要的文件
require_once 'includes/config.php';
require_once 'includes/functions.php';

// 檢查是否為管理員
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    die('需要管理員權限才能訪問此頁面');
}

// 處理視頻上傳
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video_file'])) {
    $uploadDir = 'assets/videos/';
    $allowedTypes = ['video/mp4', 'video/quicktime'];
    $maxSize = 100 * 1024 * 1024; // 100MB
    
    $file = $_FILES['video_file'];
    $fileName = $_POST['video_name'] ?? $file['name'];
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        if (in_array($file['type'], $allowedTypes) && $file['size'] <= $maxSize) {
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                $success = "視頻文件 '$fileName' 上傳成功！";
            } else {
                $error = "文件上傳失敗，請檢查目錄權限。";
            }
        } else {
            $error = "不支持的文件類型或文件過大（最大100MB）。";
        }
    } else {
        $error = "文件上傳錯誤：" . $file['error'];
    }
}

// 獲取現有視頻文件列表
$videoDir = 'assets/videos/';
$existingVideos = [];
if (is_dir($videoDir)) {
    $files = scandir($videoDir);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'mp4') {
            $existingVideos[] = $file;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>演示視頻設置 - 教練學習平台</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-video me-2"></i>演示視頻設置</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i><?php echo e($success); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i><?php echo e($error); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5>上傳視頻文件</h5>
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="video_name" class="form-label">文件名稱</label>
                                        <input type="text" class="form-control" id="video_name" name="video_name" 
                                               placeholder="例如: lesson_1.mp4" required>
                                        <div class="form-text">請使用課程中定義的文件名</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="video_file" class="form-label">選擇視頻文件</label>
                                        <input type="file" class="form-control" id="video_file" name="video_file" 
                                               accept="video/mp4" required>
                                        <div class="form-text">支持MP4格式，最大100MB</div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload me-2"></i>上傳視頻
                                    </button>
                                </form>
                            </div>
                            
                            <div class="col-md-6">
                                <h5>現有視頻文件</h5>
                                <?php if (empty($existingVideos)): ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>暫無視頻文件
                                    </div>
                                <?php else: ?>
                                    <div class="list-group">
                                        <?php foreach ($existingVideos as $video): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <span><i class="fas fa-video me-2"></i><?php echo e($video); ?></span>
                                                <small class="text-muted">
                                                    <?php echo date('Y-m-d H:i', filemtime($videoDir . $video)); ?>
                                                </small>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="alert alert-info">
                            <h6><i class="fas fa-lightbulb me-2"></i>演示視頻說明</h6>
                            <ul class="mb-0">
                                <li>目前使用在線演示視頻（Big Buck Bunny）</li>
                                <li>您可以上傳自己的視頻文件替換演示視頻</li>
                                <li>建議視頻文件名：lesson_1.mp4, lesson_2.mp4 等</li>
                                <li>視頻格式：MP4，編碼：H.264</li>
                                <li>分辨率：1920x1080 或 1280x720</li>
                            </ul>
                        </div>
                        
                        <div class="text-center">
                            <a href="<?php echo BASE_URL; ?>/course-learning?course=professional&lesson=lesson_1" 
                               class="btn btn-success">
                                <i class="fas fa-play me-2"></i>測試視頻播放
                            </a>
                            <a href="<?php echo BASE_URL; ?>/admin" class="btn btn-secondary ms-2">
                                <i class="fas fa-arrow-left me-2"></i>返回管理後台
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
