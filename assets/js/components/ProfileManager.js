/**
 * ProfileManager - 個人資料管理組件
 * 處理個人資料管理頁面的各種功能
 */
class ProfileManager {
    constructor() {
        this.init();
    }

    init() {
        this.initPasswordStrength();
        this.initPasswordToggle();
        this.initFormValidation();
        this.initPreferencesManager();
        this.initActivityFilters();
        this.initTabNavigation();
    }

    /**
     * 初始化密碼強度檢查
     */
    initPasswordStrength() {
        const newPasswordInput = document.getElementById('new_password');
        if (!newPasswordInput) return;

        newPasswordInput.addEventListener('input', (e) => {
            this.checkPasswordStrength(e.target.value);
        });

        // 密碼確認檢查
        const confirmPasswordInput = document.getElementById('confirm_password');
        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', () => {
                this.checkPasswordMatch();
            });
        }
    }

    /**
     * 檢查密碼強度
     */
    checkPasswordStrength(password) {
        const strengthBar = document.querySelector('.strength-fill');
        const strengthText = document.querySelector('.strength-text');
        const requirements = document.querySelectorAll('.requirement');

        if (!strengthBar || !strengthText) return;

        let strength = 0;
        const checks = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /\d/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };

        // 計算強度分數
        Object.values(checks).forEach(check => {
            if (check) strength++;
        });

        // 更新強度條
        strengthBar.style.width = `${(strength / 5) * 100}%`;
        strengthBar.dataset.strength = strength;

        // 更新強度文字
        let strengthLabel = '弱';
        let strengthClass = 'weak';
        
        if (strength >= 4) {
            strengthLabel = '強';
            strengthClass = 'strong';
        } else if (strength >= 3) {
            strengthLabel = '中等';
            strengthClass = 'medium';
        }

        strengthText.textContent = `密碼強度: ${strengthLabel}`;
        strengthText.className = `strength-text ${strengthClass}`;

        // 更新要求項目狀態
        requirements.forEach((req, index) => {
            const requirementType = req.dataset.requirement;
            const isMet = checks[requirementType];
            
            if (isMet) {
                req.classList.add('met');
                req.querySelector('i').className = 'fas fa-check-circle text-success';
            } else {
                req.classList.remove('met');
                req.querySelector('i').className = 'fas fa-circle text-muted';
            }
        });

        // 更新強度條顏色
        strengthBar.className = `strength-fill ${strengthClass}`;
    }

    /**
     * 檢查密碼是否匹配
     */
    checkPasswordMatch() {
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');
        
        if (!newPassword || !confirmPassword) return;

        if (confirmPassword.value && newPassword.value !== confirmPassword.value) {
            confirmPassword.classList.add('is-invalid');
            this.showFieldError(confirmPassword, '密碼不匹配');
        } else {
            confirmPassword.classList.remove('is-invalid');
            this.hideFieldError(confirmPassword);
        }
    }

    /**
     * 初始化密碼顯示/隱藏切換
     */
    initPasswordToggle() {
        const toggleButtons = document.querySelectorAll('.toggle-password');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const targetId = e.target.closest('.toggle-password').dataset.target;
                const input = document.getElementById(targetId);
                const icon = e.target.closest('.toggle-password').querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'fas fa-eye-slash';
                } else {
                    input.type = 'password';
                    icon.className = 'fas fa-eye';
                }
            });
        });
    }

    /**
     * 初始化表單驗證
     */
    initFormValidation() {
        const forms = document.querySelectorAll('.profile-form, .password-form, .preferences-form');
        
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                }
            });

            // 即時驗證
            const inputs = form.querySelectorAll('input[required], textarea[required]');
            inputs.forEach(input => {
                input.addEventListener('blur', () => {
                    this.validateField(input);
                });
                
                input.addEventListener('input', () => {
                    if (input.classList.contains('is-invalid')) {
                        this.validateField(input);
                    }
                });
            });
        });
    }

    /**
     * 驗證表單
     */
    validateForm(form) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    /**
     * 驗證單個欄位
     */
    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // 檢查必填
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = '此欄位為必填';
        }

        // 檢查電子郵件格式
        if (field.type === 'email' && value && !this.isValidEmail(value)) {
            isValid = false;
            errorMessage = '請輸入有效的電子郵件地址';
        }

        // 檢查電話號碼格式
        if (field.type === 'tel' && value && !this.isValidPhone(value)) {
            isValid = false;
            errorMessage = '請輸入有效的電話號碼';
        }

        // 檢查URL格式
        if (field.type === 'url' && value && !this.isValidUrl(value)) {
            isValid = false;
            errorMessage = '請輸入有效的網址';
        }

        // 檢查最小長度
        if (field.hasAttribute('minlength') && value.length < field.getAttribute('minlength')) {
            isValid = false;
            errorMessage = `最少需要 ${field.getAttribute('minlength')} 個字符`;
        }

        if (isValid) {
            this.hideFieldError(field);
        } else {
            this.showFieldError(field, errorMessage);
        }

        return isValid;
    }

    /**
     * 顯示欄位錯誤
     */
    showFieldError(field, message) {
        field.classList.add('is-invalid');
        
        // 移除現有錯誤訊息
        const existingError = field.parentNode.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }

        // 添加新錯誤訊息
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
    }

    /**
     * 隱藏欄位錯誤
     */
    hideFieldError(field) {
        field.classList.remove('is-invalid');
        const errorDiv = field.parentNode.querySelector('.invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    /**
     * 驗證電子郵件格式
     */
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * 驗證電話號碼格式
     */
    isValidPhone(phone) {
        const phoneRegex = /^[\+]?[0-9\s\-\(\)]{8,}$/;
        return phoneRegex.test(phone);
    }

    /**
     * 驗證URL格式
     */
    isValidUrl(url) {
        try {
            new URL(url);
            return true;
        } catch {
            return false;
        }
    }

    /**
     * 初始化偏好設定管理
     */
    initPreferencesManager() {
        // 語言切換
        const languageSelect = document.getElementById('language');
        if (languageSelect) {
            languageSelect.addEventListener('change', (e) => {
                this.updateLanguage(e.target.value);
            });
        }

        // 主題切換
        const themeSelect = document.getElementById('theme');
        if (themeSelect) {
            themeSelect.addEventListener('change', (e) => {
                this.updateTheme(e.target.value);
            });
        }

        // 通知設定
        const notificationCheckboxes = document.querySelectorAll('input[name^="notifications"]');
        notificationCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                this.updateNotificationSettings();
            });
        });

        // 隱私設定
        const privacyCheckboxes = document.querySelectorAll('input[name^="privacy"]');
        privacyCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                this.updatePrivacySettings();
            });
        });
    }

    /**
     * 更新語言設定
     */
    updateLanguage(language) {
        // 儲存到 localStorage
        const preferences = this.getUserPreferences();
        preferences.language = language;
        this.saveUserPreferences(preferences);

        // 顯示成功訊息
        this.showNotification('語言設定已更新', 'success');
    }

    /**
     * 更新主題設定
     */
    updateTheme(theme) {
        // 儲存到 localStorage
        const preferences = this.getUserPreferences();
        preferences.theme = theme;
        this.saveUserPreferences(preferences);

        // 應用主題
        this.applyTheme(theme);

        // 顯示成功訊息
        this.showNotification('主題設定已更新', 'success');
    }

    /**
     * 應用主題
     */
    applyTheme(theme) {
        const body = document.body;
        
        // 移除現有主題類別
        body.classList.remove('theme-light', 'theme-dark');
        
        // 添加新主題類別
        if (theme === 'dark') {
            body.classList.add('theme-dark');
        } else {
            body.classList.add('theme-light');
        }
    }

    /**
     * 更新通知設定
     */
    updateNotificationSettings() {
        const preferences = this.getUserPreferences();
        preferences.notifications = {
            email: document.getElementById('notify_email')?.checked || false,
            sms: document.getElementById('notify_sms')?.checked || false,
            push: document.getElementById('notify_push')?.checked || false
        };
        
        this.saveUserPreferences(preferences);
        this.showNotification('通知設定已更新', 'success');
    }

    /**
     * 更新隱私設定
     */
    updatePrivacySettings() {
        const preferences = this.getUserPreferences();
        preferences.privacy = {
            profile_visible: document.getElementById('profile_visible')?.checked || false,
            show_email: document.getElementById('show_email')?.checked || false,
            show_phone: document.getElementById('show_phone')?.checked || false
        };
        
        this.saveUserPreferences(preferences);
        this.showNotification('隱私設定已更新', 'success');
    }

    /**
     * 獲取用戶偏好設定
     */
    getUserPreferences() {
        const stored = localStorage.getItem('user_preferences');
        return stored ? JSON.parse(stored) : {
            language: 'zh-TW',
            theme: 'light',
            notifications: { email: true, sms: false, push: true },
            privacy: { profile_visible: true, show_email: false, show_phone: false }
        };
    }

    /**
     * 儲存用戶偏好設定
     */
    saveUserPreferences(preferences) {
        localStorage.setItem('user_preferences', JSON.stringify(preferences));
    }

    /**
     * 初始化活動篩選器
     */
    initActivityFilters() {
        const filterButton = document.getElementById('filter-activity');
        if (!filterButton) return;

        filterButton.addEventListener('click', () => {
            this.filterActivities();
        });

        // 載入更多活動
        const loadMoreButton = document.getElementById('load-more-activity');
        if (loadMoreButton) {
            loadMoreButton.addEventListener('click', () => {
                this.loadMoreActivities();
            });
        }
    }

    /**
     * 篩選活動
     */
    filterActivities() {
        const activityType = document.getElementById('activity-type')?.value;
        const activityDate = document.getElementById('activity-date')?.value;
        
        // 這裡可以實現實際的篩選邏輯
        console.log('篩選活動:', { type: activityType, date: activityDate });
        
        this.showNotification('活動篩選已應用', 'info');
    }

    /**
     * 載入更多活動
     */
    loadMoreActivities() {
        const loadMoreButton = document.getElementById('load-more-activity');
        if (!loadMoreButton) return;

        // 模擬載入更多活動
        loadMoreButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>載入中...';
        loadMoreButton.disabled = true;

        setTimeout(() => {
            // 這裡可以實現實際的載入邏輯
            this.showNotification('已載入更多活動', 'success');
            
            loadMoreButton.innerHTML = '<i class="fas fa-plus me-2"></i>載入更多';
            loadMoreButton.disabled = false;
        }, 1500);
    }

    /**
     * 初始化標籤頁導航
     */
    initTabNavigation() {
        const tabLinks = document.querySelectorAll('.nav-link[data-bs-toggle="pill"]');
        
        tabLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                // 更新活動狀態
                tabLinks.forEach(l => l.classList.remove('active'));
                e.target.classList.add('active');
                
                // 觸發標籤頁切換事件
                this.onTabChange(e.target.getAttribute('href').substring(1));
            });
        });
    }

    /**
     * 標籤頁切換事件處理
     */
    onTabChange(tabId) {
        console.log('切換到標籤頁:', tabId);
        
        // 根據標籤頁ID執行特定邏輯
        switch (tabId) {
            case 'password':
                // 重置密碼表單
                this.resetPasswordForm();
                break;
            case 'preferences':
                // 載入偏好設定
                this.loadPreferences();
                break;
            case 'activity':
                // 載入活動歷史
                this.loadActivityHistory();
                break;
        }
    }

    /**
     * 重置密碼表單
     */
    resetPasswordForm() {
        const passwordForm = document.querySelector('.password-form');
        if (passwordForm) {
            passwordForm.reset();
            
            // 重置密碼強度顯示
            const strengthBar = document.querySelector('.strength-fill');
            const strengthText = document.querySelector('.strength-text');
            if (strengthBar && strengthText) {
                strengthBar.style.width = '0%';
                strengthBar.dataset.strength = '0';
                strengthText.textContent = '密碼強度: 弱';
                strengthText.className = 'strength-text';
            }

            // 重置要求項目
            const requirements = document.querySelectorAll('.requirement');
            requirements.forEach(req => {
                req.classList.remove('met');
                req.querySelector('i').className = 'fas fa-circle text-muted';
            });
        }
    }

    /**
     * 載入偏好設定
     */
    loadPreferences() {
        const preferences = this.getUserPreferences();
        
        // 更新表單值
        if (preferences.language) {
            const languageSelect = document.getElementById('language');
            if (languageSelect) languageSelect.value = preferences.language;
        }
        
        if (preferences.theme) {
            const themeSelect = document.getElementById('theme');
            if (themeSelect) themeSelect.value = preferences.theme;
        }
    }

    /**
     * 載入活動歷史
     */
    loadActivityHistory() {
        // 這裡可以實現實際的活動歷史載入邏輯
        console.log('載入活動歷史');
    }

    /**
     * 顯示通知訊息
     */
    showNotification(message, type = 'info') {
        // 檢查是否有全局的 showNotification 函數
        if (typeof window.showNotification === 'function') {
            window.showNotification(message, type);
        } else {
            // 使用 Bootstrap 的 toast 或 alert
            this.showBootstrapNotification(message, type);
        }
    }

    /**
     * 顯示 Bootstrap 通知
     */
    showBootstrapNotification(message, type) {
        const alertClass = `alert-${type === 'error' ? 'danger' : type}`;
        const iconClass = type === 'success' ? 'check-circle' : 
                         type === 'error' ? 'exclamation-circle' : 
                         type === 'warning' ? 'exclamation-triangle' : 'info-circle';

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fas fa-${iconClass} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // 插入到頁面頂部
        const container = document.querySelector('.container');
        if (container) {
            container.insertAdjacentHTML('afterbegin', alertHtml);
            
            // 自動隱藏
            setTimeout(() => {
                const alert = container.querySelector('.alert');
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        }
    }
}

// 當 DOM 載入完成後初始化
document.addEventListener('DOMContentLoaded', function() {
    new ProfileManager();
});

// 導出類別供其他模組使用
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ProfileManager;
}
