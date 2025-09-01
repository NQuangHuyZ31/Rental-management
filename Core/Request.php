<?php

/*
* Author: Huy Nguyen
* Date: 2025-09-01
* Purpose: Request
*/

namespace Core;

class Request
{
    private $get;
    private $post;
    private $files;
    private $method;
    private $uri;
    
    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '/';
    }
    
    public function getMethod()
    {
        return $this->method;
    }
    
    public function isMethod($method)
    {
        return strtoupper($method) === $this->method;
    }
    
    public function isGet()
    { 
        return $this->isMethod('GET'); 
    }
    
    public function isPost()
    { 
        return $this->isMethod('POST'); 
    }
    
    public function isAjax()
    { 
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'; 
    }
    
    public function getUri()
    {
        $uri = parse_url($this->uri, PHP_URL_PATH);
        return $uri ?: '/';
    }
    
    public function get($key = null, $default = null)
    {
        if ($key === null) {
            return $this->get;
        }
        return $this->get[$key] ?? $default;
    }
    
    public function post($key = null, $default = null)
    {
        if ($key === null) {
            return $this->post;
        }
        return $this->post[$key] ?? $default;
    }
    
    public function input($key = null, $default = null)
    {
        $data = array_merge($this->get, $this->post);
        
        if ($key === null) {
            return $data;
        }
        return $data[$key] ?? $default;
    }
    
    public function has($key)
    {
        return $this->input($key) !== null;
    }
    
    public function filled($key)
    {
        $value = $this->input($key);
        return $value !== null && $value !== '';
    }
    
    public function file($key)
    {
        return $this->files[$key] ?? null;
    }
    
    public function hasFile($key)
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] !== UPLOAD_ERR_NO_FILE;
    }
    
    public function all()
    {
        return [
            'method' => $this->method,
            'uri' => $this->uri,
            'get' => $this->get,
            'post' => $this->post,
            'files' => $this->files,
        ];
    }
    
    /**
     * Redirect về route với data
     */
    public function redirect($route, $data = [], $statusCode = 200)
    {
        // Lưu data vào session flash
        if (!empty($data)) {
            $this->setFlashData($data);
        }
        
        // Set HTTP status code
        http_response_code($statusCode);
        
        // Redirect
        header("Location: " . $this->buildUrl($route));
        exit();
    }
    
    /**
     * Redirect về route trước đó với data
     */
    public function back($statusCode = 200)
    {
        $referer = $this->getReferer();
        if ($referer) {
            $this->redirect($referer, [], $statusCode);
        } else {
            $this->redirect('/', $statusCode);
        }
    }
    
    /**
     * Redirect với success message
     */
    public function redirectWithSuccess($route, $message)
    {
        $data['success'] = $message;
        $this->redirect($route, $data, 200);
    }
    
    /**
     * Redirect với error message
     */
    public function redirectWithError($route, $message)
    {
        $data['error'] = $message;
        $this->redirect($route, $data, 400);
    }
    
    /**
     * Redirect với validation errors
     */
    public function redirectWithErrors($route, $errors)
    {
        $data = [
            'errors' => $errors,
            'old' => $this->post()
        ];
        $this->redirect($route, $data, 400);
    }
    
    /**
     * Lấy referer URL
     */
    public function getReferer()
    {
        return $_SERVER['HTTP_REFERER'] ?? null;
    }
    
    /**
     * Xây dựng URL từ route
     */
    private function buildUrl($route, $statusCode = 400)        
    {
        $queryParams = $this->get();
        // Nếu route là URL đầy đủ
        if (filter_var($route, FILTER_VALIDATE_URL)) {
            $url = $route;
        } else {
            // Nếu route là relative path
            $baseUrl = $this->getBaseUrl();
            $route = ltrim($route, '/');
            $url = $baseUrl . '/' . $route;
        }
    
        // Thêm query parameters
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }
        
        return $url;
    }
    
    /**
     * Lấy base URL
     */
    private function getBaseUrl()
    {
        $url = BASE_URL;
        return $url;
    }
    
    /**
     * Kiểm tra có phải HTTPS
     */
    private function isSecure()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
               (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    }
    
    /**
     * Lưu flash data vào session
     */
    private function setFlashData($data)
    {        
        Session::set('flash_data', $data);
    }
    
    /**
     * Lấy flash data từ session
     */
    public function getFlashData($key = null)
    {
        
        if (Session::has('flash_data')) {
            if ($key === null) {
                $data = Session::get('flash_data');
                Session::delete('flash_data');
                return $data;
            }else{
                $data = Session::get('flash_data');
                Session::delete('flash_data');
                return $data[$key];
            }
        }
        
        return null;
    }
    
    /**
     * Kiểm tra có flash data
     */
    public function hasFlashData($key = null)
    {
        Session::start();
        
        if ($key === null) {
            return Session::has('flash_data');
        }
        
        return Session::has('flash_data', $key);
    }
}
