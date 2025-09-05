/**
 * 搜索組件
 * 實現搜索功能和搜索結果展示
 */

class Search {
    constructor() {
        this.searchData = [
            {
                id: 1,
                title: '專業教練培訓課程',
                type: 'course',
                category: '專業教練',
                description: '專業的教練技能培訓，幫助您成為優秀的教練',
                url: '/courses/professional-coaching',
                tags: ['教練', '培訓', '專業', '技能']
            },
            {
                id: 2,
                title: '團隊教練課程',
                type: 'course',
                category: '團隊教練',
                description: '學習如何帶領和管理團隊，提升團隊效能',
                url: '/courses/team-coaching',
                tags: ['團隊', '管理', '領導', '效能']
            },
            {
                id: 3,
                title: '家長教練課程',
                type: 'course',
                category: '家長課程',
                description: '幫助家長更好地教育孩子，建立良好的親子關係',
                url: '/courses/parent-coaching',
                tags: ['家長', '教育', '親子', '關係']
            },
            {
                id: 4,
                title: '9型人格分析',
                type: 'course',
                category: '9型人格',
                description: '深入了解9型人格理論，提升自我認知和他人理解',
                url: '/courses/enneagram',
                tags: ['人格', '分析', '認知', '理解']
            },
            {
                id: 5,
                title: '個人教練服務',
                type: 'service',
                category: '教練服務',
                description: '一對一的個人教練服務，幫助您實現個人目標',
                url: '/coach-services',
                tags: ['個人', '教練', '服務', '目標']
            },
            {
                id: 6,
                title: '企業教練服務',
                type: 'service',
                category: '教練服務',
                description: '為企業提供專業的教練服務，提升組織效能',
                url: '/enterprise-services',
                tags: ['企業', '組織', '效能', '發展']
            }
        ];
        
        this.searchResults = [];
        this.isSearchOpen = false;
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.setupSearchOverlay();
        console.log('Search initialized');
        
        // 保存到全局變量以便其他組件使用
        window.searchComponent = this;
    }

