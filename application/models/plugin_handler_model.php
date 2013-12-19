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
		//$this->output->enable_profiler(TRUE);
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
                ->select('plugins.id, plugins.name, plugins.directory, plugins.class')
                ->join('plugin_controller pc', 'pc.plugin_id = plugins.id', 'left')
                ->join('controllers c', 'pc.controller_id = c.id OR pc.controller_id = 0', 'left')
                ->join('plugin_data', 'plugin_data.plugin_id = plugins.id', 'left');
        
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
     * @access public
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
    
    /**
     * Activate plugin
     * 
     * @param int $id plugin id
     * @return void 
     * @access public
     */
    public function activate($id) {
        
        $this->db->update('plugins', array('active' => '1'), array('id' => $id));
        
    }
    
    /**
     * Deactivate plugin
     * 
     * @param int $id plugin id
     * @return void 
     * @access public
     */
    public function deactivate($id) {
        
        $this->db->update('plugins', array('active' => '0'), array('id' => $id));
        
    }
    
    /**
     * Install plugin
     * 
     * @param string $name Plugin name
     * @param string $directory Directory name
     * @param string $clase Class to instantiate
     * @param string $controller Controller where execute plugin
     * @access public
     */
    public function install($name, $directory, $clase, $controller) {
        
        $this->db->insert('plugins', array(
                                        'name'		=> $name,
                                        'directory'	=> $directory,
                                        'class'		=> $clase
                                    )
        );
	
		$controller_id	= 0;
		$id	= $this->db->insert_id();

		if (strtolower($controller) !== 'all') {
			$r	= $this->db
					->select('controllers.id')
					->where('controllers.controller_name', $controller)
					->get('controllers')
					->result();
			print_r($r);
			if (!is_null($r) && is_array($r)) {
				$controller_id	= $r[0]->id;
			}
		}
		$this->db->insert('plugin_controller', array(
											'plugin_id'	=> $id,
											'controller_id'	=> $controller_id
										)
        );
    }
    
    
    /**
     * Uninstall orfan plugin
     * 
     * @param integer $id plugin id
     * @access public
     */
    public function uninstall($id) {
        
        $this->db->delete('plugin_controller', array( 'plugin_id' => $id ));
        $this->db->delete('plugins', array( 'id' => $id ));
        
    }
    
    /**
     * Get a single plugin
     * 
     * @param int $id plugin id
     * @return object plugin
     * @access public
     */
    public function get_plugin($id) {
        
        $this->db
                ->select('plugins.id, plugins.name, plugins.directory, plugins.active, plugins.class, c.controller_name')
                ->join('plugin_controller pc', 'pc.plugin_id = plugins.id', 'left')
                ->join('controllers c', 'pc.controller_id = c.id', 'left')
                ->where('plugins.id', $id);
        
        return $this->db
                ->get('plugins')
                ->result_object();
        
    }
    
    /**
     * Get plugin data from database
     * 
     * @param int $id plugin id
     * @return object data object
     * @access public
     */
    public function get_data_plugin($id) {
        
        $this->db
                ->select('plugin_data.data')
                ->where('plugin_data.plugin_id', $id);
        
        $data =	     $this->db
			    ->get('plugin_data')
			    ->result_object();
	
		if (is_array($data) && count($data) > 0) {
			$data = $data[0];
		}

		if ((is_object($data)) && !empty($data->data)) {
			return json_decode($data->data);
		}
		else {
			return NULL;
		}
    } 
    
    /**
     * Set plugin data from database
     * 
     * @param int $id plugin id
     * @param string $data plugin data
     * @return void
     * @access public
     */
    public function set_data_plugin($id, $data) {
        
        $old_data = $this->get_data_plugin($id);
	
		if (is_null($old_data)) {

			$this->db->insert('plugin_data' , array(
				'plugin_id'	    => $id,
				'data'	    => json_encode( $data )
			));

		}
		else
		{
			$this->db->where('plugin_id', $id);
			$this->db->update('plugin_data', array( 'data' => json_encode($data) ) );
		}
    } 
    
	public function load_config($id, $plugin_path) {
		$default_config	= null;
		
		if (file_exists($plugin_path . 'config.json')) {
			$default_config			    = file_get_contents($plugin_path . 'config.json');
			$default_config				= json_decode($default_config, TRUE);
		}

		$config		    = $this->get_data_plugin($id);

		if (!is_null($config)) {
			$config						= json_decode( json_encode($config) , TRUE);
			$config						= array_merge($default_config, $config);
		}
		else {
			$config						= $default_config;
		}

		return json_decode( json_encode($config) );

			
	}
	
}

/* End of file plugin_handler_model.php */
/* Location: ./application/models/plugin_handler_model.php */