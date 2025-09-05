/**
 * 主要JavaScript文件
 * 整合所有組件和功能
 */

class MainApp {
    constructor() {
        this.isInitialized = false;
        this.components = {};
        this.config = {
            debug: true,
            animationEnabled: true,
            lazyLoadingEnabled: true,
            searchEnabled: true
        };
        
        this.init();
    }

    init() {
        if (this.isInitialized) return;
        
        this.setupConfig();
        this.initializeComponents();
        this.bindGlobalEvents();
        this.setupPerformanceMonitoring();
        
        this.isInitialized = true;
        console.log('MainApp initialized');
    }

    setupConfig() {
        // 從localStorage或環境變量獲取配置
        const savedConfig = localStorage.getItem('coach_platform_app_config') ? JSON.parse(localStorage.getItem('coach_platform_app_config')) : null;
        if (savedConfig) {
            this.config = { ...this.config, ...savedConfig };
        }
        
        // 開發環境調試
        if (this.config.debug) {
            console.log('App config:', this.config);
        }
    }

    initializeComponents() {
        // 初始化導航組件
        if (window.Navigation) {
            this.components.navigation = window.Navigation;
        }
        
        // 初始化語言切換器
        if (window.LanguageSwitcher) {
            this.components.languageSwitcher = window.LanguageSwitcher;
        }
        
        // 初始化滾動動畫器
        if (window.ScrollAnimator) {
            this.components.scrollAnimator = window.ScrollAnimator;
        }
        
        // 初始化其他組件...
        this.initializeCustomComponents();
        
        console.log('Components initialized:', Object.keys(this.components));
    }

    initializeCustomComponents() {
        // 初始化輪播圖組件
        this.initializeSlider();
        
        // 初始化表單驗證
        this.initializeFormValidation();
        
        // 初始化圖片懶加載
        this.initializeImageLazyLoading();
        
        // 初始化返回頂部按鈕
        this.initializeBackToTop();
        
        // 初始化搜索功能
        this.initializeSearch();
        
        // 初始化用戶認證
        this.initializeAuthentication();
    }

    initializeSlider() {
        const sliderContainer = document.querySelector('.slider-wrapper');
        if (!sliderContainer) return;
        
        this.components.slider = new ImageSlider(sliderContainer);
    }

    initializeFormValidation() {
        const forms = document.querySelectorAll('form[data-validate]');
        forms.forEach(form => {
            new FormValidator(form);
        });
    }

    initializeImageLazyLoading() {
        if (!this.config.lazyLoadingEnabled) return;
        
        const images = document.querySelectorAll('img[data-src]');
        if (images.length > 0) {
            this.setupImageLazyLoading(images);
        }
    }

    initializeBackToTop() {
        const backToTopBtn = document.querySelector('.back-to-top');
        if (backToTopBtn) {
            this.setupBackToTop(backToTopBtn);
        }
    }

    initializeSearch() {
        if (!this.config.searchEnabled) return;
        
        const searchInputs = document.querySelectorAll('input[type="search"]');
        searchInputs.forEach(input => {
            this.setupSearch(input);
        });
    }

    initializeAuthentication() {
        // 檢查用戶登錄狀態
        this.checkAuthStatus();
        
        // 設置登錄/登出事件
        this.setupAuthEvents();
    }

