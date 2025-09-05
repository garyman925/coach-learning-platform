/**
 * 學習進度追蹤系統
 */
class LearningProgress {
    constructor() {
        this.progressData = this.loadProgressData();
        this.achievements = this.loadAchievements();
        this.stats = this.loadStats();
        
        this.init();
    }

    init() {
        this.setupProgressTracking();
        this.setupAchievementSystem();
        this.setupStatsTracking();
        console.log('Learning Progress initialized');
    }

    /**
     * 載入進度數據
     */
    loadProgressData() {
        const defaultData = {
            courses: {},
            lessons: {},
            exercises: {},
            lastUpdated: new Date().toISOString()
        };
        
        const saved = localStorage.getItem('learning_progress');
        return saved ? { ...defaultData, ...JSON.parse(saved) } : defaultData;
    }

    /**
     * 載入成就數據
     */
    loadAchievements() {
        const defaultAchievements = {
            unlocked: [],
            progress: {},
            lastChecked: new Date().toISOString()
        };
        
        const saved = localStorage.getItem('learning_achievements');
        return saved ? { ...defaultAchievements, ...JSON.parse(saved) } : defaultAchievements;
    }

    /**
     * 載入統計數據
     */
    loadStats() {
        const defaultStats = {
            totalStudyTime: 0,
            totalLessonsCompleted: 0,
            totalExercisesCompleted: 0,
            averageScore: 0,
            streakDays: 0,
            lastStudyDate: null,
            studySessions: []
        };
        
        const saved = localStorage.getItem('learning_stats');
        return saved ? { ...defaultStats, ...JSON.parse(saved) } : defaultStats;
    }

    /**
     * 保存進度數據
     */
    saveProgressData() {
        this.progressData.lastUpdated = new Date().toISOString();
        localStorage.setItem('learning_progress', JSON.stringify(this.progressData));
    }

    /**
     * 保存成就數據
     */
    saveAchievements() {
        this.achievements.lastChecked = new Date().toISOString();
        localStorage.setItem('learning_achievements', JSON.stringify(this.achievements));
    }

    /**
     * 保存統計數據
     */
    saveStats() {
        localStorage.setItem('learning_stats', JSON.stringify(this.stats));
    }

    /**
     * 設置進度追蹤
     */
    setupProgressTracking() {
        // 監聽課程開始
        document.addEventListener('courseStarted', (event) => {
            this.trackCourseStart(event.detail.courseId);
        });

        // 監聽課程完成
        document.addEventListener('courseCompleted', (event) => {
            this.trackCourseComplete(event.detail.courseId);
        });

        // 監聽課程進度更新
        document.addEventListener('courseProgressUpdate', (event) => {
            this.updateCourseProgress(event.detail.courseId, event.detail.progress);
        });
    }

    /**
     * 設置成就系統
     */
    setupAchievementSystem() {
        // 檢查成就
        this.checkAchievements();
        
        // 定期檢查成就
        setInterval(() => {
            this.checkAchievements();
        }, 30000); // 每30秒檢查一次
    }

    /**
     * 設置統計追蹤
     */
    setupStatsTracking() {
        // 追蹤學習時間
        this.startTimeTracking();
        
        // 追蹤學習會話
        this.trackStudySession();
    }

    /**
     * 追蹤課程開始
     */
    trackCourseStart(courseId) {
        if (!this.progressData.courses[courseId]) {
            this.progressData.courses[courseId] = {
                startedAt: new Date().toISOString(),
                completedAt: null,
                progress: 0,
                lessonsCompleted: 0,
                totalLessons: 0,
                exercisesCompleted: 0,
                totalExercises: 0,
                averageScore: 0,
                totalStudyTime: 0
            };
        }
        
        this.saveProgressData();
        this.checkAchievements();
    }

    /**
     * 追蹤課程完成
     */
    trackCourseComplete(courseId) {
        if (this.progressData.courses[courseId]) {
            this.progressData.courses[courseId].completedAt = new Date().toISOString();
            this.progressData.courses[courseId].progress = 100;
            
            this.stats.totalLessonsCompleted += this.progressData.courses[courseId].lessonsCompleted;
            this.stats.totalExercisesCompleted += this.progressData.courses[courseId].exercisesCompleted;
            
            this.saveProgressData();
            this.saveStats();
            this.checkAchievements();
        }
    }

