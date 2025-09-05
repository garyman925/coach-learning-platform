/**
 * 主題管理組件
 * 處理主題切換、保存和應用功能
 */

class ThemeManager {
    constructor() {
        this.currentTheme = 'light';
        this.themes = {
            light: {
                name: '淺色主題',
                css: 'light-theme'
            },
            dark: {
                name: '深色主題',
                css: 'dark-theme'
            },
            auto: {
                name: '自動切換',
                css: 'auto-theme'
            }
        };
        
        this.init();
    }
    
    init() {
        this.loadTheme();
        this.bindEvents();
        this.applyTheme();
        console.log('ThemeManager initialized');
    }
    
    /**
     * 載入保存的主題設定
     */
    loadTheme() {
        // 從 localStorage 載入主題設定
        const savedTheme = localStorage.getItem('user_theme');
        if (savedTheme && this.themes[savedTheme]) {
            this.currentTheme = savedTheme;
        } else {
            // 檢查系統偏好
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                this.currentTheme = 'auto';
            }
        }
    }
    
    /**
     * 保存主題設定
     */
    saveTheme(theme) {
        if (this.themes[theme]) {
            this.currentTheme = theme;
            localStorage.setItem('user_theme', theme);
            this.applyTheme();
            
            // 觸發主題變更事件
            this.dispatchThemeChangeEvent(theme);
        }
    }
    
    /**
     * 應用主題
     */
    applyTheme() {
        const body = document.body;
        
        // 移除所有主題類
        Object.values(this.themes).forEach(theme => {
            body.classList.remove(theme.css);
        });
        
        // 應用當前主題
        if (this.currentTheme === 'auto') {
            this.applyAutoTheme();
        } else {
            body.classList.add(this.themes[this.currentTheme].css);
        }
        
        // 更新主題切換器
        this.updateThemeSwitcher();
    }
    
    /**
     * 應用自動主題
     */
    applyAutoTheme() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.body.classList.add('dark-theme');
        } else {
            document.body.classList.add('light-theme');
        }
    }
    
    /**
     * 更新主題切換器
     */
    updateThemeSwitcher() {
        const themeInputs = document.querySelectorAll('input[name="theme"]');
        themeInputs.forEach(input => {
            input.checked = input.value === this.currentTheme;
        });
    }
    
    /**
     * 綁定事件
     */
    bindEvents() {
        // 主題切換器事件
        document.addEventListener('change', (e) => {
            if (e.target.name === 'theme') {
                this.saveTheme(e.target.value);
            }
        });
        
        // 系統主題變更事件
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addListener(() => {
                if (this.currentTheme === 'auto') {
                    this.applyTheme();
                }
            });
        }
        
        // 鍵盤快捷鍵 (Ctrl/Cmd + Shift + T)
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'T') {
                e.preventDefault();
                this.toggleTheme();
            }
        });
    }
    
    /**
     * 切換主題
     */
    toggleTheme() {
        const themeOrder = ['light', 'dark', 'auto'];
        const currentIndex = themeOrder.indexOf(this.currentTheme);
        const nextIndex = (currentIndex + 1) % themeOrder.length;
        this.saveTheme(themeOrder[nextIndex]);
    }
    
    /**
     * 獲取當前主題
     */
    getCurrentTheme() {
        return this.currentTheme;
    }
    
    /**
     * 獲取主題信息
     */
    getThemeInfo(theme) {
        return this.themes[theme] || null;
    }
    
    /**
     * 觸發主題變更事件
     */
    dispatchThemeChangeEvent(theme) {
        const event = new CustomEvent('themeChanged', {
            detail: {
                theme: theme,
                themeInfo: this.getThemeInfo(theme)
            }
        });
        document.dispatchEvent(event);
    }
    
    /**
     * 創建主題切換按鈕
     */
    createThemeToggleButton(container) {
        const button = document.createElement('button');
        button.className = 'theme-toggle-btn';
        button.innerHTML = `
            <svg class="theme-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M10 2L12.5 7.5L18 8L14 12L15 18L10 15L5 18L6 12L2 8L7.5 7.5L10 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="theme-text">主題</span>
        `;
        
        button.addEventListener('click', () => {
            this.toggleTheme();
        });
        
        if (container) {
            container.appendChild(button);
        }
        
        return button;
    }
}

// 導出類
window.ThemeManager = ThemeManager;

// 全局實例
window.themeManager = new ThemeManager();