    setupImageLazyLoading(images) {
        if (!window.IntersectionObserver) {
            // 降級處理：直接加載圖片
            images.forEach(img => this.loadImage(img));
            return;
        }
        
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.loadImage(entry.target);
                    imageObserver.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: '50px'
        });
        
        images.forEach(img => imageObserver.observe(img));
    }

    loadImage(img) {
        const src = img.dataset.src;
        if (!src) return;
        
        // 創建新圖片對象進行預加載
        const tempImg = new Image();
        tempImg.onload = () => {
            img.src = src;
            img.classList.add('loaded');
            img.removeAttribute('data-src');
        };
        
        tempImg.onerror = () => {
            img.classList.add('error');
            console.warn(`Failed to load image: ${src}`);
        };
        
        tempImg.src = src;
    }

    setupBackToTop(button) {
        // 滾動時顯示/隱藏按鈕
        const toggleButton = () => {
            if (window.pageYOffset > 300) {
                button.classList.add('visible');
            } else {
                button.classList.remove('visible');
            }
        };
        
        window.addEventListener('scroll', Helpers.throttle(toggleButton, 100));
        
        // 點擊返回頂部
        button.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    setupSearch(input) {
        let searchTimeout;
        
        input.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            
            const query = e.target.value.trim();
            if (query.length < 2) return;
            
            searchTimeout = setTimeout(() => {
                this.performSearch(query);
            }, 300);
        });
        
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.performSearch(e.target.value.trim());
            }
        });
    }

    performSearch(query) {
        if (!query) return;
        
        console.log('Performing search for:', query);
        
        // 這裡可以實現實際的搜索邏輯
        // 例如：發送AJAX請求、過濾頁面內容等
        
        // 觸發搜索事件
        const searchEvent = new CustomEvent('searchPerformed', {
            detail: { query: query }
        });
        document.dispatchEvent(searchEvent);
    }

    checkAuthStatus() {
        const userData = localStorage.getItem('coach_platform_user_data') ? JSON.parse(localStorage.getItem('coach_platform_user_data')) : null;
        if (userData) {
            this.updateAuthUI(userData);
        }
    }

    updateAuthUI(userData) {
        const authContainer = document.querySelector('.user-actions');
        if (!authContainer) return;
        
        const loginForm = authContainer.querySelector('.login-form');
        const userMenu = authContainer.querySelector('.user-menu');
        
        if (loginForm && userMenu) {
            loginForm.style.display = 'none';
            userMenu.style.display = 'block';
            
            const usernameElement = userMenu.querySelector('.username');
            if (usernameElement) {
                usernameElement.textContent = userData.username;
            }
        }
    }

    setupAuthEvents() {
        // 登錄表單提交
        const loginForm = document.querySelector('.login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleLogin(e.target);
            });
        }
        
        // 登出按鈕
        const logoutBtn = document.querySelector('.logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleLogout();
            });
        }
        
        // 註冊按鈕
        const registerBtn = document.querySelector('.register-btn');
        if (registerBtn) {
            registerBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleRegister();
            });
        }
    }

    handleLogin(form) {
        const formData = new FormData(form);
        const username = formData.get('username');
        const password = formData.get('password');
        
        if (!username || !password) {
            this.showMessage('請輸入用戶名和密碼', 'error');
            return;
        }
        
        // 模擬登錄成功
        const userData = {
            username: username,
            email: `${username}@example.com`,
            role: 'user'
        };
        
        localStorage.setItem('coach_platform_user_data', JSON.stringify(userData));
        this.updateAuthUI(userData);
        this.showMessage('登錄成功！', 'success');
        
        // 觸發登錄事件
        const loginEvent = new CustomEvent('userLoggedIn', {
            detail: { user: userData }
        });
        document.dispatchEvent(loginEvent);
    }

    handleLogout() {
        Storage.remove('user_data');
        
        const authContainer = document.querySelector('.user-actions');
        if (authContainer) {
            const loginForm = authContainer.querySelector('.login-form');
            const userMenu = authContainer.querySelector('.user-menu');
            
            if (loginForm && userMenu) {
                loginForm.style.display = 'block';
                userMenu.style.display = 'none';
                
                // 清空表單
                loginForm.reset();
            }
        }
        
        this.showMessage('已登出', 'info');
        
        // 觸發登出事件
        const logoutEvent = new CustomEvent('userLoggedOut');
        document.dispatchEvent(logoutEvent);
    }

    handleRegister() {
        // 跳轉到註冊頁面
        window.location.href = '/register';
    }

    showMessage(message, type = 'info') {
        // 創建消息提示
        const messageElement = document.createElement('div');
        messageElement.className = `message message-${type}`;
        messageElement.textContent = message;
        
        // 添加到頁面
        document.body.appendChild(messageElement);
        
        // 顯示動畫
        setTimeout(() => {
            messageElement.classList.add('show');
        }, 100);
        
        // 自動隱藏
        setTimeout(() => {
            messageElement.classList.remove('show');
            setTimeout(() => {
                if (messageElement.parentNode) {
                    messageElement.parentNode.removeChild(messageElement);
                }
            }, 300);
        }, 3000);
    }

    bindGlobalEvents() {
        // 頁面加載完成
        window.addEventListener('load', () => {
            this.onPageLoad();
        });
        
        // 頁面可見性變化
        document.addEventListener('visibilitychange', () => {
            this.onVisibilityChange();
        });
        
        // 搜索事件
        document.addEventListener('searchPerformed', (e) => {
            this.onSearchPerformed(e.detail);
        });
        
        // 用戶登錄事件
        document.addEventListener('userLoggedIn', (e) => {
            this.onUserLoggedIn(e.detail);
        });
        
        // 用戶登出事件
        document.addEventListener('userLoggedOut', () => {
            this.onUserLoggedOut();
        });
        
        // 語言變更事件
        document.addEventListener('languageChanged', (e) => {
            this.onLanguageChanged(e.detail);
        });
    }

    onPageLoad() {
        console.log('Page fully loaded');
        
        // 隱藏加載指示器
        const loader = document.querySelector('.page-loader');
        if (loader) {
            loader.classList.add('hidden');
        }
        
        // 觸發頁面加載完成事件
        const loadEvent = new CustomEvent('pageLoaded');
        document.dispatchEvent(loadEvent);
    }

    onVisibilityChange() {
        if (document.hidden) {
            console.log('Page hidden');
        } else {
            console.log('Page visible');
        }
    }

    onSearchPerformed(detail) {
        console.log('Search performed:', detail.query);
        // 可以在這裡添加搜索結果處理邏輯
    }

    onUserLoggedIn(detail) {
        console.log('User logged in:', detail.user);
        // 可以在這裡添加登錄後的處理邏輯
    }

    onUserLoggedOut() {
        console.log('User logged out');
        // 可以在這裡添加登出後的處理邏輯
    }

    onLanguageChanged(detail) {
        console.log('Language changed:', detail.language);
        // 可以在這裡添加語言變更後的處理邏輯
    }

    setupPerformanceMonitoring() {
        // 監控頁面性能
        if ('performance' in window) {
            window.addEventListener('load', () => {
                setTimeout(() => {
                    this.measurePerformance();
                }, 0);
            });
        }
    }

    measurePerformance() {
        const perfData = performance.getEntriesByType('navigation')[0];
        if (perfData) {
            const metrics = {
                loadTime: perfData.loadEventEnd - perfData.loadEventStart,
                domContentLoaded: perfData.domContentLoadedEventEnd - perfData.domContentLoadedEventStart,
                firstPaint: performance.getEntriesByName('first-paint')[0]?.startTime || 0,
                firstContentfulPaint: performance.getEntriesByName('first-contentful-paint')[0]?.startTime || 0
            };
            
            if (this.config.debug) {
                console.log('Performance metrics:', metrics);
            }
            
            // 保存性能數據
            localStorage.setItem('coach_platform_performance_metrics', JSON.stringify(metrics));
        }
    }

    // 公共方法
    getComponent(name) {
        return this.components[name];
    }

    getConfig() {
        return { ...this.config };
    }

    updateConfig(newConfig) {
        this.config = { ...this.config, ...newConfig };
        localStorage.setItem('coach_platform_app_config', JSON.stringify(this.config));
        
        if (this.config.debug) {
            console.log('Config updated:', this.config);
        }
    }

    refresh() {
        // 刷新所有組件
        Object.values(this.components).forEach(component => {
            if (component && typeof component.refresh === 'function') {
                component.refresh();
            }
        });
        
        // 重新初始化自定義組件
        this.initializeCustomComponents();
    }

    destroy() {
        // 銷毀所有組件
        Object.values(this.components).forEach(component => {
            if (component && typeof component.destroy === 'function') {
                component.destroy();
            }
        });
        
        // 清理事件監聽器
        window.removeEventListener('load', this.onPageLoad);
        document.removeEventListener('visibilitychange', this.onVisibilityChange);
        document.removeEventListener('searchPerformed', this.onSearchPerformed);
        document.removeEventListener('userLoggedIn', this.onUserLoggedIn);
        document.removeEventListener('userLoggedOut', this.onUserLoggedOut);
        document.removeEventListener('languageChanged', this.onLanguageChanged);
        
        this.components = {};
        this.isInitialized = false;
    }
}