    /**
     * 更新課程進度
     */
    updateCourseProgress(courseId, progress) {
        if (this.progressData.courses[courseId]) {
            this.progressData.courses[courseId].progress = progress;
            this.saveProgressData();
        }
    }

    /**
     * 追蹤課程完成
     */
    trackLessonComplete(courseId, lessonId, score = 0, studyTime = 0) {
        // 更新課程進度
        if (!this.progressData.courses[courseId]) {
            this.trackCourseStart(courseId);
        }
        
        const course = this.progressData.courses[courseId];
        course.lessonsCompleted++;
        course.totalStudyTime += studyTime;
        
        // 更新課程進度
        if (course.totalLessons > 0) {
            course.progress = Math.round((course.lessonsCompleted / course.totalLessons) * 100);
        }
        
        // 記錄課程詳情
        this.progressData.lessons[lessonId] = {
            courseId: courseId,
            completedAt: new Date().toISOString(),
            score: score,
            studyTime: studyTime,
            exercisesCompleted: 0
        };
        
        this.saveProgressData();
        this.checkAchievements();
    }

    /**
     * 追蹤練習題完成
     */
    trackExerciseComplete(courseId, lessonId, exerciseId, score = 0) {
        // 更新課程進度
        if (!this.progressData.courses[courseId]) {
            this.trackCourseStart(courseId);
        }
        
        const course = this.progressData.courses[courseId];
        course.exercisesCompleted++;
        
        // 更新平均分數
        const totalScore = course.averageScore * (course.exercisesCompleted - 1) + score;
        course.averageScore = Math.round(totalScore / course.exercisesCompleted);
        
        // 記錄練習題詳情
        this.progressData.exercises[exerciseId] = {
            courseId: courseId,
            lessonId: lessonId,
            completedAt: new Date().toISOString(),
            score: score
        };
        
        this.saveProgressData();
        this.checkAchievements();
    }

    /**
     * 檢查成就
     */
    checkAchievements() {
        const achievements = this.getAvailableAchievements();
        
        achievements.forEach(achievement => {
            if (!this.achievements.unlocked.includes(achievement.id)) {
                if (this.checkAchievementCondition(achievement)) {
                    this.unlockAchievement(achievement);
                }
            }
        });
    }

    /**
     * 獲取可用成就
     */
    getAvailableAchievements() {
        return [
            {
                id: 'first_lesson',
                name: '初學者',
                description: '完成第一課',
                icon: 'fas fa-graduation-cap',
                condition: 'lessonsCompleted >= 1'
            },
            {
                id: 'first_course',
                name: '課程完成者',
                description: '完成第一個課程',
                icon: 'fas fa-trophy',
                condition: 'coursesCompleted >= 1'
            },
            {
                id: 'perfect_score',
                name: '完美主義者',
                description: '獲得滿分',
                icon: 'fas fa-star',
                condition: 'perfectScores >= 1'
            },
            {
                id: 'study_streak_7',
                name: '學習達人',
                description: '連續學習7天',
                icon: 'fas fa-fire',
                condition: 'streakDays >= 7'
            },
            {
                id: 'exercise_master',
                name: '練習大師',
                description: '完成100道練習題',
                icon: 'fas fa-dumbbell',
                condition: 'exercisesCompleted >= 100'
            },
            {
                id: 'time_master',
                name: '時間管理大師',
                description: '累計學習100小時',
                icon: 'fas fa-clock',
                condition: 'totalStudyTime >= 360000' // 100小時 = 360000秒
            }
        ];
    }

    /**
     * 檢查成就條件
     */
    checkAchievementCondition(achievement) {
        const stats = this.getStats();
        
        switch (achievement.condition) {
            case 'lessonsCompleted >= 1':
                return stats.totalLessonsCompleted >= 1;
            case 'coursesCompleted >= 1':
                return Object.values(this.progressData.courses).filter(c => c.completedAt).length >= 1;
            case 'perfectScores >= 1':
                return Object.values(this.progressData.exercises).filter(e => e.score >= 15).length >= 1;
            case 'streakDays >= 7':
                return stats.streakDays >= 7;
            case 'exercisesCompleted >= 100':
                return stats.totalExercisesCompleted >= 100;
            case 'totalStudyTime >= 360000':
                return stats.totalStudyTime >= 360000;
            default:
                return false;
        }
    }

