<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Refreak Plugin Handler Library
 *
 * @package	Refreak
 * @subpackage	plugin
 * @category	library
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Plugin_handler {
    
    /**
     * Store array events 
     * 
     * @var array Events list
     */
    protected $events = array();
    
    /**
     * Code Igniter reference for callback functions
     * 
     * @var object CI Instance
     */
    protected $_ci = null;
    
    /**
     * plugin list to be executed on init
     * 
     * @var array Clases array 
     */
    protected $_plugins_loaded = array();
    
    /**
     * Constructor
     */
    public function __construct() {

        $this->_ci              =& get_instance();

        //
                
        //load plugin base
        $this->_ci->load->file(APPPATH . 'core' . DIRECTORY_SEPARATOR . 'RF_Plugin.php');
        
        // detecting controller
        $controller             = $this->_ci->router->fetch_class();
        
        // load plugins
        $this->load_plugins($controller);               
        
    }
    
    /**
     * Load plugins. THis function look $controller var for load only plugins 
     * associated to the controller.
     * 
     * @param string $controller Name of the loaded controller.
     * @return void
     * @access public
     */
    protected function load_plugins($controller) {
        
        $this->_ci->load->model('plugin_handler_model');
        $plugins                = $this->_ci->plugin_handler_model->get_plugins($controller);
                
        
        foreach ($plugins as $plugin) {            
            if (is_dir(APPPATH . 'plugins' . DIRECTORY_SEPARATOR . $plugin->directory)) {
                include(APPPATH . 'plugins' . DIRECTORY_SEPARATOR . $plugin->directory . DIRECTORY_SEPARATOR . 'init.php');
                $class_name     = ucfirst($plugin->directory);

                $this->_plugins_loaded []= $class_name;
		
		//look for language file
		$this->_ci->lang->load( $plugin->directory , '' , FALSE , TRUE , APPPATH . 'plugins' . DIRECTORY_SEPARATOR . $plugin->directory . DIRECTORY_SEPARATOR);
            }
        }
        
    }
    
    /**
     * Initialize all plugins
     * 
     * @return void
     * @access public
     */
    public function initialize_plugins() {
        
        foreach ($this->_plugins_loaded as $class) {
            new $class;
        }
        
    }
    
    /**
     * Attach Event 
     * 
     * @param string $event_name Event name
     * @param object $callback Function to execute
     * @param string $offset function name. If you want dettach you need specify this
     * @return void
     * @access public
     */
    public function attach($event_name, $callback, $offset = null) {
        
        if (!isset($this->events[$event_name])) {
            $this->events[$event_name]                  = array();
        }
        
        if (!is_null($offset)) {
            $this->events[$event_name][$offset]         = $callback;
	}
        else {
            $this->events[$event_name][]                = $callback;
	}
        
    }
    
    /**
     * Dettach Event
     * 
     * @param string $event_name Event name
     * @param string $offset function to dettach
     * @return void
     * @access public
     */
    public function dettach($event_name, $offset) {
        
        if (!isset($this->events[$event_name][$offset])) {
            unset($this->events[$event_name][$offset]);
        }
        
    }
    
    /**
     * Launch functions from specified event
     * 
     * @param string $event_name Event name          
     * @param string $data Data to send to function
     * @return mixed return data processed
     * @access public
     */
    public function trigger($event_name, $data = null) {
        
        if (isset($this->events[$event_name])) {
        
            foreach ($this->events[$event_name] as $callback) {

                if (is_callable($callback)) { //call                    
                    $data           = call_user_func_array($callback, array($event_name, $data));
                }
            }

        }
        return $data;
    }
    
}
