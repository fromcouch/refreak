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
     * @access public
     */
    public $actual_dir      = '';
    
    /**
     * Config directory
     * 
     * @var string 
     * @access public
     */
    public $config_dir      = '';
    
    /**
     * Determine if refreak can be installed or not
     * 
     * @var boolean
     * @access public 
     */
    public $can_be_installed    = true;
    
    /**
     * Config application
     * 
     * @var array 
     * @access protected
     */
    protected $rfk_config       = null;
    
    /**
     * Database parameters
     * 
     * @var array
     * @access protected 
     */
    protected $rfk_db           = null;
    
    
    
    /**
     * Constructor
     */
    public function __construct() {
       
        // get actual dir
        $this->actual_dir = dirname(__FILE__);
        
        //calculate config directory
        $this->config_dir = realpath($this->actual_dir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'config');
        
    }
    
    /**
     * Check for layout config file
     * 
     * @return boolean
     * @access public
     */
    public function check_layout_file() {
        
        return file_exists($this->config_dir . DIRECTORY_SEPARATOR . 'layout.php');
        
    }
    
    /**
     * Check for refreak config file
     * 
     * @return boolean
     * @access public
     */
    public function check_refreak_file() {
        
        return file_exists($this->config_dir . DIRECTORY_SEPARATOR . 'refreak.php');
        
    }
    
    /**
     * Check for application config file
     * 
     * @return boolean
     * @access public
     */
    public function check_config_file() {
        
        $config_exist = file_exists($this->config_dir . DIRECTORY_SEPARATOR . 'config.php');
        
        $this->can_be_installed = $this->can_be_installed && $config_exist;
        
        return $config_exist;
        
    }
    
    /**
     * Check for database config file
     * 
     * @return boolean
     * @access public
     */
    public function check_database_file() {
        
        $db_exist = file_exists($this->config_dir . DIRECTORY_SEPARATOR . 'database.php');
        
        $this->can_be_installed = $this->can_be_installed && $db_exist;
        
        return $db_exist;
        
    }
    
    
}


/* End of file Install.php */
/* Location: ./install/Install.php */