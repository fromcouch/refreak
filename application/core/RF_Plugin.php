<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
    
    public function init() {
        
    }
    
    
    public function attach($event_name, $callback, $offset = null) {
        
        $this->_ci->plugin_handler->attach($event_name, $callback, $offset);
        
    }
    
    
    public function dettach($event_name, $offset = null) {
        
        $this->_ci->plugin_handler->dettach($event_name, $offset);
        
    }
    
    
}

/* End of file RF_Plugin.php */
/* Location: ./application/core/RF_Plugin.php */