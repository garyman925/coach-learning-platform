/**
 * 本地存儲管理組件
 */

class StorageManager {
    constructor() {
        this.prefix = 'coach_platform_';
        this.defaultExpiry = 24 * 60 * 60 * 1000; // 24小時
    }

    /**
     * 生成完整的鍵名
     */
    _getKey(key) {
        return this.prefix + key;
    }

    /**
     * 設置本地存儲
     */
    set(key, value, expiry = null) {
        try {
            const fullKey = this._getKey(key);
            const data = {
                value: value,
                timestamp: Date.now(),
                expiry: expiry ? Date.now() + expiry : null
            };
            
            localStorage.setItem(fullKey, JSON.stringify(data));
            return true;
        } catch (error) {
            console.error('Storage set error:', error);
            return false;
        }
    }

    /**
     * 獲取本地存儲
     */
    get(key, defaultValue = null) {
        try {
            const fullKey = this._getKey(key);
            const item = localStorage.getItem(fullKey);
            
            if (!item) {
                return defaultValue;
            }
            
            const data = JSON.parse(item);
            
            // 檢查是否過期
            if (data.expiry && Date.now() > data.expiry) {
                this.remove(key);
                return defaultValue;
            }
            
            return data.value;
        } catch (error) {
            console.error('Storage get error:', error);
            return defaultValue;
        }
    }

    /**
     * 移除本地存儲
     */
    remove(key) {
        try {
            const fullKey = this._getKey(key);
            localStorage.removeItem(fullKey);
            return true;
        } catch (error) {
            console.error('Storage remove error:', error);
            return false;
        }
    }

    /**
     * 檢查鍵是否存在
     */
    has(key) {
        try {
            const fullKey = this._getKey(key);
            return localStorage.getItem(fullKey) !== null;
        } catch (error) {
            console.error('Storage has error:', error);
            return false;
        }
    }

    /**
     * 清空所有相關的本地存儲
     */
    clear() {
        try {
            const keys = Object.keys(localStorage);
            keys.forEach(key => {
                if (key.startsWith(this.prefix)) {
                    localStorage.removeItem(key);
                }
            });
            return true;
        } catch (error) {
            console.error('Storage clear error:', error);
            return false;
        }
    }

    /**
     * 獲取所有相關的鍵
     */
    keys() {
        try {
            const keys = Object.keys(localStorage);
            return keys
                .filter(key => key.startsWith(this.prefix))
                .map(key => key.replace(this.prefix, ''));
        } catch (error) {
            console.error('Storage keys error:', error);
            return [];
        }
    }

    /**
     * 獲取存儲大小（字節）
     */
    size() {
        try {
            let totalSize = 0;
            const keys = this.keys();
            
            keys.forEach(key => {
                const fullKey = this._getKey(key);
                const item = localStorage.getItem(fullKey);
                if (item) {
                    totalSize += new Blob([item]).size;
                }
            });
            
            return totalSize;
        } catch (error) {
            console.error('Storage size error:', error);
            return 0;
        }
    }

    /**
     * 設置會話存儲
     */
    setSession(key, value) {
        try {
            const fullKey = this._getKey(key);
            sessionStorage.setItem(fullKey, JSON.stringify(value));
            return true;
        } catch (error) {
            console.error('Session storage set error:', error);
            return false;
        }
    }

    /**
     * 獲取會話存儲
     */
    getSession(key, defaultValue = null) {
        try {
            const fullKey = this._getKey(key);
            const item = sessionStorage.getItem(fullKey);
            
            if (!item) {
                return defaultValue;
            }
            
            return JSON.parse(item);
        } catch (error) {
            console.error('Session storage get error:', error);
            return defaultValue;
        }
    }

    /**
     * 移除會話存儲
     */
    removeSession(key) {
        try {
            const fullKey = this._getKey(key);
            sessionStorage.removeItem(fullKey);
            return true;
        } catch (error) {
            console.error('Session storage remove error:', error);
            return false;
        }
    }

    /**
     * 清空會話存儲
     */
    clearSession() {
        try {
            const keys = Object.keys(sessionStorage);
            keys.forEach(key => {
                if (key.startsWith(this.prefix)) {
                    sessionStorage.removeItem(key);
                }
            });
            return true;
        } catch (error) {
            console.error('Session storage clear error:', error);
            return false;
        }
    }

    /**
     * 設置用戶偏好設置
     */
    setPreference(key, value) {
        return this.set('pref_' + key, value);
    }

    /**
     * 獲取用戶偏好設置
     */
    getPreference(key, defaultValue = null) {
        return this.get('pref_' + key, defaultValue);
    }

    /**
     * 設置用戶設置
     */
    setUserSetting(key, value) {
        return this.set('user_' + key, value);
    }

    /**
     * 獲取用戶設置
     */
    getUserSetting(key, defaultValue = null) {
        return this.get('user_' + key, defaultValue);
    }

    /**
     * 設置緩存數據
     */
    setCache(key, value, expiry = this.defaultExpiry) {
        return this.set('cache_' + key, value, expiry);
    }

