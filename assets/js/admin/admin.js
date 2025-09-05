/**
 * 管理員後台 JavaScript 功能
 */

class AdminDashboard {
    constructor() {
        this.init();
    }
    
    init() {
        this.initScrollAnimations();
        this.initMobileSidebar();
        this.initStatsAnimation();
        this.initQuickActions();
        this.initActivityFeed();
    }
    
    /**
     * 初始化滾動動畫
     */
    initScrollAnimations() {
        if (typeof ScrollAnimator !== 'undefined') {
            new ScrollAnimator();
        }
    }
    
    /**
     * 初始化移動端側邊欄
     */
    initMobileSidebar() {
        const sidebar = document.querySelector('.admin-sidebar');
        const toggleButton = document.createElement('button');
        toggleButton.className = 'mobile-sidebar-toggle';
        toggleButton.innerHTML = '<i class="fas fa-bars"></i>';
        toggleButton.setAttribute('aria-label', '切換側邊欄');
        
        // 在header中添加切換按鈕
        const header = document.querySelector('.admin-header-content');
        if (header) {
            header.insertBefore(toggleButton, header.firstChild);
        }
        
        // 切換側邊欄
        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
        
        // 點擊外部關閉側邊欄
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !toggleButton.contains(e.target)) {
                sidebar.classList.remove('active');
            }
        });
        
        // 添加移動端樣式
        this.addMobileStyles();
    }
    
    /**
     * 添加移動端樣式
     */
    addMobileStyles() {
        const style = document.createElement('style');
        style.textContent = `
            .mobile-sidebar-toggle {
                display: none;
                background: none;
                border: none;
                color: var(--primary-color);
                font-size: 1.5rem;
                cursor: pointer;
                padding: 0.5rem;
                border-radius: 4px;
                transition: background-color 0.3s ease;
            }
            
            .mobile-sidebar-toggle:hover {
                background: var(--light-bg);
            }
            
            @media (max-width: 768px) {
                .mobile-sidebar-toggle {
                    display: block;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    /**
     * 初始化統計數據動畫
     */
    initStatsAnimation() {
        const statNumbers = document.querySelectorAll('.stat-number');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateNumber(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        });
        
        statNumbers.forEach(stat => observer.observe(stat));
    }
    
    /**
     * 數字動畫
     */
    animateNumber(element) {
        const finalValue = element.textContent;
        const isPercentage = finalValue.includes('%');
        const isDecimal = finalValue.includes('.');
        
        let startValue = 0;
        const duration = 2000;
        const startTime = performance.now();
        
        const animate = (currentTime) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // 使用緩動函數
            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
            
            let currentValue;
            if (isPercentage) {
                const numericValue = parseFloat(finalValue);
                currentValue = startValue + (numericValue - startValue) * easeOutQuart;
                element.textContent = currentValue.toFixed(1) + '%';
            } else if (isDecimal) {
                const numericValue = parseFloat(finalValue);
                currentValue = startValue + (numericValue - startValue) * easeOutQuart;
                element.textContent = currentValue.toFixed(1);
            } else {
                const numericValue = parseInt(finalValue);
                currentValue = Math.floor(startValue + (numericValue - startValue) * easeOutQuart);
                element.textContent = currentValue;
            }
            
            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };
        
        requestAnimationFrame(animate);
    }
    
    /**
     * 初始化快速操作
     */
    initQuickActions() {
        const actionCards = document.querySelectorAll('.action-card');
        
        actionCards.forEach(card => {
            card.addEventListener('click', (e) => {
                // 添加點擊效果
                this.addClickEffect(e.target);
                
                // 檢查是否為有效連結
                const href = card.getAttribute('href');
                if (href && href !== '#') {
                    // 實際部署時會導航到對應頁面
                    console.log('導航到:', href);
                }
            });
        });
    }
    
    /**
     * 添加點擊效果
     */
    addClickEffect(element) {
        element.style.transform = 'scale(0.95)';
        setTimeout(() => {
            element.style.transform = '';
        }, 150);
    }
    
    /**
     * 初始化活動動態
     */
    initActivityFeed() {
        const activityItems = document.querySelectorAll('.activity-item');
        
        activityItems.forEach((item, index) => {
            // 添加延遲動畫
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                item.style.transition = 'all 0.6s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, index * 200);
        });
    }
    
    /**
     * 顯示通知
     */
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `admin-notification admin-notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${this.getNotificationIcon(type)}"></i>
                <span>${message}</span>
            </div>
            <button class="notification-close">&times;</button>
        `;
        
        // 添加到頁面
        document.body.appendChild(notification);
        
        // 顯示動畫
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // 關閉按鈕
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            this.hideNotification(notification);
        });
        
        // 自動關閉
        setTimeout(() => {
            this.hideNotification(notification);
        }, 5000);
    }
    
    /**
     * 隱藏通知
     */
    hideNotification(notification) {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }
    
    /**
     * 獲取通知圖標
     */
    getNotificationIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    }
    
    /**
     * 更新統計數據
     */
    updateStats(newStats) {
        Object.keys(newStats).forEach(key => {
            const statElement = document.querySelector(`[data-stat="${key}"]`);
            if (statElement) {
                const numberElement = statElement.querySelector('.stat-number');
                if (numberElement) {
                    this.animateNumber(numberElement);
                }
            }
        });
    }
    
    /**
     * 刷新活動動態
     */
    refreshActivityFeed() {
        // 模擬獲取新數據
        const newActivities = [
            {
                icon: 'fas fa-user-plus',
                title: '新用戶註冊',
                description: '用戶 "new_user" 完成了註冊',
                time: '剛剛'
            }
        ];
        
        // 更新活動列表
        this.addNewActivity(newActivities[0]);
    }
    
    /**
     * 添加新活動
     */
    addNewActivity(activity) {
        const activityList = document.querySelector('.activity-list');
        if (!activityList) return;
        
        const newItem = document.createElement('div');
        newItem.className = 'activity-item new-activity';
        newItem.innerHTML = `
            <div class="activity-icon">
                <i class="${activity.icon}"></i>
            </div>
            <div class="activity-content">
                <h4>${activity.title}</h4>
                <p>${activity.description}</p>
                <span class="activity-time">${activity.time}</span>
            </div>
        `;
        
        // 插入到頂部
        activityList.insertBefore(newItem, activityList.firstChild);
        
        // 添加動畫
        newItem.style.opacity = '0';
        newItem.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            newItem.style.transition = 'all 0.6s ease';
            newItem.style.opacity = '1';
            newItem.style.transform = 'translateY(0)';
            newItem.classList.remove('new-activity');
        }, 100);
        
        // 限制活動項目數量
        const items = activityList.querySelectorAll('.activity-item');
        if (items.length > 10) {
            items[items.length - 1].remove();
        }
    }
}

// 初始化管理員儀表板
document.addEventListener('DOMContentLoaded', () => {
    window.adminDashboard = new AdminDashboard();
    
    // 模擬實時更新
    setInterval(() => {
        if (window.adminDashboard) {
            window.adminDashboard.refreshActivityFeed();
        }
    }, 30000); // 每30秒更新一次
});

// 添加通知樣式
const notificationStyles = document.createElement('style');
notificationStyles.textContent = `
    .admin-notification {
        position: fixed;
        top: 90px;
        right: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        border: 1px solid var(--border-color);
        padding: 1rem 1.5rem;
        min-width: 300px;
        z-index: 10000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    }
    
    .admin-notification.show {
        transform: translateX(0);
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .notification-content i {
        color: var(--primary-color);
        font-size: 1.2rem;
    }
    
    .admin-notification-success .notification-content i {
        color: var(--accent-color);
    }
    
    .admin-notification-error .notification-content i {
        color: #dc3545;
    }
    
    .admin-notification-warning .notification-content i {
        color: #ffc107;
    }
    
    .notification-close {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: none;
        border: none;
        font-size: 1.2rem;
        color: var(--text-secondary);
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    
    .notification-close:hover {
        background: var(--light-bg);
        color: var(--text-primary);
    }
    
    .new-activity {
        background: rgba(var(--primary-color-rgb), 0.05);
        border-left: 3px solid var(--primary-color);
    }
`;

document.head.appendChild(notificationStyles);
