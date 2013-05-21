<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends RF_Plugin {
    
    public function __construct() {
        
        parent::__construct();
        
        $this->attach('base_set_theme', function ($evt, $data) {
            
            return $data;
            
        });
        
        $this->attach('', array($this, 'testing'));
    }
    
    public function testing($evt, $data) {
        
        return $data;
        
    }
        
}