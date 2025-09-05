/**
 * 主題切換器
 */
class ThemeSwitcher {
    constructor() {
        this.currentTheme = 'light';
        this.init();
    }
    
    init() {
        this.loadTheme();
        this.createSwitcher();
        console.log('ThemeSwitcher initialized');
    }
    
    loadTheme() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        this.setTheme(savedTheme);
    }
    
    setTheme(theme) {
        this.currentTheme = theme;
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        
        // 更新切換按鈕狀態
        this.updateSwitcherState();
    }
    
    createSwitcher() {
        const switcher = document.querySelector('.theme-switcher');
        if (switcher) {
            switcher.addEventListener('click', () => {
                this.toggleTheme();
            });
        }
    }
    
    toggleTheme() {
        const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
        this.setTheme(newTheme);
    }
    
    updateSwitcherState() {
        const switcher = document.querySelector('.theme-switcher');
        if (switcher) {
            switcher.classList.toggle('dark', this.currentTheme === 'dark');
        }
    }
}

// 創建全局實例
window.themeSwitcher = new ThemeSwitcher();
