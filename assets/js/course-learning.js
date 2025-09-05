/**
 * Course Learning Page JavaScript
 * 處理學習頁面的交互功能
 */

class CourseLearning {
    constructor() {
        this.video = null;
        this.isPlaying = false;
        this.currentTime = 0;
        this.duration = 0;
        this.lessonId = null;
        this.courseId = null;
        this.volume = 1;
        this.playbackRate = 1;
        this.isMuted = false;
        this.isFullscreen = false;
        this.isPictureInPicture = false;
        this.controlsVisible = false;
        this.controlsTimeout = null;
        
        // Exercise System
        this.currentExercise = 0;
        this.exerciseAnswers = {};
        this.exerciseResults = {};
        this.exerciseStartTime = null;
        this.exerciseTimer = null;
        
        // Learning Progress
        this.learningProgress = null;
        this.lessonStartTime = null;
        
        // DOM Elements
        this.elements = {};
        
        this.init();
    }

    init() {
        this.cacheElements();
        this.setupVideoPlayer();
        this.setupCustomControls();
        this.setupExerciseSystem();
        this.setupLearningProgress();
        this.setupSidebarToggle();
        this.setupProgressTracking();
        this.setupKeyboardShortcuts();
        this.setupAutoSave();
        
        console.log('Course Learning initialized');
    }

    /**
     * 緩存DOM元素
     */
    cacheElements() {
        this.elements = {
            video: document.getElementById('lesson-video'),
            videoPlayer: document.getElementById('video-player'),
            controlsOverlay: document.getElementById('video-controls-overlay'),
            playPauseBtn: document.getElementById('play-pause-btn'),
            playBtnLarge: document.getElementById('play-btn-large'),
            rewindBtn: document.getElementById('rewind-btn'),
            forwardBtn: document.getElementById('forward-btn'),
            muteBtn: document.getElementById('mute-btn'),
            volumeSlider: document.getElementById('volume-slider'),
            volumeFill: document.getElementById('volume-fill'),
            volumeHandle: document.getElementById('volume-handle'),
            progressBar: document.getElementById('progress-bar'),
            progressFill: document.getElementById('progress-fill'),
            progressHandle: document.getElementById('progress-handle'),
            currentTime: document.getElementById('current-time'),
            duration: document.getElementById('duration'),
            speedBtn: document.getElementById('speed-btn'),
            speedText: document.getElementById('speed-text'),
            speedMenu: document.getElementById('speed-menu'),
            qualityBtn: document.getElementById('quality-btn'),
            qualityMenu: document.getElementById('quality-menu'),
            closeQualityMenu: document.getElementById('close-quality-menu'),
            fullscreenBtn: document.getElementById('fullscreen-btn'),
            pipBtn: document.getElementById('pip-btn'),
            settingsBtn: document.getElementById('settings-btn'),
            videoLoading: document.getElementById('video-loading'),
            videoError: document.getElementById('video-error'),
            retryBtn: document.getElementById('retry-btn')
        };
    }

    /**
     * 設置視頻播放器
     */
    setupVideoPlayer() {
        this.video = this.elements.video;
        if (!this.video) return;

        // 獲取課程和章節ID
        const urlParams = new URLSearchParams(window.location.search);
        this.courseId = urlParams.get('course');
        this.lessonId = urlParams.get('lesson');

        // 視頻事件監聽
        this.video.addEventListener('loadstart', () => {
            this.showLoading();
        });

        this.video.addEventListener('loadedmetadata', () => {
            this.duration = this.video.duration;
            this.updateDuration();
            this.loadProgress();
            this.hideLoading();
        });

        this.video.addEventListener('timeupdate', () => {
            this.currentTime = this.video.currentTime;
            this.updateProgress();
            this.updateCurrentTime();
            this.saveProgress();
        });

        this.video.addEventListener('play', () => {
            this.isPlaying = true;
            this.updatePlayButtons();
            this.hideControls();
        });

        this.video.addEventListener('pause', () => {
            this.isPlaying = false;
            this.updatePlayButtons();
            this.showControls();
        });

        this.video.addEventListener('ended', () => {
            this.onVideoEnded();
        });

        this.video.addEventListener('error', () => {
            this.showError();
        });

        this.video.addEventListener('waiting', () => {
            this.showLoading();
        });

        this.video.addEventListener('canplay', () => {
            this.hideLoading();
        });

        // 視頻點擊播放/暫停
        this.video.addEventListener('click', () => {
            this.togglePlay();
        });

        // 視頻容器鼠標移動事件
        this.elements.videoPlayer.addEventListener('mousemove', () => {
            this.showControls();
        });

        this.elements.videoPlayer.addEventListener('mouseleave', () => {
            if (this.isPlaying) {
                this.hideControls();
            }
        });
    }

