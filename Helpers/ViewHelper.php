<?php

namespace Helpers;

class ViewHelper
{
    /**
     * Render a view with data
     * 
     * @param string $view Path to view file (relative to views directory)
     * @param array $data Data to pass to the view
     * @param string|null $layout Layout file to use (optional)
     * @return string Rendered HTML content
     */
    public static function render($view, $data = [], $layout = null)
    {
        // Extract data to variables for use in view
        if (!empty($data)) {
            extract($data);
        }
        
        // Start output buffering
        ob_start(); 
        // Include the view file
        $viewPath = self::getViewPath($view);
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            throw new \Exception("View file not found: {$viewPath}");
        }
        
        // Get the content
        $content = ob_get_clean();
        
        // If layout is specified, wrap content in layout
        if ($layout) {
            $content = self::renderWithLayout($layout, $content, $data);
        }
        
        return $content;
    }
    
    /**
     * Render view with layout
     * 
     * @param string $layout Layout file path
     * @param string $content Main content
     * @param array $data Data to pass to layout
     * @return string Rendered HTML with layout
     */
    private static function renderWithLayout($layout, $content, $data = [])
    {
        // Extract data to variables
        if (!empty($data)) {
            extract($data);
        }

        // Start output buffering
        // ob_start();
        
        // Include layout file
        // $layoutPath = self::getViewPath($layout);
        // if (file_exists($layoutPath)) {
        //     require_once $layoutPath;
        // } else {
        //     throw new \Exception("Layout file not found: {$layoutPath}");
        // }
        require_once VIEW_PATH . $layout . '.php';
        
        // return ob_get_clean();
    }
    
    /**
     * Get full path to view file
     * 
     * @param string $view View file path
     * @return string Full path to view file
     */
    private static function getViewPath($view)
    {
        // Remove .php extension if provided
        // $view = str_replace('.php', '', $view);
        
        return VIEW_PATH . $view . '.php';
    }
    
    /**
     * Render partial view (reusable component)
     * 
     * @param string $partial Partial view path
     * @param array $data Data to pass to partial
     * @return string Rendered partial HTML
     */
    public static function partial($partial, $data = [])
    {
        return self::render('partials/' . $partial, $data);
    }
    
    /**
     * Render component with specific data
     * 
     * @param string $component Component name
     * @param array $data Component data
     * @return string Rendered component HTML
     */
    public static function component($component, $data = [])
    {
        return self::render('components/' . $component, $data);
    }
    
    /**
     * Escape HTML output for security
     * 
     * @param string $value Value to escape
     * @return string Escaped value
     */
    public static function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Check if view exists
     * 
     * @param string $view View file path
     * @return bool True if view exists
     */
    public static function exists($view)
    {
        $viewPath = self::getViewPath($view);
        return file_exists($viewPath);
    }
    
    /**
     * Get view content without rendering (useful for emails, etc.)
     * 
     * @param string $view View file path
     * @param array $data Data to pass to view
     * @return string Raw view content
     */
    public static function getContent($view, $data = [])
    {
        // Extract data to variables
        if (!empty($data)) {
            extract($data);
        }
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewPath = self::getViewPath($view);
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            throw new \Exception("View file not found: {$viewPath}");
        }
        
        return ob_get_clean();
    }
    
    /**
     * Share data across all views (global data)
     * 
     * @param string|array $key Key or array of key-value pairs
     * @param mixed $value Value (if key is string)
     */
    public static function share($key, $value = null)
    {
        static $sharedData = [];
        
        if (is_array($key)) {
            $sharedData = array_merge($sharedData, $key);
        } else {
            $sharedData[$key] = $value;
        }
        
        return $sharedData;
    }
    
    /**
     * Get shared data
     * 
     * @param string|null $key Specific key to get (null for all)
     * @return mixed Shared data
     */
    public static function getShared($key = null)
    {
        static $sharedData = [];
        
        if ($key === null) {
            return $sharedData;
        }
        
        return $sharedData[$key] ?? null;
    }
    
    /**
     * Render view with shared data
     * 
     * @param string $view View file path
     * @param array $data Additional data
     * @param string|null $layout Layout file
     * @return string Rendered HTML
     */
    public static function renderWithShared($view, $data = [], $layout = null)
    {
        // Merge shared data with view data
        $sharedData = self::getShared();
        $mergedData = array_merge($sharedData, $data);
        
        return self::render($view, $mergedData, $layout);
    }
}
