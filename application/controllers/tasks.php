<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tasks extends RF_BaseController {
   
    
    public function __construct() {
        
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        $this->lang->load('tasks');
        $this->load->library('form_validation');
        $this->load->model('task_model');        
        $this->load->helper('rfk_task');
        
        /* 
         * add javascript for task system
         */
        $this->javascript->output('
                    $.ajaxSetup({
                        data: {'. $this->security->get_csrf_token_name() . ': "' . $this->security->get_csrf_hash() . '"},
                        dataType: "json"
                    });
                ');
        $this->javascript->js->script(base_url() . '/js/ui/jquery.ui.core.js');
        $this->javascript->js->script(base_url() . '/js/ui/jquery.ui.datepicker.js');
        $this->javascript->js->script(base_url() . '/js/tasks.js');
        
        /* 
         * add css for task system
         */
        $this->css->add_style(base_url() . 'js/ui/themes/base/jquery.ui.core.css', 'jquery.ui.core');
        $this->css->add_style(base_url() . 'js/ui/themes/base/jquery.ui.theme.css', 'jquery.ui.theme');
        // I need datepicker css here because is loaded by Ajax
        $this->css->add_style(base_url() . 'js/ui/themes/base/jquery.ui.datepicker.css', 'jquery.ui.datepicker');
        $this->css->add_style(base_url() . 'theme/default/css/ui-widget.css', 'jquery.ui.regularize');
    }

    public function index()
    {
        
        $this->data['tasks']        = $this->task_model->get_tasks($this->data['actual_user']->id);
        $this->load->view('tasks/tasks', $this->data);
        
    }
    
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
    
    public function project($project_id)
    {
        
        $this->data['tasks']        = $this->task_model->get_tasks($this->data['actual_user']->id, null, $project_id);
        $this->load->view('tasks/tasks', $this->data);
        
    }
    
    public function user($user_id)
    {
        
        $this->load->model('user_model');
        
        if (!is_null($user_id)) {
            $projects               = $this->_get_user_projects($user_id);   
        }
                
        $this->data['tasks']        = $this->task_model->get_tasks($this->data['actual_user']->id, $user_id, null, 0, $projects);
        $this->load->view('tasks/tasks', $this->data);
        
    }
    
    public function show_edit() {
        
        if ($this->input->is_ajax_request()) {
            //load layout configuration
            $this->config->load('layout');

            //inform system don't use layout, don't need for this ajax call
            $this->config->set_item('layout_use', false);

            $ups            = array($this->lang->line('task_edit_project_none'));
            foreach ($this->data['user_projects'] as $up) {
                $ups[] = $up->name;
            }

            $this->data['priority']             = 3;
            $this->data['context']              = 1;
            $this->data['user_p']               = $ups;
            $this->data['tid']                  = 0;
            $this->data['showPrivate']          = 1;

            unset($ups);

            $this->load->view('tasks/edit', $this->data);
        }
    }
    
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
                
                if ($this->form_validation->run() === TRUE) {
                    // save task here
                    $this->task_model->save();
                    $response['response']       = 'rfk_ok';
                }
        }
        
        echo json_encode($response);
        
    }
    
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

}

/* End of file tasks.php */
/* Location: ./application/controllers/tasks.php */