/**
 * Service Forms Component
 * 處理服務頁面的表單提交和驗證
 */

class ServiceForms {
    constructor() {
        this.forms = {};
        this.init();
    }

    init() {
        this.cacheElements();
        this.setupEventListeners();
    }

    cacheElements() {
        // 服務諮詢表單
        const serviceContactForm = document.getElementById('service-contact-form');
        if (serviceContactForm) {
            this.forms.serviceContact = serviceContactForm;
        }

        // 個人教練預約表單
        const personalCoachingForm = document.getElementById('personal-coaching-form');
        if (personalCoachingForm) {
            this.forms.personalCoaching = personalCoachingForm;
        }

        // 企業諮詢表單
        const enterpriseContactForm = document.getElementById('enterprise-contact-form');
        if (enterpriseContactForm) {
            this.forms.enterpriseContact = enterpriseContactForm;
        }
    }

    setupEventListeners() {
        // 綁定表單提交事件
        Object.keys(this.forms).forEach(formKey => {
            const form = this.forms[formKey];
            if (form) {
                form.addEventListener('submit', (e) => this.handleFormSubmit(e, formKey));
            }
        });

        // 綁定表單驗證事件
        this.setupFormValidation();
    }

    setupFormValidation() {
        // 實時驗證
        Object.values(this.forms).forEach(form => {
            if (form) {
                const inputs = form.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    input.addEventListener('blur', () => this.validateField(input));
                    input.addEventListener('input', () => this.clearFieldError(input));
                });
            }
        });
    }

    validateField(field) {
        const value = field.value.trim();
        const isRequired = field.hasAttribute('required');
        const fieldType = field.type;
        let isValid = true;
        let errorMessage = '';

        // 必填欄位驗證
        if (isRequired && !value) {
            isValid = false;
            errorMessage = this.getRequiredErrorMessage(field);
        }

        // 特定欄位類型驗證
        if (isValid && value) {
            switch (fieldType) {
                case 'email':
                    if (!this.isValidEmail(value)) {
                        isValid = false;
                        errorMessage = '請輸入有效的電子郵件地址';
                    }
                    break;
                case 'tel':
                    if (!this.isValidPhone(value)) {
                        isValid = false;
                        errorMessage = '請輸入有效的電話號碼';
                    }
                    break;
                case 'text':
                    if (field.name === 'name' && value.length < 2) {
                        isValid = false;
                        errorMessage = '姓名至少需要2個字符';
                    }
                    break;
            }
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
        // 支援台灣手機號碼和市話格式
        const phoneRegex = /^(\+886|0)?[2-9]\d{7,8}$/;
        return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
    }

    getRequiredErrorMessage(field) {
        const label = field.previousElementSibling;
        if (label && label.tagName === 'LABEL') {
            const labelText = label.textContent.replace(' *', '');
            return `請填寫${labelText}`;
        }
        return '此欄位為必填';
    }

    showFieldError(field, message) {
        this.clearFieldError(field);
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        errorDiv.style.cssText = `
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        `;
        
        field.parentNode.appendChild(errorDiv);
        field.style.borderColor = '#dc3545';
    }

    clearFieldError(field) {
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        field.style.borderColor = '';
    }

    validateForm(form) {
        const fields = form.querySelectorAll('input, select, textarea');
        let isValid = true;

        fields.forEach(field => {
            if (!this.validateField(field)) {
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
            this.showFormMessage(form, '請檢查表單中的錯誤', 'error');
            return;
        }

        // 顯示提交中狀態
        this.setFormSubmitting(form, true);

        try {
            // 模擬表單提交（實際項目中會發送到後端）
            await this.submitForm(form, formKey);
            
            // 顯示成功消息
            this.showFormMessage(form, '表單提交成功！我們將盡快與您聯繫。', 'success');
            
            // 重置表單
            form.reset();
            
        } catch (error) {
            console.error('Form submission error:', error);
            this.showFormMessage(form, '提交失敗，請稍後再試。', 'error');
        } finally {
            // 恢復提交按鈕狀態
            this.setFormSubmitting(form, false);
        }
    }

    async submitForm(form, formKey) {
        // 收集表單數據
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        // 模擬API調用延遲
        await new Promise(resolve => setTimeout(resolve, 1500));

        // 根據表單類型處理數據
        switch (formKey) {
            case 'serviceContact':
                console.log('服務諮詢表單數據:', data);
                break;
            case 'personalCoaching':
                console.log('個人教練預約數據:', data);
                break;
            case 'enterpriseContact':
                console.log('企業諮詢表單數據:', data);
                break;
        }

        // 實際項目中這裡會發送POST請求到後端
        // const response = await fetch('/api/submit-form', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify(data)
        // });
        
        // if (!response.ok) {
        //     throw new Error('Network response was not ok');
        // }
    }

    setFormSubmitting(form, isSubmitting) {
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            if (isSubmitting) {
                submitButton.disabled = true;
                submitButton.textContent = '提交中...';
                submitButton.style.opacity = '0.7';
            } else {
                submitButton.disabled = false;
                submitButton.textContent = submitButton.dataset.originalText || '提交';
                submitButton.style.opacity = '1';
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
        
        const styles = {
            padding: '1rem',
            marginTop: '1rem',
            borderRadius: '0.5rem',
            textAlign: 'center',
            fontWeight: '500'
        };

        if (type === 'success') {
            styles.backgroundColor = '#d4edda';
            styles.color = '#155724';
            styles.border = '1px solid #c3e6cb';
        } else {
            styles.backgroundColor = '#f8d7da';
            styles.color = '#721c24';
            styles.border = '1px solid #f5c6cb';
        }

        Object.assign(messageDiv.style, styles);

        // 插入到表單底部
        form.appendChild(messageDiv);

        // 自動移除消息
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 5000);
    }

    // 保存表單數據到本地存儲（可選功能）
    saveFormData(formKey, data) {
        try {
            const key = `form_draft_${formKey}`;
            localStorage.setItem(key, JSON.stringify({
                data,
                timestamp: Date.now()
            }));
        } catch (error) {
            console.warn('無法保存表單草稿:', error);
        }
    }

    // 恢復表單數據（可選功能）
    restoreFormData(formKey) {
        try {
            const key = `form_draft_${formKey}`;
            const saved = localStorage.getItem(key);
            if (saved) {
                const { data, timestamp } = JSON.parse(saved);
                const form = this.forms[formKey];
                
                // 檢查草稿是否在24小時內
                if (Date.now() - timestamp < 24 * 60 * 60 * 1000) {
                    this.populateForm(form, data);
                    return true;
                } else {
                    // 過期草稿，清除
                    localStorage.removeItem(key);
                }
            }
        } catch (error) {
            console.warn('無法恢復表單草稿:', error);
        }
        return false;
    }

    populateForm(form, data) {
        Object.keys(data).forEach(key => {
            const field = form.querySelector(`[name="${key}"]`);
            if (field) {
                field.value = data[key];
            }
        });
    }

    destroy() {
        // 清理事件監聽器
        Object.values(this.forms).forEach(form => {
            if (form) {
                form.removeEventListener('submit', this.handleFormSubmit);
            }
        });
    }
}

// 初始化服務表單組件
document.addEventListener('DOMContentLoaded', () => {
    window.serviceForms = new ServiceForms();
});
