<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Refreak Base Plugin
 *
 * @package	Refreak
 * @subpackage	base
 * @category	plugin
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 *  
 */
class RF_Plugin {
    
    /**
     * CodeIgniter Base object
     * 
     * @var object 
     */
    public $_ci = null;
    
    /**
     * Singleton instance variable
     * 
     * @var object instance for singleton 
     */
    protected static $instances = array();
    
	/**
	 * Plugin Id
	 * 
	 * @var string
	 */
	protected $plugin_id;
	
	/**
	 * Plugin Name
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * Plugin Directory
	 * 
	 * @var string
	 */
	protected $directory;
	
	/**
	 * Original plugin class name
	 * 
	 * @var string
	 */
	protected $class;
	
	/**
	 * Plugin configuration
	 * 
	 * @var string
	 */
	protected $config;
	
    final public static function getInstance( $plugin_data ) {

        $calledClass = get_called_class();

        if (!isset(self::$instances[$calledClass]))
        {
            self::$instances[$calledClass] = new $calledClass();
        }

		if ( !is_null($plugin_data) )
			self::$instances[$calledClass]->plugin_data( $plugin_data );
		
        return self::$instances[$calledClass];
    }
    
	/**
	 * clone function
	 */
	final private function __clone() {}
	
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance(); 
        //$this->_ci->load->library('plugin_handler');        
    }
	
	/**
	 * Add plugin data to object
	 * 
	 * @param object $plugin Plugin data
	 * @return void
	 * @access private
	 */
	private function plugin_data($plugin) {
		
		$this->plugin_id	= $plugin->id;
		$this->name			= $plugin->name;
		$this->directory	= $plugin->directory;
		$this->class		= $plugin->class;
		$this->config		= $plugin->data;
		
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
               
        $this->_ci->plugin_handler->attach($event_name, $callback, $offset);
        
    }
    
    /**
     * Dettach Event
     * 
     * @param string $event_name Event name
     * @param string $offset function to dettach
     * @return void
     * @access public
     */
    public function dettach($event_name, $offset = null) {
               
        $this->_ci->plugin_handler->dettach($event_name, $offset);
        
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
        
        return $this->_ci->plugin_handler->trigger($event_name, $data);
        
    }
 
    /**
     * Activate MVC for a plugin
     * 
     * @param string $name plugin name
     * @return void
     * @access protected
     * @deprecated
     */
    private function activate_lib_mode($name) {
        
	$name = strtolower($name);
	
        $this->_ci->load->add_package_path(APPPATH . 'plugin' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR);
        
    }
    
    /**
     * Add js file to view
     * 
     * @param string $js full url path to js
     * @return void
     * @access public
     */
    public function js_add($js) {
	    
	    $this->_ci->javascript->js->script( $js );
	    
    }
    
    /**
     * Add css style to view
     * 
     * @param string $css full url path to css
     * @param string $key key to group some css. You can't remove css from queue without key
     * @return void
     * @access public
     */
    public function css_add($css, $key = null) {
	    
	    $this->_ci->css->add_style( $css, $key );
	    
    }
    
    /**
     * Remove css from queue
     * 
     * @param string $key key to remove. Can content some css files.
     * @return void
     * @access public
     */
    public function css_remove($key) {
	    
	    $this->_ci->css->remove_style( $key );
	    
    }
	
	/**
	 * Load language file for plugin
	 * 
	 * @param string $lang_file Language file
	 * @return void
	 * @access public
	 */
	public function lang_load($lang_file) {
		//look for language file
		$this->_ci->lang->load( $lang_file, '' , FALSE , TRUE , FCPATH . 'plugins' . DIRECTORY_SEPARATOR . $this->directory . DIRECTORY_SEPARATOR);
	}
}

/* End of file RF_Plugin.php */
/* Location: ./application/core/RF_Plugin.php */