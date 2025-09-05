/**
 * 個人資料頁面 JavaScript
 */

// 數據導出功能
function exportData(format) {
    try {
        if (format === 'json') {
            exportUserDataJSON();
        } else if (format === 'csv') {
            exportActivityDataCSV();
        } else {
            throw new Error('不支持的導出格式');
        }
    } catch (error) {
        console.error('Export data error:', error);
        if (window.showNotification) {
            window.showNotification('數據導出失敗：' + error.message, 'error');
        }
    }
}

// 導出完整用戶數據 (JSON)
function exportUserDataJSON() {
    // 從頁面獲取數據
    const userData = {
        profile: window.currentUser || {},
        activities: window.activities || [],
        notifications: window.notifications || [],
        preferences: window.userPreferences || {},
        exportDate: new Date().toISOString(),
        exportVersion: '1.0'
    };

    const dataStr = JSON.stringify(userData, null, 2);
    const dataBlob = new Blob([dataStr], {type: 'application/json'});
    const url = URL.createObjectURL(dataBlob);
    
    const link = document.createElement('a');
    link.href = url;
    link.download = `user-data-${new Date().toISOString().split('T')[0]}.json`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);

    if (window.showNotification) {
        window.showNotification('數據導出成功！', 'success');
    }
}

// 導出活動數據 (CSV)
function exportActivityDataCSV() {
    const activities = window.activities || [];
    if (activities.length === 0) {
        if (window.showNotification) {
            window.showNotification('沒有活動記錄可導出', 'warning');
        }
        return;
    }

    const headers = ['時間', '類型', '標題', '描述', 'IP地址', '狀態'];
    const csvContent = [
        headers.join(','),
        ...activities.map(activity => [
            activity.timestamp,
            activity.type,
            `"${activity.title}"`,
            `"${activity.description}"`,
            activity.ip_address,
            activity.status
        ].join(','))
    ].join('\n');

    const dataBlob = new Blob([csvContent], {type: 'text/csv;charset=utf-8;'});
    const url = URL.createObjectURL(dataBlob);
    
    const link = document.createElement('a');
    link.href = url;
    link.download = `activity-log-${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);

    if (window.showNotification) {
        window.showNotification('活動記錄導出成功！', 'success');
    }
}

// 清除活動記錄
function clearActivityLog() {
    if (confirm('確定要清除所有活動記錄嗎？此操作無法復原。')) {
        const activityTimeline = document.querySelector('.activity-timeline');
        if (activityTimeline) {
            activityTimeline.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="empty-title">沒有活動記錄</h3>
                    <p class="empty-description">您還沒有任何活動記錄</p>
                </div>
            `;
        }
        
        updateActivityStats(0, 0, 0, 0);
        if (window.showNotification) {
            window.showNotification('活動記錄已清除', 'success');
        }
    }
}

// 清除通知記錄
function clearNotifications() {
    if (confirm('確定要清除所有通知記錄嗎？此操作無法復原。')) {
        const notificationsList = document.querySelector('.notifications-list');
        if (notificationsList) {
            notificationsList.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-bell-slash"></i>
                    </div>
                    <h3 class="empty-title">沒有通知</h3>
                    <p class="empty-description">您還沒有收到任何通知</p>
                </div>
            `;
        }
        
        updateNotificationStats(0, 0, 0, 0);
        if (window.showNotification) {
            window.showNotification('通知記錄已清除', 'success');
        }
    }
}

// 請求刪除帳戶
function requestAccountDeletion() {
    const confirmText = 'DELETE';
    const userInput = prompt(`警告：此操作將永久刪除您的帳戶和所有相關數據，無法復原！\n\n如果您確定要刪除帳戶，請輸入 "${confirmText}" 來確認：`);
    
    if (userInput === confirmText) {
        if (confirm('最後確認：您真的要永久刪除帳戶嗎？')) {
            if (window.showNotification) {
                window.showNotification('帳戶刪除請求已提交，我們將在 24 小時內處理', 'info');
            }
        }
    } else if (userInput !== null) {
        if (window.showNotification) {
            window.showNotification('輸入不正確，操作已取消', 'warning');
        }
    }
}

// 更新活動統計
function updateActivityStats(total, today, week, month) {
    const statNumbers = document.querySelectorAll('#activity-log .stat-number');
    if (statNumbers.length >= 4) {
        statNumbers[0].textContent = total;
        statNumbers[1].textContent = today;
        statNumbers[2].textContent = week;
        statNumbers[3].textContent = month;
    }
}

// 更新通知統計
function updateNotificationStats(total, unread, today, week) {
    const statNumbers = document.querySelectorAll('#notifications .stat-number');
    if (statNumbers.length >= 4) {
        statNumbers[0].textContent = total;
        statNumbers[1].textContent = unread;
        statNumbers[2].textContent = today;
        statNumbers[3].textContent = week;
    }
}

// 頁面初始化
document.addEventListener('DOMContentLoaded', function() {
    console.log('Profile page initialized');
    
    // 設置全局變量（從 PHP 傳遞的數據）
    // 這些數據應該通過 PHP 在頁面中設置
    window.currentUser = window.currentUser || {};
    window.activities = window.activities || [];
    window.notifications = window.notifications || [];
    window.userPreferences = window.userPreferences || {};
});
