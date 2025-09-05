<?php
/**
 * 語言管理類
 * 處理多語言支持和翻譯
 */
class Language {
    private static $instance = null;
    private $currentLanguage = 'zh-TW';
    private $translations = [];
    private $languages = [
        'zh-TW' => '繁體中文',
        'zh-CN' => '簡體中文',
        'en' => 'English'
    ];
    
    private function __construct() {
        $this->currentLanguage = $this->getLanguageFromRequest();
        $this->loadTranslations();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * 從請求中獲取語言設置
     */
    private function getLanguageFromRequest() {
        // 優先從 URL 參數獲取
        if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $this->languages)) {
            return $_GET['lang'];
        }
        
        // 從 session 獲取
        if (isset($_SESSION['language']) && array_key_exists($_SESSION['language'], $this->languages)) {
            return $_SESSION['language'];
        }
        
        // 從 cookie 獲取
        if (isset($_COOKIE['language']) && array_key_exists($_COOKIE['language'], $this->languages)) {
            return $_COOKIE['language'];
        }
        
        // 默認語言
        return 'zh-TW';
    }
    
    /**
     * 設置語言
     */
    public function setLanguage($language) {
        if (array_key_exists($language, $this->languages)) {
            $this->currentLanguage = $language;
            $_SESSION['language'] = $language;
            setcookie('language', $language, time() + (86400 * 30), '/'); // 30天
            return true;
        }
        return false;
    }
    
    /**
     * 獲取當前語言
     */
    public function getCurrentLanguage() {
        return $this->currentLanguage;
    }
    
    /**
     * 獲取可用語言列表
     */
    public function getAvailableLanguages() {
        return $this->languages;
    }
    
    /**
     * 載入翻譯文件
     */
    private function loadTranslations() {
        $languageFile = __DIR__ . "/../assets/languages/{$this->currentLanguage}.php";
        if (file_exists($languageFile)) {
            $this->translations = include $languageFile;
        } else {
            // 如果語言文件不存在，載入默認語言
            $defaultFile = __DIR__ . "/../assets/languages/zh-TW.php";
            if (file_exists($defaultFile)) {
                $this->translations = include $defaultFile;
            }
        }
    }
    
    /**
     * 獲取翻譯文本
     */
    public function get($key, $default = null) {
        return isset($this->translations[$key]) ? $this->translations[$key] : (isset($default) ? $default : $key);
    }
    
    /**
     * 檢查是否有翻譯
     */
    public function has($key) {
        return isset($this->translations[$key]);
    }
    
    /**
     * 獲取所有翻譯
     */
    public function getAll() {
        return $this->translations;
    }
    
    /**
     * 重新載入翻譯
     */
    public function reload() {
        $this->loadTranslations();
    }
}

// 創建全局語言實例
$lang = Language::getInstance();

// 輔助函數
function __($key, $default = null) {
    global $lang;
    return $lang->get($key, $default);
}
