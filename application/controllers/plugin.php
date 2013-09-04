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
        
        $this->data['plugins']      = $this->plugin_handler_model->get_plugin_list();
        
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
            $this->session->set_flashdata('message', $this->lang->line('pluginsmessage_deactivated'));
        }
        else {
            $this->session->set_flashdata('message', $this->lang->line('pluginsmessage_noway'));
        }
        
        
        redirect("plugin", 'refresh');
    }
 
    public function install() {
        
        $this->load->model('plugin_handler_model');
        $plugins                = $this->plugin_handler_model->get_plugin_list();
        
        $copied_plugins         = scandir(APPPATH . 'plugins' . DIRECTORY_SEPARATOR);
        
        //remove . and ..
        $copied_plugins         = array_diff($copied_plugins, array('..', '.'));
        
        $fisical_plugins        = array();
        foreach ($copied_plugins as $cp) {
            //i need to test if element is directory
            if (is_dir(APPPATH . 'plugins' . DIRECTORY_SEPARATOR . $cp))
            {
                $fisical_plugins []= $cp;
            }
        }
        
        if (count($plugins) != count($fisical_plugins)) {
            //install and uninstall
            
            //look $plugins and match $fisical_plugins, if not, delete from db
            
            //then match $fisical_plugins with $plugins and install not matched plugins
        }
            
        print_r($plugins);
    }
    
    public function config($id) {
        
        $this->load->model('plugin_handler_model');
        $plugins                = $this->plugin_handler_model->get_plugin($id);
        
    }
}