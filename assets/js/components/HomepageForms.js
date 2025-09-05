/**
 * 首頁表單處理組件
 * 處理首頁聯繫表單的驗證和提交
 */

class HomepageForms {
    constructor() {
        this.forms = {};
        this.init();
    }

    init() {
        this.cacheElements();
        this.setupEventListeners();
        this.setupFormValidation();
    }

    cacheElements() {
        // 首頁聯繫表單
        const homepageContactForm = document.getElementById('homepage-contact-form');
        if (homepageContactForm) {
            this.forms.homepageContact = homepageContactForm;
        }
    }

    setupEventListeners() {
        // 設置表單提交事件
        if (this.forms.homepageContact) {
            this.forms.homepageContact.addEventListener('submit', (e) => {
                this.handleFormSubmit(e, 'homepageContact');
            });
        }
    }

    setupFormValidation() {
        // 為所有表單設置實時驗證
        Object.values(this.forms).forEach(form => {
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                // 失去焦點時驗證
                input.addEventListener('blur', () => {
                    this.validateField(input);
                });

                // 輸入時清除錯誤
                input.addEventListener('input', () => {
                    this.clearFieldError(input);
                });
            });
        });
    }

    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // 檢查必填欄位
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = this.getRequiredErrorMessage(field);
        }

        // 檢查電子郵件格式
        if (field.type === 'email' && value && !this.isValidEmail(value)) {
            isValid = false;
            errorMessage = '請輸入有效的電子郵件地址';
        }

        // 檢查電話號碼格式（如果提供）
        if (field.type === 'tel' && value && !this.isValidPhone(value)) {
            isValid = false;
            errorMessage = '請輸入有效的電話號碼';
        }

        // 顯示或清除錯誤
        if (!isValid) {
            this.showFieldError(field, errorMessage);
        } else {
            this.clearFieldError(field);
        }

        return isValid;
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    isValidPhone(phone) {
        // 支援台灣電話號碼格式
        const phoneRegex = /^(\+886|0)?[2-9]\d{7,8}$/;
        return phoneRegex.test(phone.replace(/\s+/g, ''));
    }

    getRequiredErrorMessage(field) {
        const fieldName = field.getAttribute('placeholder') || field.name || '此欄位';
        return `${fieldName}為必填項目`;
    }

    showFieldError(field, message) {
        this.clearFieldError(field);

        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        errorDiv.style.cssText = `
            color: #EF4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        `;

        // 添加錯誤圖標
        errorDiv.innerHTML = `
            <svg width="16" height="16" viewBox="0 0 24 24" fill="#EF4444">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            ${message}
        `;

        field.parentNode.appendChild(errorDiv);
        field.style.borderColor = '#EF4444';
    }

    clearFieldError(field) {
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
        field.style.borderColor = '';
    }

    validateForm(form) {
        const inputs = form.querySelectorAll('input, select, textarea');
        let isValid = true;

        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    async handleFormSubmit(event, formKey) {
        event.preventDefault();
        
        const form = this.forms[formKey];
        if (!form) return;

        // 驗證表單
        if (!this.validateForm(form)) {
            this.showFormMessage(form, '請檢查並填寫所有必填欄位', 'error');
            return;
        }

        // 設置提交狀態
        this.setFormSubmitting(form, true);

        try {
            // 模擬表單提交
            await this.submitForm(form, formKey);
        } catch (error) {
            console.error('表單提交錯誤:', error);
            this.showFormMessage(form, '提交失敗，請稍後再試', 'error');
        } finally {
            this.setFormSubmitting(form, false);
        }
    }

    async submitForm(form, formKey) {
        // 收集表單數據
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        // 模擬API調用延遲
        await new Promise(resolve => setTimeout(resolve, 1500));

        // 模擬成功響應
        const success = Math.random() > 0.1; // 90% 成功率

        if (success) {
            this.showFormMessage(form, '訊息已成功發送！我們會盡快回覆您。', 'success');
            form.reset();
            
            // 清除所有錯誤狀態
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                this.clearFieldError(input);
            });
        } else {
            throw new Error('模擬提交失敗');
        }
    }

    setFormSubmitting(form, isSubmitting) {
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = isSubmitting;
            submitButton.textContent = isSubmitting ? '發送中...' : '發送訊息';
            
            if (isSubmitting) {
                submitButton.style.opacity = '0.7';
                submitButton.style.cursor = 'not-allowed';
            } else {
                submitButton.style.opacity = '1';
                submitButton.style.cursor = 'pointer';
            }
        }
    }

    showFormMessage(form, message, type) {
        // 移除現有消息
        const existingMessage = form.querySelector('.form-message');
        if (existingMessage) {
            existingMessage.remove();
        }

        // 創建新消息
        const messageDiv = document.createElement('div');
        messageDiv.className = `form-message form-message-${type}`;
        messageDiv.textContent = message;
        
        // 設置樣式
        const isSuccess = type === 'success';
        messageDiv.style.cssText = `
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            font-weight: 500;
            text-align: center;
            background: ${isSuccess ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)'};
            color: ${isSuccess ? '#10B981' : '#EF4444'};
            border: 1px solid ${isSuccess ? 'rgba(16, 185, 129, 0.3)' : 'rgba(239, 68, 68, 0.3)'};
        `;

        // 添加圖標
        const icon = isSuccess ? '✅' : '❌';
        messageDiv.innerHTML = `${icon} ${message}`;

        // 插入到表單底部
        form.appendChild(messageDiv);

        // 自動隱藏成功消息
        if (isSuccess) {
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.remove();
                }
            }, 5000);
        }
    }

    destroy() {
        // 清理事件監聽器
        Object.values(this.forms).forEach(form => {
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.removeEventListener('blur', () => this.validateField(input));
                input.removeEventListener('input', () => this.clearFieldError(input));
            });
        });
    }
}

// 初始化組件
document.addEventListener('DOMContentLoaded', () => {
    window.homepageForms = new HomepageForms();
});
