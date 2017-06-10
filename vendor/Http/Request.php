<?php

namespace Phphilosophy\Http;

use Phphilosophy\Http\Interfaces\{InputInterface,SessionInterface};

/**
 * Phphilosophy Request
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2017 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 */
class Request {
    
    /**
     * @var string
     */
    private $method;
    
    /**
     * @var string
     */
    private $uri;
    
    /**
     * @var     array   Array with get/post data
     */
    private $input = [];
    
    /**
     * @var \Phphilosophy\Http\Interfaces\SessionInterface
     */
    private $session;
    
    /**
     * Saves the request data into an array
     * @return  void
     */
    protected function setRequest()
    {
        // The HTTP request URI
        $this->uri = $_SERVER['REQUEST_URI'];
        
        // The HTTP request method
        $this->method = $_SERVER['REQUEST_METHOD'];
        
        // The query string (with GET data)
        $this->input['get'] = $_GET;
        
        // The PHP Input Stream (with POST data)
        $this->input['post'] = $_POST;
        
        // Set the session class
        $this->session = new Session();
    }
    
    public function __construct() {
        $this->setRequest();
    }
    
    /**
     * Retrieves the HTTP method of the request.
     * @return  string  Returns the request method.
     */
    public function getMethod() {
        return $this->method;
    }
    
    /**
     * Returns the request URI as a string
     * @return  string  The request uri
     */
    public function getRequestTarget() {
        return $this->uri;
    }
    
    /**
     * Returns the segments of the request URI
     * @return  array   The array with URI segments
     */
    public function uriSegments()
    {
        $uri = new Uri($this->uri);
        return $uri->getSegments();
    }
    
    /**
     * @param   string|null $key        GET|POST-key
     * @param   mixed|null  $default    default value
     * @param   string      $method     method
     * @return  mixed|array
     */
    private function getInput($key = null, $default = null, $method = 'get')
    {        
        // Checks, whether a specific value was requested
        if (isset($key)) {
            
            // Does the requested value exist?
            if (isset($this->input[$method][$key])) {
                
                // Positive: return the value
                return $this->input[$method][$key];  
            } 
            
            // Negative: the default value
            return $default;
        }
            
        // return the entire array
        return $this->input[$method];
    }
    
    /**
     * @param   string|null $key        get key
     * @param   mixed|null  $default    default value
     * @return  mixed|array
     */
    public function get($key = null, $default = null) {
        return $this->getInput($key, $default);
    }
    
    /**
     * @param   string|null $key        get key
     * @param   mixed|null  $default    default value
     * @return  mixed|array
     */
    public function post($key = null, $default = null) {
        return $this->getInput($key, $default, 'post');
    }
    
    /**
     * @param   string  $key
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function session($key = null, $default = null) {
        return $this->session->get($name, $default);
    }
}
