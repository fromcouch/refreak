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
        $this->load->database();
    }
    
    
    /**
     * Get plugin list for matched controller
     * 
     * @param string $controller controller to load plugins
     * @return object list of plugins
     */
    public function get_plugins($controller = NULL) {
        
        $this->db
                ->select('plugins.name, plugins.directory')
                ->join('plugin_controller pc', 'pc.plugin_id = plugins.id', 'left')
                ->join('controllers c', 'pc.controller_id = c.id OR pc.controller_id = 0', 'left');
        
        if (!is_null($controller)) {
                $this->db->where('c.controller_name', $controller);
        }
        
        return $this->db->where('plugins.active', 1)
                ->get('plugins')
                ->result_object();
        
    }
    
    
    /**
     * Get plugin list
     * 
     * @return object list of plugins
     */
    public function get_plugin_list() {
        
        $this->db
                ->select('plugins.id, plugins.name, plugins.directory, plugins.active, c.controller_name')
                ->join('plugin_controller pc', 'pc.plugin_id = plugins.id', 'left')
                ->join('controllers c', 'pc.controller_id = c.id', 'left');
        
        return $this->db
                ->get('plugins')
                ->result_object();
        
    }
    
    
    
}

/* End of file plugin_handler_model.php */
/* Location: ./application/models/plugin_handler_model.php */