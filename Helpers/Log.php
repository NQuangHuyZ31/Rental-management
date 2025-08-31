<?php

namespace Helpers;

class Log
{
    private static function getLogDir()
    {
        if (defined('ROOT_PATH')) {
            return ROOT_PATH . '/Logs/';
        } else {
            return __DIR__ . '/../Logs/';
        }
    }

    protected static $maxFileSize = 10 * 1024 * 1024; // 10MB
    protected static $maxFiles = 5;

    const LEVEL_DEBUG    = 'DEBUG';
    const LEVEL_INFO     = 'INFO';
    const LEVEL_WARNING  = 'WARNING';
    const LEVEL_ERROR    = 'ERROR';
    const LEVEL_CRITICAL = 'CRITICAL';

    /**
     * Ghi log vào file
     *
     * @param string      $logData
     * @param string      $level
     * @param string|null $logFileName
     */
    public static function write($logData, $level = self::LEVEL_INFO, $logFileName = null)
    {
        $timestamp = date('Y-m-d H:i:s');
        
        // Xử lý array hoặc object
        if (is_array($logData) || is_object($logData)) {
            $logData = print_r($logData, true);
        }
        
        $logEntry = sprintf("[%s] [%s] %s%s", $timestamp, $level, $logData, PHP_EOL);

        $logFilePath = self::getLogDir() . ($logFileName ?: 'server.log');

        // Rotate chỉ áp dụng cho server.log mặc định
        if ($logFileName === null && file_exists($logFilePath) && filesize($logFilePath) > self::$maxFileSize) {
            self::rotateLogFiles();
        }

        if (!is_dir(dirname($logFilePath))) {
            mkdir(dirname($logFilePath), 0755, true);
        }

        // Sử dụng file_put_contents với LOCK_EX để tránh conflict
        $result = file_put_contents($logFilePath, $logEntry, FILE_APPEND | LOCK_EX);
        
        // Nếu ghi thành công, flush buffer để đảm bảo dữ liệu được ghi ngay lập tức
        if ($result !== false) {
            // Flush output buffer nếu có
            if (ob_get_level() > 0) {
                ob_flush();
            }
            
            // Flush file system buffer
            if (function_exists('fflush')) {
                $handle = fopen($logFilePath, 'a');
                if ($handle) {
                    fflush($handle);
                    fclose($handle);
                }
            }
        }
        
        return $result !== false;
    }

    /**
     * Rotate log files (chỉ cho server.log mặc định)
     */
    protected static function rotateLogFiles()
    {
        $logDir = self::getLogDir();
        $baseLogFile = $logDir . 'server.log';

        $oldestLog = $logDir . 'server.log.' . self::$maxFiles;
        if (file_exists($oldestLog)) {
            unlink($oldestLog);
        }

        for ($i = self::$maxFiles - 1; $i >= 1; $i--) {
            $oldFile = $logDir . 'server.log.' . $i;
            $newFile = $logDir . 'server.log.' . ($i + 1);
            if (file_exists($oldFile)) {
                rename($oldFile, $newFile);
            }
        }

        if (file_exists($baseLogFile)) {
            rename($baseLogFile, $logDir . 'server.log.1');
        }
    }

    // ==========================
    // Helper methods
    // ==========================

    public static function server($msg, $level = self::LEVEL_INFO)
    {
        return self::write($msg, $level, 'server.log');
    }

    public static function queue($msg, $level = self::LEVEL_INFO)
    {
        return self::write($msg, $level, 'queue_jobs.log');
    }

    public static function payment($msg, $level = self::LEVEL_INFO)
    {
        return self::write($msg, $level, 'payment.log');
    }

    public static function auth($msg, $level = self::LEVEL_INFO)
    {
        return self::write($msg, $level, 'auth.log');
    }

    public static function custom($msg, $fileName, $level = self::LEVEL_INFO)
    {
        // Cho phép log ra bất kỳ file nào
        return self::write($msg, $level, $fileName);
    }
}
