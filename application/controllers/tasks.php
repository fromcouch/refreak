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
class Tasks extends RF_Controller {
   
    /**
     * Constructor
     * 
     */
    public function __construct() {
        
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        
        $this->plugin_handler->trigger('tasks_pre_init');
        
        $this->load->library('form_validation');
        $this->load->model('task_model');        
        $this->load->helper( array('rfk_task', 'decorators/task') );
        
        // add javascript for task system
        $this->javascript->output('
                    $.ajaxSetup({
                        data: {'. $this->security->get_csrf_token_name() . ': "' . $this->security->get_csrf_hash() . '"},
                        dataType: "json"
                    });
                ');
        $this->javascript->js->script(base_url() . '/js/ui/jquery.ui.core.js');
        $this->javascript->js->script(base_url() . '/js/ui/jquery.ui.datepicker.js');
        $this->javascript->js->script(base_url() . '/js/jquery.tablesorter.min.js');
        $this->javascript->js->script(base_url() . '/js/tasks.js');
        
        // add css for task system
        $this->css->add_style(base_url() . 'js/ui/themes/base/jquery.ui.core.css', 'jquery.ui.core');
        $this->css->add_style(base_url() . 'js/ui/themes/base/jquery.ui.theme.css', 'jquery.ui.theme');
        // I need datepicker css here because is loaded by Ajax
        $this->css->add_style(base_url() . 'js/ui/themes/base/jquery.ui.datepicker.css', 'jquery.ui.datepicker');
        $this->css->add_style(base_url() . '/' . $this->data['theme'] . '/css/ui-widget.css', 'jquery.ui.regularize');
        
        $this->data['js_vars'] .=         "\n" .
                    'var tasksmessage_created    = "' . $this->lang->line('tasksmessage_created') . "\";\n" .
                    'var tasksmessage_updated    = "' . $this->lang->line('tasksmessage_updated') . "\";\n" .
                    'var tasksmessage_deleted    = "' . $this->lang->line('tasksmessage_deleted') . "\";\n" .
                    'var tasksmessage_delete     = "' . $this->lang->line('task_show_delete_confirm') . "\";\n" .
                    'var tasksmessage_delete_comment     = "' . $this->lang->line('task_show_delete_comment_confirm') . "\";\n" .
                    'var task_list_close_task    = "' . $this->lang->line('task_list_close_task') . "\";\n" .
                    'var maximum_status          = ' . $this->config->item('rfk_status_levels') . ";\n" 
                ;
        
        $this->data                         = $this->plugin_handler->trigger('tasks_post_init', $this->data);
    }

    /**
     * Search base tasks and call default view
     * 
     * @access public
     * @return void 
     */
    public function index()
    {
        
        $this->data['tasks']			= $this->plugin_handler->trigger(
                                                        'tasks_list', 
                                                        $this->task_model->get_tasks($this->data['actual_user']->id) 
                                       );
        
		
		$this->data['subtasks']			= $this->subtasking();
			
        $this->data['max_status']		= $this->config->item('rfk_status_levels');
        
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
        
        $this->data['tasks']		= $this->search($project_id, $user_id, $time_concept, $context_id);  
	
        $this->data['tasks']		= $this->plugin_handler->trigger('tasks_search_result_list', $this->data['tasks'] );
		$this->data['subtasks']		= $this->subtasking();
        $this->data['max_status']	= $this->config->item('rfk_status_levels');
        
        $this->load->view('tasks/tasks', $this->data);
        
    }
    
    /**
     * Print tasks. 
     * All parameters are optional.
     * 
     * @param int $project_id Project ID
     * @param int $user_id User ID
     * @param int $time_concept 0 = future, 1 = past, 2 = all
     * @param int $context_id Task Context
     * @access public
     * @return void
     */
    public function p($project_id = 0, $user_id = 0, $time_concept = 0, $context_id = 0) {
	    
		$this->css->add_style(base_url() . '/' . $this->data['theme'] . '/css/print.css', 'print');

		$this->data['tasks']		= $this->search($project_id, $user_id, $time_concept, $context_id);    
		$this->data['max_status']	= $this->config->item('rfk_status_levels');
		$this->data['subtasks']		= $this->subtasking();
		
		$this->data['tasks']		= $this->plugin_handler->trigger('tasks_search_result_print', $this->data['tasks'] );
	
        $this->load->view('tasks/print', $this->data);
	    
    }
    
    /**
     * Search Action for Tasks. Is called when need to find tasks in more specific way.
     * All parameters are optional.
     * 
     * @param int $project_id Project ID
     * @param int $user_id User ID
     * @param int $time_concept 0 = future, 1 = past, 2 = all
     * @param int $context_id Task Context
     * @access private
     * @return object/array list of tasks
     */
    private function search($project_id = 0, $user_id = 0, $time_concept = 0, $context_id = 0) {
	    
		// transform 0 to null for task model. $time_concept don't need, 0 is future
		// and init vars
		$project_id                 = $project_id   == 0 ? null : $project_id;
		$user_id                    = $user_id      == 0 ? null : $user_id;
		$context_id                 = $context_id   == 0 ? null : $context_id;
		$projects                   = array();

		if (!is_null($user_id)) {
			$projects		= $this->_get_user_projects($user_id);           
		}                    

		$tasks			= $this->task_model->get_tasks($this->data['actual_user']->id, $user_id, $project_id, $time_concept, $projects, $context_id);

		return $tasks;
	    
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
        
        $this->data['tasks']        = $this->plugin_handler->trigger('tasks_list_from_project', $this->data['tasks'] );
        $this->data['max_status']   = $this->config->item('rfk_status_levels');
        $this->data['subtasks']		= $this->subtasking();
		
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
        
        $this->data['tasks']        = $this->plugin_handler->trigger('tasks_list_from_user', $this->data['tasks'] );
        $this->data['max_status']   = $this->config->item('rfk_status_levels');
        $this->data['subtasks']		= $this->subtasking();
		
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
            $tpid							= 0;
            $task                           = array();
            $parent_title					= '';
			$project_id						= 0;
			
            if ($this->input->post('tid') && $this->input->post('tid') > 0) {
                $tid                        = $this->input->post('tid');
                $task                       = $this->task_model->get_task($tid, $this->data['actual_user']->id);
            }
            
			if ($this->config->item('rfk_subtasks') && ($this->input->post('tpid') && $this->input->post('tpid') > 0)) {
				$tpid						= $this->input->post('tpid');
				$parent_title				= $this->task_model->get_parent_task_title($tpid);
				$project_id					= $this->task_model->get_task_project($tpid);
			}
			
            //load layout configuration
            $this->config->load('layout');

            //inform system don't use layout, don't need for this ajax call
            $this->config->set_item('layout_use', false);
            
            // get default value for visibility
            $visibility                     = $this->config->item('rfk_task_visibility');
            
            $ups							= array($this->lang->line('task_edit_project_none'));
            foreach ($this->data['user_projects'] as $up) {
                $ups[$up->project_id] = $up->name;
            }

            $defaults                       = array(
													'task_id'               => $tid,
													'task_parent_id'        => $tpid,
													'priority'              => 3,
													'context'               => 1,
													'title'                 => null,
													'deadline_date'         => null,
													'project_id'            => $project_id,
													'description'           => null,
													'user_id'               => $this->data['actual_user']->id,
													'private'               => $visibility,
													'status'                => 0,
            );
            
            if (count($task) === 1) {
                $data                       = array_merge($defaults, $task[0]);
            }
            else {
                $data                       = $defaults;
            }                               
            
            $this->data                     = array_merge($data, $this->data);
            
            if ($this->data['deadline_date'] === '0000-00-00' || $this->data['deadline_date'] === '9999-00-00') {
                $this->data['deadline_date'] = null;
            }
            
            $this->data['user_p']           = $ups;
            $this->data['max_status']       = $this->config->item('rfk_status_levels');
			$this->data['parent_title']		= $parent_title;
			
            $this->data                     = $this->plugin_handler->trigger('tasks_show_edit_task', $this->data );
            
            unset($ups, $defaults, $task);

            $this->load->view('tasks/edit', $this->data);
        }
        else {
            show_error("Isn't Ajax Call. What are you thinking about?", 403);
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
                $this->form_validation->set_rules('task_id', 'Task ID', 'xss_clean');
                $this->form_validation->set_rules('task_parent_id', 'Task Parent ID', 'xss_clean');
                
                $this->form_validation          = $this->plugin_handler->trigger('tasks_save_task_validation', $this->form_validation );
                
                if ($this->form_validation->run() === TRUE) {
                    // save task here
                    $task_id                    = $this->input->post('task_id');
					$task_parent_id				= 0;
					
					if ($this->config->item('rfk_subtasks'))
							$task_parent_id     = $this->input->post('task_parent_id');
                    
                    $this->input                = $this->plugin_handler->trigger('tasks_save_task_data', $this->input );
                    
                    $task_id                    = $this->task_model->save_task(
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
                                                        (int)$task_id,
                                                        (int)$task_parent_id
                    );
                    
                    $this->plugin_handler->trigger('tasks_save_task_saved', $this->input );
                    
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
        
        $projects                   = $this->plugin_handler->trigger('tasks_list_projects_from_user', $projects );
        
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
            $task                       = $this->task_model->get_task($tid, $this->data['actual_user']->id);
            
            //load layout configuration
            $this->config->load('layout');

            //inform system don't use layout, don't need for this ajax call
            $this->config->set_item('layout_use', false);
                                   
            if ($task[0]['project_id'] != 0) {
                    $this->load->model('project_model');
                    $project                = $this->project_model->get_project($task[0]['project_id']);
                    $this->data['project_name']     = $project->name;
            }
            else {
                    $this->data['project_name']     = '';
            }
            
            $context                        = $this->lang->line('task_context');
            $context_letter                 = substr($context[$task[0]['context']], 0, 1);
            $visibility                     = $this->lang->line('task_visibility');
            $user_id                        = $task[0]['user_id'];
            $username                       = ' - ';
            
            if ($user_id > 0) {
                $user                           = $this->data['users'][$this->extract_user_id((int)$user_id)];
                $username                       = $user->first_name . ' ' . $user->last_name;
            }
            
            $status                         = $this->lang->line('task_status');
 				
			$parent_active			= FALSE;
			$subtask_active			= FALSE;
				           
			if ($this->config->item('rfk_subtasks')) {

				if ($task[0]['task_parent_id'] > 0) {
					//is a subtask
					$parent_active			= TRUE;
					$subtask_active			= FALSE;
				}
				else {
					$parent_active			= FALSE;
					$subtask_active			= $this->task_model->get_subtasks_number($task[0]['task_id']);
				}
					
			}
			
            $this->data['tf']               = $task[0];
            $this->data['context']          = $context;
            $this->data['visibility']       = $visibility;
            $this->data['context_letter']   = $context_letter;
            $this->data['username']         = $username;
            $this->data['status']           = $status;
            $this->data['parent_active']    = $parent_active;
            $this->data['subtask_active']   = $subtask_active;
            
            $this->data                     = $this->plugin_handler->trigger('tasks_show_task', $this->data );
            
            unset($user, $project);
            
            $this->load->view('tasks/show', $this->data);
        }
        else {
            show_error("Isn't Ajax Call. What are you thinking about?", 403);
        }       
        
    }
    
	/**
	 * Extract User Id from user array
	 * @param array $user_id Array of users
	 * @return mixed
	 * @access private
	 */
    private function extract_user_id($user_id) {
        
        foreach ($this->data['users'] as $key => $value) {
            
            if ($value->id == $user_id) return $key;
            
        }
        
        return FALSE;
    }
    
    /**
     * Ajax call. Get task description
     *      
     * @return void
     * @access public
     */
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
    
    /**
     * Ajax call. Get task comments
     *      
     * @return void
     * @access public
     */
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
    
    /**
     * Ajax call. Get task history
     *      
     * @return void
     * @access public
     */
    public function get_history() {
        
        if ($this->input->is_ajax_request())
        {
            $task_id                        = $this->input->post('tid');
            $history                        = $this->task_model->get_status_history($task_id);
            $status                         = $this->lang->line('task_status');
            $returned_history               = array();
            
            //need to change status, I don't like do that!
            foreach ($history as $hist) {                                    
                
                    $hist['status']         = $status[$hist['status']];
                    $returned_history     []= $hist;
                    
            }
            
            echo json_encode(
                                array(
                                    'response'          => 'rfk_ok',
                                    'history'           => $returned_history
                                )
                                
                    );
            
        }
        else
        {
            echo json_encode(array('response' => 'rfk_fuckyou'));
        }
        
    }
    
    
    /**
     * Ajax call for save comments
     * 
     * @return void
     * @access public
     */
    public function save_comment() {
        
        $task_id                            = $this->input->post('tid');
        $actual_user_id                     = $this->data['actual_user']->id;
        
        if ($this->input->is_ajax_request() && $this->can_do($task_id, $actual_user_id, 2))
        {
            
            $task_comment_id                = $this->input->post('tcid');
            $comment                        = $this->input->post('comment');
            
            $task_comment_id                = $this->task_model->save_comment($comment, $actual_user_id, $task_id, (int)$task_comment_id);
            
            echo json_encode(
                                array(
                                    'response'          => 'rfk_ok',
                                    'tcid'              => $task_comment_id
                                )
                                
                    );
            
        }
        else
        {
            echo json_encode(array('response' => 'rfk_fuckyou'));
        }
    }
    
    /**
     * Ajax for deleting comment
     * 
     * @return void
     * @access public
     */
    public function delete_comment() {
        
        $task_id                            = $this->input->post('tid');
        $actual_user_id                     = $this->data['actual_user']->id;
        
        if ($this->input->is_ajax_request() && $this->can_do($task_id, $actual_user_id, 4))
        {
            
            $task_comment_id                = $this->input->post('tcid');
            
            $this->task_model->delete_comment((int)$task_comment_id);
            
            echo json_encode(
                                array(
                                    'response'          => 'rfk_ok'
                                )
                                
                    );
            
        }
        else
        {
            echo json_encode(array('response' => 'rfk_fuckyou'));
        }
        
    }
    
    /**
     * Ajax call for change status
     * 
     * @return void
     * @access public
     */
    public function change_status() {
        
        $task_id                            = $this->input->post('tid');
        $actual_user_id                     = $this->data['actual_user']->id;
        
        if ($this->input->is_ajax_request() && $this->can_do($task_id, $actual_user_id, 4))
        {
            $this->config->load('refreak');
            
            $cd                             = $this->config->item('rfk_complete_deadline');
            $status                         = $this->input->post('status');
            
            $this->task_model->set_status($task_id, $status, $this->data['actual_user']->id);
            
            if ($cd && $status == $this->config->item('rfk_status_levels')) {
                $this->task_model->close_task($task_id);
            }
                
            $this->plugin_handler->trigger('tasks_change_status');
            
            echo json_encode(
                                array(
                                    'response'          => 'rfk_ok'
                                )
                                
                    );
            
        }
        else
        {
            echo json_encode(array('response' => 'rfk_fuckyou'));
        }
        
    }

    /**
     * Ajax call for deleting task
     * 
     * @return void
     * @access public
     */
    public function delete() {
        
        $task_id                            = $this->input->post('tid');
        $actual_user_id                     = $this->data['actual_user']->id;
        
        if ($this->input->is_ajax_request() && $this->can_do($task_id, $actual_user_id, 5))
        {
                        
            $this->task_model->delete_task($task_id);
                
            echo json_encode(
                                array(
                                    'response'          => 'rfk_ok'
                                )
                                
                    );
            
        }
        else
        {
            echo json_encode(array('response' => 'rfk_fuckyou'));
        }
        
    }
    
	/**
	 * Choose if subtasking are acticated and return them
	 * 
	 * @return array Subtasking array
	 * @access private
	 */
	private function subtasking() {
		
		if ($this->config->item('rfk_subtasks')) {
				return $this->task_model->process_subtasks(
															$this->task_model->get_tasks($this->data['actual_user']->id, null, null, 0, array(), null, true) 
											);
		}
		
		return array();
						
	}	
	
    /**
     * See if user have access to do something in task
     * 
     * @param int $task_id Task ID
     * @param int $actual_user_id User ID
     * @param int $level level to compare
     * @return boolean
     * @access private
     */
    private function can_do($task_id, $actual_user_id, $level) {
                
        $this->load->model('task_model');
        
        if ($this->task_model->get_user_position((int)$task_id, $actual_user_id) >= $level ||         
             $this->ion_auth->in_group(array(1,2)) ||
             $this->task_model->is_owner((int)$task_id, (int)$actual_user_id))
                return true;
        else 
                return false;
                     
    }
}

/* End of file tasks.php */
/* Location: ./application/controllers/tasks.php */