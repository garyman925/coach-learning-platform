/**
 * 通知系統
 */
class Notification {
    constructor() {
        this.container = null;
        this.init();
    }
    
    init() {
        this.createContainer();
        console.log('Notification system initialized');
    }
    
    createContainer() {
        if (!document.querySelector('.notification-container')) {
            this.container = document.createElement('div');
            this.container.className = 'notification-container';
            this.container.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
                pointer-events: none;
            `;
            document.body.appendChild(this.container);
        } else {
            this.container = document.querySelector('.notification-container');
        }
    }
    
    show(message, type = 'info', duration = 3000) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            background: ${this.getTypeColor(type)};
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            pointer-events: auto;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 300px;
            word-wrap: break-word;
        `;
        notification.textContent = message;
        
        this.container.appendChild(notification);
        
        // 動畫進入
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 10);
        
        // 自動移除
        setTimeout(() => {
            this.remove(notification);
        }, duration);
        
        // 點擊移除
        notification.addEventListener('click', () => {
            this.remove(notification);
        });
    }
    
    remove(notification) {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }
    
    getTypeColor(type) {
        const colors = {
            success: '#10b981',
            error: '#ef4444',
            warning: '#f59e0b',
            info: '#3b82f6'
        };
        return colors[type] || colors.info;
    }
}

// 創建全局實例
window.notification = new Notification();

// 全局函數
window.showNotification = (message, type, duration) => {
    window.notification.show(message, type, duration);
};
