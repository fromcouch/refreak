<?php
/**
 * 11/04/2004
 */
/**
 * Install Class
 *
 * @package	Refreak
 * @subpackage	installer
 * @category	class
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Install {
    
    /**
     * Actual directory 
     * 
     * @var string  
     */
    public $actual_dir      = '';
    
    /**
     * Config directory
     * 
     * @var string 
     */
    public $config_dir      = '';
    
    public function __construct() {
       
        // get actual dir
        $this->actual_dir = dirname(__FILE__);
        
        //calculate config directory
        $this->config_dir = realpath($this->actual_dir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'config');
        
    }
    
    public function check_layout_file() {
        
        return file_exists($this->config_dir . DIRECTORY_SEPARATOR . 'layout.php');
        
    }
    
    public function check_refreak_file() {
        
        return file_exists($this->config_dir . DIRECTORY_SEPARATOR . 'refreak.php');
        
    }
    
    public function check_config_file() {
        
        return file_exists($this->config_dir . DIRECTORY_SEPARATOR . 'config.php');
        
    }
    
    public function check_database_file() {
        
        return file_exists($this->config_dir . DIRECTORY_SEPARATOR . 'database.php');
        
    }
    
    
}


/* End of file Install.php */
/* Location: ./install/Install.php */