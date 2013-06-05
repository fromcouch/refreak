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
     * @access public
     */
    public $rfk_db              = null;
    
    /**
     * Database parameters for Taskfreak!
     * 
     * @var array
     * @access public
     */
    public $frk_db              = null;
    
    /**
     * Conection error Message
     * 
     * @var string 
     * @access public
     */
    public $connection_error    = '';

    /**
     * MySQLi Connection
     * 
     * @var object 
     */
    public $mys                 = null;
    
    /**
     * Array of existing Tables
     * 
     * @var array
     */
    public $tables              = null;

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
    
    /**
     * Check for Database parameters
     * 
     * @return boolean
     * @access public
     */
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
            
            if (!empty($db['import_tf']['hostname']) &&
                !empty($db['import_tf']['username']) &&
                !empty($db['import_tf']['password']) &&
                !empty($db['import_tf']['database']) &&
                !empty($db['import_tf']['dbprefix'])) {
                
                $this->frk_db = $db['import_tf'];
            }
            
        }
        
        $this->can_be_installed = $this->can_be_installed && $db_param;
        
        return $db_param;
        
    }
    
    /**
     * Check for configuration parameters
     * 
     * @return boolean
     * @access public
     */
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
    
    /**
     * Check for Database Connection
     * 
     * @return boolean
     * @access public
     */
    public function check_connection() {
        
        $connection         = FALSE;
        
        $msi                = $this->connect($this->rfk_db);
        
        if ($msi->connect_errno) {
            $this->connection_error = $msi->connect_error;
        } 
        else { 
            $connection     = TRUE;
            $this->mys      = $msi;
            $this->show_tables();
        }
        
        $this->can_be_installed = $this->can_be_installed && $connection;
        
        return $connection;
    }
    
    /**
     * Get Table List from Database
     * 
     * @return void
     * @access public
     */
    private function show_tables() {
        
        $result             = $this->mys->query('SHOW TABLES');
        
        $this->tables       = array();
        while ($row = $result->fetch_row()) {
            $this->tables []= $row[0];
        }
        
    }
    
    /**
     * Connect to Database
     * 
     * @param array $config Configuration for connection
     * @return \mysqli
     * @access private
     */
    private function connect($config) {
        $msi                = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);
        
        return $msi;
    }
    
    /**
     * Execute a SQL Sentence
     * 
     * @param string $sql SQL Sentence
     * @return boolean True for Success, False when fail
     * @access public
     */
    public function install_table($sql) {
        
        return (bool)$this->mys->query($sql);
        
    }
    
    /**
     * Check for Taskfreak Tables in DB 
     * 
     * @return boolean
     * @access public
     */
    public function check_tf_exists_tables() {
        
        $this->check_database_parameters(); //dependency
        $this->check_connection(); //dependency
        
        //first looking in same database
        //for frk_item (task table)
        if(is_array($this->tables) && array_search('frk_item', $this->tables) !== FALSE) {
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * Check for Taskfreak Configuration 
     * 
     * @return boolean
     * @access public
     */
    public function check_tf_exists_config() {
       
        $this->check_database_parameters(); //dependency
        
        //look for existing config
        if (!is_null($this->frk_db)) {
            return TRUE;
        }
        
        return FALSE;
    }    
    
    /**
     * Check for Taskfreak Database Connection
     * 
     * @return boolean
     * @access public
     */
    public function check_tf_exists_connection() {
    
        $connected      = FALSE;
        $msi            = $this->connect($this->frk_db);

        if (!$msi->connect_errno) {                                    
            $connected  = TRUE;
        }
        
        $msi->close();
        return $connected;
        
    }
    
    public function __destruct() {
        
        if (!is_null($this->mys))
            $this->mys->close();
        
    }
}

/* End of file Install.php */
/* Location: ./install/Install.php */