    /**
     * 設置自定義控制
     */
    setupCustomControls() {
        // 播放/暫停按鈕
        if (this.elements.playPauseBtn) {
            this.elements.playPauseBtn.addEventListener('click', () => {
                this.togglePlay();
            });
        }

        if (this.elements.playBtnLarge) {
            this.elements.playBtnLarge.addEventListener('click', () => {
                this.togglePlay();
            });
        }

        // 快退/快進按鈕
        if (this.elements.rewindBtn) {
            this.elements.rewindBtn.addEventListener('click', () => {
                this.seek(-10);
            });
        }

        if (this.elements.forwardBtn) {
            this.elements.forwardBtn.addEventListener('click', () => {
                this.seek(10);
            });
        }

        // 靜音按鈕
        if (this.elements.muteBtn) {
            this.elements.muteBtn.addEventListener('click', () => {
                this.toggleMute();
            });
        }

        // 音量滑塊
        this.setupVolumeSlider();

        // 進度條
        this.setupProgressBar();

        // 播放速度
        this.setupSpeedControl();

        // 視頻質量
        this.setupQualityControl();

        // 全屏按鈕
        if (this.elements.fullscreenBtn) {
            this.elements.fullscreenBtn.addEventListener('click', () => {
                this.toggleFullscreen();
            });
        }

        // 畫中畫按鈕
        if (this.elements.pipBtn) {
            this.elements.pipBtn.addEventListener('click', () => {
                this.togglePictureInPicture();
            });
        }

        // 重試按鈕
        if (this.elements.retryBtn) {
            this.elements.retryBtn.addEventListener('click', () => {
                this.retryVideo();
            });
        }
    }

    /**
     * 切換播放/暫停
     */
    togglePlay() {
        if (!this.video) return;

        if (this.isPlaying) {
            this.video.pause();
        } else {
            this.video.play();
        }
    }

    /**
     * 更新播放按鈕狀態
     */
    updatePlayButtons() {
        const playIcon = this.isPlaying ? 'fa-pause' : 'fa-play';
        
        if (this.elements.playPauseBtn) {
            const icon = this.elements.playPauseBtn.querySelector('i');
            if (icon) icon.className = `fas ${playIcon}`;
        }

        if (this.elements.playBtnLarge) {
            const icon = this.elements.playBtnLarge.querySelector('i');
            if (icon) icon.className = `fas ${playIcon}`;
        }
    }

    /**
     * 顯示/隱藏控制欄
     */
    showControls() {
        if (this.elements.controlsOverlay) {
            this.elements.controlsOverlay.classList.add('show');
            this.controlsVisible = true;
        }
        
        // 清除之前的定時器
        if (this.controlsTimeout) {
            clearTimeout(this.controlsTimeout);
        }
        
        // 如果正在播放，3秒後自動隱藏控制欄
        if (this.isPlaying) {
            this.controlsTimeout = setTimeout(() => {
                this.hideControls();
            }, 3000);
        }
    }

    hideControls() {
        if (this.elements.controlsOverlay && this.isPlaying) {
            this.elements.controlsOverlay.classList.remove('show');
            this.controlsVisible = false;
        }
    }

    /**
     * 設置音量滑塊
     */
    setupVolumeSlider() {
        if (!this.elements.volumeSlider) return;

        this.elements.volumeSlider.addEventListener('click', (e) => {
            const rect = this.elements.volumeSlider.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            const percentage = clickX / rect.width;
            this.setVolume(percentage);
        });

        // 拖拽音量滑塊
        let isDragging = false;
        
        this.elements.volumeHandle.addEventListener('mousedown', (e) => {
            isDragging = true;
            e.preventDefault();
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            
            const rect = this.elements.volumeSlider.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            const percentage = Math.max(0, Math.min(1, clickX / rect.width));
            this.setVolume(percentage);
        });

        document.addEventListener('mouseup', () => {
            isDragging = false;
        });
    }

    /**
     * 設置進度條
     */
    setupProgressBar() {
        if (!this.elements.progressBar) return;

        this.elements.progressBar.addEventListener('click', (e) => {
            const rect = this.elements.progressBar.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            const percentage = clickX / rect.width;
            this.seekTo(percentage);
        });

        // 拖拽進度條
        let isDragging = false;
        
        this.elements.progressHandle.addEventListener('mousedown', (e) => {
            isDragging = true;
            e.preventDefault();
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            
            const rect = this.elements.progressBar.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            const percentage = Math.max(0, Math.min(1, clickX / rect.width));
            this.seekTo(percentage);
        });

        document.addEventListener('mouseup', () => {
            isDragging = false;
        });
    }

    /**
     * 設置播放速度控制
     */
    setupSpeedControl() {
        if (!this.elements.speedMenu) return;

        const speedOptions = this.elements.speedMenu.querySelectorAll('.speed-option');
        speedOptions.forEach(option => {
            option.addEventListener('click', () => {
                const speed = parseFloat(option.dataset.speed);
                this.setPlaybackRate(speed);
                
                // 更新選中狀態
                speedOptions.forEach(opt => opt.classList.remove('active'));
                option.classList.add('active');
            });
        });
    }

