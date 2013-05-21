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
        
        $this->_ci = &get_instance(); 
        
    }
    
    public function init() {
        
    }
}

/* End of file RF_Plugin.php */
/* Location: ./application/core/RF_Plugin.php */