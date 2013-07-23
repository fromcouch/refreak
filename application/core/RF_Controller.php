<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Refreak Base Controller
 *
 * @package	Refreak
 * @subpackage	base
 * @category	controller
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 * 
 * @todo change the way that ion_auth return data or write my own auth!
 */
class RF_Controller extends CI_Controller {
    
    public $data = array();

    /**
     * Constructor
     * Init base for refreak
     * 
     * 
     */
    public function __construct()
    {
        parent::__construct();
        
        //$this->output->enable_profiler(TRUE);
        
        //init plugin system
        $this->plugin_handler->initialize_plugins();

        //trigger first event
        $this->plugin_handler->trigger('base_pre_init');
        
        $this->load->helper(array( 'url', 'rfk_plugin' ));
        $this->data['theme']                = $this->config->item('rfk_theme_dir') . '/' . $this->config->item('rfk_theme_selected');
        
        $this->data['theme']                = $this->plugin_handler->trigger('base_set_theme', $this->data['theme']);
        
        if (!$this->ion_auth->logged_in())
        {
                redirect('auth/login');
        }

        $this->lang->load('layout/header');
        $this->lang->load('general');
        $this->lang->load('tasks');
        $this->load->model('user_model');
        $this->load->helper(array('rfk_date', 'html', 'form', 'rfk_form', 'decorators/layout'));
        
        $params                             = $this->_detect_user_project();
        $actual_user                        = $this->plugin_handler->trigger('base_user_loaded', $this->ion_auth->user()->row());
        $actual_user_id                     = $actual_user->id;
        $selected_user                      = 0;
        $selected_context                   = 0;
        $selected_project                   = 0;
        $selected_time                      = 0;
        
        if ($params != false) {
            $selected_user                  = $params['user'];
            $selected_context               = $params['context'];
            $selected_project               = $params['project'];
            $selected_time                  = $params['time'];
        }

        // preparing javascript variables
        $this->data['js_vars'] =         
                    'var user_id    = ' . $selected_user . ";\n" .
                    'var context_id = ' . $selected_context . ";\n" .
                    'var project_id = ' . $selected_project . ";\n" .
                    'var time_concept = ' . $selected_time . ";\n" .
                    'var theme_url  = "' . site_url() . $this->data['theme'] . '";' . "\n" .
                    'var s_url      = "' . site_url() . '";' . "\n"
                ;
        
        // preparing user variables
        $this->data['users']                = $this->user_model->get_all_users_with_group();
        $this->data['actual_user']          = $actual_user;
        $this->data['groups']               = $this->ion_auth->groups()->result_array();
        $this->data['user_projects']        = $this->user_model->get_projects_user($actual_user_id);
        $this->data['menu_left']            = $this->plugin_handler->trigger('base_create_left_menu', $this->_create_left_menu($this->data['user_projects'], $params) );
        $this->data['menu_right']           = $this->plugin_handler->trigger('base_create_right_menu', $this->_create_right_menu($actual_user_id, $params, $selected_user, $selected_context) );
        
        $this->data['js_vars']             .= "\n" .
                    'var genmessage_ajax_error_security    = "' . $this->lang->line('genmessage_ajax_error_security') . "\";\n" .
                    'var genmessage_ajax_error_server    = "' . $this->lang->line('genmessage_ajax_error_server') . "\";\n";
        
        $this->data['js_vars']              = $this->plugin_handler->trigger('base_set_js_var', $this->data['js_vars'] );
        
        $this->javascript->js->script(base_url() . 'js/refreak.js');
        $this->css->add_style(base_url() . $this->data['theme'] . '/css/refreak.css', 'core');
        
        unset($params, $actual_user);
        $this->plugin_handler->trigger('base_post_init');
    } 
    
    /**
     * Prepare data to be added to html select
     *  
     * @param array $array Array with data
     * @param int $id key from array
     * @param string $description key from array
     * @return array
     * @access protected
     */
    protected function to_dropdown_array($array, $id, $description) {
                
        $result = array();
        
        if (count($array) > 0) 
            foreach ($array as $value) 
                $result[$value[$id]] = $value[$description];
        
        return $result;
    }
    
