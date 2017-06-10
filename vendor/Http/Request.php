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
     * @var \Phphilosophy\Http\Interfaces\InputInterface
     */
    private $input;
    
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
        
        // Add GET and POST input
        $this->input = new Input($_GET, $_POST);
        
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
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function get(string $name = null, $default = null) {
        return $this->input->get($name, $default);
    }

    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function post(string $name = null, $default = null) {
        return $this->input->post($name, $default);
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
