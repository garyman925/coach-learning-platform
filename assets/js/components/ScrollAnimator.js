/**
 * 滾動動畫組件
 * 處理滾動觸發的動畫效果
 */
class ScrollAnimator {
    constructor() {
        this.animatedElements = [];
        this.observer = null;
        this.init();
    }

    init() {
        this.cacheElements();
        this.setupIntersectionObserver();
        this.bindEvents();
    }

    cacheElements() {
        // 獲取所有需要動畫的元素
        this.animatedElements = document.querySelectorAll('[data-animate]');
    }

    setupIntersectionObserver() {
        if (!window.IntersectionObserver) {
            // 降級處理：直接顯示所有元素
            this.showAllElements();
            return;
        }

        this.observer = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.animateElement(entry.target);
                    }
                });
            },
            {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            }
        );

        // 觀察所有元素
        this.animatedElements.forEach(element => {
            this.observer.observe(element);
        });
    }

    animateElement(element) {
        const animationType = element.dataset.animate;
        
        switch (animationType) {
            case 'fadeInUp':
                element.classList.add('animate');
                break;
            case 'fadeInLeft':
                element.classList.add('animate');
                break;
            case 'fadeInRight':
                element.classList.add('animate');
                break;
            case 'scaleIn':
                element.classList.add('animate');
                break;
            default:
                element.classList.add('animate');
        }

        // 停止觀察已動畫的元素
        if (this.observer) {
            this.observer.unobserve(element);
        }
    }

    showAllElements() {
        this.animatedElements.forEach(element => {
            element.classList.add('animate');
        });
    }

    bindEvents() {
        // 監聽滾動事件（降級處理）
        if (!window.IntersectionObserver) {
            window.addEventListener('scroll', this.handleScroll.bind(this));
        }

        // 監聽視窗大小變化
        window.addEventListener('resize', this.handleResize.bind(this));
    }

    handleScroll() {
        if (!window.IntersectionObserver) {
            this.animatedElements.forEach(element => {
                if (this.isElementInViewport(element)) {
                    this.animateElement(element);
                }
            });
        }
    }

    handleResize() {
        // 重新計算元素位置
        this.cacheElements();
    }

    isElementInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8 &&
            rect.bottom >= 0
        );
    }

    refresh() {
        // 重新初始化
        if (this.observer) {
            this.observer.disconnect();
        }
        this.init();
    }

    destroy() {
        if (this.observer) {
            this.observer.disconnect();
        }
        window.removeEventListener('scroll', this.handleScroll);
        window.removeEventListener('resize', this.handleResize);
    }
}

// 初始化滾動動畫
document.addEventListener('DOMContentLoaded', () => {
    window.scrollAnimator = new ScrollAnimator();
});

// 導出類
window.ScrollAnimator = ScrollAnimator;
