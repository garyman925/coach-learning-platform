/**
 * 導航組件
 */

class Navigation {
    constructor() {
        this.isInitialized = false;
        this.isMobileMenuOpen = false;
        this.isScrolled = false;
        this.lastScrollTop = 0;
        this.scrollThreshold = 100;
        
        this.elements = {
            header: null,
            topBar: null,
            mainNav: null,
            mobileMenuToggle: null,
            mobileMenu: null,
            dropdowns: [],
            searchBar: null,
            searchToggle: null,
            searchOverlay: null
        };
        
        this.init();
    }

    init() {
        if (this.isInitialized) return;
        
        this.cacheElements();
        this.bindEvents();
        this.setupDropdowns();
        this.setupSearch();
        this.setupScrollEffects();
        this.setupMobileMenu();
        
        this.isInitialized = true;
        console.log('Navigation initialized');
    }

    cacheElements() {
        this.elements.header = document.querySelector('header');
        this.elements.topBar = document.querySelector('.top-bar');
        this.elements.mainNav = document.querySelector('.main-navigation');
        this.elements.mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        this.elements.mobileMenu = document.querySelector('#mobile-menu');
        this.elements.searchBar = document.querySelector('.search-bar');
        this.elements.searchToggle = document.querySelector('.search-toggle');
        this.elements.searchOverlay = document.querySelector('.search-overlay');
        
        // 緩存所有下拉選單
        this.elements.dropdowns = document.querySelectorAll('.nav-dropdown');
        
        console.log('cacheElements: mobileMenuToggle:', this.elements.mobileMenuToggle);
        console.log('cacheElements: mobileMenu:', this.elements.mobileMenu);
        
        // 檢查 HTML 結構
        if (this.elements.mobileMenuToggle) {
            console.log('mobileMenuToggle HTML:', this.elements.mobileMenuToggle.outerHTML);
        }
        if (this.elements.mobileMenu) {
            console.log('mobileMenu HTML:', this.elements.mobileMenu.outerHTML);
        }
        
        // 檢查父元素
        const mainNav = document.querySelector('.main-navigation');
        if (mainNav) {
            console.log('main-navigation HTML:', mainNav.outerHTML);
        }
    }

    bindEvents() {
        // 滾動事件
        window.addEventListener('scroll', this.handleScroll.bind(this));
        
        // 調整視窗大小事件
        window.addEventListener('resize', this.handleResize.bind(this));
        
        // 點擊外部關閉下拉選單
        document.addEventListener('click', this.handleDocumentClick.bind(this));
        
        // 鍵盤事件
        document.addEventListener('keydown', this.handleKeydown.bind(this));
    }

    setupDropdowns() {
        this.elements.dropdowns.forEach(dropdown => {
            const trigger = dropdown.previousElementSibling;
            if (trigger) {
                // 滑鼠事件
                trigger.addEventListener('mouseenter', () => this.openDropdown(dropdown));
                dropdown.addEventListener('mouseenter', () => this.openDropdown(dropdown));
                
                trigger.addEventListener('mouseleave', () => this.closeDropdown(dropdown));
                dropdown.addEventListener('mouseleave', () => this.closeDropdown(dropdown));
                
                // 觸摸事件（移動設備）
                trigger.addEventListener('touchstart', (e) => {
                    e.preventDefault();
                    this.toggleDropdown(dropdown);
                });
                
                // 點擊事件
                trigger.addEventListener('click', (e) => {
                    if (window.innerWidth <= 1024) {
                        e.preventDefault();
                        this.toggleDropdown(dropdown);
                    }
                });
            }
        });
    }