// 圖片輪播組件
class ImageSlider {
    constructor(container) {
        this.container = container;
        this.currentSlide = 0;
        this.slides = [];
        this.autoPlayInterval = null;
        this.autoPlayDelay = 5000;
        
        this.init();
    }

    init() {
        this.cacheElements();
        this.bindEvents();
        this.startAutoPlay();
    }

    cacheElements() {
        this.slides = Array.from(this.container.querySelectorAll('.slider-slide'));
        this.indicators = Array.from(this.container.querySelectorAll('.slider-indicator'));
        this.prevBtn = this.container.querySelector('.slider-btn.prev');
        this.nextBtn = this.container.querySelector('.slider-btn.next');
    }

    bindEvents() {
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => this.prevSlide());
        }
        
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => this.nextSlide());
        }
        
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => this.goToSlide(index));
        });
        
        // 觸摸事件支持
        this.setupTouchEvents();
    }

    setupTouchEvents() {
        let startX = 0;
        let endX = 0;
        
        this.container.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });
        
        this.container.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            const diff = startX - endX;
            
            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    this.nextSlide();
                } else {
                    this.prevSlide();
                }
            }
        });
    }

    goToSlide(index) {
        if (index < 0 || index >= this.slides.length) return;
        
        this.currentSlide = index;
        this.updateSlider();
    }

    nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        this.updateSlider();
    }

    prevSlide() {
        this.currentSlide = this.currentSlide === 0 ? this.slides.length - 1 : this.currentSlide - 1;
        this.updateSlider();
    }

    updateSlider() {
        const offset = -this.currentSlide * 100;
        const track = this.container.querySelector('.slider-track');
        
        if (track) {
            track.style.transform = `translateX(${offset}%)`;
        }
        
        // 更新指示器
        this.indicators.forEach((indicator, index) => {
            if (index === this.currentSlide) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    }

    startAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
        }
        
        this.autoPlayInterval = setInterval(() => {
            this.nextSlide();
        }, this.autoPlayDelay);
    }

    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
}

