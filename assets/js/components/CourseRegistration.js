/**
 * 課程報名模態框功能
 */
class CourseRegistration {
    constructor() {
        this.modal = null;
        this.form = null;
        this.courseNameInput = null;
        this.init();
    }

    init() {
        this.modal = document.getElementById('courseModal');
        this.form = document.getElementById('courseForm');
        this.courseNameInput = document.getElementById('courseName');
        
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
     * 顯示課程報名模態框
     * @param {string} courseType - 課程類型
     */
    showModal(courseType) {
        if (!this.modal) return;

        // 設置課程名稱
        const courseNames = {
            'professional-coaching': '專業教練基礎課程',
            'team-coaching': '團隊教練實戰課程',
            'parent-coaching': '家長教練課程',
            'enneagram': '9型人格課程',
            'consultation': '免費諮詢'
        };

        const courseName = courseNames[courseType] || '課程報名';
        this.courseNameInput.value = courseName;

        // 更新模態框標題
        const modalTitle = document.getElementById('modalTitle');
        if (modalTitle) {
            modalTitle.textContent = courseType === 'consultation' ? '免費諮詢' : '課程報名';
        }

        // 顯示模態框
        this.modal.classList.add('active');
        document.body.style.overflow = 'hidden';

        // 聚焦到第一個輸入框
        const firstInput = this.form.querySelector('input:not([readonly])');
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
        const modalContent = this.modal.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.animation = 'modalSlideIn 0.3s ease-out';
        }
    }

    /**
     * 模態框退出動畫
     */
    animateModalOut(callback) {
        const modalContent = this.modal.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.animation = 'modalSlideOut 0.3s ease-in';
            setTimeout(callback, 300);
        } else {
            callback();
        }
    }

    /**
     * 重置表單
     */
    resetForm() {
        if (this.form) {
            this.form.reset();
            this.clearValidationErrors();
        }
    }

    /**
     * 清除驗證錯誤
     */
    clearValidationErrors() {
        const errorElements = this.form.querySelectorAll('.error-message');
        errorElements.forEach(element => element.remove());
        
        const errorInputs = this.form.querySelectorAll('.error');
        errorInputs.forEach(input => input.classList.remove('error'));
    }

    /**
     * 處理表單提交
     */
    async handleSubmit(e) {
        e.preventDefault();
        
        if (!this.validateForm()) {
            return;
        }

        const formData = new FormData(this.form);
        const data = Object.fromEntries(formData.entries());

        try {
            // 顯示提交中狀態
            this.showSubmittingState();

            // 模擬 API 調用
            await this.submitForm(data);

            // 顯示成功訊息
            this.showSuccessMessage();
            
            // 延遲關閉模態框
            setTimeout(() => {
                this.closeModal();
            }, 2000);

        } catch (error) {
            console.error('表單提交失敗:', error);
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
        const requiredFields = ['applicantName', 'applicantEmail', 'applicantPhone'];

        requiredFields.forEach(fieldName => {
            const field = this.form.querySelector(`[name="${fieldName}"]`);
            if (!field || !field.value.trim()) {
                this.showFieldError(field, '此欄位為必填');
                isValid = false;
            }
        });

        // 驗證電子郵件格式
        const emailField = this.form.querySelector('[name="applicantEmail"]');
        if (emailField && emailField.value.trim()) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailField.value.trim())) {
                this.showFieldError(emailField, '請輸入有效的電子郵件地址');
                isValid = false;
            }
        }

        // 驗證電話號碼格式
        const phoneField = this.form.querySelector('[name="applicantPhone"]');
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
        errorElement.style.color = 'var(--error-color)';
        errorElement.style.fontSize = '0.875rem';
        errorElement.style.marginTop = '0.25rem';
        
        field.parentNode.appendChild(errorElement);
    }

    /**
     * 顯示提交中狀態
     */
    showSubmittingState() {
        const submitBtn = this.form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner"></span> 提交中...';
        }
    }

    /**
     * 隱藏提交中狀態
     */
    hideSubmittingState() {
        const submitBtn = this.form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = '提交報名';
        }
    }

    /**
     * 提交表單（模擬）
     */
    async submitForm(data) {
        // 模擬 API 調用延遲
        await new Promise(resolve => setTimeout(resolve, 1500));
        
        // 模擬成功響應
        console.log('課程報名資料:', data);
        
        // 這裡可以添加實際的 API 調用
        // const response = await fetch('/api/course-registration', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify(data)
        // });
        // 
        // if (!response.ok) {
        //     throw new Error('提交失敗');
        // }
        
        return { success: true };
    }

    /**
     * 顯示成功訊息
     */
    showSuccessMessage() {
        const successMessage = document.createElement('div');
        successMessage.className = 'success-message';
        successMessage.innerHTML = `
            <div style="text-align: center; padding: 2rem;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="var(--success-color)" style="margin-bottom: 1rem;">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                <h3 style="color: var(--success-color); margin-bottom: 0.5rem;">報名成功！</h3>
                <p style="color: var(--text-secondary);">我們會盡快與您聯繫，確認課程詳情。</p>
            </div>
        `;
        
        const modalBody = this.modal.querySelector('.modal-body');
        if (modalBody) {
            modalBody.innerHTML = '';
            modalBody.appendChild(successMessage);
        }
    }

    /**
     * 顯示錯誤訊息
     */
    showErrorMessage(message) {
        const errorMessage = document.createElement('div');
        errorMessage.className = 'error-message';
        errorMessage.innerHTML = `
            <div style="text-align: center; padding: 2rem; color: var(--error-color);">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="margin-bottom: 1rem;">
                    <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                </svg>
                <h3 style="margin-bottom: 0.5rem;">提交失敗</h3>
                <p>${message}</p>
            </div>
        `;
        
        const modalBody = this.modal.querySelector('.modal-body');
        if (modalBody) {
            modalBody.innerHTML = '';
            modalBody.appendChild(errorMessage);
        }
    }
}

// 全局函數，供 HTML 調用
function showCourseModal(courseType) {
    if (window.courseRegistration) {
        window.courseRegistration.showModal(courseType);
    }
}

function closeCourseModal() {
    if (window.courseRegistration) {
        window.courseRegistration.closeModal();
    }
}

// 初始化
document.addEventListener('DOMContentLoaded', () => {
    window.courseRegistration = new CourseRegistration();
});
