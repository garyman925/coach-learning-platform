        </div>
    </main>

    <!-- 用戶專用 Footer -->
    <footer class="user-footer">
        <div class="user-footer-container">
            <div class="user-footer-content">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. 保留所有權利。</p>
                <a href="<?php echo BASE_URL; ?>/" class="back-to-main-link">
                    <i class="fas fa-home"></i> 返回主頁
                </a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript -->
    <script src="<?php echo BASE_URL; ?>/assets/js/utils/storage.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/components/ScrollAnimator.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/components/Modal.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/components/Notification.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/components/LanguageSwitcher.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/components/ThemeSwitcher.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/components/Search.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/components/UserAuth.js"></script>
    
    <!-- 頁面特定 JavaScript -->
    <?php if (isset($pageJS)): ?>
        <?php foreach ($pageJS as $js): ?>
            <script src="<?php echo BASE_URL; ?>/assets/js/<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Dashboard 導航功能 -->
    <script>
        // 移動端導航切換 - 性能優化版本
        document.addEventListener('DOMContentLoaded', function() {
            const navToggle = document.querySelector('.user-nav-toggle');
            const navList = document.querySelector('.user-nav-list');
            
            if (navToggle && navList) {
                // 防抖動函數
                function debounce(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }
                
                // 切換導航狀態
                function toggleNav() {
                    const isExpanded = navToggle.getAttribute('aria-expanded') === 'true';
                    
                    navToggle.setAttribute('aria-expanded', !isExpanded);
                    navList.classList.toggle('show');
                    
                    // 切換圖標
                    const icon = navToggle.querySelector('i');
                    if (icon) {
                        icon.className = isExpanded ? 'fas fa-bars' : 'fas fa-times';
                    }
                }
                
                // 關閉導航
                function closeNav() {
                    navList.classList.remove('show');
                    navToggle.setAttribute('aria-expanded', 'false');
                    const icon = navToggle.querySelector('i');
                    if (icon) {
                        icon.className = 'fas fa-bars';
                    }
                }
                
                // 事件監聽器
                navToggle.addEventListener('click', toggleNav);
                
                // 使用事件委託處理導航鏈接點擊
                navList.addEventListener('click', function(e) {
                    if (e.target.closest('.user-nav-link')) {
                        closeNav();
                    }
                });
                
                // 點擊外部關閉導航
                document.addEventListener('click', function(e) {
                    if (!navToggle.contains(e.target) && !navList.contains(e.target)) {
                        closeNav();
                    }
                });
                
                // 窗口大小改變時關閉導航
                window.addEventListener('resize', debounce(function() {
                    if (window.innerWidth >= 768) {
                        closeNav();
                    }
                }, 250));
            }
        });
    </script>

    <!-- 用戶頁面專用 JavaScript -->
    <script>
        // 用戶菜單切換
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.user-menu-toggle');
            const dropdown = document.querySelector('.user-dropdown');
            
            if (menuToggle && dropdown) {
                menuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', !isExpanded);
                    dropdown.classList.toggle('show', !isExpanded);
                });
                
                // 點擊外部關閉菜單
                document.addEventListener('click', function() {
                    menuToggle.setAttribute('aria-expanded', 'false');
                    dropdown.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>
