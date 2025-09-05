/**
 * 教練輪播組件
 * 實現教練卡片的滑動輪播功能
 */
class CoachCarousel {
    constructor(containerSelector = '.coach-carousel-container') {
        this.container = document.querySelector(containerSelector);
        this.track = null;
        this.cards = [];
        this.currentSlide = 0;
        this.totalSlides = 0;
        this.cardsPerSlide = 6;
        this.isAnimating = false;
        
        this.init();
    }
    
    init() {
        if (!this.container) {
            console.warn('CoachCarousel: Container not found');
            return;
        }
        
        this.cacheElements();
        this.setupEventListeners();
        this.updateControls();
        this.updateIndicators();
        
        console.log('CoachCarousel initialized');
    }
    
    cacheElements() {
        this.track = this.container.querySelector('.coach-carousel-track');
        this.cards = Array.from(this.container.querySelectorAll('.coach-card'));
        this.prevBtn = this.container.querySelector('.coach-carousel-prev');
        this.nextBtn = this.container.querySelector('.coach-carousel-next');
        this.indicators = Array.from(this.container.querySelectorAll('.coach-carousel-indicator'));
        
        this.totalSlides = Math.ceil(this.cards.length / this.cardsPerSlide);
    }
    
    setupEventListeners() {
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => this.prevSlide());
        }
        
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => this.nextSlide());
        }
        
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => this.goToSlide(index));
        });
        
        // 觸摸滑動支持
        this.setupTouchEvents();
        
        // 鍵盤導航
        this.setupKeyboardEvents();
    }
    
    setupTouchEvents() {
        let startX = 0;
        let startY = 0;
        let isDragging = false;
        
        this.track.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            isDragging = true;
        });
        
        this.track.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            
            const currentX = e.touches[0].clientX;
            const currentY = e.touches[0].clientY;
            const diffX = startX - currentX;
            const diffY = startY - currentY;
            
            // 防止垂直滾動
            if (Math.abs(diffY) > Math.abs(diffX)) {
                return;
            }
            
            e.preventDefault();
        });
        
        this.track.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            
            const endX = e.changedTouches[0].clientX;
            const diffX = startX - endX;
            const threshold = 50;
            
            if (Math.abs(diffX) > threshold) {
                if (diffX > 0) {
                    this.nextSlide();
                } else {
                    this.prevSlide();
                }
            }
            
            isDragging = false;
        });
    }
    
    setupKeyboardEvents() {
        document.addEventListener('keydown', (e) => {
            if (!this.container.contains(document.activeElement)) return;
            
            switch (e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    this.prevSlide();
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    this.nextSlide();
                    break;
                case 'Home':
                    e.preventDefault();
                    this.goToSlide(0);
                    break;
                case 'End':
                    e.preventDefault();
                    this.goToSlide(this.totalSlides - 1);
                    break;
            }
        });
    }
    
    nextSlide() {
        if (this.isAnimating || this.currentSlide >= this.totalSlides - 1) return;
        
        this.goToSlide(this.currentSlide + 1);
    }
    
    prevSlide() {
        if (this.isAnimating || this.currentSlide <= 0) return;
        
        this.goToSlide(this.currentSlide - 1);
    }
    
    goToSlide(slideIndex) {
        if (this.isAnimating || slideIndex < 0 || slideIndex >= this.totalSlides) return;
        
        this.isAnimating = true;
        this.currentSlide = slideIndex;
        
        const translateX = -(slideIndex * this.cardsPerSlide * (280 + 24)); // 卡片寬度 + gap
        this.track.style.transform = `translateX(${translateX}px)`;
        
        // 更新控制按鈕狀態
        this.updateControls();
        
        // 更新指示器
        this.updateIndicators();
        
        // 動畫完成後重置狀態
        setTimeout(() => {
            this.isAnimating = false;
        }, 500);
    }
    
    updateControls() {
        if (this.prevBtn) {
            this.prevBtn.disabled = this.currentSlide <= 0;
        }
        
        if (this.nextBtn) {
            this.nextBtn.disabled = this.currentSlide >= this.totalSlides - 1;
        }
    }
    
    updateIndicators() {
        this.indicators.forEach((indicator, index) => {
            if (index === this.currentSlide) {
                indicator.classList.add('active');
                indicator.setAttribute('aria-current', 'true');
            } else {
                indicator.classList.remove('active');
                indicator.setAttribute('aria-current', 'false');
            }
        });
    }
    
    // 自動播放功能
    startAutoPlay(interval = 5000) {
        this.stopAutoPlay();
        this.autoPlayInterval = setInterval(() => {
            if (this.currentSlide < this.totalSlides - 1) {
                this.nextSlide();
            } else {
                this.goToSlide(0);
            }
        }, interval);
    }
    
    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
    
    // 暫停自動播放（當用戶互動時）
    pauseAutoPlay() {
        this.stopAutoPlay();
    }
    
    // 響應式調整
    updateCardsPerSlide() {
        const containerWidth = this.container.offsetWidth;
        
        if (containerWidth < 768) {
            this.cardsPerSlide = 2;
        } else if (containerWidth < 1024) {
            this.cardsPerSlide = 4;
        } else {
            this.cardsPerSlide = 6;
        }
        
        this.totalSlides = Math.ceil(this.cards.length / this.cardsPerSlide);
        this.updateIndicators();
        
        // 如果當前頁面超出範圍，重置到第一頁
        if (this.currentSlide >= this.totalSlides) {
            this.goToSlide(0);
        }
    }
    
    // 銷毀組件
    destroy() {
        this.stopAutoPlay();
        
        if (this.prevBtn) {
            this.prevBtn.removeEventListener('click', () => this.prevSlide());
        }
        
        if (this.nextBtn) {
            this.nextBtn.removeEventListener('click', () => this.nextSlide());
        }
        
        this.indicators.forEach((indicator, index) => {
            indicator.removeEventListener('click', () => this.goToSlide(index));
        });
        
        // 移除觸摸事件
        this.track.removeEventListener('touchstart', () => {});
        this.track.removeEventListener('touchmove', () => {});
        this.track.removeEventListener('touchend', () => {});
        
        // 移除鍵盤事件
        document.removeEventListener('keydown', () => {});
    }
}

// 創建全局實例
const coachCarousel = new CoachCarousel();

// 導出到全局
window.CoachCarousel = CoachCarousel;

// 頁面加載完成後初始化
document.addEventListener('DOMContentLoaded', () => {
    if (window.coachCarousel) {
        // 響應式調整
        window.addEventListener('resize', () => {
            window.coachCarousel.updateCardsPerSlide();
        });
        
        // 可選：啟動自動播放
        // window.coachCarousel.startAutoPlay();
    }
});