    /**
     * 解鎖成就
     */
    unlockAchievement(achievement) {
        this.achievements.unlocked.push(achievement.id);
        this.saveAchievements();
        
        // 顯示成就通知
        this.showAchievementNotification(achievement);
    }

    /**
     * 顯示成就通知
     */
    showAchievementNotification(achievement) {
        // 創建成就通知元素
        const notification = document.createElement('div');
        notification.className = 'achievement-notification';
        notification.innerHTML = `
            <div class="achievement-content">
                <div class="achievement-icon">
                    <i class="${achievement.icon}"></i>
                </div>
                <div class="achievement-text">
                    <h4>成就解鎖！</h4>
                    <h5>${achievement.name}</h5>
                    <p>${achievement.description}</p>
                </div>
            </div>
        `;
        
        // 添加到頁面
        document.body.appendChild(notification);
        
        // 顯示動畫
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // 自動隱藏
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    /**
     * 開始時間追蹤
     */
    startTimeTracking() {
        this.sessionStartTime = new Date();
        
        // 追蹤頁面可見性變化
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.pauseTimeTracking();
            } else {
                this.resumeTimeTracking();
            }
        });
    }

    /**
     * 暫停時間追蹤
     */
    pauseTimeTracking() {
        if (this.sessionStartTime) {
            const sessionTime = Math.floor((new Date() - this.sessionStartTime) / 1000);
            this.stats.totalStudyTime += sessionTime;
            this.saveStats();
        }
    }

    /**
     * 恢復時間追蹤
     */
    resumeTimeTracking() {
        this.sessionStartTime = new Date();
    }

    /**
     * 追蹤學習會話
     */
    trackStudySession() {
        const today = new Date().toDateString();
        const lastStudyDate = this.stats.lastStudyDate;
        
        if (lastStudyDate !== today) {
            // 檢查是否連續學習
            const yesterday = new Date();
            yesterday.setDate(yesterday.getDate() - 1);
            
            if (lastStudyDate === yesterday.toDateString()) {
                this.stats.streakDays++;
            } else if (lastStudyDate !== today) {
                this.stats.streakDays = 1;
            }
            
            this.stats.lastStudyDate = today;
            this.saveStats();
        }
        
        // 記錄學習會話
        this.stats.studySessions.push({
            date: today,
            startTime: new Date().toISOString(),
            duration: 0
        });
        
        // 保持最近30天的記錄
        if (this.stats.studySessions.length > 30) {
            this.stats.studySessions = this.stats.studySessions.slice(-30);
        }
        
        this.saveStats();
    }

    /**
     * 獲取統計數據
     */
    getStats() {
        return {
            ...this.stats,
            coursesCompleted: Object.values(this.progressData.courses).filter(c => c.completedAt).length,
            totalCourses: Object.keys(this.progressData.courses).length,
            averageScore: this.calculateAverageScore()
        };
    }

    /**
     * 計算平均分數
     */
    calculateAverageScore() {
        const exercises = Object.values(this.progressData.exercises);
        if (exercises.length === 0) return 0;
        
        const totalScore = exercises.reduce((sum, exercise) => sum + exercise.score, 0);
        return Math.round(totalScore / exercises.length);
    }

    /**
     * 獲取課程進度
     */
    getCourseProgress(courseId) {
        return this.progressData.courses[courseId] || null;
    }

    /**
     * 獲取所有課程進度
     */
    getAllCourseProgress() {
        return this.progressData.courses;
    }

    /**
     * 獲取成就列表
     */
    getAchievements() {
        const availableAchievements = this.getAvailableAchievements();
        
        return availableAchievements.map(achievement => ({
            ...achievement,
            unlocked: this.achievements.unlocked.includes(achievement.id)
        }));
    }

    /**
     * 導出學習數據
     */
    exportLearningData() {
        return {
            progress: this.progressData,
            achievements: this.achievements,
            stats: this.stats,
            exportedAt: new Date().toISOString()
        };
    }

    /**
     * 清除所有數據
     */
    clearAllData() {
        localStorage.removeItem('learning_progress');
        localStorage.removeItem('learning_achievements');
        localStorage.removeItem('learning_stats');
        
        this.progressData = this.loadProgressData();
        this.achievements = this.loadAchievements();
        this.stats = this.loadStats();
    }
}

// 導出類供其他腳本使用
window.LearningProgress = LearningProgress;
