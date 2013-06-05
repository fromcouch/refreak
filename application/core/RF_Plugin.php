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
    
    public function __construct() {
        $this->_ci =& get_instance(); 
        $this->_ci->load->library('plugin_handler');        
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
 
    protected function activate_lib_mode() {
        
        $this->_ci->load->add_package_path(APPPATH . 'plugin' . DIRECTORY_SEPARATOR);
        
    }
}

/* End of file RF_Plugin.php */
/* Location: ./application/core/RF_Plugin.php */