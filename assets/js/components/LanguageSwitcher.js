/**
 * 語言切換組件
 * 處理多語言切換功能
 */

class LanguageSwitcher {
    constructor() {
        this.currentLanguage = 'zh-TW'; // 默認語言
        this.languages = {
            'zh-TW': {
                name: '繁體中文',
                short: '繁體',
                flag: '🇹🇼'
            },
            'zh-CN': {
                name: '簡體中文',
                short: '簡體',
                flag: '🇨🇳'
            },
            'en': {
                name: 'English',
                short: 'EN',
                flag: '🇺🇸'
            }
        };
        
        this.init();
    }

    init() {
        this.loadLanguagePreference();
        this.bindEvents();
        this.updateUI();
        console.log('LanguageSwitcher initialized');
    }

    loadLanguagePreference() {
        // 從 localStorage 加載語言偏好
        const savedLanguage = localStorage.getItem('preferred-language');
        if (savedLanguage && this.languages[savedLanguage]) {
            this.currentLanguage = savedLanguage;
        }
        
        // 從 URL 參數獲取語言設置
        const urlParams = new URLSearchParams(window.location.search);
        const langParam = urlParams.get('lang');
        if (langParam && this.languages[langParam]) {
            this.currentLanguage = langParam;
            this.saveLanguagePreference();
        }
    }

    saveLanguagePreference() {
        localStorage.setItem('preferred-language', this.currentLanguage);
    }

    bindEvents() {
        // 語言切換按鈕事件
        const languageToggles = document.querySelectorAll('.language-toggle');
        languageToggles.forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleLanguageDropdown(toggle);
            });
        });

        // 語言選項點擊事件
        const languageOptions = document.querySelectorAll('.language-dropdown a');
        languageOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                e.preventDefault();
                const lang = option.dataset.lang;
                if (lang && this.languages[lang]) {
                    this.switchLanguage(lang);
                }
            });
        });

        // 點擊外部關閉下拉選單
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.language-switcher')) {
                this.closeAllLanguageDropdowns();
            }
        });
    }

    toggleLanguageDropdown(toggle) {
        const dropdown = toggle.nextElementSibling;
        const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
        
        // 關閉所有其他下拉選單
        this.closeAllLanguageDropdowns();
        
        if (!isExpanded) {
            this.openLanguageDropdown(toggle, dropdown);
        }
    }

    openLanguageDropdown(toggle, dropdown) {
        toggle.setAttribute('aria-expanded', 'true');
        dropdown.classList.add('show');
        
        // 添加動畫效果
        dropdown.style.opacity = '0';
        dropdown.style.transform = 'translateY(-10px)';
        
        requestAnimationFrame(() => {
            dropdown.style.transition = 'all 0.3s ease';
            dropdown.style.opacity = '1';
            dropdown.style.transform = 'translateY(0)';
        });
    }

    closeLanguageDropdown(toggle, dropdown) {
        toggle.setAttribute('aria-expanded', 'false');
        dropdown.classList.remove('show');
    }

    closeAllLanguageDropdowns() {
        const toggles = document.querySelectorAll('.language-toggle');
        const dropdowns = document.querySelectorAll('.language-dropdown');
        
        toggles.forEach(toggle => {
            toggle.setAttribute('aria-expanded', 'false');
        });
        
        dropdowns.forEach(dropdown => {
            dropdown.classList.remove('show');
        });
    }

    switchLanguage(lang) {
        if (lang === this.currentLanguage) return;
        
        this.currentLanguage = lang;
        this.saveLanguagePreference();
        this.updateUI();
        
        // 顯示語言切換成功消息
        this.showLanguageChangeMessage(lang);
        
        // 重新加載頁面以應用新語言
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    }

    updateUI() {
        const currentLang = this.languages[this.currentLanguage];
        if (!currentLang) return;
        
        // 更新語言切換按鈕
        const languageToggles = document.querySelectorAll('.language-toggle .current-language');
        languageToggles.forEach(toggle => {
            toggle.textContent = currentLang.short;
        });
        
        // 更新頁面語言屬性
        document.documentElement.lang = this.currentLanguage;
        
        // 更新語言選項的活動狀態
        const languageOptions = document.querySelectorAll('.language-dropdown a');
        languageOptions.forEach(option => {
            const lang = option.dataset.lang;
            if (lang === this.currentLanguage) {
                option.classList.add('active');
            } else {
                option.classList.remove('active');
            }
        });
    }

    showLanguageChangeMessage(lang) {
        const langInfo = this.languages[lang];
        if (!langInfo) return;
        
        // 創建通知消息
        const notification = document.createElement('div');
        notification.className = 'language-notification';
        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-flag">${langInfo.flag}</span>
                <span class="notification-text">語言已切換為 ${langInfo.name}</span>
            </div>
        `;
        
        // 添加樣式
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--primary-color);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        `;
        
        document.body.appendChild(notification);
        
        // 顯示動畫
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // 自動隱藏
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
}

// 創建並初始化語言切換器
document.addEventListener('DOMContentLoaded', () => {
    new LanguageSwitcher();
});
