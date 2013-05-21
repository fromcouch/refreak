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
    
    protected function init() {
        
        
        
    }
    
    
    public function attach($event_name, $callback, $offset = null) {
        
//        if (is_null($this->_ci)) {
//            $this->init();            
//        }
        
        $this->_ci->plugin_handler->attach($event_name, $callback, $offset);
        
    }
    
    
    public function dettach($event_name, $offset = null) {
        
//        if (is_null($this->_ci)) {
//            $this->init();            
//        }
        
        $this->_ci->plugin_handler->dettach($event_name, $offset);
        
    }
    
    
}

/* End of file RF_Plugin.php */
/* Location: ./application/core/RF_Plugin.php */