<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Plugin Controller
 *
 * @package	Refreak
 * @subpackage	plugin
 * @category	controller
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Plugin extends RF_Controller {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->lang->load('plugin');
        
        //$this->output->enable_profiler(TRUE);
        
        $this->plugin_handler->trigger('plugin_pre_init');
        
        $this->data['message']              = ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'));
    }
    
    /**
     * Show table plugin list
     * 
     * @return void 
     * @access public
     */
    public function index() {
    
        $this->load->model('plugin_handler_model');
        
        $plugins		    = $this->plugin_handler_model->get_plugin_list();
	
		foreach ($plugins as $plg) {
			$plg->dir_exists = 1;
			if (!is_dir(FCPATH . 'plugins' . DIRECTORY_SEPARATOR . $plg->directory)) {
			//means plugin don't exist
			$plg->dir_exists = 0;
			}
			$plg->installed = 1;
		}

		$copied_plugins         = scandir(FCPATH . 'plugins' . DIRECTORY_SEPARATOR);
        $copied_plugins         = array_diff($copied_plugins, array('..', '.')); //remove . and ..
                
        foreach ($copied_plugins as $cp) {
			$found = FALSE;	    

				//search inside plugin object array
			foreach ($plugins as $plg) {
				if ($plg->directory == $cp) {
					$found = TRUE;
					break;		
				}
			}

			if (!$found) {
				
				$p					= new stdClass();
				
				if (is_file(FCPATH . 'plugins' . DIRECTORY_SEPARATOR . $cp . DIRECTORY_SEPARATOR . 'install.json')) {
					$install_json	= file_get_contents(FCPATH . 'plugins' . DIRECTORY_SEPARATOR . $cp . DIRECTORY_SEPARATOR . 'install.json');
					$plg_install	= json_decode($install_json);
					$p->name			= $plg_install->plugin_name;
					$p->directory		= $cp;
					$p->active			= 0;
					$p->id				= 0;
					$p->controller_name = $plg_install->controller;
					$p->dir_exists	    = 1;
					$p->installed	    = 0;
				}
				else {
					
					$p->name			= $cp;
					$p->id				= 0;
					$p->directory	    = $cp;
					$p->active			= 0;
					$p->controller_name = '';
					$p->dir_exists	    = 1;
					$p->installed	    = 0;
				}
				$plugins		  []= $p;
			}
	    
        }
	
        $this->data['plugins']      = $plugins;
        
        $this->load->view('plugin/plugin', $this->data);
        
    }
    
    /**
     * Activate plugin
     * 
     * @param int $id plugin id
     * @return void 
     * @access public
     */
    public function activate($id) {
                
        if ($this->ion_auth->is_admin()) {
            $this->load->model('plugin_handler_model');
            
            $this->plugin_handler_model->activate($id);
            $this->session->set_flashdata('message', $this->lang->line('pluginsmessage_activated'));
        }
        else {
            $this->session->set_flashdata('message', $this->lang->line('pluginsmessage_noway'));
        }
        
        
        redirect("plugin", 'refresh');
    }
    
    /**
     * Deactivate plugin
     * 
     * @param int $id plugin id
     * @return void 
     * @access public
     */
    public function deactivate($id) {
                
        if ($this->ion_auth->is_admin()) {
            $this->load->model('plugin_handler_model');
            
            $this->plugin_handler_model->deactivate($id);
            
        }
        else {
            $this->session->set_flashdata('message', $this->lang->line('pluginsmessage_noway'));
        }
        
        
        redirect("plugin", 'refresh');
    }
 
    /**
     * Install Plugin
     * 
     * @param string $dir Plugin directory
     * @return void
     * @access public
     */
    public function install($dir) {
        
		if ($this->ion_auth->is_admin()) {
			$this->load->model('plugin_handler_model');

			if (is_dir(FCPATH . 'plugins' . DIRECTORY_SEPARATOR . $dir)) {

				$name		= $dir;
				$clase		= $dir;
				$controller	= 'all';

				if (is_file(FCPATH . 'plugins' . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . 'install.json')) {
					$install_json	= file_get_contents(FCPATH . 'plugins' . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . 'install.json');
					$plg_install	= json_decode($install_json);

					$name		= property_exists($plg_install, 'plugin_name') ? $plg_install->plugin_name : $dir;
					$clase		= property_exists($plg_install, 'class') ? $plg_install->class : $dir;
					$controller	= property_exists($plg_install, 'controller') ? $plg_install->controller : 'all';
				}

				$this->plugin_handler_model->install($name, $dir, $clase, $controller);
			}
			$this->session->set_flashdata('message', $this->lang->line('pluginsmessage_installed'));
		}
		else {
				$this->session->set_flashdata('message', $this->lang->line('pluginsmessage_noway'));
		}	
	
		redirect("plugin", 'refresh');
    }
    
    /**
     * Shows plugin edit page
     * 
     * @param int $id plugin identificator
     * @return void
     * @access public
     */
    public function config($id) {
        
		if ($this->ion_auth->is_admin()) {
			$this->load->model('plugin_handler_model');
			$plugin                 = $this->plugin_handler_model->get_plugin($id);
			$plugin                 = $plugin[0];
			$plugin_path            = FCPATH . 'plugins' . DIRECTORY_SEPARATOR . $plugin->directory  . DIRECTORY_SEPARATOR ;


			if ($this->input->post(NULL, TRUE) !== FALSE) {
				$data = $this->input->post(NULL, TRUE);
				unset($data['submit']); //remove button data

				$this->plugin_handler_model->set_data_plugin($id, $data);
			}
			
			$this->data['config']       = $this->plugin_handler_model->load_config($id, $plugin_path);

			if (file_exists($plugin_path . 'edit.php'))
			{
				$this->data['form']     = $plugin_path . 'edit.php';
			}
			
			//look for class
			$plg_class		= $plugin->class;

			//if exist edit method
			if (method_exists($plg_class, 'edit')) {
				$plg_class::getInstance(null)->edit();	//load class and execute edit method before load view
			}
			
			$this->data['plg']      = $plugin;
		}
		else {
				$this->session->set_flashdata('message', $this->lang->line('pluginsmessage_noway'));
		}	

		$this->load->view('plugin/config', $this->data);
        
    }
    
    /**
     * Delete Plugin
     * 
     * @param int $id plugin identificator
     * @return void
     * @access public
     */
    public function delete($id) {
	
		if ($this->ion_auth->is_admin()) {
            $this->load->model('plugin_handler_model');
            
			$plugin_dir         = FCPATH . 'plugins' . DIRECTORY_SEPARATOR;
			$plugin				= $this->plugin_handler_model->get_plugin($id);
	    
            $this->plugin_handler_model->deactivate($id);
            $this->plugin_handler_model->uninstall($id);
	   
			if (is_object($plugin[0]) && !empty($plugin[0]->directory) &&
				is_dir($plugin_dir . $plugin[0]->directory)) {
		
				$this->load->helper('file');
				delete_files($plugin_dir . $plugin[0]->directory, TRUE);
			}
	    
			$this->session->set_flashdata('message', $this->lang->line('pluginsmessage_uninstalled'));
        }
        else {
            $this->session->set_flashdata('message', $this->lang->line('pluginsmessage_noway'));
        }
	
	redirect("plugin", 'refresh');
    }
}