    /**
     * 設置視頻質量控制
     */
    setupQualityControl() {
        if (!this.elements.qualityBtn || !this.elements.qualityMenu) return;

        this.elements.qualityBtn.addEventListener('click', () => {
            this.elements.qualityMenu.classList.toggle('show');
        });

        if (this.elements.closeQualityMenu) {
            this.elements.closeQualityMenu.addEventListener('click', () => {
                this.elements.qualityMenu.classList.remove('show');
            });
        }

        // 點擊外部關閉菜單
        document.addEventListener('click', (e) => {
            if (!this.elements.qualityMenu.contains(e.target) && 
                !this.elements.qualityBtn.contains(e.target)) {
                this.elements.qualityMenu.classList.remove('show');
            }
        });

        const qualityOptions = this.elements.qualityMenu.querySelectorAll('.quality-option');
        qualityOptions.forEach(option => {
            option.addEventListener('click', () => {
                const quality = option.dataset.quality;
                this.setQuality(quality);
                
                // 更新選中狀態
                qualityOptions.forEach(opt => opt.classList.remove('active'));
                option.classList.add('active');
                
                // 關閉菜單
                this.elements.qualityMenu.classList.remove('show');
            });
        });
    }

    /**
     * 設置音量
     */
    setVolume(volume) {
        this.volume = Math.max(0, Math.min(1, volume));
        this.video.volume = this.volume;
        this.video.muted = this.volume === 0;
        
        // 更新音量滑塊
        if (this.elements.volumeFill) {
            this.elements.volumeFill.style.width = `${this.volume * 100}%`;
        }
        
        if (this.elements.volumeHandle) {
            this.elements.volumeHandle.style.left = `${this.volume * 100}%`;
        }
        
        // 更新靜音按鈕
        this.updateMuteButton();
    }

    /**
     * 切換靜音
     */
    toggleMute() {
        this.isMuted = !this.isMuted;
        this.video.muted = this.isMuted;
        this.updateMuteButton();
    }

    /**
     * 更新靜音按鈕
     */
    updateMuteButton() {
        if (!this.elements.muteBtn) return;
        
        const icon = this.elements.muteBtn.querySelector('i');
        if (!icon) return;
        
        if (this.isMuted || this.volume === 0) {
            icon.className = 'fas fa-volume-mute';
        } else if (this.volume < 0.5) {
            icon.className = 'fas fa-volume-down';
        } else {
            icon.className = 'fas fa-volume-up';
        }
    }

    /**
     * 設置播放速度
     */
    setPlaybackRate(rate) {
        this.playbackRate = rate;
        this.video.playbackRate = rate;
        
        if (this.elements.speedText) {
            this.elements.speedText.textContent = `${rate}x`;
        }
    }

    /**
     * 設置視頻質量
     */
    setQuality(quality) {
        // 這裡可以實現不同質量的視頻源切換
        console.log('Setting video quality to:', quality);
        // 實際實現需要根據不同的視頻源URL來切換
    }

    /**
     * 快進/快退
     */
    seek(seconds) {
        if (!this.video) return;
        
        this.video.currentTime = Math.max(0, Math.min(this.video.duration, this.video.currentTime + seconds));
    }

    /**
     * 跳轉到指定位置
     */
    seekTo(percentage) {
        if (!this.video) return;
        
        const time = percentage * this.video.duration;
        this.video.currentTime = time;
    }

    /**
     * 更新進度條
     */
    updateProgress() {
        if (!this.video || !this.elements.progressFill) return;
        
        const percentage = (this.video.currentTime / this.video.duration) * 100;
        this.elements.progressFill.style.width = `${percentage}%`;
        
        if (this.elements.progressHandle) {
            this.elements.progressHandle.style.left = `${percentage}%`;
        }
    }

    /**
     * 更新當前時間顯示
     */
    updateCurrentTime() {
        if (this.elements.currentTime) {
            this.elements.currentTime.textContent = this.formatTime(this.video.currentTime);
        }
    }

    /**
     * 更新總時長顯示
     */
    updateDuration() {
        if (this.elements.duration) {
            this.elements.duration.textContent = this.formatTime(this.video.duration);
        }
    }

    /**
     * 格式化時間
     */
    formatTime(seconds) {
        if (isNaN(seconds)) return '0:00';
        
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = Math.floor(seconds % 60);
        return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
    }

    /**
     * 切換全屏
     */
    toggleFullscreen() {
        if (!document.fullscreenElement) {
            this.elements.videoPlayer.requestFullscreen();
            this.isFullscreen = true;
        } else {
            document.exitFullscreen();
            this.isFullscreen = false;
        }
    }

    /**
     * 切換畫中畫
     */
    async togglePictureInPicture() {
        if (!document.pictureInPictureElement) {
            try {
                await this.video.requestPictureInPicture();
                this.isPictureInPicture = true;
            } catch (error) {
                console.log('Picture-in-Picture not supported');
            }
        } else {
            document.exitPictureInPicture();
            this.isPictureInPicture = false;
        }
    }

    /**
     * 顯示加載狀態
     */
    showLoading() {
        if (this.elements.videoLoading) {
            this.elements.videoLoading.style.display = 'flex';
        }
    }

    /**
     * 隱藏加載狀態
     */
    hideLoading() {
        if (this.elements.videoLoading) {
            this.elements.videoLoading.style.display = 'none';
        }
    }

    /**
     * 顯示錯誤狀態
     */
    showError() {
        if (this.elements.videoError) {
            this.elements.videoError.style.display = 'flex';
        }
        this.hideLoading();
    }

    /**
     * 重試視頻
     */
    retryVideo() {
        if (this.elements.videoError) {
            this.elements.videoError.style.display = 'none';
        }
        this.video.load();
    }

