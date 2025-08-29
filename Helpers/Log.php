<?php

namespace Helpers;

class Log
{
    protected static $logFile = ROOT_PATH . '/Logs/';
    protected static $maxFileSize = 10 * 1024 * 1024; // 10MB
    protected static $maxFiles = 5;
    
    const LEVEL_DEBUG = 'DEBUG';
    const LEVEL_INFO = 'INFO';
    const LEVEL_WARNING = 'WARNING';
    const LEVEL_ERROR = 'ERROR';
    const LEVEL_CRITICAL = 'CRITICAL';

    /**
     * Log text message
     */
    public static function text($logData, $level = self::LEVEL_INFO)
    {
        self::writeLog($logData, $level);
    }

    /**
     * Log array data
     */
    public static function array(array $logData, $level = self::LEVEL_INFO)
    {
        self::writeLog(print_r($logData, true), $level);
    }

    /**
     * Log JSON data
     */
    public static function json($logData, $level = self::LEVEL_INFO)
    {
        self::writeLog(json_encode($logData, JSON_PRETTY_PRINT), $level);
    }

    /**
     * Log debug information
     */
    public static function debug($logData)
    {
        self::writeLog($logData, self::LEVEL_DEBUG);
    }

    /**
     * Log info message
     */
    public static function info($logData)
    {
        self::writeLog($logData, self::LEVEL_INFO);
    }

    /**
     * Log warning message
     */
    public static function warning($logData)
    {
        self::writeLog($logData, self::LEVEL_WARNING);
    }

    /**
     * Log error message
     */
    public static function error($logData)
    {
        self::writeLog($logData, self::LEVEL_ERROR);
    }

    /**
     * Log critical error
     */
    public static function critical($logData)
    {
        self::writeLog($logData, self::LEVEL_CRITICAL);
    }

    /**
     * Log exception with stack trace
     */
    public static function exception(\Exception $exception, $level = self::LEVEL_ERROR)
    {
        $logData = sprintf(
            "Exception: %s\nMessage: %s\nFile: %s\nLine: %d\nStack Trace:\n%s",
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );
        self::writeLog($logData, $level);
    }

    /**
     * Write log to file with rotation
     */
    protected static function writeLog($logData, $level = self::LEVEL_INFO)
    {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = sprintf("[%s] [%s] %s%s", $timestamp, $level, $logData, PHP_EOL);
        
        $logFilePath = self::$logFile . 'server.log';
        
        // Check if file exists and rotate if needed
        if (file_exists($logFilePath) && filesize($logFilePath) > self::$maxFileSize) {
            self::rotateLogFiles();
        }
        
        // Create directory if it doesn't exist
        if (!is_dir(dirname($logFilePath))) {
            mkdir(dirname($logFilePath), 0755, true);
        }
        
        file_put_contents($logFilePath, $logEntry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Rotate log files
     */
    protected static function rotateLogFiles()
    {
        $logDir = self::$logFile;
        $baseLogFile = $logDir . 'server.log';
        
        // Remove oldest log file if we have reached max files
        $oldestLog = $logDir . 'server.log.' . self::$maxFiles;
        if (file_exists($oldestLog)) {
            unlink($oldestLog);
        }
        
        // Shift existing log files
        for ($i = self::$maxFiles - 1; $i >= 1; $i--) {
            $oldFile = $logDir . 'server.log.' . $i;
            $newFile = $logDir . 'server.log.' . ($i + 1);
            if (file_exists($oldFile)) {
                rename($oldFile, $newFile);
            }
        }
        
        // Rename current log file
        if (file_exists($baseLogFile)) {
            rename($baseLogFile, $logDir . 'server.log.1');
        }
    }

    /**
     * Clear all log files
     */
    public static function clear()
    {
        $logDir = self::$logFile;
        $files = glob($logDir . 'server.log*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * Get log file size
     */
    public static function getLogSize()
    {
        $logFilePath = self::$logFile . 'server.log';
        if (file_exists($logFilePath)) {
            return filesize($logFilePath);
        }
        return 0;
    }

    /**
     * Get log file path
     */
    public static function getLogPath()
    {
        return self::$logFile . 'server.log';
    }
}
