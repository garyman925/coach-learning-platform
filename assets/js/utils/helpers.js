/**
 * 通用JavaScript輔助函數
 */

// DOM 操作輔助函數
const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => document.querySelectorAll(selector);

// 元素存在性檢查
const exists = (element) => element !== null && element !== undefined;

// 添加事件監聽器的輔助函數
const addEvent = (element, event, handler, options = {}) => {
    if (exists(element)) {
        element.addEventListener(event, handler, options);
    }
};

// 移除事件監聽器的輔助函數
const removeEvent = (element, event, handler, options = {}) => {
    if (exists(element)) {
        element.removeEventListener(event, handler, options);
    }
};

// 添加多個事件監聽器
const addEvents = (element, events) => {
    if (exists(element)) {
        Object.entries(events).forEach(([event, handler]) => {
            element.addEventListener(event, handler);
        });
    }
};

// 切換CSS類
const toggleClass = (element, className) => {
    if (exists(element)) {
        element.classList.toggle(className);
    }
};

// 添加CSS類
const addClass = (element, className) => {
    if (exists(element)) {
        element.classList.add(className);
    }
};

// 移除CSS類
const removeClass = (element, className) => {
    if (exists(element)) {
        element.classList.remove(className);
    }
};

// 檢查是否包含CSS類
const hasClass = (element, className) => {
    return exists(element) && element.classList.contains(className);
};

// 設置元素樣式
const setStyle = (element, styles) => {
    if (exists(element)) {
        Object.assign(element.style, styles);
    }
};

// 獲取元素樣式
const getStyle = (element, property) => {
    return exists(element) ? element.style[property] : null;
};

// 設置元素屬性
const setAttr = (element, attribute, value) => {
    if (exists(element)) {
        element.setAttribute(attribute, value);
    }
};

// 獲取元素屬性
const getAttr = (element, attribute) => {
    return exists(element) ? element.getAttribute(attribute) : null;
};

// 設置元素文本內容
const setText = (element, text) => {
    if (exists(element)) {
        element.textContent = text;
    }
};

// 設置元素HTML內容
const setHTML = (element, html) => {
    if (exists(element)) {
        element.innerHTML = html;
    }
};

// 創建元素
const createElement = (tag, attributes = {}, content = '') => {
    const element = document.createElement(tag);
    
    // 設置屬性
    Object.entries(attributes).forEach(([key, value]) => {
        if (key === 'className') {
            element.className = value;
        } else if (key === 'textContent') {
            element.textContent = value;
        } else if (key === 'innerHTML') {
            element.innerHTML = value;
        } else {
            element.setAttribute(key, value);
        }
    });
    
    // 設置內容
    if (content) {
        element.textContent = content;
    }
    
    return element;
};

// 添加子元素
const appendChild = (parent, child) => {
    if (exists(parent) && exists(child)) {
        parent.appendChild(child);
    }
};

// 移除子元素
const removeChild = (parent, child) => {
    if (exists(parent) && exists(child)) {
        parent.removeChild(child);
    }
};

// 清空元素內容
const clearElement = (element) => {
    if (exists(element)) {
        element.innerHTML = '';
    }
};

// 顯示/隱藏元素
const show = (element) => {
    if (exists(element)) {
        element.style.display = '';
        removeClass(element, 'hidden');
    }
};

const hide = (element) => {
    if (exists(element)) {
        element.style.display = 'none';
        addClass(element, 'hidden');
    }
};

const toggle = (element) => {
    if (exists(element)) {
        if (element.style.display === 'none' || hasClass(element, 'hidden')) {
            show(element);
        } else {
            hide(element);
        }
    }
};

// 動畫輔助函數
const animate = (element, keyframes, options = {}) => {
    if (exists(element) && element.animate) {
        return element.animate(keyframes, {
            duration: 300,
            easing: 'ease-in-out',
            fill: 'forwards',
            ...options
        });
    }
    return null;
};

// 淡入動畫
const fadeIn = (element, duration = 300) => {
    if (exists(element)) {
        element.style.opacity = '0';
        element.style.display = '';
        
        animate(element, [
            { opacity: 0 },
            { opacity: 1 }
        ], { duration });
    }
};

// 淡出動畫
const fadeOut = (element, duration = 300) => {
    if (exists(element)) {
        const animation = animate(element, [
            { opacity: 1 },
            { opacity: 0 }
        ], { duration });
        
        if (animation) {
            animation.onfinish = () => {
                element.style.display = 'none';
            };
        }
    }
};

// 滑入動畫
const slideDown = (element, duration = 300) => {
    if (exists(element)) {
        element.style.height = '0';
        element.style.overflow = 'hidden';
        element.style.display = '';
        
        const height = element.scrollHeight;
        
        animate(element, [
            { height: '0px' },
            { height: height + 'px' }
        ], { duration });
    }
};

// 滑出動畫
const slideUp = (element, duration = 300) => {
    if (exists(element)) {
        const height = element.scrollHeight;
        element.style.height = height + 'px';
        element.style.overflow = 'hidden';
        
        const animation = animate(element, [
            { height: height + 'px' },
            { height: '0px' }
        ], { duration });
        
        if (animation) {
            animation.onfinish = () => {
                element.style.display = 'none';
            };
        }
    }
};

