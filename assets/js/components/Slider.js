/**
 * 輪播圖組件
 */

class Slider {
    constructor(container, options = {}) {
        this.container = container;
        this.options = {
            autoplay: true,
            autoplaySpeed: 5000,
            pauseOnHover: true,
            showArrows: true,
            showDots: true,
            ...options
        };
        
        this.currentSlide = 0;
        this.slides = [];
        this.autoPlayInterval = null;
        this.isPaused = false;
        
        this.init();
    }

    init() {
        this.cacheElements();
        this.bindEvents();
        this.setupAutoPlay();
        this.updateSlider();
    }

    cacheElements() {
        this.slides = Array.from(this.container.querySelectorAll('.hero-slide'));
        this.arrows = this.container.querySelectorAll('.slider-arrow');
        this.dots = this.container.querySelectorAll('.slider-dot');
    }

    bindEvents() {
        // 箭頭點擊事件
        if (this.options.showArrows) {
            this.arrows.forEach(arrow => {
                arrow.addEventListener('click', (e) => {
                    e.preventDefault();
                    const direction = arrow.dataset.direction;
                    if (direction === 'prev') {
                        this.prevSlide();
                    } else if (direction === 'next') {
                        this.nextSlide();
                    }
                });
            });
        }
        
        // 點擊指示器
        if (this.options.showDots) {
            this.dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    this.goToSlide(index);
                });
            });
        }
        
        // 滑鼠懸停暫停自動播放
        if (this.options.pauseOnHover) {
            this.container.addEventListener('mouseenter', () => {
                this.pauseAutoPlay();
            });
            
            this.container.addEventListener('mouseleave', () => {
                this.resumeAutoPlay();
            });
        }
        
        // 觸摸事件支持
        this.setupTouchEvents();
        
        // 鍵盤事件支持
        this.setupKeyboardEvents();
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

    setupKeyboardEvents() {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                this.prevSlide();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                this.nextSlide();
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
        // 更新幻燈片顯示
        this.slides.forEach((slide, index) => {
            if (index === this.currentSlide) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });
        
        // 更新箭頭狀態
        if (this.options.showArrows) {
            this.arrows.forEach(arrow => {
                const direction = arrow.dataset.direction;
                if (direction === 'prev') {
                    arrow.style.opacity = this.currentSlide === 0 ? '0.5' : '1';
                } else if (direction === 'next') {
                    arrow.style.opacity = this.currentSlide === this.slides.length - 1 ? '0.5' : '1';
                }
            });
        }
        
        // 更新指示器狀態
        if (this.options.showDots) {
            this.dots.forEach((dot, index) => {
                if (index === this.currentSlide) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }
        
        // 觸發幻燈片變更事件
        this.triggerSlideChangeEvent();
    }

    setupAutoPlay() {
        if (!this.options.autoplay) return;
        
        this.startAutoPlay();
    }

    startAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
        }
        
        this.autoPlayInterval = setInterval(() => {
            if (!this.isPaused) {
                this.nextSlide();
            }
        }, this.options.autoplaySpeed);
    }

    pauseAutoPlay() {
        this.isPaused = true;
    }

    resumeAutoPlay() {
        this.isPaused = false;
    }

    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }

    triggerSlideChangeEvent() {
        const event = new CustomEvent('slideChanged', {
            detail: {
                currentSlide: this.currentSlide,
                totalSlides: this.slides.length,
                slideElement: this.slides[this.currentSlide]
            }
        });
        this.container.dispatchEvent(event);
    }

    // 公共方法
    refresh() {
        this.cacheElements();
        this.updateSlider();
    }

    destroy() {
        this.stopAutoPlay();
        
        // 移除事件監聽器
        this.arrows.forEach(arrow => {
            arrow.removeEventListener('click', this.handleArrowClick);
        });
        
        this.dots.forEach(dot => {
            dot.removeEventListener('click', this.handleDotClick);
        });
        
        this.container.removeEventListener('mouseenter', this.pauseAutoPlay);
        this.container.removeEventListener('mouseleave', this.resumeAutoPlay);
        this.container.removeEventListener('touchstart', this.handleTouchStart);
        this.container.removeEventListener('touchend', this.handleTouchEnd);
        
        document.removeEventListener('keydown', this.handleKeydown);
    }
}

// 導出到全局
window.Slider = Slider;