    setupSearch() {
        if (this.elements.searchToggle && this.elements.searchOverlay) {
            this.elements.searchToggle.addEventListener('click', () => {
                this.toggleSearch();
            });
            
            // 點擊搜索覆蓋層關閉搜索
            this.elements.searchOverlay.addEventListener('click', (e) => {
                if (e.target === this.elements.searchOverlay) {
                    this.closeSearch();
                }
            });
            
            // 搜索框焦點事件
            const searchInput = this.elements.searchOverlay.querySelector('input[type="search"]');
            if (searchInput) {
                searchInput.addEventListener('focus', () => {
                    this.elements.searchOverlay.classList.add('focused');
                });
                
                searchInput.addEventListener('blur', () => {
                    this.elements.searchOverlay.classList.remove('focused');
                });
                
                // 搜索提交
                searchInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        this.handleSearch(e.target.value);
                    }
                });
            }
        }
    }

    setupScrollEffects() {
        // 檢查初始滾動位置
        this.handleScroll();
    }

    setupMobileMenu() {
        console.log('setupMobileMenu called');
        console.log('mobileMenuToggle:', this.elements.mobileMenuToggle);
        console.log('mobileMenu:', this.elements.mobileMenu);
        
        if (this.elements.mobileMenuToggle && this.elements.mobileMenu) {
            // 移除舊的事件監聽器（如果存在）
            if (this.mobileMenuClickHandler) {
                this.elements.mobileMenuToggle.removeEventListener('click', this.mobileMenuClickHandler);
            }
            
            // 創建新的事件處理器
            this.mobileMenuClickHandler = () => {
                console.log('Mobile menu toggle clicked');
                this.toggleMobileMenu();
            };
            
            // 綁定點擊事件
            this.elements.mobileMenuToggle.addEventListener('click', this.mobileMenuClickHandler);
            console.log('Mobile menu click event bound');
            
            // 點擊移動選單外部關閉
            if (this.mobileMenuOutsideClickHandler) {
                document.removeEventListener('click', this.mobileMenuOutsideClickHandler);
            }
            
            this.mobileMenuOutsideClickHandler = (e) => {
                if (this.isMobileMenuOpen && 
                    !this.elements.mobileMenu.contains(e.target) && 
                    !this.elements.mobileMenuToggle.contains(e.target)) {
                    this.closeMobileMenu();
                }
            };
            
            document.addEventListener('click', this.mobileMenuOutsideClickHandler);
            console.log('Mobile menu outside click event bound');
        } else {
            console.log('setupMobileMenu: required elements not found');
        }
    }

    handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const isScrollingDown = scrollTop > this.lastScrollTop;
        
        // 檢查是否滾動超過閾值
        if (scrollTop > this.scrollThreshold) {
            if (!this.isScrolled) {
                this.addScrollClass();
            }
        } else {
            if (this.isScrolled) {
                this.removeScrollClass();
            }
        }
        
        // 隱藏/顯示導航欄（向下滾動時隱藏，向上滾動時顯示）
        if (Math.abs(scrollTop - this.lastScrollTop) > 10) {
            if (isScrollingDown && scrollTop > 200) {
                this.hideNavigation();
            } else {
                this.showNavigation();
            }
        }
        
        this.lastScrollTop = scrollTop;
    }

    handleResize() {
        // 重置移動選單狀態
        if (window.innerWidth > 1024 && this.isMobileMenuOpen) {
            this.closeMobileMenu();
        }
        
        // 重置下拉選單狀態
        this.elements.dropdowns.forEach(dropdown => {
            this.closeDropdown(dropdown);
        });
    }

    handleDocumentClick(e) {
        // 關閉所有下拉選單（如果點擊的不是導航元素）
        if (!e.target.closest('.main-navigation')) {
            this.closeAllDropdowns();
        }
    }

    handleKeydown(e) {
        // ESC鍵關閉移動選單和搜索
        if (e.key === 'Escape') {
            if (this.isMobileMenuOpen) {
                this.closeMobileMenu();
            }
            this.closeSearch();
        }
        
        // 方向鍵導航
        if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
            this.handleArrowNavigation(e);
        }
    }

    handleArrowNavigation(e) {
        const activeElement = document.activeElement;
        const isInDropdown = activeElement.closest('.nav-dropdown');
        
        if (isInDropdown) {
            e.preventDefault();
            const items = Array.from(isInDropdown.querySelectorAll('a'));
            const currentIndex = items.indexOf(activeElement);
            
            if (e.key === 'ArrowDown') {
                const nextIndex = (currentIndex + 1) % items.length;
                items[nextIndex].focus();
            } else if (e.key === 'ArrowUp') {
                const prevIndex = currentIndex === 0 ? items.length - 1 : currentIndex - 1;
                items[prevIndex].focus();
            }
        }
    }

    addScrollClass() {
        if (this.elements.header) {
            this.elements.header.classList.add('scrolled');
        }
        if (this.elements.mainNav) {
            this.elements.mainNav.classList.add('scrolled');
        }
        this.isScrolled = true;
    }

    removeScrollClass() {
        if (this.elements.header) {
            this.elements.header.classList.remove('scrolled');
        }
        if (this.elements.mainNav) {
            this.elements.mainNav.classList.remove('scrolled');
        }
        this.isScrolled = false;
    }

    hideNavigation() {
        if (this.elements.mainNav) {
            this.elements.mainNav.style.transform = 'translateY(-100%)';
        }
    }

    showNavigation() {
        if (this.elements.mainNav) {
            this.elements.mainNav.style.transform = 'translateY(0)';
        }
    }

    openDropdown(dropdown) {
        if (window.innerWidth <= 1024) return;
        
        this.closeAllDropdowns();
        dropdown.classList.add('active');
        
        // 添加動畫
        const items = dropdown.querySelectorAll('li');
        items.forEach((item, index) => {
            item.style.animationDelay = `${index * 50}ms`;
            item.classList.add('animate-in');
        });
    }

    closeDropdown(dropdown) {
        if (window.innerWidth <= 1024) return;
        
        dropdown.classList.remove('active');
        const items = dropdown.querySelectorAll('li');
        items.forEach(item => {
            item.classList.remove('animate-in');
            item.style.animationDelay = '';
        });
    }

    toggleDropdown(dropdown) {
        if (dropdown.classList.contains('active')) {
            this.closeDropdown(dropdown);
        } else {
            this.openDropdown(dropdown);
        }
    }

    closeAllDropdowns() {
        this.elements.dropdowns.forEach(dropdown => {
            this.closeDropdown(dropdown);
        });
    }

    toggleMobileMenu() {
        console.log('toggleMobileMenu called, current state:', this.isMobileMenuOpen);
        if (this.isMobileMenuOpen) {
            this.closeMobileMenu();
        } else {
            this.openMobileMenu();
        }
    }

    openMobileMenu() {
        if (!this.elements.mobileMenu) {
            console.log('openMobileMenu: mobileMenu element not found');
            return;
        }
        
        console.log('openMobileMenu: opening mobile menu');
        this.elements.mobileMenu.classList.add('active');
        this.elements.mobileMenuToggle.classList.add('active');
        document.body.classList.add('mobile-menu-open');
        this.isMobileMenuOpen = true;
        
        // 添加動畫
        const menuItems = this.elements.mobileMenu.querySelectorAll('.mobile-menu-item');
        menuItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 100}ms`;
            item.classList.add('animate-in');
        });
        
        // 防止背景滾動
        this.disableScroll();
        
        console.log('openMobileMenu: mobile menu opened, isMobileMenuOpen:', this.isMobileMenuOpen);
    }

    closeMobileMenu() {
        if (!this.elements.mobileMenu) {
            console.log('closeMobileMenu: mobileMenu element not found');
            return;
        }
        
        console.log('closeMobileMenu: closing mobile menu');
        this.elements.mobileMenu.classList.remove('active');
        this.elements.mobileMenuToggle.classList.remove('active');
        document.body.classList.remove('mobile-menu-open');
        this.isMobileMenuOpen = false;
        
        // 移除動畫
        const menuItems = this.elements.mobileMenu.querySelectorAll('.mobile-menu-item');
        menuItems.forEach(item => {
            item.classList.remove('animate-in');
            item.style.animationDelay = '';
        });
        
        // 恢復背景滾動
        this.enableScroll();
        
        console.log('closeMobileMenu: mobile menu closed, isMobileMenuOpen:', this.isMobileMenuOpen);
    }

    toggleSearch() {
        if (this.elements.searchOverlay.classList.contains('active')) {
            this.closeSearch();
        } else {
            this.openSearch();
        }
    }

    openSearch() {
        if (!this.elements.searchOverlay) return;
        
        this.elements.searchOverlay.classList.add('active');
        document.body.classList.add('search-open');
        
        // 聚焦搜索輸入框
        const searchInput = this.elements.searchOverlay.querySelector('input[type="search"]');
        if (searchInput) {
            setTimeout(() => searchInput.focus(), 100);
        }
        
        // 防止背景滾動
        this.disableScroll();
    }

    closeSearch() {
        if (!this.elements.searchOverlay) return;
        
        this.elements.searchOverlay.classList.remove('active');
        document.body.classList.remove('search-open');
        
        // 恢復背景滾動
        this.enableScroll();
    }

    handleSearch(query) {
        if (!query.trim()) return;
        
        console.log('Search query:', query);
        
        // 這裡可以實現搜索邏輯
        // 例如：發送AJAX請求、過濾內容等
        
        // 關閉搜索
        this.closeSearch();
        
        // 可以觸發自定義事件
        const searchEvent = new CustomEvent('search', {
            detail: { query: query.trim() }
        });
        document.dispatchEvent(searchEvent);
    }

    disableScroll() {
        document.body.style.overflow = 'hidden';
        document.body.style.position = 'fixed';
        document.body.style.width = '100%';
    }

    enableScroll() {
        document.body.style.overflow = '';
        document.body.style.position = '';
        document.body.style.width = '';
    }

    // 公共方法
    refresh() {
        this.cacheElements();
        this.setupDropdowns();
        this.setupSearch();
        this.setupMobileMenu();
    }

    destroy() {
        // 移除事件監聽器
        window.removeEventListener('scroll', this.handleScroll.bind(this));
        window.removeEventListener('resize', this.handleResize.bind(this));
        document.removeEventListener('click', this.handleDocumentClick.bind(this));
        document.removeEventListener('keydown', this.handleKeydown.bind(this));
        
        // 移除移動菜單事件監聽器
        if (this.mobileMenuClickHandler && this.elements.mobileMenuToggle) {
            this.elements.mobileMenuToggle.removeEventListener('click', this.mobileMenuClickHandler);
        }
        if (this.mobileMenuOutsideClickHandler) {
            document.removeEventListener('click', this.mobileMenuOutsideClickHandler);
        }
        
        // 重置狀態
        this.isInitialized = false;
        this.isMobileMenuOpen = false;
        this.isScrolled = false;
        
        // 清理樣式
        if (this.elements.mainNav) {
            this.elements.mainNav.style.transform = '';
        }
        
        document.body.classList.remove('mobile-menu-open', 'search-open');
    }
}

// 創建全局實例
const navigationInstance = new Navigation();

// 導出到全局
window.Navigation = navigationInstance;

// 頁面加載完成後初始化
document.addEventListener('DOMContentLoaded', () => {
    if (window.Navigation) {
        window.Navigation.refresh();
    }
});
