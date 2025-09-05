/**
 * 模態框控制組件
 * 實現模態框的顯示、隱藏和切換功能
 */

class Modal {
    constructor() {
        this.activeModal = null;
        this.init();
    }

    init() {
        this.bindEvents();
        console.log('Modal initialized');
    }

    bindEvents() {
        // 關閉按鈕事件
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-close')) {
                this.closeModal(e.target.closest('.modal'));
            }
        });

        // 背景遮罩點擊事件
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-backdrop')) {
                this.closeAllModals();
            }
        });

        // ESC 鍵關閉模態框
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeAllModals();
            }
        });
    }

    showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        // 關閉其他模態框
        this.closeAllModals();

        // 顯示當前模態框
        modal.classList.add('show');
        this.activeModal = modal;

        // 顯示背景遮罩
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.classList.add('show');
        }

        // 禁止背景滾動
        document.body.style.overflow = 'hidden';

        // 聚焦第一個輸入框
        const firstInput = modal.querySelector('input');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }
    }

    closeModal(modal) {
        if (!modal) return;

        modal.classList.remove('show');
        this.activeModal = null;

        // 隱藏背景遮罩
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.classList.remove('show');
        }

        // 恢復背景滾動
        document.body.style.overflow = '';

        // 清空表單
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
        }
    }

    closeAllModals() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            this.closeModal(modal);
        });
    }

    // 公共方法
    getActiveModal() {
        return this.activeModal;
    }

    isModalOpen() {
        return this.activeModal !== null;
    }
}

// 初始化模態框組件
document.addEventListener('DOMContentLoaded', () => {
    window.modal = new Modal();
});

// 導出類
window.Modal = Modal;

// 全局函數，用於 HTML 中的 onclick 事件
window.showLoginModal = function() {
    if (window.modal) {
        window.modal.showModal('login-modal');
    }
};

window.showRegisterModal = function() {
    if (window.modal) {
        window.modal.showModal('register-modal');
    }
};
