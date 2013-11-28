<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Refreak Plugin Example
 *
 * @package	Refreak
 * @subpackage	plugin
 * @category	plugin
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Example extends RF_Plugin {
    
    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct() {
        
        parent::__construct();
       
    }
	
    /**
	 * Called to initialize plugin
	 * 
	 * @return void
	 * @access public
	 */
	public function initialize() {
		/**
         * I attach method to add our function to event
         */        
        $this->attach('base_set_theme', function ($evt, $data) {
            
            return $data;
            
        });
        
        /**
         * I have another way to add function to event
         */        
        $this->attach('base_create_left_menu', array($this, 'testing'));
	}
	
    /**
     * This is a method added to event in constructor
     * 
     * @param string $evt Event name
     * @param mixed $data Data sended to Event
     * @return mixed data to return
     */
    public function testing($evt, $data) {
        
        $data[anchor('#', 'example plugin menu')] = array( anchor('#', 'Deactivate and this menu hide') );
        
        return $data;
        
    }
        
}