// 表單驗證組件
class FormValidator {
    constructor(form) {
        this.form = form;
        this.rules = this.parseValidationRules();
        this.init();
    }

    init() {
        this.bindEvents();
    }

    parseValidationRules() {
        const rules = {};
        const inputs = this.form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            const fieldRules = {};
            
            if (input.hasAttribute('required')) {
                fieldRules.required = true;
            }
            
            if (input.hasAttribute('minlength')) {
                fieldRules.minlength = parseInt(input.getAttribute('minlength'));
            }
            
            if (input.hasAttribute('maxlength')) {
                fieldRules.maxlength = parseInt(input.getAttribute('maxlength'));
            }
            
            if (input.hasAttribute('pattern')) {
                fieldRules.pattern = input.getAttribute('pattern');
            }
            
            if (input.type === 'email') {
                fieldRules.email = true;
            }
            
            if (Object.keys(fieldRules).length > 0) {
                rules[input.name] = fieldRules;
            }
        });
        
        return rules;
    }

    bindEvents() {
        this.form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
            }
        });
        
        // 實時驗證
        Object.keys(this.rules).forEach(fieldName => {
            const field = this.form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.addEventListener('blur', () => {
                    this.validateField(field);
                });
                
                field.addEventListener('input', () => {
                    this.clearFieldError(field);
                });
            }
        });
    }

    validateForm() {
        let isValid = true;
        
        Object.keys(this.rules).forEach(fieldName => {
            const field = this.form.querySelector(`[name="${fieldName}"]`);
            if (field && !this.validateField(field)) {
                isValid = false;
            }
        });
        
        return isValid;
    }

    validateField(field) {
        const fieldName = field.name;
        const value = field.value.trim();
        const rules = this.rules[fieldName];
        
        // 清除之前的錯誤
        this.clearFieldError(field);
        
        // 檢查必填
        if (rules.required && !value) {
            this.showFieldError(field, '此欄位為必填項');
            return false;
        }
        
        // 檢查最小長度
        if (rules.minlength && value.length < rules.minlength) {
            this.showFieldError(field, `最少需要 ${rules.minlength} 個字符`);
            return false;
        }
        
        // 檢查最大長度
        if (rules.maxlength && value.length > rules.maxlength) {
            this.showFieldError(field, `最多只能輸入 ${rules.maxlength} 個字符`);
            return false;
        }
        
        // 檢查郵箱格式
        if (rules.email && value && !this.isValidEmail(value)) {
            this.showFieldError(field, '請輸入有效的郵箱地址');
            return false;
        }
        
        // 檢查正則表達式
        if (rules.pattern && value && !new RegExp(rules.pattern).test(value)) {
            this.showFieldError(field, '格式不正確');
            return false;
        }
        
        return true;
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    showFieldError(field, message) {
        field.classList.add('error');
        
        // 創建錯誤消息
        const errorElement = document.createElement('div');
        errorElement.className = 'field-error';
        errorElement.textContent = message;
        
        // 插入錯誤消息
        field.parentNode.appendChild(errorElement);
    }

    clearFieldError(field) {
        field.classList.remove('error');
        
        const errorElement = field.parentNode.querySelector('.field-error');
        if (errorElement) {
            errorElement.remove();
        }
    }
}

// 創建全局實例
const mainAppInstance = new MainApp();

// 導出到全局
window.MainApp = mainAppInstance;

// 頁面加載完成後初始化
document.addEventListener('DOMContentLoaded', () => {
    if (window.MainApp) {
        console.log('MainApp ready');
    }
});

// 導出組件類
window.ImageSlider = ImageSlider;
window.FormValidator = FormValidator;
