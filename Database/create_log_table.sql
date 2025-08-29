-- Tạo bảng log cho Database Core
-- File: Database/create_log_table.sql

-- Bảng log mặc định
CREATE TABLE IF NOT EXISTS `query_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sql` TEXT NOT NULL COMMENT 'Câu truy vấn SQL',
    `params` TEXT COMMENT 'Tham số truyền vào (JSON)',
    `type` VARCHAR(20) NOT NULL COMMENT 'Loại query: SELECT, INSERT, UPDATE, DELETE, RAW, ERROR',
    `table_name` VARCHAR(100) COMMENT 'Tên bảng được truy vấn',
    `executed_at` DATETIME NOT NULL COMMENT 'Thời gian thực thi',
    `user_id` INT COMMENT 'ID của user thực hiện query',
    `ip_address` VARCHAR(45) COMMENT 'IP address của client',
    `user_agent` TEXT COMMENT 'User agent của client',
    `error_message` TEXT COMMENT 'Thông tin lỗi nếu có',
    `execution_time` DECIMAL(10,4) COMMENT 'Thời gian thực thi (giây)',
    `rows_affected` INT COMMENT 'Số dòng bị ảnh hưởng',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian tạo log'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Log tất cả queries từ Database Core';

-- Tạo index để tối ưu performance
CREATE INDEX `idx_query_logs_type` ON `query_logs` (`type`);
CREATE INDEX `idx_query_logs_table` ON `query_logs` (`table_name`);
CREATE INDEX `idx_query_logs_executed_at` ON `query_logs` (`executed_at`);
CREATE INDEX `idx_query_logs_user_id` ON `query_logs` (`user_id`);
CREATE INDEX `idx_query_logs_ip_address` ON `query_logs` (`ip_address`);

-- Bảng log tùy chỉnh (nếu muốn đổi tên)
CREATE TABLE IF NOT EXISTS `custom_query_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sql` TEXT NOT NULL COMMENT 'Câu truy vấn SQL',
    `params` TEXT COMMENT 'Tham số truyền vào (JSON)',
    `type` VARCHAR(20) NOT NULL COMMENT 'Loại query: SELECT, INSERT, UPDATE, DELETE, RAW, ERROR',
    `table_name` VARCHAR(100) COMMENT 'Tên bảng được truy vấn',
    `executed_at` DATETIME NOT NULL COMMENT 'Thời gian thực thi',
    `user_id` INT COMMENT 'ID của user thực hiện query',
    `ip_address` VARCHAR(45) COMMENT 'IP address của client',
    `user_agent` TEXT COMMENT 'User agent của client',
    `error_message` TEXT COMMENT 'Thông tin lỗi nếu có',
    `execution_time` DECIMAL(10,4) COMMENT 'Thời gian thực thi (giây)',
    `rows_affected` INT COMMENT 'Số dòng bị ảnh hưởng',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian tạo log'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Log tùy chỉnh cho Database Core';

-- Tạo index cho bảng tùy chỉnh
CREATE INDEX `idx_custom_query_logs_type` ON `custom_query_logs` (`type`);
CREATE INDEX `idx_custom_query_logs_table` ON `custom_query_logs` (`table_name`);
CREATE INDEX `idx_custom_query_logs_executed_at` ON `custom_query_logs` (`executed_at`);
CREATE INDEX `idx_custom_query_logs_user_id` ON `custom_query_logs` (`user_id`);

-- Bảng log performance (nếu muốn theo dõi performance)
CREATE TABLE IF NOT EXISTS `performance_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sql` TEXT NOT NULL COMMENT 'Câu truy vấn SQL',
    `params` TEXT COMMENT 'Tham số truyền vào (JSON)',
    `type` VARCHAR(20) NOT NULL COMMENT 'Loại query',
    `table_name` VARCHAR(100) COMMENT 'Tên bảng',
    `execution_time` DECIMAL(10,4) NOT NULL COMMENT 'Thời gian thực thi (giây)',
    `memory_usage` BIGINT COMMENT 'Memory usage (bytes)',
    `rows_affected` INT COMMENT 'Số dòng bị ảnh hưởng',
    `user_id` INT COMMENT 'ID user',
    `ip_address` VARCHAR(45) COMMENT 'IP address',
    `executed_at` DATETIME NOT NULL COMMENT 'Thời gian thực thi',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian tạo log'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Log performance của queries';

-- Tạo index cho bảng performance
CREATE INDEX `idx_performance_logs_type` ON `performance_logs` (`type`);
CREATE INDEX `idx_performance_logs_execution_time` ON `performance_logs` (`execution_time`);
CREATE INDEX `idx_performance_logs_executed_at` ON `performance_logs` (`executed_at`);

-- Bảng log errors (nếu muốn tách riêng errors)
CREATE TABLE IF NOT EXISTS `error_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sql` TEXT NOT NULL COMMENT 'Câu truy vấn SQL gây lỗi',
    `params` TEXT COMMENT 'Tham số truyền vào (JSON)',
    `table_name` VARCHAR(100) COMMENT 'Tên bảng',
    `error_code` VARCHAR(10) COMMENT 'Mã lỗi SQL',
    `error_message` TEXT NOT NULL COMMENT 'Thông tin lỗi chi tiết',
    `stack_trace` TEXT COMMENT 'Stack trace nếu có',
    `user_id` INT COMMENT 'ID user',
    `ip_address` VARCHAR(45) COMMENT 'IP address',
    `user_agent` TEXT COMMENT 'User agent',
    `executed_at` DATETIME NOT NULL COMMENT 'Thời gian xảy ra lỗi',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian tạo log'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Log các lỗi database';