    /**
     * 視頻結束處理
     */
    onVideoEnded() {
        // 標記章節為已完成
        this.markLessonCompleted();
        
        // 顯示完成提示
        this.showCompletionMessage();
        
        // 自動跳轉到下一課（可選）
        // this.autoNextLesson();
    }

    /**
     * 標記章節為已完成
     */
    markLessonCompleted() {
        if (!this.lessonId || !this.courseId) return;

        // 更新本地存儲
        const progressKey = `course_progress_${this.courseId}`;
        let progress = JSON.parse(localStorage.getItem(progressKey) || '{}');
        
        if (!progress.lessons) {
            progress.lessons = {};
        }
        
        progress.lessons[this.lessonId] = {
            completed: true,
            completedAt: new Date().toISOString(),
            watchTime: this.currentTime
        };

        localStorage.setItem(progressKey, JSON.stringify(progress));

        // 更新UI
        this.updateLessonStatus();
        
        // 發送到服務器（模擬）
        this.saveProgressToServer();
    }

    /**
     * 更新章節狀態UI
     */
    updateLessonStatus() {
        const currentLessonItem = document.querySelector('.lesson-item.active');
        if (currentLessonItem) {
            currentLessonItem.classList.add('completed');
            
            const lessonNumber = currentLessonItem.querySelector('.lesson-number');
            if (lessonNumber) {
                lessonNumber.innerHTML = '<i class="fas fa-check-circle"></i>';
            }
        }

        // 更新章節頭部的狀態
        const statusElement = document.querySelector('.lesson-status');
        if (statusElement) {
            statusElement.className = 'lesson-status completed';
            statusElement.innerHTML = '<i class="fas fa-check-circle me-1"></i>已完成';
        }
    }

