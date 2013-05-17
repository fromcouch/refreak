<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Plugin Handler Model
 *
 * @package	Refreak
 * @subpackage	plugin
 * @category	model
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class plugin_handler_model extends CI_Model  {
    
    /**
     * Constructor
     */    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function get_plugins($controller) {
        
        return $this->db
                ->select('name, directory')
                ->join('plugin_controller pc', 'pc.plugin_id = p.id', 'inner')
                ->join('controller c', 'pc.controller_id = c.id', 'inner')
                ->where('c.controller_name', $controller)
                ->from('plugins')
                ->result_object();
        
    }
}

?>