    /**
     * 獲取緩存數據
     */
    getCache(key, defaultValue = null) {
        return this.get('cache_' + key, defaultValue);
    }

    /**
     * 清除過期的緩存
     */
    clearExpiredCache() {
        try {
            const keys = this.keys();
            keys.forEach(key => {
                if (key.startsWith('cache_')) {
                    // 觸發get方法會自動檢查過期並清理
                    this.get(key);
                }
            });
            return true;
        } catch (error) {
            console.error('Clear expired cache error:', error);
            return false;
        }
    }

    /**
     * 設置表單數據
     */
    setFormData(formId, data) {
        return this.set('form_' + formId, data, 60 * 60 * 1000); // 1小時過期
    }

    /**
     * 獲取表單數據
     */
    getFormData(formId, defaultValue = null) {
        return this.get('form_' + formId, defaultValue);
    }

    /**
     * 清除表單數據
     */
    clearFormData(formId) {
        return this.remove('form_' + formId);
    }

    /**
     * 設置購物車數據
     */
    setCartData(data) {
        return this.set('cart', data);
    }

    /**
     * 獲取購物車數據
     */
    getCartData(defaultValue = []) {
        return this.get('cart', defaultValue);
    }

    /**
     * 添加商品到購物車
     */
    addToCart(item) {
        const cart = this.getCartData();
        const existingItemIndex = cart.findIndex(cartItem => cartItem.id === item.id);
        
        if (existingItemIndex > -1) {
            cart[existingItemIndex].quantity += (item.quantity || 1);
        } else {
            cart.push({ ...item, quantity: item.quantity || 1 });
        }
        
        return this.setCartData(cart);
    }

    /**
     * 從購物車移除商品
     */
    removeFromCart(itemId) {
        const cart = this.getCartData();
        const filteredCart = cart.filter(item => item.id !== itemId);
        return this.setCartData(filteredCart);
    }

    /**
     * 清空購物車
     */
    clearCart() {
        return this.remove('cart');
    }

    /**
     * 設置搜索歷史
     */
    setSearchHistory(term) {
        const history = this.get('search_history', []);
        const filteredHistory = history.filter(item => item !== term);
        const newHistory = [term, ...filteredHistory].slice(0, 10); // 保留最近10個
        return this.set('search_history', newHistory);
    }

    /**
     * 獲取搜索歷史
     */
    getSearchHistory() {
        return this.get('search_history', []);
    }

    /**
     * 清除搜索歷史
     */
    clearSearchHistory() {
        return this.remove('search_history');
    }

    /**
     * 設置最近查看的項目
     */
    setRecentlyViewed(item) {
        const recent = this.get('recently_viewed', []);
        const filteredRecent = recent.filter(recentItem => recentItem.id !== item.id);
        const newRecent = [item, ...filteredRecent].slice(0, 20); // 保留最近20個
        return this.set('recently_viewed', newRecent);
    }

    /**
     * 獲取最近查看的項目
     */
    getRecentlyViewed() {
        return this.get('recently_viewed', []);
    }

    /**
     * 清除最近查看的項目
     */
    clearRecentlyViewed() {
        return this.remove('recently_viewed');
    }

    /**
     * 導出所有數據
     */
    exportData() {
        try {
            const data = {};
            const keys = this.keys();
            
            keys.forEach(key => {
                data[key] = this.get(key);
            });
            
            return JSON.stringify(data, null, 2);
        } catch (error) {
            console.error('Export data error:', error);
            return null;
        }
    }

    /**
     * 導入數據
     */
    importData(jsonData) {
        try {
            const data = JSON.parse(jsonData);
            let successCount = 0;
            let errorCount = 0;
            
            Object.entries(data).forEach(([key, value]) => {
                if (this.set(key, value)) {
                    successCount++;
                } else {
                    errorCount++;
                }
            });
            
            return {
                success: successCount,
                error: errorCount,
                total: Object.keys(data).length
            };
        } catch (error) {
            console.error('Import data error:', error);
            return null;
        }
    }

    /**
     * 獲取存儲統計信息
     */
    getStats() {
        try {
            const keys = this.keys();
            const totalSize = this.size();
            const categories = {};
            
            keys.forEach(key => {
                const category = key.split('_')[0];
                categories[category] = (categories[category] || 0) + 1;
            });
            
            return {
                totalKeys: keys.length,
                totalSize: totalSize,
                totalSizeKB: Math.round(totalSize / 1024 * 100) / 100,
                categories: categories
            };
        } catch (error) {
            console.error('Get stats error:', error);
            return null;
        }
    }
}

// 創建全局實例
const Storage = new StorageManager();

// 導出到全局
window.Storage = Storage;

// 自動清理過期緩存（每小時執行一次）
setInterval(() => {
    Storage.clearExpiredCache();
}, 60 * 60 * 1000);

// 頁面卸載時保存重要數據
window.addEventListener('beforeunload', () => {
    // 可以在此處保存一些重要的臨時數據
    Storage.setSession('last_visit', Date.now());
});
