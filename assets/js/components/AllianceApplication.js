/**
 * 聯盟申請模態框功能
 */
class AllianceApplication {
    constructor() {
        this.modal = null;
        this.form = null;
        this.init();
    }

    init() {
        this.modal = document.getElementById('allianceModal');
        this.form = document.getElementById('allianceForm');
        
        if (this.form) {
            this.bindEvents();
        }
    }

    bindEvents() {
        // 表單提交事件
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        // 點擊模態框外部關閉
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                this.closeModal();
            }
        });
        
        // ESC 鍵關閉模態框
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isModalOpen()) {
                this.closeModal();
            }
        });
    }

    /**
     * 顯示聯盟申請模態框
     */
    showModal() {
        if (!this.modal) return;

        // 顯示模態框
        this.modal.classList.add('active');
        document.body.style.overflow = 'hidden';

        // 聚焦到第一個輸入框
        const firstInput = this.form.querySelector('input, select, textarea');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }

        // 觸發動畫
        this.animateModalIn();
    }

    /**
     * 關閉模態框
     */
    closeModal() {
        if (!this.modal) return;

        this.animateModalOut(() => {
            this.modal.classList.remove('active');
            document.body.style.overflow = '';
            this.resetForm();
        });
    }

    /**
     * 檢查模態框是否開啟
     */
    isModalOpen() {
        return this.modal && this.modal.classList.contains('active');
    }

    /**
     * 模態框進入動畫
     */
    animateModalIn() {
        if (!this.modal) return;

        this.modal.style.display = 'flex';
        this.modal.style.opacity = '0';
        
        requestAnimationFrame(() => {
            this.modal.style.transition = 'opacity 0.3s ease';
            this.modal.style.opacity = '1';
        });
    }

    /**
     * 模態框退出動畫
     */
    animateModalOut(callback) {
        if (!this.modal) return;

        this.modal.style.transition = 'opacity 0.3s ease';
        this.modal.style.opacity = '0';
        
        setTimeout(() => {
            if (callback) callback();
        }, 300);
    }

    /**
     * 重置表單
     */
    resetForm() {
        if (!this.form) return;

        this.form.reset();
        this.clearValidationErrors();
    }

    /**
     * 清除驗證錯誤
     */
    clearValidationErrors() {
        const errorElements = this.form.querySelectorAll('.error-message');
        errorElements.forEach(element => element.remove());

        const errorFields = this.form.querySelectorAll('.error');
        errorFields.forEach(field => field.classList.remove('error'));
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
            this.closeModal();
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
        this.clearValidationErrors();
        let isValid = true;

        // 驗證必填欄位
        const requiredFields = this.form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                this.showFieldError(field, '此欄位為必填');
                isValid = false;
            }
        });

        // 驗證電子郵件
        const emailField = this.form.querySelector('#applicantEmail');
        if (emailField && emailField.value.trim()) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailField.value.trim())) {
                this.showFieldError(emailField, '請輸入有效的電子郵件地址');
                isValid = false;
            }
        }

        // 驗證電話號碼
        const phoneField = this.form.querySelector('#applicantPhone');
        if (phoneField && phoneField.value.trim()) {
            const phoneRegex = /^[\d\s\-\+\(\)]+$/;
            if (!phoneRegex.test(phoneField.value.trim())) {
                this.showFieldError(phoneField, '請輸入有效的電話號碼');
                isValid = false;
            }
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
     * 顯示提交中狀態
     */
    showSubmittingState() {
        const submitButton = this.form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 提交中...';
        }
    }

    /**
     * 隱藏提交中狀態
     */
    hideSubmittingState() {
        const submitButton = this.form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.innerHTML = '提交申請';
        }
    }

    /**
     * 提交表單
     */
    async submitForm(data) {
        // 模擬後端提交
        return new Promise((resolve) => {
            setTimeout(() => {
                console.log('聯盟申請數據:', data);
                resolve({ success: true });
            }, 1500);
        });
    }

    /**
     * 顯示成功訊息
     */
    showSuccessMessage() {
        // 使用現有的通知系統或創建一個
        if (window.showNotification) {
            window.showNotification('申請提交成功！我們將在3-5個工作日內審核您的申請。', 'success');
        } else {
            alert('申請提交成功！我們將在3-5個工作日內審核您的申請。');
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
}

// 全局函數，供 HTML 調用
function showAllianceModal() {
    if (window.allianceApplication) {
        window.allianceApplication.showModal();
    }
}

function closeAllianceModal() {
    if (window.allianceApplication) {
        window.allianceApplication.closeModal();
    }
}

// 初始化
document.addEventListener('DOMContentLoaded', () => {
    window.allianceApplication = new AllianceApplication();
});