// 工具函數
const debounce = (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

const throttle = (func, limit) => {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
};

// 隨機數生成
const random = (min, max) => {
    return Math.floor(Math.random() * (max - min + 1)) + min;
};

const randomFloat = (min, max) => {
    return Math.random() * (max - min) + min;
};

// 數組操作
const shuffle = (array) => {
    const newArray = [...array];
    for (let i = newArray.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [newArray[i], newArray[j]] = [newArray[j], newArray[i]];
    }
    return newArray;
};

const chunk = (array, size) => {
    const chunks = [];
    for (let i = 0; i < array.length; i += size) {
        chunks.push(array.slice(i, i + size));
    }
    return chunks;
};

// 字符串操作
const capitalize = (str) => {
    return str.charAt(0).toUpperCase() + str.slice(1);
};

const truncate = (str, length, suffix = '...') => {
    return str.length > length ? str.substring(0, length) + suffix : str;
};

// 日期格式化
const formatDate = (date, format = 'YYYY-MM-DD') => {
    const d = new Date(date);
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    const hours = String(d.getHours()).padStart(2, '0');
    const minutes = String(d.getMinutes()).padStart(2, '0');
    const seconds = String(d.getSeconds()).padStart(2, '0');
    
    return format
        .replace('YYYY', year)
        .replace('MM', month)
        .replace('DD', day)
        .replace('HH', hours)
        .replace('mm', minutes)
        .replace('ss', seconds);
};

// 數字格式化
const formatNumber = (num, decimals = 0) => {
    return Number(num).toLocaleString('en-US', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    });
};

// 貨幣格式化
const formatCurrency = (amount, currency = 'USD') => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency
    }).format(amount);
};

// 檢測設備類型
const isMobile = () => {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
};

const isTablet = () => {
    return /iPad|Android(?!.*Mobile)/i.test(navigator.userAgent);
};

const isDesktop = () => {
    return !isMobile() && !isTablet();
};

// 檢測瀏覽器
const getBrowser = () => {
    const userAgent = navigator.userAgent;
    if (userAgent.includes('Chrome')) return 'Chrome';
    if (userAgent.includes('Firefox')) return 'Firefox';
    if (userAgent.includes('Safari')) return 'Safari';
    if (userAgent.includes('Edge')) return 'Edge';
    if (userAgent.includes('Opera')) return 'Opera';
    return 'Unknown';
};

// 檢測操作系統
const getOS = () => {
    const userAgent = navigator.userAgent;
    if (userAgent.includes('Windows')) return 'Windows';
    if (userAgent.includes('Mac')) return 'macOS';
    if (userAgent.includes('Linux')) return 'Linux';
    if (userAgent.includes('Android')) return 'Android';
    if (userAgent.includes('iOS')) return 'iOS';
    return 'Unknown';
};

// 滾動輔助函數
const scrollTo = (element, offset = 0, behavior = 'smooth') => {
    if (exists(element)) {
        const elementPosition = element.offsetTop - offset;
        window.scrollTo({
            top: elementPosition,
            behavior: behavior
        });
    }
};

const scrollToTop = (behavior = 'smooth') => {
    window.scrollTo({
        top: 0,
        behavior: behavior
    });
};

// 獲取元素位置
const getElementPosition = (element) => {
    if (!exists(element)) return null;
    
    const rect = element.getBoundingClientRect();
    return {
        top: rect.top + window.pageYOffset,
        left: rect.left + window.pageXOffset,
        right: rect.right + window.pageXOffset,
        bottom: rect.bottom + window.pageYOffset,
        width: rect.width,
        height: rect.height
    };
};

// 檢查元素是否在視窗中
const isInViewport = (element) => {
    if (!exists(element)) return false;
    
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
};

// 檢查元素是否部分可見
const isPartiallyVisible = (element) => {
    if (!exists(element)) return false;
    
    const rect = element.getBoundingClientRect();
    const windowHeight = window.innerHeight || document.documentElement.clientHeight;
    
    return (
        rect.top < windowHeight &&
        rect.bottom > 0
    );
};

// 導出所有函數
window.Helpers = {
    // DOM 操作
    $, $$, exists, addEvent, removeEvent, addEvents,
    toggleClass, addClass, removeClass, hasClass,
    setStyle, getStyle, setAttr, getAttr,
    setText, setHTML, createElement,
    appendChild, removeChild, clearElement,
    show, hide, toggle,
    
    // 動畫
    animate, fadeIn, fadeOut, slideDown, slideUp,
    
    // 工具
    debounce, throttle, random, randomFloat,
    shuffle, chunk, capitalize, truncate,
    formatDate, formatNumber, formatCurrency,
    
    // 檢測
    isMobile, isTablet, isDesktop, getBrowser, getOS,
    
    // 滾動
    scrollTo, scrollToTop, getElementPosition, isInViewport, isPartiallyVisible
};