    /**
     * 顯示完成提示
     */
    showCompletionMessage() {
        // 創建完成提示
        const message = document.createElement('div');
        message.className = 'completion-message';
        message.innerHTML = `
            <div class="completion-content">
                <i class="fas fa-check-circle"></i>
                <h3>恭喜！章節學習完成</h3>
                <p>您已成功完成此章節的學習</p>
                <div class="completion-actions">
                    <button class="btn btn-primary" onclick="this.parentElement.parentElement.parentElement.remove()">
                        繼續學習
                    </button>
                </div>
            </div>
        `;

        // 添加樣式
        message.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease;
        `;

        const content = message.querySelector('.completion-content');
        content.style.cssText = `
            background: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            max-width: 400px;
            margin: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        `;

        content.querySelector('i').style.cssText = `
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 1rem;
        `;

        content.querySelector('h3').style.cssText = `
            color: #1f2937;
            margin-bottom: 0.5rem;
        `;

        content.querySelector('p').style.cssText = `
            color: #6b7280;
            margin-bottom: 1.5rem;
        `;

        document.body.appendChild(message);

        // 3秒後自動關閉
        setTimeout(() => {
            if (message.parentElement) {
                message.remove();
            }
        }, 3000);
    }

    /**
     * 設置側邊欄切換
     */
    setupSidebarToggle() {
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebar = document.querySelector('.course-sidebar');

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
            });

            // 點擊外部關閉側邊欄
            document.addEventListener('click', (e) => {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            });
        }
    }

    /**
     * 設置進度追蹤
     */
    setupProgressTracking() {
        // 定期保存進度
        setInterval(() => {
            this.saveProgress();
        }, 10000); // 每10秒保存一次
    }

    /**
     * 保存學習進度
     */
    saveProgress() {
        if (!this.video || !this.lessonId || !this.courseId) return;

        const progressKey = `course_progress_${this.courseId}`;
        let progress = JSON.parse(localStorage.getItem(progressKey) || '{}');
        
        if (!progress.lessons) {
            progress.lessons = {};
        }
        
        if (!progress.lessons[this.lessonId]) {
            progress.lessons[this.lessonId] = {};
        }
        
        progress.lessons[this.lessonId].currentTime = this.currentTime;
        progress.lessons[this.lessonId].lastWatched = new Date().toISOString();
        progress.lessTime = this.currentTime;

        localStorage.setItem(progressKey, JSON.stringify(progress));
    }

    /**
     * 載入學習進度
     */
    loadProgress() {
        if (!this.video || !this.lessonId || !this.courseId) return;

        const progressKey = `course_progress_${this.courseId}`;
        const progress = JSON.parse(localStorage.getItem(progressKey) || '{}');
        
        if (progress.lessons && progress.lessons[this.lessonId]) {
            const lessonProgress = progress.lessons[this.lessonId];
            
            if (lessonProgress.currentTime && lessonProgress.currentTime > 0) {
                this.video.currentTime = lessonProgress.currentTime;
            }
        }
    }

    /**
     * 保存進度到服務器（模擬）
     */
    saveProgressToServer() {
        // 這裡可以發送AJAX請求到服務器
        console.log('Saving progress to server...', {
            courseId: this.courseId,
            lessonId: this.lessonId,
            currentTime: this.currentTime,
            completed: true
        });
    }

    /**
     * 設置鍵盤快捷鍵
     */
    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // 空格鍵播放/暫停
            if (e.code === 'Space' && e.target.tagName !== 'INPUT') {
                e.preventDefault();
                this.togglePlay();
            }
            
            // 左右箭頭快進/快退
            if (e.code === 'ArrowLeft') {
                e.preventDefault();
                this.seek(-10); // 快退10秒
            }
            
            if (e.code === 'ArrowRight') {
                e.preventDefault();
                this.seek(10); // 快進10秒
            }
            
            // M鍵靜音/取消靜音
            if (e.code === 'KeyM') {
                e.preventDefault();
                this.toggleMute();
            }
            
            // F鍵全屏
            if (e.code === 'KeyF') {
                e.preventDefault();
                this.toggleFullscreen();
            }
        });
    }

    /**
     * 快進/快退
     */
    seek(seconds) {
        if (!this.video) return;
        
        this.video.currentTime = Math.max(0, Math.min(this.video.duration, this.video.currentTime + seconds));
    }

    /**
     * 切換靜音
     */
    toggleMute() {
        if (!this.video) return;
        
        this.video.muted = !this.video.muted;
    }

    /**
     * 切換全屏
     */
    toggleFullscreen() {
        if (!this.video) return;
        
        if (document.fullscreenElement) {
            document.exitFullscreen();
        } else {
            this.video.requestFullscreen();
        }
    }

    /**
     * 設置自動保存
     */
    setupAutoSave() {
        // 頁面卸載前保存進度
        window.addEventListener('beforeunload', () => {
            this.saveProgress();
        });

        // 頁面可見性變化時保存進度
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.saveProgress();
            }
        });
    }

    /**
     * 更新課程總進度
     */
    updateCourseProgress() {
        if (!this.courseId) return;

        const progressKey = `course_progress_${this.courseId}`;
        const progress = JSON.parse(localStorage.getItem(progressKey) || '{}');
        
        if (progress.lessons) {
            const totalLessons = document.querySelectorAll('.lesson-item').length;
            const completedLessons = Object.values(progress.lessons).filter(lesson => lesson.completed).length;
            const progressPercentage = Math.round((completedLessons / totalLessons) * 100);
            
            // 更新進度條
            const progressFill = document.querySelector('.progress-fill');
            if (progressFill) {
                progressFill.style.width = `${progressPercentage}%`;
            }
            
            // 更新百分比文字
            const progressPercentageElement = document.querySelector('.progress-percentage');
            if (progressPercentageElement) {
                progressPercentageElement.textContent = `${progressPercentage}%`;
            }
        }
    }

    /**
     * 設置練習題系統
     */
    setupExerciseSystem() {
        this.setupExerciseTabs();
        this.setupExerciseQuestions();
        this.setupExerciseActions();
        this.loadExerciseProgress();
    }

    /**
     * 設置學習進度追蹤
     */
    setupLearningProgress() {
        // 初始化學習進度系統
        if (window.LearningProgress) {
            this.learningProgress = new LearningProgress();
        }
        
        // 開始追蹤課程
        this.trackCourseStart();
        
        // 開始追蹤課程時間
        this.lessonStartTime = new Date();
    }

    /**
     * 設置練習題標籤
     */
    setupExerciseTabs() {
        const exerciseTabs = document.querySelectorAll('.exercise-tab');
        exerciseTabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                this.switchToExercise(index);
            });
        });
    }

    /**
     * 設置練習題問題
     */
    setupExerciseQuestions() {
        const exerciseQuestions = document.querySelectorAll('.exercise-question');
        
        exerciseQuestions.forEach((question, index) => {
            const optionInputs = question.querySelectorAll('.option-input');
            const textInput = question.querySelector('.text-answer-input');
            const submitBtn = question.querySelector(`#submit-btn-${index}`);
            const hintBtn = question.querySelector(`#hint-btn-${index}`);

            // MC選項點擊事件
            optionInputs.forEach(input => {
                input.addEventListener('change', () => {
                    this.onOptionSelected(index, input.value);
                });
            });

            // 文字輸入事件
            if (textInput) {
                textInput.addEventListener('input', () => {
                    this.onTextInput(index, textInput.value);
                });
            }

            // 提交按鈕事件
            if (submitBtn) {
                submitBtn.addEventListener('click', () => {
                    this.submitAnswer(index);
                });
            }

            // 提示按鈕事件
            if (hintBtn) {
                hintBtn.addEventListener('click', () => {
                    this.showHint(index);
                });
            }
        });
    }

    /**
     * 設置練習題操作
     */
    setupExerciseActions() {
        // 查看答案按鈕
        const reviewBtn = document.getElementById('review-answers');
        if (reviewBtn) {
            reviewBtn.addEventListener('click', () => {
                this.reviewAnswers();
            });
        }

        // 下一課按鈕
        const nextLessonBtn = document.getElementById('next-lesson');
        if (nextLessonBtn) {
            nextLessonBtn.addEventListener('click', () => {
                this.goToNextLesson();
            });
        }
    }

    /**
     * 切換到指定練習題
     */
    switchToExercise(exerciseIndex) {
        // 更新標籤狀態
        const tabs = document.querySelectorAll('.exercise-tab');
        tabs.forEach((tab, index) => {
            tab.classList.toggle('active', index === exerciseIndex);
        });

        // 更新問題顯示
        const questions = document.querySelectorAll('.exercise-question');
        questions.forEach((question, index) => {
            question.classList.toggle('active', index === exerciseIndex);
        });

        this.currentExercise = exerciseIndex;
        this.startExerciseTimer(exerciseIndex);
    }

    /**
     * 選項被選中時
     */
    onOptionSelected(exerciseIndex, optionValue) {
        this.exerciseAnswers[exerciseIndex] = parseInt(optionValue);
        this.enableSubmitButton(exerciseIndex);
    }

    /**
     * 文字輸入時
     */
    onTextInput(exerciseIndex, textValue) {
        this.exerciseAnswers[exerciseIndex] = textValue.trim();
        this.enableSubmitButton(exerciseIndex);
    }

    /**
     * 啟用提交按鈕
     */
    enableSubmitButton(exerciseIndex) {
        const submitBtn = document.getElementById(`submit-btn-${exerciseIndex}`);
        if (submitBtn) {
            submitBtn.disabled = false;
        }

        // 啟用提示按鈕
        const hintBtn = document.getElementById(`hint-btn-${exerciseIndex}`);
        if (hintBtn) {
            hintBtn.disabled = false;
        }
    }

    /**
     * 提交答案
     */
    submitAnswer(exerciseIndex) {
        const answer = this.exerciseAnswers[exerciseIndex];
        if (answer === undefined || answer === '') return;

        // 獲取題目類型
        const exerciseElement = document.getElementById(`exercise-${exerciseIndex}`);
        const exerciseId = exerciseElement.dataset.exerciseId;
        const exerciseType = this.getExerciseType(exerciseIndex);
        
        let isCorrect = false;
        let correctAnswer = null;
        let score = 0;

        if (exerciseType === 'mc') {
            // 多選題評分
            correctAnswer = this.getCorrectAnswer(exerciseIndex);
            isCorrect = answer === correctAnswer;
            score = isCorrect ? 10 : 0;
        } else if (exerciseType === 'text') {
            // 文字題評分
            const result = this.evaluateTextAnswer(exerciseIndex, answer);
            isCorrect = result.isCorrect;
            score = result.score;
            correctAnswer = result.correctAnswer;
        }
        
        // 保存結果
        this.exerciseResults[exerciseIndex] = {
            answer: answer,
            correct: isCorrect,
            score: score,
            type: exerciseType,
            submittedAt: new Date().toISOString()
        };

        // 顯示反饋
        this.showAnswerFeedback(exerciseIndex, isCorrect, answer, correctAnswer, score);
        
        // 更新標籤狀態
        this.updateTabStatus(exerciseIndex, isCorrect);
        
        // 更新進度
        this.updateExerciseProgress();
        
        // 禁用提交按鈕
        const submitBtn = document.getElementById(`submit-btn-${exerciseIndex}`);
        if (submitBtn) {
            submitBtn.disabled = true;
        }

        // 保存進度
        this.saveExerciseProgress();
        
        // 追蹤練習題完成
        this.trackExerciseComplete(exerciseId, score);
    }

    /**
     * 獲取題目類型
     */
    getExerciseType(exerciseIndex) {
        const exerciseElement = document.getElementById(`exercise-${exerciseIndex}`);
        if (exerciseElement.querySelector('.option-input')) {
            return 'mc';
        } else if (exerciseElement.querySelector('.text-answer-input')) {
            return 'text';
        }
        return 'mc'; // 默認
    }

    /**
     * 獲取正確答案（模擬）
     */
    getCorrectAnswer(exerciseIndex) {
        // 這裡應該從服務器獲取，現在使用硬編碼
        const correctAnswers = [1, 1, 1, 2, 2, 2, 0, 0, 0, 1, 1, 1];
        return correctAnswers[exerciseIndex] || 0;
    }

    /**
     * 評估文字答案
     */
    evaluateTextAnswer(exerciseIndex, userAnswer) {
        // 獲取正確答案關鍵詞（這裡應該從服務器獲取）
        const correctKeywords = this.getCorrectKeywords(exerciseIndex);
        const userText = userAnswer.toLowerCase();
        
        let matchedKeywords = 0;
        let totalKeywords = correctKeywords.length;
        
        // 檢查關鍵詞匹配
        correctKeywords.forEach(keyword => {
            if (userText.includes(keyword.toLowerCase())) {
                matchedKeywords++;
            }
        });
        
        // 計算分數（至少匹配50%的關鍵詞才算正確）
        const matchRatio = matchedKeywords / totalKeywords;
        const isCorrect = matchRatio >= 0.5;
        const score = Math.round(matchRatio * 15); // 文字題15分滿分
        
        return {
            isCorrect: isCorrect,
            score: score,
            correctAnswer: correctKeywords.join('、'),
            matchedKeywords: matchedKeywords,
            totalKeywords: totalKeywords
        };
    }

    /**
     * 獲取正確關鍵詞（模擬）
     */
    getCorrectKeywords(exerciseIndex) {
        // 這裡應該從服務器獲取，現在使用硬編碼
        const keywords = [
            ['目標', '現狀', '選項', '意願'], // ex_1_2
            ['什麼', '如何', '為什麼', '開放式'], // ex_2_2
            ['Specific', 'Measurable', 'Achievable', 'Relevant', 'Time-bound'], // ex_3_2
            ['信任', '溝通', '目標', '協作'] // ex_4_2
        ];
        
        // 根據題目索引返回對應的關鍵詞
        const textQuestionIndex = [1, 1, 1, 1]; // 每課的第2題是文字題
        const lessonIndex = Math.floor(exerciseIndex / 3);
        return keywords[lessonIndex] || [];
    }

    /**
     * 顯示答案反饋
     */
    showAnswerFeedback(exerciseIndex, isCorrect, userAnswer, correctAnswer, score) {
        const feedbackElement = document.getElementById(`feedback-${exerciseIndex}`);
        if (!feedbackElement) return;

        // 設置反饋樣式
        feedbackElement.className = `answer-feedback ${isCorrect ? 'correct' : 'incorrect'}`;
        
        // 更新反饋內容
        const resultElement = feedbackElement.querySelector('.feedback-result');
        const scoreElement = feedbackElement.querySelector('.feedback-score');
        const correctIcon = feedbackElement.querySelector('.correct-icon');
        const incorrectIcon = feedbackElement.querySelector('.incorrect-icon');

        const exerciseType = this.getExerciseType(exerciseIndex);

        if (isCorrect) {
            resultElement.textContent = '回答正確！';
            scoreElement.textContent = `獲得 ${score} 分`;
            correctIcon.style.display = 'block';
            incorrectIcon.style.display = 'none';
        } else {
            resultElement.textContent = '回答需要改進';
            if (exerciseType === 'mc') {
                scoreElement.textContent = '正確答案是：' + String.fromCharCode(65 + correctAnswer);
            } else {
                scoreElement.textContent = `獲得 ${score} 分，關鍵詞：${correctAnswer}`;
            }
            correctIcon.style.display = 'none';
            incorrectIcon.style.display = 'block';
        }

        // 顯示反饋
        feedbackElement.style.display = 'block';

        // 高亮正確和錯誤的選項（僅MC題）
        if (exerciseType === 'mc') {
            this.highlightAnswers(exerciseIndex, userAnswer, correctAnswer, isCorrect);
        }
    }

    /**
     * 高亮答案選項
     */
    highlightAnswers(exerciseIndex, userAnswer, correctAnswer, isCorrect) {
        const questionElement = document.getElementById(`exercise-${exerciseIndex}`);
        const options = questionElement.querySelectorAll('.option-item');

        options.forEach((option, index) => {
            const label = option.querySelector('.option-label');
            if (index === correctAnswer) {
                label.style.background = 'rgba(16, 185, 129, 0.2)';
                label.style.borderColor = 'var(--accent-color)';
                label.style.color = 'var(--accent-color)';
            } else if (index === userAnswer && !isCorrect) {
                label.style.background = 'rgba(239, 68, 68, 0.2)';
                label.style.borderColor = '#ef4444';
                label.style.color = '#ef4444';
            }
        });
    }

    /**
     * 更新標籤狀態
     */
    updateTabStatus(exerciseIndex, isCorrect) {
        const tabStatus = document.getElementById(`tab-status-${exerciseIndex}`);
        if (tabStatus) {
            const icon = tabStatus.querySelector('i');
            if (isCorrect) {
                icon.className = 'fas fa-check-circle';
                tabStatus.className = 'tab-status completed';
            } else {
                icon.className = 'fas fa-times-circle';
                tabStatus.className = 'tab-status incorrect';
            }
        }
    }

    /**
     * 更新練習題進度
     */
    updateExerciseProgress() {
        const totalExercises = Object.keys(this.exerciseResults).length;
        const progressElement = document.getElementById('exercise-progress');
        if (progressElement) {
            const totalCount = progressElement.textContent.split('/')[1];
            progressElement.textContent = `${totalExercises}/${totalCount}`;
        }

        // 檢查是否完成所有練習題
        const allExercises = document.querySelectorAll('.exercise-question');
        if (totalExercises >= allExercises.length) {
            this.showExerciseSummary();
        }
    }

    /**
     * 顯示練習題總結
     */
    showExerciseSummary() {
        const summaryElement = document.getElementById('exercise-summary');
        if (!summaryElement) return;

        // 計算統計數據
        const totalScore = Object.values(this.exerciseResults).reduce((sum, result) => {
            return sum + (result.score || 0);
        }, 0);

        const correctCount = Object.values(this.exerciseResults).filter(result => result.correct).length;
        const totalCount = Object.keys(this.exerciseResults).length;
        const accuracyRate = Math.round((correctCount / totalCount) * 100);

        const totalTime = this.calculateTotalTime();

        // 更新統計數據
        document.getElementById('total-score').textContent = totalScore;
        document.getElementById('accuracy-rate').textContent = `${accuracyRate}%`;
        document.getElementById('total-time').textContent = totalTime;

        // 顯示總結
        summaryElement.style.display = 'block';
        summaryElement.scrollIntoView({ behavior: 'smooth' });
    }

    /**
     * 計算總用時
     */
    calculateTotalTime() {
        if (!this.exerciseStartTime) return '0:00';
        
        const endTime = new Date();
        const totalSeconds = Math.floor((endTime - this.exerciseStartTime) / 1000);
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        
        return `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }

    /**
     * 開始練習題計時器
     */
    startExerciseTimer(exerciseIndex) {
        if (this.exerciseTimer) {
            clearInterval(this.exerciseTimer);
        }

        if (!this.exerciseStartTime) {
            this.exerciseStartTime = new Date();
        }

        // 這裡可以實現單題計時器
        const timerElement = document.getElementById(`timer-${exerciseIndex}`);
        if (timerElement) {
            // 實現單題計時邏輯
        }
    }

    /**
     * 顯示提示
     */
    showHint(exerciseIndex) {
        // 這裡可以實現提示功能
        alert('提示功能開發中...');
    }

    /**
     * 查看答案
     */
    reviewAnswers() {
        // 切換到第一個未完成的練習題
        const allExercises = document.querySelectorAll('.exercise-question');
        for (let i = 0; i < allExercises.length; i++) {
            if (!this.exerciseResults[i]) {
                this.switchToExercise(i);
                break;
            }
        }
    }

    /**
     * 跳轉到下一課
     */
    goToNextLesson() {
        // 這裡可以實現跳轉到下一課的邏輯
        const nextLessonUrl = this.getNextLessonUrl();
        if (nextLessonUrl) {
            window.location.href = nextLessonUrl;
        }
    }

    /**
     * 獲取下一課URL
     */
    getNextLessonUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        const courseId = urlParams.get('course');
        const currentLessonId = urlParams.get('lesson');
        
        // 這裡應該根據課程結構返回下一課的URL
        // 現在返回當前頁面
        return window.location.href;
    }

    /**
     * 載入練習題進度
     */
    loadExerciseProgress() {
        if (!this.courseId || !this.lessonId) return;

        const progressKey = `exercise_progress_${this.courseId}_${this.lessonId}`;
        const savedProgress = localStorage.getItem(progressKey);
        
        if (savedProgress) {
            const progress = JSON.parse(savedProgress);
            this.exerciseAnswers = progress.answers || {};
            this.exerciseResults = progress.results || {};
            
            // 恢復UI狀態
            this.restoreExerciseUI();
        }
    }

    /**
     * 恢復練習題UI狀態
     */
    restoreExerciseUI() {
        Object.keys(this.exerciseResults).forEach(exerciseIndex => {
            const result = this.exerciseResults[exerciseIndex];
            this.updateTabStatus(parseInt(exerciseIndex), result.correct);
            
            // 恢復答案輸入
            if (result.answer !== undefined) {
                const exerciseType = this.getExerciseType(parseInt(exerciseIndex));
                if (exerciseType === 'mc') {
                    // 恢復MC選擇
                    const optionInput = document.querySelector(`#option-${exerciseIndex}-${result.answer}`);
                    if (optionInput) {
                        optionInput.checked = true;
                    }
                } else if (exerciseType === 'text') {
                    // 恢復文字輸入
                    const textInput = document.getElementById(`text-answer-${exerciseIndex}`);
                    if (textInput) {
                        textInput.value = result.answer;
                    }
                }
            }
            
            // 如果已經提交過答案，顯示反饋
            if (result.submittedAt) {
                const correctAnswer = result.type === 'mc' ? 
                    this.getCorrectAnswer(parseInt(exerciseIndex)) : 
                    this.getCorrectKeywords(parseInt(exerciseIndex)).join('、');
                
                this.showAnswerFeedback(
                    parseInt(exerciseIndex), 
                    result.correct, 
                    result.answer, 
                    correctAnswer,
                    result.score || 0
                );
            }
        });
        
        this.updateExerciseProgress();
    }

    /**
     * 保存練習題進度
     */
    saveExerciseProgress() {
        if (!this.courseId || !this.lessonId) return;

        const progressKey = `exercise_progress_${this.courseId}_${this.lessonId}`;
        const progress = {
            answers: this.exerciseAnswers,
            results: this.exerciseResults,
            savedAt: new Date().toISOString()
        };

        localStorage.setItem(progressKey, JSON.stringify(progress));
    }

    /**
     * 追蹤課程開始
     */
    trackCourseStart() {
        if (this.learningProgress && this.courseId) {
            this.learningProgress.trackCourseStart(this.courseId);
        }
    }

    /**
     * 追蹤課程完成
     */
    trackLessonComplete(score = 0) {
        if (this.learningProgress && this.courseId && this.lessonId) {
            const studyTime = this.lessonStartTime ? 
                Math.floor((new Date() - this.lessonStartTime) / 1000) : 0;
            
            this.learningProgress.trackLessonComplete(this.courseId, this.lessonId, score, studyTime);
        }
    }

    /**
     * 追蹤練習題完成
     */
    trackExerciseComplete(exerciseId, score) {
        if (this.learningProgress && this.courseId && this.lessonId) {
            this.learningProgress.trackExerciseComplete(this.courseId, this.lessonId, exerciseId, score);
        }
    }
}

// 頁面載入完成後初始化
document.addEventListener('DOMContentLoaded', () => {
    new CourseLearning();
});

// 導出類供其他腳本使用
window.CourseLearning = CourseLearning;
