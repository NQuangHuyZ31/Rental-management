<?php

namespace Core;

class ViewRender
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
    
    /** XSS security
     * Escape HTML output for security
     * 
     * @param string $value Value to escape
     * @return string Escaped value
     */
    public static function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }   
}