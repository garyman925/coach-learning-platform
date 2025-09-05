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
    <script src="<?php echo BASE_URL; ?>/assets/js/components/ScrollAnimator.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/components/Modal.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/components/Notification.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/components/LanguageSwitcher.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/components/ThemeSwitcher.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/components/Search.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/main.js"></script>
    
    <!-- 頁面特定 JavaScript -->
    <?php if (isset($pageJS)): ?>
        <?php foreach ($pageJS as $js): ?>
            <script src="<?php echo BASE_URL; ?>/assets/js/<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

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
