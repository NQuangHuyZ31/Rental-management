<?php

/*
    Author: Huy Nguyen
    Date: 2025-09-01
    Purpose: provide view render functionality
*/

namespace Core;

class ViewRender
{
    /**
     * Render a view with data
     * @return void - Outputs directly to browser
     */
    public static function render($view, $data = [], $layout = null)
    {
        // Extract data to variables for use in view
        if (!empty($data)) {
            extract($data);
        }
        
        // Include the view file directly (no output buffering)
        $viewPath = self::getViewPath($view);
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            throw new \Exception("View file not found: {$viewPath}");
        }
    }


    /** Render a view with layout
     * 
     * Outputs the layout with view content directly to browser
     */
    public static function renderWithLayout($view, $data = [], $layout = null)
    {
        // Extract data to variables for use in layout
        if (!empty($data)) {
            extract($data);
        }
        
        // Start output buffering to capture view content
        ob_start();
        
        // Render the view content first
        self::render($view, $data);
        $content = ob_get_clean();
        
        // Include the layout file (which will use $content variable)
        $layoutPath = self::getViewPath($layout);
        if (file_exists($layoutPath)) {
            include $layoutPath;
        } else {
            throw new \Exception("Layout file not found: {$layoutPath}");
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
        return VIEW_PATH . $view . '.php';
    }
    
    /**
     * Render partial view (reusable component)
     * 
     * @param string $partial Partial view path
     * @param array $data Data to pass to partial
     * @return string    partial HTML
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