    bindEvents() {
        // 搜索表單提交事件
        const searchForms = document.querySelectorAll('.search-form');
        searchForms.forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleSearch(e.target);
            });
        });

        // 搜索輸入框事件
        const searchInputs = document.querySelectorAll('.search-input');
        searchInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                this.handleSearchInput(e.target);
            });
            
            // 點擊事件 - 確保點擊時顯示搜索覆蓋層
            input.addEventListener('click', (e) => {
                e.preventDefault();
                this.openSearchOverlay();
            });
            
            // 聚焦事件 - 作為備用
            input.addEventListener('focus', () => {
                // 延遲一點點，避免與點擊事件衝突
                setTimeout(() => {
                    if (!this.isSearchOpen) {
                        this.openSearchOverlay();
                    }
                }, 100);
            });
        });

        // 搜索按鈕點擊事件
        const searchButtons = document.querySelectorAll('.search-button');
        searchButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const form = button.closest('.search-form');
                if (form) {
                    this.handleSearch(form);
                }
            });
        });

        // 鍵盤事件
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeSearchOverlay();
            }
            
            if (e.key === 'k' && (e.ctrlKey || e.metaKey)) {
                e.preventDefault();
                this.toggleSearchOverlay();
            }
        });

        // 點擊外部關閉搜索
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-container') && !e.target.closest('.search-overlay')) {
                this.closeSearchOverlay();
            }
        });
    }

    setupSearchOverlay() {
        // 創建搜索覆蓋層
        const overlay = document.createElement('div');
        overlay.className = 'search-overlay';
        overlay.innerHTML = `
            <div class="search-overlay-content">
                <div class="search-header">
                    <h2>搜索課程和服務</h2>
                    <button class="close-search" aria-label="關閉搜索">×</button>
                </div>
                <div class="search-input-container">
                    <input type="search" class="search-overlay-input" placeholder="輸入關鍵詞搜索..." aria-label="搜索">
                    <button type="button" class="search-overlay-button" aria-label="搜索">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <circle cx="8" cy="8" r="6"/>
                            <path d="M12.5 12.5L18 18"/>
                        </svg>
                    </button>
                </div>
                <div class="search-results"></div>
                <div class="search-suggestions">
                    <h3>熱門搜索</h3>
                    <div class="suggestion-tags">
                        <button class="suggestion-tag" data-query="教練培訓">教練培訓</button>
                        <button class="suggestion-tag" data-query="團隊管理">團隊管理</button>
                        <button class="suggestion-tag" data-query="9型人格">9型人格</button>
                        <button class="suggestion-tag" data-query="個人發展">個人發展</button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(overlay);
        
        // 綁定覆蓋層事件
        const closeBtn = overlay.querySelector('.close-search');
        closeBtn.addEventListener('click', () => {
            this.closeSearchOverlay();
        });
        
        const searchInput = overlay.querySelector('.search-overlay-input');
        searchInput.addEventListener('input', (e) => {
            this.handleSearchInput(e.target);
        });
        
        const searchBtn = overlay.querySelector('.search-overlay-button');
        searchBtn.addEventListener('click', () => {
            this.performSearch(searchInput.value);
        });
        
        // 建議標籤點擊事件
        const suggestionTags = overlay.querySelectorAll('.suggestion-tag');
        suggestionTags.forEach(tag => {
            tag.addEventListener('click', () => {
                const query = tag.dataset.query;
                searchInput.value = query;
                this.performSearch(query);
            });
        });
    }

    handleSearch(form) {
        const searchInput = form.querySelector('.search-input');
        if (searchInput) {
            const query = searchInput.value.trim();
            if (query) {
                this.performSearch(query);
                this.openSearchOverlay();
            }
        }
    }

    handleSearchInput(input) {
        const query = input.value.trim();
        if (query.length >= 2) {
            this.performSearch(query);
        } else {
            this.clearSearchResults();
        }
    }

    performSearch(query) {
        if (!query.trim()) {
            this.clearSearchResults();
            return;
        }
        
        // 執行搜索
        this.searchResults = this.searchData.filter(item => {
            const searchText = `${item.title} ${item.description} ${item.category} ${item.tags.join(' ')}`.toLowerCase();
            const queryLower = query.toLowerCase();
            return searchText.includes(queryLower);
        });
        
        // 顯示搜索結果
        this.displaySearchResults(query);
    }

    displaySearchResults(query) {
        const resultsContainer = document.querySelector('.search-results');
        if (!resultsContainer) return;
        
        if (this.searchResults.length === 0) {
            resultsContainer.innerHTML = `
                <div class="search-results-header">
                    <p>沒有找到與 "${query}" 相關的結果</p>
                    <p>請嘗試其他關鍵詞</p>
                </div>
            `;
            return;
        }
        
        const resultsHTML = `
            <div class="search-results-header">
                <h3>找到 ${this.searchResults.length} 個結果</h3>
                <p>搜索: "${query}"</p>
            </div>
            <div class="search-results-list">
                ${this.searchResults.map(item => this.renderSearchResult(item)).join('')}
            </div>
        `;
        
        resultsContainer.innerHTML = resultsHTML;
        
        // 綁定結果點擊事件
        const resultLinks = resultsContainer.querySelectorAll('.search-result-item');
        resultLinks.forEach((link, index) => {
            link.addEventListener('click', () => {
                this.handleResultClick(this.searchResults[index]);
            });
        });
    }

    renderSearchResult(item) {
        const typeIcon = item.type === 'course' ? '📚' : '🎯';
        const typeText = item.type === 'course' ? '課程' : '服務';
        
        return `
            <div class="search-result-item" data-url="${item.url}">
                <div class="result-icon">${typeIcon}</div>
                <div class="result-content">
                    <h4 class="result-title">${item.title}</h4>
                    <p class="result-description">${item.description}</p>
                    <div class="result-meta">
                        <span class="result-category">${item.category}</span>
                        <span class="result-type">${typeText}</span>
                    </div>
                    <div class="result-tags">
                        ${item.tags.map(tag => `<span class="result-tag">${tag}</span>`).join('')}
                    </div>
                </div>
            </div>
        `;
    }

    clearSearchResults() {
        const resultsContainer = document.querySelector('.search-results');
        if (resultsContainer) {
            resultsContainer.innerHTML = '';
        }
    }

    handleResultClick(item) {
        // 關閉搜索覆蓋層
        this.closeSearchOverlay();
        
        // 導航到結果頁面
        if (item.url) {
            window.location.href = item.url;
        }
    }

    openSearchOverlay() {
        const overlay = document.querySelector('.search-overlay');
        if (overlay) {
            overlay.classList.add('show');
            this.isSearchOpen = true;
            
            // 聚焦搜索輸入框
            const searchInput = overlay.querySelector('.search-overlay-input');
            if (searchInput) {
                searchInput.focus();
            }
            
            // 添加動畫效果
            overlay.style.opacity = '0';
            overlay.style.transform = 'scale(0.95)';
            
            requestAnimationFrame(() => {
                overlay.style.transition = 'all 0.3s ease';
                overlay.style.opacity = '1';
                overlay.style.transform = 'scale(1)';
            });
        }
    }

    closeSearchOverlay() {
        const overlay = document.querySelector('.search-overlay');
        if (overlay) {
            overlay.style.opacity = '0';
            overlay.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                overlay.classList.remove('show');
                this.isSearchOpen = false;
            }, 300);
        }
    }

    toggleSearchOverlay() {
        if (this.isSearchOpen) {
            this.closeSearchOverlay();
        } else {
            this.openSearchOverlay();
        }
    }

    // 公共方法
    getSearchResults() {
        return this.searchResults;
    }

    isSearchActive() {
        return this.isSearchOpen;
    }
}

// 創建並初始化搜索組件
document.addEventListener('DOMContentLoaded', () => {
    new Search();
});

// 全局搜索切換函數
window.toggleSearch = function() {
    const searchComponent = window.searchComponent;
    if (searchComponent) {
        searchComponent.toggleSearchOverlay();
    }
};