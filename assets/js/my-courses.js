/**
 * 我的課程頁面 JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // 初始化頁面
    initializeMyCourses();
    
    // 設置事件監聽器
    setupEventListeners();
});

function initializeMyCourses() {
    // 初始化統計數據
    updateStatistics();
    
    // 初始化課程進度
    updateCourseProgress();
    
    // 初始化服務狀態
    updateServiceStatus();
}

function setupEventListeners() {
    // 課程操作按鈕
    document.addEventListener('click', function(e) {
        if (e.target.matches('[data-action="continue-course"]')) {
            const courseId = e.target.dataset.courseId;
            continueCourse(courseId);
        }
        
        if (e.target.matches('[data-action="start-course"]')) {
            const courseId = e.target.dataset.courseId;
            startCourse(courseId);
        }
        
        if (e.target.matches('[data-action="review-course"]')) {
            const courseId = e.target.dataset.courseId;
            reviewCourse(courseId);
        }
    });
    
    // 服務操作按鈕
    document.addEventListener('click', function(e) {
        if (e.target.matches('[data-action="view-service"]')) {
            const serviceId = e.target.dataset.serviceId;
            viewService(serviceId);
        }
        
        if (e.target.matches('[data-action="cancel-service"]')) {
            const serviceId = e.target.dataset.serviceId;
            cancelService(serviceId);
        }
    });
}

function updateStatistics() {
    // 更新統計數據顯示
    const stats = {
        totalCourses: document.querySelectorAll('.course-card').length,
        inProgressCourses: document.querySelectorAll('.course-card .status-in-progress').length,
        completedCourses: document.querySelectorAll('.course-card .status-completed').length,
        totalServices: document.querySelectorAll('.service-card').length
    };
    
    // 更新統計卡片
    updateStatCard('total-courses', stats.totalCourses);
    updateStatCard('in-progress', stats.inProgressCourses);
    updateStatCard('completed', stats.completedCourses);
    updateStatCard('total-services', stats.totalServices);
}

function updateStatCard(statType, value) {
    const statElement = document.querySelector(`[data-stat="${statType}"]`);
    if (statElement) {
        statElement.textContent = value;
    }
}

function updateCourseProgress() {
    // 更新課程進度條
    document.querySelectorAll('.progress-fill').forEach(progressBar => {
        const percentage = progressBar.dataset.progress || 0;
        progressBar.style.width = percentage + '%';
    });
}

function updateServiceStatus() {
    // 更新服務狀態顯示
    document.querySelectorAll('.service-card').forEach(card => {
        const status = card.dataset.status;
        const statusElement = card.querySelector('.service-status');
        
        if (statusElement) {
            statusElement.className = `service-status status-${status}`;
        }
    });
}

function continueCourse(courseId) {
    // 繼續課程邏輯
    console.log('繼續課程:', courseId);
    // 這裡可以跳轉到課程學習頁面
    window.location.href = `/course/${courseId}/learn`;
}

function startCourse(courseId) {
    // 開始課程邏輯
    console.log('開始課程:', courseId);
    // 這裡可以跳轉到課程開始頁面
    window.location.href = `/course/${courseId}/start`;
}

function reviewCourse(courseId) {
    // 複習課程邏輯
    console.log('複習課程:', courseId);
    // 這裡可以跳轉到課程複習頁面
    window.location.href = `/course/${courseId}/review`;
}

function viewService(serviceId) {
    // 查看服務詳情邏輯
    console.log('查看服務:', serviceId);
    // 這裡可以顯示服務詳情模態框或跳轉到服務詳情頁面
}

function cancelService(serviceId) {
    // 取消服務邏輯
    if (confirm('確定要取消這個服務預約嗎？')) {
        console.log('取消服務:', serviceId);
        // 這裡可以發送取消請求
    }
}

// 導出函數供其他腳本使用
window.MyCourses = {
    updateStatistics,
    updateCourseProgress,
    updateServiceStatus,
    continueCourse,
    startCourse,
    reviewCourse,
    viewService,
    cancelService
};