-- Tạo index cho bảng error
CREATE INDEX `idx_error_logs_error_code` ON `error_logs` (`error_code`);
CREATE INDEX `idx_error_logs_executed_at` ON `error_logs` (`executed_at`);
CREATE INDEX `idx_error_logs_user_id` ON `error_logs` (`user_id`);

-- Tạo view để dễ dàng xem logs
CREATE OR REPLACE VIEW `v_query_logs_summary` AS
SELECT 
    DATE(executed_at) as log_date,
    type,
    COUNT(*) as total_queries,
    AVG(execution_time) as avg_execution_time,
    MAX(execution_time) as max_execution_time,
    SUM(rows_affected) as total_rows_affected
FROM query_logs 
WHERE executed_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
GROUP BY DATE(executed_at), type
ORDER BY log_date DESC, type;

-- Tạo view để xem performance
CREATE OR REPLACE VIEW `v_slow_queries` AS
SELECT 
    sql,
    params,
    type,
    table_name,
    execution_time,
    executed_at,
    user_id,
    ip_address
FROM query_logs 
WHERE execution_time > 1.0  -- Queries chậm hơn 1 giây
ORDER BY execution_time DESC
LIMIT 100;

-- Tạo view để xem errors
CREATE OR REPLACE VIEW `v_recent_errors` AS
SELECT 
    sql,
    params,
    table_name,
    error_message,
    executed_at,
    user_id,
    ip_address
FROM query_logs 
WHERE type = 'ERROR'
ORDER BY executed_at DESC
LIMIT 100;

-- Stored procedure để cleanup logs cũ
DELIMITER //
CREATE PROCEDURE `cleanup_old_logs`(IN days_to_keep INT)
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE table_name VARCHAR(100);
    DECLARE cur CURSOR FOR 
        SELECT TABLE_NAME 
        FROM INFORMATION_SCHEMA.TABLES 
        WHERE TABLE_SCHEMA = DATABASE() 
        AND TABLE_NAME LIKE '%_logs';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    OPEN cur;
    
    read_loop: LOOP
        FETCH cur INTO table_name;
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        SET @sql = CONCAT('DELETE FROM ', table_name, ' WHERE executed_at < DATE_SUB(NOW(), INTERVAL ', days_to_keep, ' DAY)');
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
        
    END LOOP;
    
    CLOSE cur;
    
    SELECT CONCAT('Cleaned up logs older than ', days_to_keep, ' days') as result;
END //
DELIMITER ;

-- Stored procedure để get query statistics
DELIMITER //
CREATE PROCEDURE `get_query_stats`(IN days_back INT)
BEGIN
    SELECT 
        type,
        COUNT(*) as total_queries,
        AVG(execution_time) as avg_execution_time,
        MAX(execution_time) as max_execution_time,
        MIN(execution_time) as min_execution_time,
        SUM(rows_affected) as total_rows_affected
    FROM query_logs 
    WHERE executed_at >= DATE_SUB(NOW(), INTERVAL days_back DAY)
    GROUP BY type
    ORDER BY total_queries DESC;
END //
DELIMITER ;

-- Tạo trigger để tự động cập nhật execution_time (nếu cần)
DELIMITER //
CREATE TRIGGER `before_query_logs_insert` 
BEFORE INSERT ON `query_logs`
FOR EACH ROW
BEGIN
    -- Có thể thêm logic validation hoặc transformation ở đây
    IF NEW.execution_time IS NULL THEN
        SET NEW.execution_time = 0.0000;
    END IF;
    
    IF NEW.rows_affected IS NULL THEN
        SET NEW.rows_affected = 0;
    END IF;
END //
DELIMITER ;

-- Insert dữ liệu mẫu để test
INSERT INTO `query_logs` (`sql`, `params`, `type`, `table_name`, `executed_at`, `user_id`, `ip_address`, `user_agent`, `execution_time`, `rows_affected`) VALUES
('SELECT * FROM users WHERE status = ?', '["active"]', 'SELECT', 'users', NOW(), 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', 0.0012, 5),
('INSERT INTO users (name, email) VALUES (?, ?)', '["John Doe", "john@example.com"]', 'INSERT', 'users', NOW(), 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', 0.0008, 1),
('UPDATE users SET status = ? WHERE id = ?', '["inactive", 1]', 'UPDATE', 'users', NOW(), 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', 0.0006, 1);

-- Tạo user để test (nếu cần)
-- CREATE USER 'log_user'@'localhost' IDENTIFIED BY 'log_password';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON `query_logs`.* TO 'log_user'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON `custom_query_logs`.* TO 'log_user'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON `performance_logs`.* TO 'log_user'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON `error_logs`.* TO 'log_user'@'localhost';

-- Hiển thị thông tin về các bảng đã tạo
SELECT 
    TABLE_NAME as 'Table Name',
    TABLE_ROWS as 'Rows',
    ROUND(((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024), 2) AS 'Size (MB)',
    TABLE_COMMENT as 'Description'
FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME LIKE '%_logs'
ORDER BY TABLE_NAME;

-- Hiển thị thông tin về các views
SELECT 
    TABLE_NAME as 'View Name',
    VIEW_DEFINITION as 'Definition'
FROM INFORMATION_SCHEMA.VIEWS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME LIKE 'v_%';

-- Hiển thị thông tin về các stored procedures
SELECT 
    ROUTINE_NAME as 'Procedure Name',
    ROUTINE_DEFINITION as 'Definition'
FROM INFORMATION_SCHEMA.ROUTINES 
WHERE ROUTINE_SCHEMA = DATABASE() 
AND ROUTINE_TYPE = 'PROCEDURE';
