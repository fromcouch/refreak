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
     * Database parameters
     * 
     * @var array
     * @access protected 
     */
    public $rfk_db           = null;
    
    public $connection_error    = '';


    /**
     * Constructor
     */
    public function __construct() {
       
        // get actual dir
        $this->actual_dir = dirname(__FILE__);
        
        //calculate config directory
        $this->config_dir = realpath($this->actual_dir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'config');
        
        define('BASEPATH','1');
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
    
    public function check_database_parameters() {
        
        $db_param = FALSE;
        
        if ($this->check_database_file()) {
            
            include ($this->config_dir . DIRECTORY_SEPARATOR . 'database.php');
            $this->rfk_db = $db[$active_group];
            
            if (!empty($db[$active_group]['hostname']) &&
                !empty($db[$active_group]['username']) &&
                !empty($db[$active_group]['password']) &&
                !empty($db[$active_group]['database']) &&
                !empty($db[$active_group]['dbprefix'])) {
                
                $db_param = TRUE;
            }
            
        }
        
        $this->can_be_installed = $this->can_be_installed && $db_param;
        
        return $db_param;
        
    }
    
    public function check_config_parameters() {
        
        $config_param = FALSE;
        
        if ($this->check_config_file()) {
            
            include($this->config_dir . DIRECTORY_SEPARATOR . 'config.php');
            
            if (!empty($config['base_url'])) {
                
                $config_param = TRUE;
                
            }
            
        }
        
        $this->can_be_installed = $this->can_be_installed && $config_param;
        
        return $config_param;
        
    }
    
    public function check_connection() {
        
        $connection = FALSE;
        
        $con = mysqli_connect($this->rfk_db['hostname'], $this->rfk_db['username'], $this->rfk_db['password'], $this->rfk_db['database']);
        
        if (mysqli_connect_errno($con)) {
            $this->connection_error = mysqli_connect_error();
        } 
        else { 
            $connection = TRUE;
        }
        
        $this->can_be_installed = $this->can_be_installed && $connection;
        
        return $connection;
    }
    
}


/* End of file Install.php */
/* Location: ./install/Install.php */