    /**
     * Prepare array to draw left header menu
     * 
     * @param array $user_projects Array for projects menus with the user projects
     * @param array $params Array with user id, project id and context
     * @return array Array with menu
     * @access protected
     */
    protected function _create_left_menu($user_projects, $params) {
        
        $user_id            = 0;
        $project_id         = 0;
        $context_id         = 0;
        
        if ($params !== false && is_array($params)) {
            $user_id        = $params['user'];
            $project_id     = $params['project'];
            $context_id     = $params['context'];
        }
        
        $view_menu          = array(
                                anchor('#', $this->lang->line('menu_view_all_projects'))    => array(
                                                            anchor('tasks/s/0/' . $user_id . '/2/' . $context_id . '/', $this->lang->line('menu_view_all_tasks')),
                                                            anchor('tasks/s/0/' . $user_id . '/0/' . $context_id . '/', $this->lang->line('menu_view_future_tasks')),
                                                            anchor('tasks/s/0/' . $user_id . '/1/' . $context_id . '/', $this->lang->line('menu_view_past_tasks')),
                                )
        );
        foreach ($user_projects as $up) {
            $view_menu[anchor('#', $up->name)]       = array(
                                anchor('tasks/s/' . $up->project_id . '/' . $user_id . '/2/' . $context_id . '/', $this->lang->line('menu_view_all_tasks')),
                                anchor('tasks/s/' . $up->project_id . '/' . $user_id . '/0/' . $context_id . '/', $this->lang->line('menu_view_future_tasks')),
                                anchor('tasks/s/' . $up->project_id . '/' . $user_id . '/1/' . $context_id . '/', $this->lang->line('menu_view_past_tasks')),
            ); 
        }
            
        
        $menu               = array(
                                anchor('#', $this->lang->line('menu_tasks'))    => array(
                                                            anchor('#', $this->lang->line('menu_tasks_new'), array('class' => 'menu_new_task'))
                                                                    ),
                                anchor('#', $this->lang->line('menu_view'))     => $view_menu,
                                
                                anchor('#', $this->lang->line('menu_manage'))   => array(
                                                            anchor('projects', $this->lang->line('menu_manage_projects')),
                                                            anchor('users', $this->lang->line('menu_manage_users')),
                                                            anchor('users/edit_user', $this->lang->line('menu_manage_profile'))
                                                                    ),
                                anchor('#', $this->lang->line('menu_config'))    => array(
                                                            anchor('plugin/', $this->lang->line('menu_config_plugin')) ),
                                
        );
        
        
        return $menu;
    }
    
    /**
     * Prepare array to draw right header menu
     * 
     * @param int $user_id Actual user id
     * @param array $params Array with user id, project id and context
     * @param int $selected_user User id to be selected in html user select
     * @param int $selected_context Context to be marked in search
     * @return array Array with menu
     * @access protected
     */
    protected function _create_right_menu($user_id, $params, $selected_user, $selected_context) {
        
        $project_id         = 0;
        
        if ($params !== false && is_array($params)) {
            $project_id     = $params['project'];
        }
        
        $contexts           = $this->lang->line('task_context');
        array_unshift($contexts, $this->lang->line('combo_context_all_contexts')) ;
                
        $menu               = array(
                               anchor('tasks/s/' . $project_id . '/' . $user_id . '/0/' . $selected_context , $this->lang->line('header_mytasks')),
                               anchor('/', $this->lang->line('header_alltasks')),
                               form_dropdown_users('list_users', $this->lang->line('header_allusers'), $selected_user),
                               form_dropdown('header_context', $contexts, array($selected_context), 'class = "list_contexts"'),
                               anchor(current_url(), img(site_url() . $this->data['theme'] . '/images/refresh.png'))
        );
        
        return $menu;
        
    }
    
    /**
     *  this method detects is passing user and project throught uri and fill array 
     *  with this parameters. Otherwise returns false
     * 
     * @return array|bool user and project for draw menus
     * @access private
     */
    private function _detect_user_project() {
        $class      = $this->router->fetch_class();
        $method     = $this->router->fetch_method();
        $params     = false;
        
        if ($class == 'tasks' && $method == 's') {
            $params         = array(
                                'project'       => $this->uri->segment(3),
                                'user'          => $this->uri->segment(4),
                                'time'          => $this->uri->segment(5),
                                'context'       => $this->uri->segment(6)
            );
        }
        
        return $params;
    }
        
}

/* End of file RF_BaseController.php */
/* Location: ./application/core/RF_BaseController.php */