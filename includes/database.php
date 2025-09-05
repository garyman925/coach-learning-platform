<?php
/**
 * 教練學習平台 - 數據庫連接類
 * 處理數據庫連接和基本操作
 */

// 防止直接訪問
if (!defined('SECURE_ACCESS')) {
    http_response_code(403);
    exit('直接訪問被禁止');
}

class Database {
    private $connection;
    private static $instance = null;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
            
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                throw new Exception("數據庫連接失敗: " . $e->getMessage());
            } else {
                error_log("數據庫連接失敗: " . $e->getMessage());
                throw new Exception("數據庫連接失敗，請稍後再試");
            }
        }
    }
    
    // 單例模式
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // 獲取數據庫連接
    public function getConnection() {
        return $this->connection;
    }
    
    // 執行查詢
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                throw new Exception("查詢執行失敗: " . $e->getMessage());
            } else {
                error_log("查詢執行失敗: " . $e->getMessage());
                throw new Exception("查詢執行失敗，請稍後再試");
            }
        }
    }
    
    // 獲取單行數據
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    // 獲取多行數據
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    // 插入數據
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, $data);
        
        return $this->connection->lastInsertId();
    }
    
    // 更新數據
    public function update($table, $data, $where, $whereParams = []) {
        $setClause = [];
        foreach (array_keys($data) as $column) {
            $setClause[] = "{$column} = :{$column}";
        }
        
        $sql = "UPDATE {$table} SET " . implode(', ', $setClause) . " WHERE {$where}";
        $params = array_merge($data, $whereParams);
        
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
    
    // 刪除數據
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
    
    // 檢查表是否存在
    public function tableExists($tableName) {
        $sql = "SHOW TABLES LIKE :table";
        $result = $this->fetchOne($sql, ['table' => $tableName]);
        return $result !== false;
    }
    
    // 創建用戶表（如果不存在）
    public function createUsersTable() {
        if (!$this->tableExists('users')) {
            $sql = "CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) UNIQUE NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password_hash VARCHAR(255) NOT NULL,
                first_name VARCHAR(50),
                last_name VARCHAR(50),
                role ENUM('user', 'admin') DEFAULT 'user',
                language VARCHAR(10) DEFAULT 'zh-TW',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                last_login TIMESTAMP NULL,
                is_active BOOLEAN DEFAULT TRUE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            $this->query($sql);
        }
    }
    
    // 關閉連接
    public function close() {
        $this->connection = null;
    }
    
    // 防止克隆
    private function __clone() {}
    
    // 防止反序列化
    public function __wakeup() {}
}

// 創建數據庫實例（暫時禁用，避免數據庫連接錯誤）
/*
try {
    $db = Database::getInstance();
    // 創建必要的表
    $db->createUsersTable();
} catch (Exception $e) {
    if (DEBUG_MODE) {
        echo "數據庫初始化失敗: " . $e->getMessage();
    }
}
*/
