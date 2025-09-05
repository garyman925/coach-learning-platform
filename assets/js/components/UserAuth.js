/**
 * 用戶認證組件
 * 處理登入/註冊的前端功能
 */

class UserAuth {
    constructor() {
        this.isAuthenticated = false;
        this.currentUser = null;
        this.init();
    }

    init() {
        this.loadUserSession();
        this.bindEvents();
        this.updateUI();
        console.log('UserAuth initialized');
    }

    loadUserSession() {
        // 檢查是否有用戶會話（由後端PHP管理）
        // 前端只負責UI更新
        this.updateUI();
    }

    bindEvents() {
        // 登入表單事件
        const loginForm = document.querySelector('#login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleLogin(e.target);
            });
        }

        // 註冊表單事件
        const registerForm = document.querySelector('#register-form');
        if (registerForm) {
            registerForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleRegister(e.target);
            });
        }

        // 登出按鈕事件
        const logoutButtons = document.querySelectorAll('.logout-btn, .user-dropdown a[href="/logout"]');
        logoutButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleLogout();
            });
        });

        // 用戶菜單切換事件
        const userMenuToggles = document.querySelectorAll('.user-menu-toggle');
        userMenuToggles.forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleUserMenu(toggle);
            });
        });

        // 點擊外部關閉用戶菜單
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.user-dropdown')) {
                this.closeUserMenu();
            }
        });
    }

    handleLogin(form) {
        const formData = new FormData(form);
        const email = formData.get('email');
        const password = formData.get('password');
        const rememberMe = formData.get('remember_me') === 'on';

        if (!email || !password) {
            this.showMessage('請填寫所有必填欄位', 'error');
            return;
        }

        // 顯示載入狀態
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 登入中...';
        submitBtn.disabled = true;

        // 提交到後端登入頁面
        form.action = '/login';
        form.method = 'POST';
        
        // 創建隱藏的用戶名字段（因為後端期望用戶名）
        let usernameField = form.querySelector('input[name="username"]');
        if (!usernameField) {
            usernameField = document.createElement('input');
            usernameField.type = 'hidden';
            usernameField.name = 'username';
            form.appendChild(usernameField);
        }
        usernameField.value = email; // 使用郵箱作為用戶名

        // 提交表單
        form.submit();
    }

    handleRegister(form) {
        const formData = new FormData(form);
        const username = formData.get('username');
        const email = formData.get('email');
        const password = formData.get('password');
        const confirmPassword = formData.get('confirm_password');
        const firstName = formData.get('first_name');
        const lastName = formData.get('last_name');
        const phone = formData.get('phone');
        const agreeTerms = formData.get('agree_terms') === 'on';

        // 前端驗證
        if (!username || !email || !password || !confirmPassword || !firstName || !lastName) {
            this.showMessage('請填寫所有必填欄位', 'error');
            return;
        }

        if (password !== confirmPassword) {
            this.showMessage('密碼確認不匹配', 'error');
            return;
        }

        if (password.length < 6) {
            this.showMessage('密碼長度至少需要6個字符', 'error');
            return;
        }

        if (!agreeTerms) {
            this.showMessage('請同意服務條款和隱私政策', 'error');
            return;
        }

        // 顯示載入狀態
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 註冊中...';
        submitBtn.disabled = true;

        // 提交到後端註冊頁面
        form.action = '/register';
        form.method = 'POST';
        
        // 提交表單
        form.submit();
    }

    handleLogout() {
        // 顯示確認對話框
        if (confirm('確定要登出嗎？')) {
            // 重定向到登出頁面
            window.location.href = '/admin/logout';
        }
    }

    toggleUserMenu(toggle) {
        const dropdown = toggle.closest('.user-dropdown');
        const menu = dropdown.querySelector('.user-menu');
        
        if (menu.classList.contains('show')) {
            this.closeUserMenu();
        } else {
            this.closeUserMenu();
            menu.classList.add('show');
            toggle.classList.add('active');
        }
    }

    closeUserMenu() {
        const menus = document.querySelectorAll('.user-menu');
        const toggles = document.querySelectorAll('.user-menu-toggle');
        
        menus.forEach(menu => menu.classList.remove('show'));
        toggles.forEach(toggle => toggle.classList.remove('active'));
    }

    updateUI() {
        // 檢查頁面是否有用戶狀態指示器
        const userStatusElements = document.querySelectorAll('.user-status, .auth-status');
        
        userStatusElements.forEach(element => {
            if (element.classList.contains('logged-in')) {
                this.showLoggedInState(element);
            } else if (element.classList.contains('logged-out')) {
                this.showLoggedOutState(element);
            }
        });

        // 更新導航欄的用戶狀態
        this.updateNavigation();
    }

    showLoggedInState(element) {
        element.innerHTML = `
            <div class="user-info">
                <span class="user-avatar">👤</span>
                <span class="user-name">已登入</span>
                <div class="user-actions">
                    <a href="/profile" class="btn btn-sm btn-primary">個人資料</a>
                    <button class="btn btn-sm btn-outline logout-btn">登出</button>
                </div>
            </div>
        `;
    }

    showLoggedOutState(element) {
        element.innerHTML = `
            <div class="auth-actions">
                <a href="/login" class="btn btn-sm btn-primary">登入</a>
                <a href="/register" class="btn btn-sm btn-outline">註冊</a>
            </div>
        `;
    }

    updateNavigation() {
        // 更新導航欄的用戶相關元素
        const loginLinks = document.querySelectorAll('a[href="/login"]');
        const registerLinks = document.querySelectorAll('a[href="/register"]');
        const userMenuElements = document.querySelectorAll('.user-menu, .user-dropdown');
        const logoutElements = document.querySelectorAll('.logout-btn, a[href="/logout"]');

        // 這些元素會根據後端PHP的用戶狀態動態顯示/隱藏
        // 前端只負責樣式和交互
    }

    showMessage(message, type = 'info') {
        // 創建消息提示
        const messageDiv = document.createElement('div');
        messageDiv.className = `auth-message auth-message-${type}`;
        messageDiv.innerHTML = `
            <span class="message-text">${message}</span>
            <button class="message-close">&times;</button>
        `;

        // 添加到頁面
        document.body.appendChild(messageDiv);

        // 自動關閉
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);

        // 手動關閉
        const closeBtn = messageDiv.querySelector('.message-close');
        closeBtn.addEventListener('click', () => {
            messageDiv.remove();
        });
    }

    // 檢查用戶是否已登入（用於前端邏輯）
    checkAuthStatus() {
        // 這個方法會根據後端PHP的會話狀態來判斷
        // 目前返回false，實際狀態由後端控制
        return false;
    }

    // 獲取當前用戶信息（用於前端邏輯）
    getCurrentUser() {
        // 用戶信息由後端PHP提供
        return null;
    }
}

// 導出類
if (typeof module !== 'undefined' && module.exports) {
    module.exports = UserAuth;
}
