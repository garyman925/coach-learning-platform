/**
 * 聯絡表單功能
 */
class ContactForm {
    constructor() {
        this.form = null;
        this.faqItems = null;
        this.init();
    }

    init() {
        this.form = document.getElementById('contactForm');
        this.faqItems = document.querySelectorAll('.faq-item');
        
        if (this.form) {
            this.bindFormEvents();
        }
        
        if (this.faqItems.length > 0) {
            this.bindFAQEvents();
        }
    }

    bindFormEvents() {
        // 表單提交事件
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        // 即時驗證
        this.form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('blur', () => this.validateField(field));
            field.addEventListener('input', () => this.clearFieldError(field));
        });
    }

    bindFAQEvents() {
        this.faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            question.addEventListener('click', () => this.toggleFAQ(item));
        });
    }

    /**
     * 處理表單提交
     */
    async handleSubmit(e) {
        e.preventDefault();

        if (!this.validateForm()) {
            return;
        }

        this.showSubmittingState();

        try {
            const formData = new FormData(this.form);
            const data = Object.fromEntries(formData.entries());
            
            await this.submitForm(data);
            this.showSuccessMessage();
            this.resetForm();
        } catch (error) {
            this.showErrorMessage('提交失敗，請稍後再試');
        } finally {
            this.hideSubmittingState();
        }
    }

    /**
     * 驗證表單
     */
    validateForm() {
        let isValid = true;
        this.clearAllErrors();

        // 驗證必填欄位
        const requiredFields = this.form.querySelectorAll('[required]');
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

        // 清除之前的錯誤
        this.clearFieldError(field);

        // 必填欄位驗證
        if (field.hasAttribute('required') && !value) {
            errorMessage = '此欄位為必填';
            isValid = false;
        }

        // 電子郵件驗證
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                errorMessage = '請輸入有效的電子郵件地址';
                isValid = false;
            }
        }

        // 電話號碼驗證
        if (field.type === 'tel' && value) {
            const phoneRegex = /^[\d\s\-\+\(\)]+$/;
            if (!phoneRegex.test(value)) {
                errorMessage = '請輸入有效的電話號碼';
                isValid = false;
            }
        }

        // 顯示錯誤訊息
        if (!isValid && errorMessage) {
            this.showFieldError(field, errorMessage);
        }

        return isValid;
    }

    /**
     * 顯示欄位錯誤
     */
    showFieldError(field, message) {
        field.classList.add('error');
        
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        errorElement.textContent = message;
        errorElement.style.color = '#dc3545';
        errorElement.style.fontSize = '0.875rem';
        errorElement.style.marginTop = '0.25rem';
        
        field.parentNode.appendChild(errorElement);
    }

    /**
     * 清除欄位錯誤
     */
    clearFieldError(field) {
        field.classList.remove('error');
        const errorElement = field.parentNode.querySelector('.error-message');
        if (errorElement) {
            errorElement.remove();
        }
    }

    /**
     * 清除所有錯誤
     */
    clearAllErrors() {
        this.form.querySelectorAll('.error').forEach(field => {
            field.classList.remove('error');
        });
        this.form.querySelectorAll('.error-message').forEach(element => {
            element.remove();
        });
    }

    /**
     * 顯示提交中狀態
     */
    showSubmittingState() {
        const submitButton = this.form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 發送中...';
        }
    }

    /**
     * 隱藏提交中狀態
     */
    hideSubmittingState() {
        const submitButton = this.form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-paper-plane"></i> 發送訊息';
        }
    }

    /**
     * 提交表單
     */
    async submitForm(data) {
        // 模擬後端提交
        return new Promise((resolve) => {
            setTimeout(() => {
                console.log('聯絡表單數據:', data);
                resolve({ success: true });
            }, 1500);
        });
    }

    /**
     * 顯示成功訊息
     */
    showSuccessMessage() {
        if (window.showNotification) {
            window.showNotification('訊息發送成功！我們將在24小時內回覆您。', 'success');
        } else {
            alert('訊息發送成功！我們將在24小時內回覆您。');
        }
    }

    /**
     * 顯示錯誤訊息
     */
    showErrorMessage(message) {
        if (window.showNotification) {
            window.showNotification(message, 'error');
        } else {
            alert(message);
        }
    }

    /**
     * 重置表單
     */
    resetForm() {
        this.form.reset();
        this.clearAllErrors();
    }

    /**
     * 切換 FAQ 展開/收起
     */
    toggleFAQ(item) {
        const isActive = item.classList.contains('active');
        
        // 關閉其他展開的 FAQ
        this.faqItems.forEach(otherItem => {
            if (otherItem !== item) {
                otherItem.classList.remove('active');
            }
        });
        
        // 切換當前 FAQ
        if (isActive) {
            item.classList.remove('active');
        } else {
            item.classList.add('active');
        }
    }
}

// 全局函數，供 HTML 調用
function scrollToForm() {
    const formSection = document.querySelector('.contact-form-section');
    if (formSection) {
        formSection.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// 初始化
document.addEventListener('DOMContentLoaded', () => {
    window.contactForm = new ContactForm();
});
