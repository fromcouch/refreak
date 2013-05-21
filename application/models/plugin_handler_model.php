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
    
    public function get_plugins($controller) {
        
        return $this->db
                ->select('plugins.name, plugins.directory')
                ->join('plugin_controller pc', 'pc.plugin_id = plugins.id', 'left')
                ->join('controllers c', 'pc.controller_id = c.id OR pc.controller_id = 0', 'left')
                ->where('c.controller_name', $controller)
                ->where('plugins.active', 1)
                ->get('plugins')
                ->result_object();
        
    }
}

/* End of file plugin_handler_model.php */
/* Location: ./application/models/plugin_handler_model.php */