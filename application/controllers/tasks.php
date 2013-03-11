<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Tasks Controller
 *
 * @package	Refreak
 * @subpackage	tasks
 * @category	controller
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Tasks extends RF_BaseController {
   
    /**
     * Constructor
     * 
     */
    public function __construct() {
        
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        $this->lang->load('tasks');
        $this->load->library('form_validation');
        $this->load->model('task_model');        
        $this->load->helper('rfk_task');
        
        // add javascript for task system
        $this->javascript->output('
                    $.ajaxSetup({
                        data: {'. $this->security->get_csrf_token_name() . ': "' . $this->security->get_csrf_hash() . '"},
                        dataType: "json"
                    });
                ');
        $this->javascript->js->script(base_url() . '/js/ui/jquery.ui.core.js');
        $this->javascript->js->script(base_url() . '/js/ui/jquery.ui.datepicker.js');
        $this->javascript->js->script(base_url() . '/js/tasks.js');
        
        // add css for task system
        $this->css->add_style(base_url() . 'js/ui/themes/base/jquery.ui.core.css', 'jquery.ui.core');
        $this->css->add_style(base_url() . 'js/ui/themes/base/jquery.ui.theme.css', 'jquery.ui.theme');
        // I need datepicker css here because is loaded by Ajax
        $this->css->add_style(base_url() . 'js/ui/themes/base/jquery.ui.datepicker.css', 'jquery.ui.datepicker');
        $this->css->add_style(base_url() . 'theme/default/css/ui-widget.css', 'jquery.ui.regularize');
        
        $this->data['js_vars'] .=         "\n" .
                    'var tasksmessage_ajax_error_security    = "' . $this->lang->line('tasksmessage_ajax_error_security') . "\";\n" .
                    'var tasksmessage_ajax_error_server    = "' . $this->lang->line('tasksmessage_ajax_error_server') . "\";\n" .
                    'var tasksmessage_created    = "' . $this->lang->line('tasksmessage_created') . "\";\n" .
                    'var tasksmessage_updated    = "' . $this->lang->line('tasksmessage_updated') . "\";\n" 
                ;
    }

    /**
     * Search base tasks and call default view
     * 
     * @access public
     * @return void 
     */
    public function index()
    {
        
        $this->data['tasks']        = $this->task_model->get_tasks($this->data['actual_user']->id);
        $this->load->view('tasks/tasks', $this->data);
        
    }
    
    /**
     * Search Action for Tasks. Is called when need to find tasks in more specific way.
     * All parameters are optional.
     * 
     * @param int $project_id Project ID
     * @param int $user_id User ID
     * @param int $time_concept 0 = future, 1 = past, 2 = all
     * @param int $context_id Task Context
     * @access public
     * @return void
     */
    public function s($project_id = 0, $user_id = 0, $time_concept = 0, $context_id = 0) {
        
        // transform 0 to null for task model. $time_concept don't need, 0 is future
        // and init vars
        $project_id                 = $project_id   == 0 ? null : $project_id;
        $user_id                    = $user_id      == 0 ? null : $user_id;
        $context_id                 = $context_id   == 0 ? null : $context_id;
        $projects                   = array();
        
        if (!is_null($user_id)) {
            $projects               = $this->_get_user_projects($user_id);
            //store user for render menus in render
            $this->session->set_flashdata('menu_user_id', $user_id);
        }
        
        if(!is_null($project_id)) {
            //store user for render menus in render
            $this->session->set_flashdata('menu_project_id', $project_id);
        }
            
                
        $this->data['tasks']        = $this->task_model->get_tasks($this->data['actual_user']->id, $user_id, $project_id, $time_concept, $projects);
        $this->load->view('tasks/tasks', $this->data);
        
    }
    
    /**
     * Show tasks from specific project
     * 
     * @param int $project_id Project ID
     * @access public
     * @return void
     */
    public function project($project_id)
    {
        
        $this->data['tasks']        = $this->task_model->get_tasks($this->data['actual_user']->id, null, $project_id);
        $this->load->view('tasks/tasks', $this->data);
        
    }
    
    /**
     * Show tasks from specific User
     * 
     * @param int $user_id User ID
     * @access public
     * @return void
     */
    public function user($user_id)
    {
        
        $this->load->model('user_model');
        
        if (!is_null($user_id)) {
            $projects               = $this->_get_user_projects($user_id);   
        }
                
        $this->data['tasks']        = $this->task_model->get_tasks($this->data['actual_user']->id, $user_id, null, 0, $projects);
        $this->load->view('tasks/tasks', $this->data);
        
    }
    
    /**
     * Show new/edit task popup. This action is only called via Ajax
     * 
     * @access public
     * @return void
     */
    public function edit() {
        
        if ($this->input->is_ajax_request()) {
            
            $tid                            = 0;
            $task                           = array();
            
            if ($this->input->post('tid') && $this->input->post('tid') > 0) {
                $tid                        = $this->input->post('tid');
                $task                       = $this->task_model->get_task($tid);
            }
            
            //load layout configuration
            $this->config->load('layout');

            //inform system don't use layout, don't need for this ajax call
            $this->config->set_item('layout_use', false);

            $ups            = array($this->lang->line('task_edit_project_none'));
            foreach ($this->data['user_projects'] as $up) {
                $ups[] = $up->name;
            }

            $defaults                       = array(
                                        'task_id'               => $tid,
                                        'priority'              => 3,
                                        'context'               => 1,
                                        'title'                 => null,
                                        'deadline_date'         => null,
                                        'project_id'            => 0,
                                        'description'           => null,
                                        'user_id'               => $this->data['actual_user']->id,
                                        'private'               => 1,
                                        'status'                => 0,
            );
            
            if (count($task) === 1) {
                $data                       = array_merge($defaults, $task[0]);
            }
            else {
                $data                       = $defaults;
            }            
            
            $this->data                     = array_merge($data, $this->data);
            
            if ($this->data['deadline_date'] === '0000-00-00') {
                $this->data['deadline_date'] = null;
            }
            
            $this->data['user_p']           = $ups;
            
            unset($ups, $defaults, $task);

            $this->load->view('tasks/edit', $this->data);
        }
    }
    
    /**
     * Create or Update Task
     * 
     * @access public
     * @return void
     */
    public function save_task() {
        
        $response                               = array('response' => 'rfk_fuckyou');
        
        if ($this->input->is_ajax_request() && $this->input->post('task_title')) {
            
                $this->form_validation->set_rules('task_priority', 'Priority', 'xss_clean');
                $this->form_validation->set_rules('task_context', 'Context', 'xss_clean');
                $this->form_validation->set_rules('deadline', 'Deadline', 'xss_clean');
                $this->form_validation->set_rules('task_projects', 'Projects', 'xss_clean');
                $this->form_validation->set_rules('task_project_name', 'Project Name', 'xss_clean');
                $this->form_validation->set_rules('task_title', 'Title', 'required|xss_clean');
                $this->form_validation->set_rules('task_description', 'Description', 'prep_for_form|xss_clean');
                $this->form_validation->set_rules('task_users', 'User', 'xss_clean');
                $this->form_validation->set_rules('showPrivate', 'Scope', 'xss_clean');
                $this->form_validation->set_rules('task_status', 'Status', 'xss_clean');
                $this->form_validation->set_rules('task_id', 'Status', 'xss_clean');
                
                if ($this->form_validation->run() === TRUE) {
                    // save task here
                    $task_id                    = $this->input->post('task_id');
                    
                    $this->task_model->save_task(
                                                $this->input->post('task_title'),
                                                $this->input->post('task_priority'),
                                                $this->input->post('task_context'),
                                                $this->input->post('deadline'),
                                                $this->input->post('task_projects'),
                                                $this->input->post('task_project_name'),
                                                $this->input->post('task_description'),
                                                $this->input->post('task_users'),
                                                $this->input->post('showPrivate'),
                                                $this->input->post('task_status'),
                                                $this->data['actual_user']->id,
                                                $task_id
                    );
                    
                    $response['response']       = 'rfk_ok';
                    $response['tid']            = $task_id;
                    
                }
        }
        
        echo json_encode($response);
        
    }
    
    /**
     * Retrieve users of specific project. Is called from show_edit view
     * 
     * @access public
     * @return void
     */
    public function get_users_from_project() {
                
        if ($this->input->is_ajax_request())
        {
            $project_id                         = $this->input->post('project_id');
            $ups                                = $this->task_model->get_users_project($project_id);
            echo json_encode(
                                array(
                                    'response'  => 'rfk_ok',
                                    'data'      => $ups
                                )
                                
                    );
            
        }
        else
        {
            echo json_encode(array('response' => 'rfk_fuckyou'));
        }
        
    }
    
    /**
     * Retrieve projects from a specific user.
     * 
     * @param int $user_id User ID
     * @return array Projects list
     * @access private
     */
    private function _get_user_projects($user_id) {
        
        $this->load->model('user_model');
        
        $user_projects              = $this->user_model->get_projects_user($user_id);

        $projects = array();
        
        if (count($user_projects) > 0) {
            foreach ($user_projects as $prjs) {
                $projects []        = $prjs->project_id;
            }
        }
        
        return $projects;
    }
    
    /**
     * Show task information panel
     * 
     * @param int $task_id
     * @access public
     * @return void
     */
    public function show() {
        
        if ($this->input->is_ajax_request() && $this->input->post('tid')) {
            
            $tid                        = $this->input->post('tid');
            $task                       = $this->task_model->get_task($tid);
            
            //load layout configuration
            $this->config->load('layout');

            //inform system don't use layout, don't need for this ajax call
            $this->config->set_item('layout_use', false);
            
            $this->load->model('project_model');
            
            $project                        = $this->project_model->get_project($task[0]['project_id']);
            
            $context                        = $this->lang->line('task_context');
            $context_letter                 = substr($context[$task[0]['context']], 0, 1);
            $visibility                     = $this->lang->line('task_visibility');
            $user                           = $this->data['users'][$task[0]['user_id']];
            $username                       = $user->first_name . ' ' . $user->last_name;
            $project_name                   = $project->name;
            $status                         = $this->lang->line('task_status');
            
            $this->data['tf']               = $task[0];
            $this->data['context']          = $context;
            $this->data['visibility']       = $visibility;
            $this->data['context_letter']   = $context_letter;
            $this->data['username']         = $username;
            $this->data['project_name']     = $project_name;
            $this->data['status']           = $status;
            
            unset($user, $project);
            
            $this->load->view('tasks/show', $this->data);
        }
        
    }
    
    public function get_description() {
        
        if ($this->input->is_ajax_request())
        {
            $task_id                        = $this->input->post('tid');
            $description                    = $this->task_model->get_task_description($task_id);
            echo json_encode(
                                array(
                                    'response'          => 'rfk_ok',
                                    'description'       => $description
                                )
                                
                    );
            
        }
        else
        {
            echo json_encode(array('response' => 'rfk_fuckyou'));
        }
        
    }
    
    public function get_comments() {
        
        if ($this->input->is_ajax_request())
        {
            $task_id                        = $this->input->post('tid');
            $comments                       = $this->task_model->get_task_comments($task_id);
            echo json_encode(
                                array(
                                    'response'          => 'rfk_ok',
                                    'comments'          => $comments
                                )
                                
                    );
            
        }
        else
        {
            echo json_encode(array('response' => 'rfk_fuckyou'));
        }
        
    }

}

/* End of file tasks.php */
/* Location: ./application/controllers/tasks.php */