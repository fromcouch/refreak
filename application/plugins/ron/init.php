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
       
        /**
         * I attach method to add our function to event
         */        
        $this->attach('base_set_theme', function ($evt, $data) {
            
            return $data;
            
        });
        
        /**
         * I have another way to add function to event
         */        
        $this->attach('base_create_right_menu', array($this, 'menu_logout'));
        
        $this->activate_lib_mode();
    }
    
    /**
     * Add logout menu 
     * 
     * @param string $evt Event name
     * @param mixed $data Data sended to Event
     * @return mixed data to return
     */
    public function menu_logout($evt, $data) {
       
        $ci =& get_instance();
        $ci->lang->load('layout/header');
        
        array_unshift($data, anchor(site_url() . 'auth/logout', $this->lang->line('header_logout')));
        
        
        return $data;
        
    }
        
}